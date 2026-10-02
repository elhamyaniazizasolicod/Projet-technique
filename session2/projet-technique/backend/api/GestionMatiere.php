<?php

// En-têtes pour renvoyer du JSON et autoriser les requêtes CORS
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Répondre immédiatement aux requêtes préliminaires CORS (preflight OPTIONS)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once "../class/matiere.php";

class GestionMatiere
{
    private string $path_file;

    public function __construct()
    {
        $this->path_file = __DIR__ . "/../database/gestionMatiere.json";
    }

    // Lit le fichier JSON et retourne un tableau PHP
    private function lireFichier(): array
    {
        if (!file_exists($this->path_file)) {
            return [];
        }

        $content = file_get_contents($this->path_file);
        $data = json_decode($content, true);

        return is_array($data) ? $data : [];
    }

    // Écrit le tableau PHP dans le fichier JSON
    private function ecrireFichier(array $data): void
    {
        file_put_contents(
            $this->path_file,
            json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );
    }

    // GET : Afficher toutes les matières
    public function afficherMatiere()
    {
        $matieres = $this->lireFichier();
        echo json_encode($matieres);
    }

    // POST : Ajouter une matière
    public function ajouterMatiere()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        // Validation des champs
        if (empty(trim($data["nom_matiere"] ?? '')) || empty(trim($data["description"] ?? ''))) {
            http_response_code(400);
            echo json_encode([
                "success" => false,
                "message" => "Veuillez remplir tous les champs."
            ]);
            return;
        }

        $matieres = $this->lireFichier();

        // Calcul du nouvel ID (ID max existant + 1 pour éviter les collisions)
        $maxId = 0;
        foreach ($matieres as $item) {
            if (isset($item["id_matiere"]) && $item["id_matiere"] > $maxId) {
                $maxId = $item["id_matiere"];
            }
        }
        $newId = $maxId + 1;

        // Création de l'objet Matière
        $nouvelleMatiere = new Matiere($newId, trim($data["nom_matiere"]), trim($data["description"]));

        $matieres[] = $nouvelleMatiere->toArray();

        $this->ecrireFichier($matieres);

        http_response_code(201);
        echo json_encode([
            "success" => true,
            "message" => "Matière ajoutée avec succès.",
            "data" => $nouvelleMatiere->toArray()
        ]);
    }

    // PUT : Modifier une matière existante
    public function modifierMatiere()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (empty($data["id_matiere"]) || empty(trim($data["nom_matiere"] ?? '')) || empty(trim($data["description"] ?? ''))) {
            http_response_code(400);
            echo json_encode([
                "success" => false,
                "message" => "Tous les champs (ID, nom et description) sont obligatoires."
            ]);
            return;
        }

        $id = (int)$data["id_matiere"];
        $matieres = $this->lireFichier();
        $trouve = false;

        foreach ($matieres as &$item) {
            if (isset($item["id_matiere"]) && (int)$item["id_matiere"] === $id) {
                $item["nom_matiere"] = trim($data["nom_matiere"]);
                $item["description"] = trim($data["description"]);
                $trouve = true;
                break;
            }
        }

        if (!$trouve) {
            http_response_code(404);
            echo json_encode([
                "success" => false,
                "message" => "Matière introuvable."
            ]);
            return;
        }

        $this->ecrireFichier($matieres);

        echo json_encode([
            "success" => true,
            "message" => "Matière modifiée avec succès."
        ]);
    }

    // DELETE : Supprimer une matière
    public function supprimerMatiere()
    {
        // Récupération de l'ID via paramètre GET (?id=...) ou corps JSON
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;

        if (!$id) {
            $data = json_decode(file_get_contents("php://input"), true);
            $id = isset($data['id_matiere']) ? (int)$data['id_matiere'] : null;
        }

        if (!$id) {
            http_response_code(400);
            echo json_encode([
                "success" => false,
                "message" => "ID de la matière manquant."
            ]);
            return;
        }

        $matieres = $this->lireFichier();
        $nbAvant = count($matieres);

        // Filtrer les éléments pour retirer la matière ciblée
        $matieres = array_values(array_filter($matieres, function ($item) use ($id) {
            return isset($item["id_matiere"]) && (int)$item["id_matiere"] !== $id;
        }));

        if (count($matieres) === $nbAvant) {
            http_response_code(404);
            echo json_encode([
                "success" => false,
                "message" => "Matière introuvable."
            ]);
            return;
        }

        $this->ecrireFichier($matieres);

        echo json_encode([
            "success" => true,
            "message" => "Matière supprimée avec succès."
        ]);
    }

    // Routeur de la requête HTTP
    public function requestTraitement()
    {
        $method = $_SERVER["REQUEST_METHOD"];

        switch ($method) {
            case "GET":
                $this->afficherMatiere();
                break;
            case "POST":
                $this->ajouterMatiere();
                break;
            case "PUT":
                $this->modifierMatiere();
                break;
            case "DELETE":
                $this->supprimerMatiere();
                break;
            default:
                http_response_code(405);
                echo json_encode([
                    "success" => false,
                    "message" => "Méthode non autorisée."
                ]);
                break;
        }
    }
}

$api = new GestionMatiere();
$api->requestTraitement();
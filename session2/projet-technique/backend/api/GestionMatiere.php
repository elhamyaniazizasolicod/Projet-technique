<?php

require_once "../class/matiere.php";

header('Content-Type: application/json');

class GestionMatiere
{
    private string $path_file;

    public function __construct()
    {
        $this->path_file = __DIR__ . "/../database/gestionMatiere.json";
    }

    public function afficherMatiere()
    {
        $content = file_get_contents($this->path_file);

        $matiere = json_decode($content, true);

        echo json_encode($matiere);
    }

    public function ajouterMatiere()
    {
        $content = file_get_contents($this->path_file);

        $matiere = json_decode($content, true);

        $data = json_decode(file_get_contents("php://input"), true);

        $matiere[] = [
            "id_matiere" => count($matiere) + 1,
            "nom_matiere" => $data["nom_matiere"],
            "description" => $data["description"]
        ];

        file_put_contents(
            $this->path_file,
            json_encode($matiere, JSON_PRETTY_PRINT)
        );

        echo json_encode([
            "success" => true,
            "message" => "Matière ajoutée"
        ]);
    }

    public function requestTraitement()
    {
        $method = $_SERVER["REQUEST_METHOD"];

        if ($method == "GET") {
            $this->afficherMatiere();
        }

        if ($method == "POST") {
            $this->ajouterMatiere();
        }
    }
}

$api = new GestionMatiere();

$api->requestTraitement();
?>
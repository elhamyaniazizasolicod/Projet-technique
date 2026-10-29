
<?php

require_once __DIR__ . "/matiere.php";

class GestionMatiere
{
    private string $path_file;
    public function __construct()
    {
        $this->path_file = __DIR__ . "/../database/gestionMatiere.json";
    }

    // Afficher les matières
    public function afficherMatiere()
    {
        $content = file_get_contents($this->path_file);
        $matieres = json_decode($content, true);

        if (!is_array($matieres)) {
            return [];
        }

        $resultat = [];

        foreach ($matieres as $data) {
           $matiere = new Matiere(
           (int) ($data["id_matiere"] ?? $data["id"] ?? 0),
           $data["nom_matiere"] ?? $data["nom"] ?? "",
           $data["description"] ?? ""
          );

            if (isset($data["id_matiere"])) {
                $matiere->setId($data["id_matiere"]);
            } elseif (isset($data["id"])) {
                $matiere->setId($data["id"]);
            }

            $resultat[] = $matiere;
        }

        return $resultat;
    }

    // Ajouter une matière
    public function ajouterMatiere(Matiere $matiere)
    {
        $content = file_get_contents($this->path_file);
        $matieres = json_decode($content, true);

        if (!is_array($matieres)) {
            $matieres = [];
        }

        $nouvelleMatiere = [
            "id_matiere" => count($matieres) + 1,
            "nom_matiere" => $matiere->getNom(),
            "description" => $matiere->getDescription()
        ];

        $matieres[] = $nouvelleMatiere;

        file_put_contents(
            $this->path_file,
            json_encode($matieres, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );

        return $nouvelleMatiere;
    }
}

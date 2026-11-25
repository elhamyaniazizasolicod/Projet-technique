<?php

require_once dirname(__DIR__) . '/services/BaseService.php';
require_once dirname(__DIR__) . '/models/Matiere.php';

class MatiereService extends BaseService 
{
    // instead $domaine name it $model 
    private Matiere $matiere;

    public function __construct()
    {
        $this->matiere = new Matiere();
    }

    public function listerMatieres(): array
    {
        return $this->matiere->afficherTous();
    }

    public function ajouter(array $input): array
    {
        $nom_matiere = trim($input['nom_matiere'] ?? '');
        $description = trim($input['description'] ?? '');

        if (empty($nom_matiere) || empty($description)) {
            throw new InvalidArgumentException("Tous les champs sont obligatoires");
        }

        $this->validateNomLength($nom_matiere);

        $this->matiere->ajouter($nom_matiere, $description);

        return [
            'success' => true,
            'message' => 'Domaine ajouté avec succès'
        ];
    }
}

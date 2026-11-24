<?php

require_once dirname(__DIR__) . '/services/BaseService.php';
require_once dirname(__DIR__) . '/models/Domaine.php';

class DomaineService extends BaseService 
{
    // instead $domaine name it $model 
    private Domaine $domaine;

    public function __construct()
    {
        $this->domaine = new Domaine();
    }

    public function listerDomaines(): array
    {
        return $this->domaine->afficherTous();
    }

    public function ajouterDomaine(array $input): array
    {
        $nom_matiere = trim($input['nom_matiere'] ?? '');
        $description = trim($input['description'] ?? '');

        if (empty($nom_matiere) || empty($description)) {
            throw new InvalidArgumentException("Tous les champs sont obligatoires");
        }

        $this->validateNomLength($nom_matiere);

        $this->domaine->ajouter($nom_matiere, $description);

        return [
            'success' => true,
            'message' => 'Domaine ajouté avec succès'
        ];
    }
}

<?php

require_once __DIR__ . '/DomaineDAO.php';

class Domaine extends DomaineDAO
{
    private ?int $id_matiere;
    private string $nom_matiere;
    private string $description;

    public function __construct(?int $id_matiere = null, string $nom_matiere = '', string $description = '')
    {
        parent::__construct();
        $this->id_matiere = $id_matiere;
        $this->nom_matiere = $nom_matiere;
        $this->description = $description;
    }

    public function getId(): int
    {
        return $this->id_matiere;
    }

    public function getNom(): string
    {
        return $this->nom_matiere;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}

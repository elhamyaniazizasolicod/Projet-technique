<?php

require_once dirname(__DIR__) . '/config/Database.php';

class MatiereDAO
{
    protected ?PDO $db = null;

    public function __construct(?PDO $db = null)
    {
        $this->db = $db;
    }

    protected function getDB(): PDO
    {
        if ($this->db === null) {
            $this->db = Database::getConnection();
        }
        return $this->db;
    }

    public function afficherTous(): array
    {
        return $this->getDB()->query("SELECT * FROM matiere ORDER BY id_matiere ASC")->fetchAll();
    }

    public function ajouter(string $nom_matiere, string $description): bool
    {
        $stmt = $this->getDB()->prepare("INSERT INTO matiere (nom_matiere, description) VALUES (?, ?)");
        return $stmt->execute([$nom_matiere, $description]);
    }
}

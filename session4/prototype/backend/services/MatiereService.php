<?php
require_once __DIR__ . '/../dao/MatiereDAO.php';

class MatiereService
{
    private MatiereDAO $matiereDAO;

    public function __construct(?MatiereDAO $matiereDAO = null)
    {
        $this->matiereDAO = $matiereDAO ?? new MatiereDAO();
    }

    /**
     * @return Matiere[]
     */
    public function listerMatieres(): array
    {
        return $this->matiereDAO->findAll();
    }

    public function ajouterMatiere(string $nom, string $description): Matiere
    {
        $nom = trim($nom);
        $description = trim($description);

        if ($nom === '') {
            throw new InvalidArgumentException('Le nom de la matière est obligatoire.');
        }
        if ($description === '') {
            throw new InvalidArgumentException('La description de la matière est obligatoire.');
        }

        return $this->matiereDAO->save(new Matiere(0, $nom, $description));
    }
}

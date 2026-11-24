<?php 
    abstract class BaseService
    {
        protected function validateNomLength(string $nom_matiere): void {
            if (mb_strlen($nom_matiere) < 4) {
                throw new \InvalidArgumentException("Le nom de domaine doit contenir plus de 4 caractères");
            }
        }
    }

?>
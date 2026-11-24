CREATE DATABASE IF NOT EXISTS plateforme_de_cours;
USE plateforme_de_cours;

CREATE TABLE IF NOT EXISTS matiere (
    id_matiere INT AUTO_INCREMENT PRIMARY KEY,
    nom_matiere VARCHAR(255) NOT NULL,
    description TEXT NOT NULL
);

INSERT INTO matiere (nom_matiere, description) VALUES
('Informatique', 'Développement, réseaux et systèmes'),
('Finance', 'Comptabilité et gestion financière'),
('Marketing', 'Communication et stratégie digitale');

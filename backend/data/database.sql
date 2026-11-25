CREATE DATABASE IF NOT EXISTS plateforme_de_cours;
USE plateforme_de_cours;

CREATE TABLE IF NOT EXISTS matiere (
    id_matiere INT AUTO_INCREMENT PRIMARY KEY,
    nom_matiere VARCHAR(255) NOT NULL,
    description TEXT NOT NULL
);

INSERT INTO matiere (nom_matiere, description) VALUES
('PHP', 'Programmation côté serveur avec PHP'),
('JavaScript', 'Développement web avec JavaScript'),
('HTML & CSS', 'Création et mise en forme des pages web'),
('MySQL', 'Gestion et manipulation des bases de données'),
('Git & GitHub', 'Gestion des versions et collaboration');
<?php

$host = "localhost";
$dbname = "Plateforme_de_cours";
$username = "root";
$password = "ADMINE2345";

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8",
        $username,
        $password
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //echo "Connexion réussie !";

} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
<?php
require "Connexion.php";
$sql = "
SELECT 
    COURS.id_cours,
    COURS.titre,
    COURS.description,
    COURS.duree,
    COURS.image,
    FORMATEUR.nom,
    FORMATEUR.prenom,
    MATIERE.nom_matiere

FROM COURS

INNER JOIN FORMATEUR
ON COURS.id_formateur = FORMATEUR.id_formateur

INNER JOIN MATIERE
ON COURS.id_matiere = MATIERE.id_matiere
";
$stmt = $pdo->query($sql);

$cours = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>

<html lang="fr">

<head>

    <meta charset="UTF-8">

    <title>Plateforme de cours</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<header>

    <h1>Plateforme de cours</h1>

    <nav>

        <a href="index.php">Accueil</a>

        <a href="#">À propos</a>

        <a href="Admin/admin.php">Admin</a>

    </nav>

</header>


<main>

    <h2>Nos cours</h2>

    <div class="cours-container">

    <?php if (count($cours) > 0) { ?>

        <?php foreach ($cours as $cour) { ?>

            <div class="cours">

                <?php if (!empty($cour["image"])) { ?>
                    <img
                        src="<?= htmlspecialchars($cour["image"]) ?>"
                        alt="<?= htmlspecialchars($cour["titre"]) ?>"
                        class="cours-image"
                    >
                <?php } ?>

                <h3>
                    <?= htmlspecialchars($cour["titre"]) ?>
                </h3>

                <p>
                    <?= htmlspecialchars($cour["description"]) ?>
                </p>

                <p>
                    <strong>Durée :</strong>
                    <?= $cour["duree"] ?> minutes
                </p>

                <p>
                    <strong>Formateur :</strong>
                    <?= htmlspecialchars(
                        $cour["prenom"] . " " . $cour["nom"]
                    ) ?>
                </p>

                <p>
                    <strong>Matière :</strong>
                    <?= htmlspecialchars($cour["nom_matiere"]) ?>
                </p>

            </div>

        <?php } ?>

    <?php } else { ?>

        <p>Aucun cours trouvé.</p>

    <?php } ?>

</div>
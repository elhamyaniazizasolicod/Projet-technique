<?php

require_once "../connexion.php";

$sql = "
SELECT 
    COURS.id_cours,
    COURS.titre,
    COURS.duree,
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

    <title>Administration</title>

    <link rel="stylesheet" href="../style.css">

</head>

<body>

<header>

    <h1>Administration</h1>

    <nav>

        <a href="../index.php">Accueil</a>

        <a href="admin.php">Admin</a>

        <a href="ajouter.php">Ajouter un cours</a>

    </nav>

</header>


<main>

    <h2>Gestion des cours</h2>

    <a class="btn" href="ajouter.php">
        + Ajouter un cours
    </a>


    <table>

        <tr>

            <th>ID</th>
            <th>Titre</th>
            <th>Durée</th>
            <th>Formateur</th>
            <th>Matière</th>

        </tr>


        <?php foreach ($cours as $cour) { ?>

            <tr>

                <td>
                    <?= $cour["id_cours"] ?>
                </td>

                <td>
                    <?= htmlspecialchars($cour["titre"]) ?>
                </td>

                <td>
                    <?= $cour["duree"] ?> min
                </td>

                <td>
                    <?= htmlspecialchars(
                        $cour["prenom"] . " " . $cour["nom"]
                    ) ?>
                </td>

                <td>
                    <?= htmlspecialchars(
                        $cour["nom_matiere"]
                    ) ?>
                </td>

            </tr>

        <?php } ?>

    </table>

</main>

</body>

</html>
<?php

require_once __DIR__ . "/../connexion.php";

$formateurs = $pdo->query("
    SELECT * FROM FORMATEUR
    ORDER BY nom
")->fetchAll(PDO::FETCH_ASSOC);

$matieres = $pdo->query("
    SELECT * FROM MATIERE
    ORDER BY nom_matiere
")->fetchAll(PDO::FETCH_ASSOC);


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $titre = $_POST["titre"];
    $description = $_POST["description"];
    $duree = $_POST["duree"];
    $id_formateur = $_POST["id_formateur"];
    $id_matiere = $_POST["id_matiere"];
    $image = $_POST["image"];

    $sql = "
    INSERT INTO COURS
    (titre, description, duree, id_formateur, id_matiere,image)
    VALUES
    (:titre, :description, :duree, :id_formateur, :id_matiere, :image)
    ";

    $stmt = $pdo->prepare($sql);

   
        $stmt->execute([
            ":titre" => $titre,
            ":description" => $description,
            ":duree" => $duree,
            ":id_formateur" => $id_formateur,
            ":id_matiere" => $id_matiere,
            ":image" => $image
        ]);
   

    header("Location: admin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Ajouter un cours</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>

<header>
    <h1>Ajouter un cours</h1>

    <nav>
        <a href="../index.php">Accueil</a>
        <a href="admin.php">Admin</a>
    </nav>
</header>

<main>

    <h2>Nouveau cours</h2>

    <form method="POST">
        <label for=""></label>

        <label>Titre</label>
        <input type="text" name="titre" required>

        <label>Description</label>
        <textarea name="description"></textarea>
         
          <label>Image du cours</label>
        <input
            type="url"
            name="image"
            placeholder="https://exemple.com/image.jpg"
        >

        <label>Durée en minutes</label>
        <input type="number" name="duree" required>

        <label>Formateur</label>
        <select name="id_formateur" required>

            <option value="">Choisir un formateur</option>

            <?php foreach ($formateurs as $formateur) { ?>

                <option value="<?= $formateur["id_formateur"] ?>">
                    <?= htmlspecialchars($formateur["prenom"] . " " . $formateur["nom"]) ?>
                </option>

            <?php } ?>

        </select>

        <label>Matière</label>
        <select name="id_matiere" required>

            <option value="">Choisir une matière</option>

            <?php foreach ($matieres as $matiere) { ?>

                <option value="<?= $matiere["id_matiere"] ?>">
                    <?= htmlspecialchars($matiere["nom_matiere"]) ?>
                </option>

            <?php } ?>

        </select>

        <button type="submit">Ajouter le cours</button>

    </form>

</main>

</body>
</html>
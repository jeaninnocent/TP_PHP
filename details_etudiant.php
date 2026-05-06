<?php

include("config.php");

if(!isset($_GET['id_etudiant'])) {

    header("Location: liste_etudiant.php");

}

$id = $_GET['id_etudiant'];

$requete = $connexion->prepare(
    "SELECT * FROM etudiants WHERE id=?"
);

$requete->execute([$id]);

$etudiant = $requete->fetch();

$message = "";

// Upload image

if(isset($_POST['upload'])) {

    $nomImage = $_FILES['photo']['name'];

    $tmp_name = $_FILES['photo']['tmp_name'];

    move_uploaded_file(
        $tmp_name,
        "uploads/".$nomImage
    );

    $update = $connexion->prepare(
        "UPDATE etudiants SET photo=? WHERE id=?"
    );

    $update->execute([$nomImage, $id]);

    $message = "Photo ajoutée";

}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Détails étudiant</title>
</head>
<body>

<h1>Détails étudiant</h1>

<p><?= $message ?></p>

<p>Nom : <?= $etudiant['nom'] ?></p>

<p>Prénoms : <?= $etudiant['prenoms'] ?></p>

<p>Email : <?= $etudiant['email'] ?></p>

<?php if($etudiant['photo']) { ?>

<img
    src="uploads/<?= $etudiant['photo'] ?>"
    width="200"
>

<?php } ?>

<form method="POST" enctype="multipart/form-data">

    <input type="file" name="photo">

    <br><br>

    <button type="submit" name="upload">

        Ajouter image

    </button>

</form>

</body>
</html>
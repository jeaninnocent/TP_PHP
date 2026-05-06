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

if(isset($_POST['modifier'])) {

    $nom = htmlspecialchars($_POST['nom']);

    $prenoms = htmlspecialchars($_POST['prenoms']);

    $email = htmlspecialchars($_POST['email']);

    $update = $connexion->prepare(
        "UPDATE etudiants
         SET nom=?, prenoms=?, email=?
         WHERE id=?"
    );

    $update->execute([
        $nom,
        $prenoms,
        $email,
        $id
    ]);

    header("Location: liste_etudiant.php");

}

?>

<form method="POST">

<input
type="text"
name="nom"
value="<?= $etudiant['nom'] ?>"
>

<br><br>

<input
type="text"
name="prenoms"
value="<?= $etudiant['prenoms'] ?>"
>

<br><br>

<input
type="email"
name="email"
value="<?= $etudiant['email'] ?>"
>

<br><br>

<button type="submit" name="modifier">

Modifier

</button>

</form>
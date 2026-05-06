<?php

include("config.php");

if(!isset($_GET['id_etudiant'])) {

    header("Location: liste_etudiant.php");

}

$id = $_GET['id_etudiant'];

$delete = $connexion->prepare(
    "DELETE FROM etudiants WHERE id=?"
);

$delete->execute([$id]);

header("Location: liste_etudiant.php");

?>
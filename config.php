<?php

$host = "localhost";
$dbname = "esatic_tp_twin_2";
$user = "root";
$password = "";

try {

    $connexion = new PDO(
        "mysql:host=$host;dbname=$dbname",
        $user,
        $password
    );

    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e) {

    die("Erreur : " . $e->getMessage());

}

?>
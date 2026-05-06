<?php

include("config.php");

$message = "";

if(isset($_POST["valider"])) {

    if(
        !empty($_POST["nom_filiere"]) &&
        !empty($_POST["description_filiere"])
    ) {

        $nom_filiere = htmlspecialchars($_POST["nom_filiere"]);
        $description_filiere = htmlspecialchars($_POST["description_filiere"]);

        // Vérifier si la filière existe déjà

        $check = $connexion->prepare(
            "SELECT * FROM filieres WHERE nom_filiere = ?"
        );

        $check->execute([$nom_filiere]);

        if($check->rowCount() == 0) {

            // Insertion

            $requete = $connexion->prepare(
                "INSERT INTO filieres(nom_filiere, description_filiere)
                 VALUES(?, ?)"
            );

            $requete->execute([
                $nom_filiere,
                $description_filiere
            ]);

            $message = "Filière ajoutée avec succès";

        } else {

            $message = "Cette filière existe déjà";

        }

    } else {

        $message = "Veuillez remplir tous les champs";

    }

}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Ajout Filière</title>
</head>
<body>

<h1>Ajouter une filière</h1>

<p><?= $message ?></p>

<form method="POST">

    <input type="text"
           name="nom_filiere"
           placeholder="Nom filière">

    <br><br>

    <textarea
        name="description_filiere"
        placeholder="Description">
    </textarea>

    <br><br>

    <button type="submit" name="valider">
        Ajouter
    </button>

</form>

</body>
</html>
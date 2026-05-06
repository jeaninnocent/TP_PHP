<?php

include("config.php");

$message = "";

// Récupérer les filières

$filieres = $connexion->query(
    "SELECT * FROM filieres"
);

if(isset($_POST["valider"])) {

    if(
        !empty($_POST["nom"]) &&
        !empty($_POST["prenoms"]) &&
        !empty($_POST["email"])
    ) {

        // Sécurisation

        $nom = htmlspecialchars($_POST["nom"]);
        $prenoms = htmlspecialchars($_POST["prenoms"]);
        $sexe = htmlspecialchars($_POST["sexe"]);
        $email = htmlspecialchars($_POST["email"]);
        $contact = htmlspecialchars($_POST["contact"]);
        $quartier = htmlspecialchars($_POST["quartier"]);
        $id_filiere = htmlspecialchars($_POST["id_filiere"]);

        // Vérifier email

        $check = $connexion->prepare(
            "SELECT * FROM etudiants WHERE email = ?"
        );

        $check->execute([$email]);

        if($check->rowCount() == 0) {

            // Insertion

            $requete = $connexion->prepare(
                "INSERT INTO etudiants
                (nom, prenoms, sexe, email, contact, quartier, id_filiere)

                VALUES(?,?,?,?,?,?,?)"
            );

            $insert = $requete->execute([
                $nom,
                $prenoms,
                $sexe,
                $email,
                $contact,
                $quartier,
                $id_filiere
            ]);

            if($insert) {

                $message = "Etudiant ajouté avec succès";

            } else {

                $message = "Erreur lors de l'insertion";

            }

        } else {

            $message = "Cet email existe déjà";

        }

    } else {

        $message = "Veuillez remplir les champs";

    }

}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Ajout étudiant</title>
</head>
<body>

<h1>Ajouter un étudiant</h1>

<p><?= $message ?></p>

<form method="POST">

    <input type="text" name="nom" placeholder="Nom">
    <br><br>

    <input type="text" name="prenoms" placeholder="Prénoms">
    <br><br>

    <select name="sexe">

        <option value="M">Masculin</option>
        <option value="F">Féminin</option>

    </select>

    <br><br>

    <input type="email" name="email" placeholder="Email">
    <br><br>

    <input type="text" name="contact" placeholder="Contact">
    <br><br>

    <input type="text" name="quartier" placeholder="Quartier">
    <br><br>

    <select name="id_filiere">

        <?php while($filiere = $filieres->fetch()) { ?>

            <option value="<?= $filiere['id'] ?>">

                <?= $filiere['nom_filiere'] ?>

            </option>

        <?php } ?>

    </select>

    <br><br>

    <button type="submit" name="valider">

        Ajouter

    </button>

</form>

</body>
</html>
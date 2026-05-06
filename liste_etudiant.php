<?php

include("config.php");

$requete = $connexion->query(
    "SELECT * FROM etudiants"
);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Liste étudiants</title>
</head>
<body>

<h1>Liste des étudiants</h1>

<a href="ajout_etudiant.php">

    Ajouter un étudiant

</a>

<br><br>

<table border="1" cellpadding="10">

<tr>

    <th>ID</th>
    <th>Nom</th>
    <th>Prénoms</th>
    <th>Email</th>
    <th>Actions</th>

</tr>

<?php while($etudiant = $requete->fetch()) { ?>

<tr>

    <td><?= $etudiant['id'] ?></td>

    <td><?= $etudiant['nom'] ?></td>

    <td><?= $etudiant['prenoms'] ?></td>

    <td><?= $etudiant['email'] ?></td>

    <td>

        <a href="details_etudiant.php?id_etudiant=<?= $etudiant['id'] ?>">
            Voir
        </a>

        |

        <a href="modifier_etudiant.php?id_etudiant=<?= $etudiant['id'] ?>">
            Modifier
        </a>

        |

        <a href="supprimer_etudiant.php?id_etudiant=<?= $etudiant['id'] ?>">
            Supprimer
        </a>

    </td>

</tr>

<?php } ?>

</table>

</body>
</html>
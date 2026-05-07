<?php

include("config.php");

$message = "";

// Récupérer les filières
$filieres = $connexion->query("SELECT * FROM filieres");

if(isset($_POST["valider"])) {

    if(
        !empty($_POST["nom"]) &&
        !empty($_POST["prenoms"]) &&
        !empty($_POST["email"])
    ) {

        $nom = htmlspecialchars(trim($_POST["nom"]));
        $prenoms = htmlspecialchars(trim($_POST["prenoms"]));
        $sexe = htmlspecialchars(trim($_POST["sexe"]));
        $email = htmlspecialchars(trim($_POST["email"]));
        $contact = htmlspecialchars(trim($_POST["contact"]));
        $quartier = htmlspecialchars(trim($_POST["quartier"]));
        $id_filiere = htmlspecialchars(trim($_POST["id_filiere"]));
        $presentation = htmlspecialchars(trim($_POST["presentation"]));

        $check = $connexion->prepare("SELECT * FROM etudiants WHERE email = ?");
        $check->execute([$email]);

        if($check->rowCount() == 0) {

            $requete = $connexion->prepare(
                "INSERT INTO etudiants
                (nom, prenoms, sexe, email, contact, quartier, id_filiere, presentation)
                VALUES(?,?,?,?,?,?,?,?)"
            );

            $insert = $requete->execute([
                $nom,
                $prenoms,
                $sexe,
                $email,
                $contact,
                $quartier,
                $id_filiere,
                $presentation
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
        $message = "Veuillez remplir les champs obligatoires";
    }

}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un étudiant</title>
    <style>
        :root {
            color-scheme: light;
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 16px;
        }
        * {
            box-sizing: border-box;
        }
        body {
            margin: 0;
            min-height: 100vh;
            background: radial-gradient(circle at top left, rgba(111, 123, 255, 0.18), transparent 30%),
                        radial-gradient(circle at bottom right, rgba(79, 101, 237, 0.14), transparent 25%),
                        linear-gradient(180deg, #eef2ff 0%, #f8fbff 100%);
            color: #142245;
        }
        .container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px 20px;
        }
        .card {
            width: min(100%, 860px);
            background: #ffffff;
            border: 1px solid rgba(111, 123, 255, 0.22);
            border-radius: 26px;
            box-shadow: 0 24px 70px rgba(46, 71, 139, 0.1);
            overflow: hidden;
        }
        .card-header {
            padding: 32px 34px 24px;
            text-align: center;
        }
        .card-header h1 {
            margin: 0;
            font-size: clamp(2.2rem, 3vw, 3rem);
            letter-spacing: -0.04em;
            text-transform: uppercase;
            color: #121d3d;
        }
        .card-body {
            padding: 32px 36px 40px;
        }
        .sub-link {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 28px;
            color: #4f5aed;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.98rem;
        }
        .message {
            margin-bottom: 24px;
            padding: 16px 18px;
            border-radius: 16px;
            border: 1px solid rgba(79, 90, 255, 0.22);
            background: rgba(79, 90, 255, 0.08);
            color: #1f2e61;
            font-weight: 600;
        }
        .form-grid {
            display: grid;
            grid-template-columns: 180px minmax(0, 1fr);
            gap: 18px 24px;
            align-items: center;
        }
        .form-row {
            display: contents;
        }
        .form-label {
            display: flex;
            align-items: center;
            font-weight: 700;
            color: #4d5c7d;
            padding-left: 6px;
        }
        .form-field {
            display: flex;
            justify-content: flex-start;
        }
        .form-row.full-width .form-label {
            grid-column: 1 / -1;
            padding-left: 0;
            margin-bottom: 8px;
        }
        .form-row.full-width .form-field {
            grid-column: 1 / -1;
        }
        .form-row input,
        .form-row select,
        .form-row textarea {
            width: 100%;
            border: 1px solid rgba(111, 123, 255, 0.25);
            border-radius: 14px;
            padding: 16px 18px;
            font-size: 0.97rem;
            color: #1f2d56;
            background: #f8faff;
            transition: border-color 0.25s ease, box-shadow 0.25s ease, transform 0.25s ease;
        }
        .form-row input::placeholder,
        .form-row textarea::placeholder {
            color: #9ba3c0;
        }
        .form-row select {
            appearance: none;
            background-image: linear-gradient(45deg, transparent 50%, #6f7bff 50%),
                              linear-gradient(135deg, #6f7bff 50%, transparent 50%);
            background-position: calc(100% - 14px) calc(1em + 2px), calc(100% - 9px) calc(1em + 2px);
            background-size: 8px 8px, 8px 8px;
            background-repeat: no-repeat;
            padding-right: 44px;
        }
        .form-row input:focus,
        .form-row select:focus,
        .form-row textarea:focus {
            border-color: rgba(79, 90, 255, 0.9);
            box-shadow: 0 0 0 8px rgba(111, 123, 255, 0.12);
            outline: none;
            transform: translateY(-1px);
        }
        textarea {
            min-height: 140px;
            resize: vertical;
        }
        .actions {
            grid-column: 1 / -1;
            display: flex;
            justify-content: center;
            margin-top: 28px;
        }
        .button-primary {
            cursor: pointer;
            border: none;
            background: linear-gradient(135deg, #5b68ff 0%, #7e97ff 100%);
            color: #ffffff;
            padding: 14px 28px;
            border-radius: 14px;
            font-size: 1rem;
            font-weight: 700;
            box-shadow: 0 18px 30px rgba(83, 104, 255, 0.18);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .button-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 22px 34px rgba(83, 104, 255, 0.24);
        }
        @media (max-width: 780px) {
            .card {
                width: 100%;
                border-radius: 24px;
            }
            .card-body {
                padding: 28px 24px 34px;
            }
            .form-grid {
                grid-template-columns: 1fr;
            }
            .form-row.full-width .form-label,
            .form-row.full-width .form-field {
                grid-column: auto;
            }
            .form-row {
                display: grid;
            }
            .form-label {
                padding-left: 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h1>AJOUTER UN ÉTUDIANT EN BD</h1>
            </div>
            <div class="card-body">
                <a class="sub-link" href="liste_etudiant.php">Consulter la liste des étudiants</a>
                <?php if($message): ?>
                    <div class="message"><?= htmlspecialchars($message) ?></div>
                <?php endif; ?>
                <form method="POST">
                    <div class="form-grid">
                    <div class="form-row">
                        <div class="form-label"><label for="nom">Nom</label></div>
                        <div class="form-field"><input id="nom" type="text" name="nom" placeholder="Nom de l'étudiant" required></div>
                    </div>
                    <div class="form-row">
                        <div class="form-label"><label for="prenoms">Prénoms</label></div>
                        <div class="form-field"><input id="prenoms" type="text" name="prenoms" placeholder="Prénoms de l'étudiant" required></div>
                    </div>
                    <div class="form-row">
                        <div class="form-label"><label for="sexe">Sexe</label></div>
                        <div class="form-field"><select id="sexe" name="sexe" required>
                            <option value="">Choisir le genre</option>
                            <option value="M">Masculin</option>
                            <option value="F">Féminin</option>
                        </select></div>
                    </div>
                    <div class="form-row">
                        <div class="form-label"><label for="email">Email</label></div>
                        <div class="form-field"><input id="email" type="email" name="email" placeholder="Email de l'étudiant" required></div>
                    </div>
                    <div class="form-row">
                        <div class="form-label"><label for="contact">Contact</label></div>
                        <div class="form-field"><input id="contact" type="text" name="contact" placeholder="Contact de l'étudiant"></div>
                    </div>
                    <div class="form-row">
                        <div class="form-label"><label for="quartier">Quartier</label></div>
                        <div class="form-field"><input id="quartier" type="text" name="quartier" placeholder="Quartier de l'étudiant"></div>
                    </div>
                    <div class="form-row">
                        <div class="form-label"><label for="id_filiere">Filière</label></div>
                        <div class="form-field"><select id="id_filiere" name="id_filiere" required>
                            <option value="">Choisir la filière</option>
                            <?php while($filiere = $filieres->fetch()): ?>
                                <option value="<?= $filiere['id'] ?>"><?= htmlspecialchars($filiere['nom_filiere']) ?></option>
                            <?php endwhile; ?>
                        </select></div>
                    </div>
                    <div class="form-row full-width">
                        <div class="form-label"><label for="presentation">Présentation</label></div>
                        <div class="form-field"><textarea id="presentation" name="presentation" placeholder="Présentation de l'étudiant"></textarea></div>
                    </div>
                </div>
                <div class="actions">
                    <button class="button-primary" type="submit" name="valider">Valider</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

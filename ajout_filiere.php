<?php

include("config.php");

$message = "";

if(isset($_POST["valider"])) {

    if(
        !empty($_POST["nom_filiere"]) &&
        !empty($_POST["description_filiere"])
    ) {

        $nom_filiere = htmlspecialchars(trim($_POST["nom_filiere"]));
        $description_filiere = htmlspecialchars(trim($_POST["description_filiere"]));

        $check = $connexion->prepare(
            "SELECT * FROM filieres WHERE nom_filiere = ?"
        );
        $check->execute([$nom_filiere]);

        if($check->rowCount() == 0) {
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
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une filière</title>
    <style>
        :root {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color-scheme: light;
            font-size: 16px;
        }
        * {
            box-sizing: border-box;
        }
        body {
            margin: 0;
            min-height: 100vh;
            background: radial-gradient(circle at top left, rgba(109, 122, 255, 0.12), transparent 24%),
                        radial-gradient(circle at bottom right, rgba(96, 184, 255, 0.14), transparent 22%),
                        linear-gradient(180deg, #edf2ff 0%, #f3f7ff 48%, #eef4ff 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px;
            color: #1d2143;
        }
        .card {
            width: min(100%, 780px);
            background: linear-gradient(180deg, rgba(255,255,255,0.98), rgba(245,248,255,0.95));
            border: 1px solid rgba(117, 129, 255, 0.28);
            border-radius: 32px;
            box-shadow: 0 28px 70px rgba(34, 63, 137, 0.14);
            overflow: hidden;
            backdrop-filter: blur(10px);
        }
        .card-header {
            padding: 34px 40px 22px;
            text-align: left;
            border-bottom: 1px solid rgba(99, 118, 255, 0.16);
            position: relative;
            background: linear-gradient(135deg, rgba(92, 109, 255, 0.08), transparent 80%);
        }
        .card-header::before {
            content: "";
            position: absolute;
            left: 0;
            top: 28px;
            width: 8px;
            height: 64px;
            border-radius: 18px;
            background: linear-gradient(180deg, #4f6cff 0%, #8aa4ff 100%);
            box-shadow: 0 12px 24px rgba(79, 108, 255, 0.16);
        }
        .card-header h1 {
            margin: 0;
            margin-left: 18px;
            font-size: clamp(2rem, 4vw, 2.4rem);
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: #101f3d;
            line-height: 1.05;
        }
        .page-description {
            margin: 14px 0 0 18px;
            max-width: 680px;
            font-size: 1rem;
            color: #4d5578;
            opacity: 0.92;
            line-height: 1.6;
        }
        .card-body {
            padding: 30px 36px 36px;
        }
        .message {
            margin-bottom: 26px;
            padding: 18px 20px;
            border-radius: 16px;
            border: 1px solid rgba(74, 92, 255, 0.22);
            background: rgba(236, 239, 255, 0.78);
            color: #28305d;
            font-weight: 600;
        }
        .form-grid {
            display: grid;
            grid-template-columns: 210px minmax(0, 1fr);
            gap: 22px 24px;
            align-items: start;
        }
        .field-label {
            font-weight: 700;
            color: #3b4a7a;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-size: 0.78rem;
            padding-left: 10px;
        }
        .field-input,
        .field-textarea {
            width: 100%;
            border: 1px solid rgba(119, 138, 255, 0.28);
            border-radius: 16px;
            padding: 16px 18px;
            font-size: 0.98rem;
            background: #f6f8ff;
            color: #1d264b;
            transition: border-color 0.2s ease, box-shadow 0.25s ease;
        }
        .field-input::placeholder,
        .field-textarea::placeholder {
            color: rgba(29, 38, 75, 0.45);
        }
        .field-input:focus,
        .field-textarea:focus {
            border-color: #4f6cff;
            box-shadow: 0 0 0 10px rgba(79, 108, 255, 0.12);
            outline: none;
            background: #ffffff;
        }
        .field-textarea {
            min-height: 150px;
            resize: vertical;
            line-height: 1.6;
        }
        .form-actions {
            grid-column: 1 / -1;
            display: flex;
            justify-content: center;
            margin-top: 28px;
        }
        .btn-submit {
            border: none;
            border-radius: 24px;
            padding: 16px 40px;
            background: linear-gradient(135deg, #556bff 0%, #7b95ff 52%, #a6b6ff 100%);
            color: #ffffff;
            font-weight: 700;
            letter-spacing: 0.04em;
            cursor: pointer;
            box-shadow: 0 20px 36px rgba(64, 91, 221, 0.22);
            transition: transform 0.25s ease, box-shadow 0.25s ease, filter 0.25s ease;
        }
        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 22px 40px rgba(64, 91, 221, 0.28);
            filter: brightness(1.05);
        }
        @media (max-width: 760px) {
            .card {
                width: 100%;
                border-radius: 22px;
            }
            .card-header {
                text-align: center;
            }
            .card-header::before {
                display: none;
            }
            .card-header h1 {
                margin-left: 0;
            }
            .page-description {
                margin: 18px auto 0;
                text-align: center;
            }
            .form-grid {
                grid-template-columns: 1fr;
            }
            .field-label {
                padding-left: 0;
            }
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="card-header">
            <h1>AJOUTER UNE FILIÈRE EN BD</h1>
            <p class="page-description">Créez une nouvelle filière avec un formulaire épuré, moderne et agréable à utiliser.</p>
        </div>
        <div class="card-body">
            <?php if($message): ?>
                <div class="message"><?= htmlspecialchars($message) ?></div>
            <?php endif; ?>
            <form method="POST">
                <div class="form-grid">
                    <div class="field-label">
                        <label for="nom_filiere">Nom de la filière</label>
                    </div>
                    <div>
                        <input id="nom_filiere" class="field-input" type="text" name="nom_filiere" placeholder="Intitulé de la filière" required>
                    </div>
                    <div class="field-label">
                        <label for="description_filiere">Description de la filière</label>
                    </div>
                    <div>
                        <textarea id="description_filiere" class="field-textarea" name="description_filiere" placeholder="Description de la filière" required></textarea>
                    </div>
                    <div class="form-actions">
                        <button class="btn-submit" type="submit" name="valider">Valider</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

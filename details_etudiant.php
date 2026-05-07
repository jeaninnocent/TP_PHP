<?php

include("config.php");

if(!isset($_GET['id_etudiant'])) {
    header("Location: liste_etudiant.php");
    exit;
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
    if(!empty($_FILES['photo']['name'])) {
        $nomImage = basename($_FILES['photo']['name']);
        $tmp_name = $_FILES['photo']['tmp_name'];
        $destination = __DIR__ . "/uploads/" . $nomImage;
        move_uploaded_file($tmp_name, $destination);

        $update = $connexion->prepare(
            "UPDATE etudiants SET photo=? WHERE id=?"
        );
        $update->execute([$nomImage, $id]);
        $message = "Photo ajoutée avec succès";
        header("Location: details_etudiant.php?id_etudiant=" . $id);
        exit;
    } else {
        $message = "Veuillez sélectionner un fichier";
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Information étudiant</title>
    <style>
        :root {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color-scheme: light;
            font-size: 16px;
            background: #f4f7ff;
            color: #142245;
        }
        * {
            box-sizing: border-box;
        }
        body {
            margin: 0;
            min-height: 100vh;
            background: radial-gradient(circle at top left, rgba(94, 129, 255, 0.14), transparent 30%),
                        radial-gradient(circle at bottom right, rgba(79, 101, 237, 0.12), transparent 25%),
                        linear-gradient(180deg, #eef2ff 0%, #fbfdff 100%);
        }
        .page {
            width: min(100%, 1120px);
            margin: 0 auto;
            padding: 32px 24px 48px;
        }
        h1 {
            margin: 0;
            font-size: clamp(2rem, 3vw, 3rem);
            letter-spacing: -0.06em;
            text-transform: uppercase;
            color: #101f3f;
        }
        .top-link {
            display: inline-flex;
            margin: 18px 0 28px;
            color: #4f5aed;
            text-decoration: none;
            font-weight: 600;
        }
        .card {
            background: rgba(255,255,255,0.98);
            border: 1px solid rgba(111, 123, 255, 0.18);
            border-radius: 32px;
            box-shadow: 0 24px 70px rgba(58, 81, 170, 0.10);
            overflow: hidden;
        }
        .card-grid {
            display: grid;
            grid-template-columns: 360px minmax(0, 1fr);
            gap: 0;
        }
        .profile-panel {
            padding: 32px;
            background: linear-gradient(180deg, #eff3ff 0%, #ffffff 100%);
            text-align: center;
        }
        .avatar {
            width: 100%;
            max-width: 300px;
            aspect-ratio: 1 / 1;
            margin: 0 auto 24px;
            border-radius: 24px;
            background: #d9e0ff;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .avatar-placeholder {
            width: 70%;
            opacity: 0.32;
        }
        .image-title {
            margin: 0 0 16px;
            font-size: 1.15rem;
            font-weight: 700;
            color: #1d2f62;
        }
        .upload-form {
            display: grid;
            gap: 16px;
            padding: 0 16px;
        }
        .upload-input {
            display: block;
            width: 100%;
            border: 1px solid rgba(111, 123, 255, 0.5);
            border-radius: 14px;
            padding: 14px 16px;
            font-size: 0.95rem;
            background: #fbfcff;
        }
        .upload-button {
            border: none;
            border-radius: 14px;
            padding: 12px 24px;
            background: linear-gradient(135deg, #5468ff 0%, #7b95ff 100%);
            color: #ffffff;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 16px 30px rgba(84, 104, 255, 0.18);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .upload-button:hover {
            transform: translateY(-1px);
            box-shadow: 0 18px 34px rgba(84, 104, 255, 0.24);
        }
        .content-panel {
            padding: 32px 34px 34px;
        }
        .content-panel h2 {
            margin: 0 0 22px;
            font-size: 1.55rem;
            color: #1b2b55;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }
        .info-table td {
            padding: 14px 16px;
            border-bottom: 1px solid rgba(111, 123, 255, 0.12);
        }
        .info-table tr:last-child td {
            border-bottom: none;
        }
        .info-table td.label {
            width: 160px;
            font-weight: 700;
            color: #3f4a76;
            background: rgba(111, 123, 255, 0.05);
        }
        .info-table td.value {
            color: #24345d;
        }
        .edit-link {
            display: inline-flex;
            margin-top: 18px;
            padding: 12px 18px;
            border-radius: 999px;
            border: 1px solid rgba(79, 90, 255, 0.22);
            color: #4f5aed;
            text-decoration: none;
            font-weight: 700;
            transition: background 0.2s ease, transform 0.2s ease;
        }
        .edit-link:hover {
            background: rgba(79, 90, 255, 0.08);
            transform: translateY(-1px);
        }
        .message {
            margin: 0 0 18px;
            padding: 14px 16px;
            border-radius: 16px;
            border: 1px solid rgba(79, 90, 255, 0.22);
            background: rgba(111, 123, 255, 0.08);
            color: #1f2e61;
            font-weight: 600;
        }
        @media (max-width: 900px) {
            .card-grid {
                grid-template-columns: 1fr;
            }
            .profile-panel,
            .content-panel {
                padding: 28px;
            }
            .avatar {
                max-width: 240px;
            }
        }
        @media (max-width: 640px) {
            .page {
                padding: 24px 16px 36px;
            }
            .top-link {
                margin-bottom: 18px;
            }
            .upload-form {
                gap: 14px;
            }
            .info-table td {
                padding: 12px 14px;
            }
        }
    </style>
</head>
<body>
    <div class="page">
        <h1>INFORMATION ETUDIANT</h1>
        <a class="top-link" href="liste_etudiant.php">[ Consulter la liste des étudiants ]</a>
        <div class="card">
            <div class="card-grid">
                <div class="profile-panel">
                    <div class="avatar">
                        <?php if(!empty($etudiant['photo']) && file_exists(__DIR__ . '/uploads/' . $etudiant['photo'])): ?>
                            <img src="uploads/<?= htmlspecialchars($etudiant['photo']) ?>" alt="Photo etudiant">
                        <?php else: ?>
                            <svg class="avatar-placeholder" viewBox="0 0 256 256" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect width="256" height="256" rx="32" fill="#d9e0ff"/>
                                <path d="M128 128C150.091 128 168 110.091 168 88C168 65.909 150.091 48 128 48C105.909 48 88 65.909 88 88C88 110.091 105.909 128 128 128Z" fill="#a5b2ff"/>
                                <path d="M62.9091 218C62.9091 176.253 96.2534 144 136 144C175.747 144 209.091 176.253 209.091 218" stroke="#a5b2ff" stroke-width="24" stroke-linecap="round"/>
                            </svg>
                        <?php endif; ?>
                    </div>
                    <div class="image-title">Enregistrement d'une image</div>
                    <?php if($message): ?>
                        <div class="message"><?= htmlspecialchars($message) ?></div>
                    <?php endif; ?>
                    <form class="upload-form" method="POST" enctype="multipart/form-data">
                        <input class="upload-input" type="file" name="photo" accept="image/*">
                        <button class="upload-button" type="submit" name="upload">Valider</button>
                    </form>
                </div>
                <div class="content-panel">
                    <h2>Informations</h2>
                    <table class="info-table">
                        <tr>
                            <td class="label">Id</td>
                            <td class="value"><?= htmlspecialchars($etudiant['id']) ?></td>
                        </tr>
                        <tr>
                            <td class="label">Nom</td>
                            <td class="value"><?= htmlspecialchars($etudiant['nom']) ?></td>
                        </tr>
                        <tr>
                            <td class="label">Prénoms</td>
                            <td class="value"><?= htmlspecialchars($etudiant['prenoms']) ?></td>
                        </tr>
                        <tr>
                            <td class="label">Genre</td>
                            <td class="value"><?= htmlspecialchars($etudiant['sexe']) ?></td>
                        </tr>
                        <tr>
                            <td class="label">Email</td>
                            <td class="value"><?= htmlspecialchars($etudiant['email']) ?></td>
                        </tr>
                        <tr>
                            <td class="label">Quartier</td>
                            <td class="value"><?= htmlspecialchars($etudiant['quartier']) ?></td>
                        </tr>
                        <tr>
                            <td class="label">Contact</td>
                            <td class="value"><?= htmlspecialchars($etudiant['contact']) ?></td>
                        </tr>
                    </table>
                    <a class="edit-link" href="modifier_etudiant.php?id_etudiant=<?= htmlspecialchars($etudiant['id']) ?>">Modifier informations étudiant</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

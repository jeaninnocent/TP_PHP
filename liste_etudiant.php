<?php

include("config.php");

$requete = $connexion->query(
    "SELECT * FROM etudiants"
);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des étudiants</title>
    <style>
        :root {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 16px;
            color-scheme: light;
        }
        * {
            box-sizing: border-box;
        }
        body {
            margin: 0;
            min-height: 100vh;
            background: radial-gradient(circle at top left, rgba(79, 101, 237, 0.18), transparent 32%),
                        radial-gradient(circle at bottom right, rgba(111, 123, 255, 0.12), transparent 24%),
                        linear-gradient(180deg, #f7f9ff 0%, #eef4ff 100%);
            color: #15263c;
        }
        .page {
            width: min(100%, 1180px);
            margin: 0 auto;
            padding: 32px 24px;
        }
        .page-header {
            display: flex;
            flex-wrap: wrap;
            align-items: flex-end;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 28px;
        }
        .page-header h1 {
            margin: 0;
            font-size: clamp(2.1rem, 2.8vw, 2.6rem);
            letter-spacing: -0.04em;
        }
        .page-header a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 14px 22px;
            border-radius: 999px;
            background: linear-gradient(135deg, #5a6bff 0%, #7c8bff 100%);
            color: #fff;
            text-decoration: none;
            font-weight: 700;
            box-shadow: 0 16px 32px rgba(84, 104, 255, 0.18);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .page-header a:hover {
            transform: translateY(-2px);
            box-shadow: 0 22px 38px rgba(84, 104, 255, 0.24);
        }
        .table-card {
            background: rgba(255,255,255,0.98);
            border: 1px solid rgba(111, 123, 255, 0.16);
            border-radius: 28px;
            box-shadow: 0 28px 80px rgba(46, 71, 139, 0.08);
            overflow: hidden;
        }
        .table-card header {
            padding: 28px 32px 0;
        }
        .table-card p {
            margin: 0;
            color: #4f5c7a;
            line-height: 1.7;
            max-width: 680px;
        }
        .table-wrapper {
            overflow-x: auto;
            padding: 0 16px 18px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 720px;
        }
        thead {
            background: linear-gradient(90deg, rgba(90, 107, 255, 0.12), rgba(111, 123, 255, 0.06));
        }
        th, td {
            padding: 16px 18px;
            text-align: left;
            border-bottom: 1px solid rgba(111, 123, 255, 0.12);
        }
        th {
            font-size: 0.95rem;
            font-weight: 700;
            color: #2c3865;
            letter-spacing: 0.02em;
        }
        tbody tr {
            transition: background 0.2s ease;
        }
        tbody tr:hover {
            background: rgba(90, 107, 255, 0.05);
        }
        td:first-child {
            font-weight: 700;
            color: #2f3c72;
        }
        td:nth-child(4), td:nth-child(5), td:nth-child(6), td:nth-child(7) {
            color: #4a5678;
        }
        .actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }
        .actions a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 8px 14px;
            border-radius: 999px;
            text-decoration: none;
            color: #4f5aed;
            border: 1px solid rgba(79, 90, 255, 0.22);
            transition: background 0.2s ease, color 0.2s ease, transform 0.2s ease;
        }
        .actions a:hover {
            background: rgba(79, 90, 255, 0.08);
            transform: translateY(-1px);
        }
        .actions a.delete {
            color: #d94864;
            border-color: rgba(217, 72, 100, 0.22);
        }
        .actions a.delete:hover {
            background: rgba(217, 72, 100, 0.08);
        }
        @media (max-width: 980px) {
            .page-header {
                flex-direction: column;
                align-items: flex-start;
            }
            table {
                min-width: 100%;
            }
        }
        @media (max-width: 720px) {
            .page {
                padding: 20px 16px;
            }
            .table-wrapper {
                padding: 0;
            }
            table,
            thead,
            tbody,
            th,
            td,
            tr {
                display: block;
            }
            thead tr {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }
            tr {
                margin-bottom: 18px;
                border-radius: 20px;
                background: #ffffff;
                box-shadow: 0 12px 28px rgba(46, 71, 139, 0.08);
                overflow: hidden;
            }
            td {
                border: none;
                display: flex;
                justify-content: space-between;
                padding: 14px 18px;
            }
            td::before {
                content: attr(data-label);
                font-weight: 700;
                color: #56608f;
            }
            td:last-child {
                padding-bottom: 18px;
            }
            .actions {
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="page-header">
            <div>
                <h1>Liste des étudiants</h1>
                <p>Visualisez les étudiants enregistrés avec leurs informations principales et actions disponibles.</p>
            </div>
            <a href="ajout_etudiant.php">Ajouter un étudiant</a>
        </div>
        <div class="table-card">
            <header>
                <p>Voici la liste des étudiants actuellement enregistrés dans la base de données.</p>
            </header>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nom</th>
                            <th>Prénoms</th>
                            <th>Genre</th>
                            <th>Email</th>
                            <th>Quartier</th>
                            <th>Contact</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($etudiant = $requete->fetch()): ?>
                            <tr>
                                <td data-label="Id"><?= htmlspecialchars($etudiant['id']) ?></td>
                                <td data-label="Nom"><?= htmlspecialchars($etudiant['nom']) ?></td>
                                <td data-label="Prénoms"><?= htmlspecialchars($etudiant['prenoms']) ?></td>
                                <td data-label="Genre"><?= htmlspecialchars($etudiant['sexe']) ?></td>
                                <td data-label="Email"><?= htmlspecialchars($etudiant['email']) ?></td>
                                <td data-label="Quartier"><?= htmlspecialchars($etudiant['quartier']) ?></td>
                                <td data-label="Contact"><?= htmlspecialchars($etudiant['contact']) ?></td>
                                <td data-label="Actions">
                                    <div class="actions">
                                        <a href="details_etudiant.php?id_etudiant=<?= $etudiant['id'] ?>">Voir plus</a>
                                        <a href="modifier_etudiant.php?id_etudiant=<?= $etudiant['id'] ?>">Modifier</a>
                                        <a class="delete" href="supprimer_etudiant.php?id_etudiant=<?= $etudiant['id'] ?>">Supprimer</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>

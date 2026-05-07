-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 07 mai 2026 à 02:28
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

START TRANSACTION;

SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */
;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */
;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */
;
/*!40101 SET NAMES utf8mb4 */
;

--
-- Base de données : `esatic_tp_twin_2`
--

-- --------------------------------------------------------

--
-- Structure de la table `etudiants`
--

CREATE TABLE `etudiants` (
    `id` int(11) NOT NULL,
    `nom` varchar(45) NOT NULL,
    `prenoms` varchar(45) NOT NULL,
    `sexe` enum('M', 'F') DEFAULT NULL,
    `email` varchar(45) NOT NULL,
    `contact` varchar(20) DEFAULT NULL,
    `quartier` varchar(45) DEFAULT NULL,
    `presentation` longtext DEFAULT NULL,
    `photo` varchar(100) DEFAULT NULL,
    `id_filiere` int(11) DEFAULT NULL,
    `created_at` datetime NOT NULL DEFAULT current_timestamp(),
    `updated_at` datetime DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

--
-- Déchargement des données de la table `etudiants`
--

INSERT INTO
    `etudiants` (
        `id`,
        `nom`,
        `prenoms`,
        `sexe`,
        `email`,
        `contact`,
        `quartier`,
        `presentation`,
        `photo`,
        `id_filiere`,
        `created_at`,
        `updated_at`
    )
VALUES (
        1,
        'BOUA',
        'EDWIGE',
        'F',
        'bouaedwige@gmail.com',
        '0701010101',
        'Bingerville',
        NULL,
        'WIN_20251016_18_05_08_Pro.jpg',
        NULL,
        '2026-04-22 21:54:51',
        NULL
    ),
    (
        2,
        'GNIENLYOMOU JEAN INNOCENT',
        'OUATTARA',
        'M',
        'gnienlyomoujeaninnocent@gmail.com',
        '0710613567',
        'treichville',
        NULL,
        'fejufegfegfefe.jpg',
        1,
        '2026-05-06 23:55:25',
        NULL
    );

-- --------------------------------------------------------

--
-- Structure de la table `filieres`
--

CREATE TABLE `filieres` (
    `id` int(11) NOT NULL,
    `nom_filiere` varchar(100) NOT NULL,
    `description_filiere` varchar(255) DEFAULT NULL,
    `created_at` datetime DEFAULT current_timestamp(),
    `updated_at` datetime DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

--
-- Déchargement des données de la table `filieres`
--

INSERT INTO
    `filieres` (
        `id`,
        `nom_filiere`,
        `description_filiere`,
        `created_at`,
        `updated_at`
    )
VALUES (
        1,
        'TWIN',
        'Technologies du Web et Image Numérique',
        '2026-04-22 21:52:40',
        NULL
    ),
    (
        2,
        'SRIT',
        '    Système réseaux informatiques et télécommunications ',
        '2026-05-06 23:38:50',
        NULL
    );

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `etudiants`
--
ALTER TABLE `etudiants`
ADD PRIMARY KEY (`id`),
ADD UNIQUE KEY `email` (`email`),
ADD KEY `id_filiere` (`id_filiere`);

--
-- Index pour la table `filieres`
--
ALTER TABLE `filieres` ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `etudiants`
--
ALTER TABLE `etudiants`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 4;

--
-- AUTO_INCREMENT pour la table `filieres`
--
ALTER TABLE `filieres`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 3;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */
;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */
;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */
;
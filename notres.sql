-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 13 juil. 2023 à 19:20
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `notres`
--

-- --------------------------------------------------------

--
-- Structure de la table `absence`
--

CREATE TABLE `absence` (
  `id` int(11) NOT NULL,
  `heure` varchar(50) DEFAULT NULL,
  `etudiant_id` int(11) DEFAULT NULL,
  `classe_id` int(11) DEFAULT NULL,
  `date_absence` date DEFAULT NULL,
  `motif` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `absence`
--

INSERT INTO `absence` (`id`, `heure`, `etudiant_id`, `classe_id`, `date_absence`, `motif`) VALUES
(3, '8H-10h', 3, 1, '2023-12-12', 'MALADE'),
(5, NULL, NULL, NULL, NULL, NULL),
(6, NULL, NULL, NULL, NULL, NULL),
(7, NULL, NULL, NULL, NULL, NULL),
(9, NULL, NULL, NULL, NULL, NULL),
(11, NULL, NULL, NULL, NULL, NULL),
(12, '8H-10h', 1, 1, '0223-12-12', 'MALADE'),
(13, '10h-12h', 1, 1, '2023-02-21', 'INJUSTIFIER'),
(14, '12H-14h', 1, 1, '2023-07-12', 'INJUSTIFIER');

-- --------------------------------------------------------

--
-- Structure de la table `administrateurs`
--

CREATE TABLE `administrateurs` (
  `id` int(11) NOT NULL,
  `nom_utilisateur` varchar(50) DEFAULT NULL,
  `mot_de_passe` varchar(50) DEFAULT NULL,
  `ecole_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `administrateurs`
--

INSERT INTO `administrateurs` (`id`, `nom_utilisateur`, `mot_de_passe`, `ecole_id`) VALUES
(1, 'okhassan', 'passer', 1),
(2, 'dadiok', 'passer', 2);

-- --------------------------------------------------------

--
-- Structure de la table `classes`
--

CREATE TABLE `classes` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `ecole_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `classes`
--

INSERT INTO `classes` (`id`, `nom`, `ecole_id`) VALUES
(1, 'licence2 Genie Informatique B', 1),
(2, 'licence3 en droit publique', 2),
(3, 'Licence3 GENIE INFORMATIQUE A', 1),
(4, 'LICENCE1 EN GENIE CIVIL B', 1);

-- --------------------------------------------------------

--
-- Structure de la table `cours`
--

CREATE TABLE `cours` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `cours`
--

INSERT INTO `cours` (`id`, `nom`) VALUES
(1, 'java'),
(2, 'python'),
(3, 'MATH'),
(4, 'ANGLAIS'),
(5, 'algorithme'),
(6, 'informatique'),
(7, 'html'),
(8, 'cisco'),
(9, 'rien');

-- --------------------------------------------------------

--
-- Structure de la table `ecoles`
--

CREATE TABLE `ecoles` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `ecoles`
--

INSERT INTO `ecoles` (`id`, `nom`) VALUES
(1, 'unipro'),
(2, 'sahel');

-- --------------------------------------------------------

--
-- Structure de la table `emploi_temps`
--

CREATE TABLE `emploi_temps` (
  `id` int(11) NOT NULL,
  `heure` varchar(50) DEFAULT NULL,
  `matiere_lundi` varchar(50) DEFAULT NULL,
  `matiere_mardi` varchar(50) DEFAULT NULL,
  `matiere_mercredi` varchar(50) DEFAULT NULL,
  `matiere_jeudi` varchar(50) DEFAULT NULL,
  `matiere_vendredi` varchar(50) DEFAULT NULL,
  `matiere_samedi` varchar(50) DEFAULT NULL,
  `classe_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `emploi_temps`
--

INSERT INTO `emploi_temps` (`id`, `heure`, `matiere_lundi`, `matiere_mardi`, `matiere_mercredi`, `matiere_jeudi`, `matiere_vendredi`, `matiere_samedi`, `classe_id`) VALUES
(1, '8h-10h', 'anglais', 'anglais', 'h.g', 'francais', 'algorithme', 'chinois', 1),
(2, '10h-12h', 'java', '', '', '', '', '', 1),
(3, '12H-14h', 'java', '', 'html', '', 'algorithme', '', 1),
(4, '14h-16h', '', 'anglais', '', 'math', '', '', 1),
(5, '16h-18h', '', '', '', '', '', '', 1),
(6, '8h-10h', 'math', NULL, NULL, NULL, NULL, NULL, 3),
(7, '10h:12h', 'ANGLIS', NULL, NULL, NULL, NULL, NULL, 3),
(8, '12H-14h', 'JAVA', NULL, NULL, NULL, NULL, NULL, 3),
(9, '14h-16h', NULL, NULL, NULL, NULL, NULL, NULL, 3);

-- --------------------------------------------------------

--
-- Structure de la table `etudiants`
--

CREATE TABLE `etudiants` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `nom_utilisateur` varchar(50) DEFAULT NULL,
  `mot_de_passe` varchar(50) DEFAULT NULL,
  `classe_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `etudiants`
--

INSERT INTO `etudiants` (`id`, `nom`, `prenom`, `nom_utilisateur`, `mot_de_passe`, `classe_id`) VALUES
(1, 'oki', 'hassan', 'okihassan', 'passer', 1),
(2, 'dadi', 'oki chaibe', 'dadi oki', 'passer', 2),
(3, 'hamoudi', 'ahmat idriss', 'hamoudi', 'passer', 1),
(4, 'mahamat', 'oki chaib', 'mahamat', 'passer', 1),
(5, 'guihini', 'dadi', 'guihini mht', 'passer', 3),
(6, 'colonel', 'mht', 'colonel mht', 'passer', 3);

-- --------------------------------------------------------

--
-- Structure de la table `heures`
--

CREATE TABLE `heures` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `heures`
--

INSERT INTO `heures` (`id`, `nom`) VALUES
(1, 'lundi'),
(2, 'mardi');

-- --------------------------------------------------------

--
-- Structure de la table `jours`
--

CREATE TABLE `jours` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `jours`
--

INSERT INTO `jours` (`id`, `nom`) VALUES
(1, 'lundi'),
(2, 'mardi');

-- --------------------------------------------------------

--
-- Structure de la table `notes`
--

CREATE TABLE `notes` (
  `id` int(11) NOT NULL,
  `etudiant_id` int(11) DEFAULT NULL,
  `cours_id` int(11) DEFAULT NULL,
  `note` float DEFAULT NULL,
  `note_examen` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `notes`
--

INSERT INTO `notes` (`id`, `etudiant_id`, `cours_id`, `note`, `note_examen`) VALUES
(3, 2, 1, 14, 13),
(5, 4, 2, 20, 0),
(6, 4, 3, 10, 10),
(8, 4, 4, 10, 10),
(12, 1, 1, 19, 18),
(14, 1, 2, 18, 19),
(15, 4, 5, 10, 10),
(16, 4, 8, 20, 20),
(18, 4, 1, 20, 20),
(21, 1, 6, 16, 19),
(22, 1, 5, 18, 14),
(49, 3, 1, 19, 19),
(50, 3, 4, 14, 19),
(51, 3, 8, 17, 16),
(52, 3, 1, 19, 19),
(53, 3, 4, 14, 19),
(54, 3, 8, 17, 16),
(55, 5, 1, 12, 18),
(56, 6, 5, 10, 0),
(57, 1, 3, 16, 0),
(58, 1, 7, 15, 0),
(59, 1, 8, 19, 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `absence`
--
ALTER TABLE `absence`
  ADD PRIMARY KEY (`id`),
  ADD KEY `etudiant_id` (`etudiant_id`),
  ADD KEY `classe_id` (`classe_id`);

--
-- Index pour la table `administrateurs`
--
ALTER TABLE `administrateurs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ecole_id` (`ecole_id`);

--
-- Index pour la table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ecole_id` (`ecole_id`);

--
-- Index pour la table `cours`
--
ALTER TABLE `cours`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `ecoles`
--
ALTER TABLE `ecoles`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `emploi_temps`
--
ALTER TABLE `emploi_temps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `classe_id` (`classe_id`);

--
-- Index pour la table `etudiants`
--
ALTER TABLE `etudiants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `classe_id` (`classe_id`);

--
-- Index pour la table `heures`
--
ALTER TABLE `heures`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `jours`
--
ALTER TABLE `jours`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `etudiant_id` (`etudiant_id`),
  ADD KEY `cours_id` (`cours_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `absence`
--
ALTER TABLE `absence`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `emploi_temps`
--
ALTER TABLE `emploi_temps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `heures`
--
ALTER TABLE `heures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `jours`
--
ALTER TABLE `jours`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `absence`
--
ALTER TABLE `absence`
  ADD CONSTRAINT `absence_ibfk_2` FOREIGN KEY (`etudiant_id`) REFERENCES `etudiants` (`id`),
  ADD CONSTRAINT `absence_ibfk_3` FOREIGN KEY (`classe_id`) REFERENCES `classes` (`id`);

--
-- Contraintes pour la table `administrateurs`
--
ALTER TABLE `administrateurs`
  ADD CONSTRAINT `administrateurs_ibfk_1` FOREIGN KEY (`ecole_id`) REFERENCES `ecoles` (`id`);

--
-- Contraintes pour la table `classes`
--
ALTER TABLE `classes`
  ADD CONSTRAINT `classes_ibfk_1` FOREIGN KEY (`ecole_id`) REFERENCES `ecoles` (`id`);

--
-- Contraintes pour la table `emploi_temps`
--
ALTER TABLE `emploi_temps`
  ADD CONSTRAINT `emploi_temps_ibfk_1` FOREIGN KEY (`classe_id`) REFERENCES `classes` (`id`);

--
-- Contraintes pour la table `etudiants`
--
ALTER TABLE `etudiants`
  ADD CONSTRAINT `etudiants_ibfk_1` FOREIGN KEY (`classe_id`) REFERENCES `classes` (`id`);

--
-- Contraintes pour la table `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `notes_ibfk_1` FOREIGN KEY (`etudiant_id`) REFERENCES `etudiants` (`id`),
  ADD CONSTRAINT `notes_ibfk_2` FOREIGN KEY (`cours_id`) REFERENCES `cours` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

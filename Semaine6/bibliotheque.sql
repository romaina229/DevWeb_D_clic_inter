-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mar. 11 nov. 2025 à 03:06
-- Version du serveur :  5.7.17
-- Version de PHP :  5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `bibliotheque`
--

-- --------------------------------------------------------

--
-- Structure de la table `lecteurs`
--

CREATE TABLE `lecteurs` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_inscription` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `lecteurs`
--

INSERT INTO `lecteurs` (`id`, `nom`, `prenom`, `email`, `date_inscription`) VALUES
(1, 'Dupont', 'Jean', 'jean.dupont@email.com', '2025-11-10 23:44:33'),
(2, 'Martin', 'Marie', 'marie.martin@email.com', '2025-11-10 23:44:33'),
(3, 'Bernard', 'Pierre', 'pierre.bernard@email.com', '2025-11-10 23:44:33'),
(4, 'Dubois', 'Sophie', 'sophie.dubois@email.com', '2025-11-10 23:44:33'),
(5, 'Moreau', 'Luc', 'luc.moreau@email.com', '2025-11-10 23:44:33'),
(6, 'Laurent', 'Isabelle', 'isabelle.laurent@email.com', '2025-11-10 23:44:33'),
(7, 'Simon', 'Michel', 'michel.simon@email.com', '2025-11-10 23:44:33'),
(8, 'Michel', 'Catherine', 'catherine.michel@email.com', '2025-11-10 23:44:33'),
(9, 'Lefebvre', 'Philippe', 'philippe.lefebvre@email.com', '2025-11-10 23:44:33'),
(10, 'Leroy', 'Jacqueline', 'jacqueline.leroy@email.com', '2025-11-10 23:44:33');

-- --------------------------------------------------------

--
-- Structure de la table `liste_lecture`
--

CREATE TABLE `liste_lecture` (
  `id` int(11) NOT NULL,
  `id_livre` int(11) NOT NULL,
  `id_lecteur` int(11) NOT NULL,
  `date_emprunt` date DEFAULT NULL,
  `date_retour` date DEFAULT NULL,
  `statut` enum('en_cours','termine') COLLATE utf8mb4_unicode_ci DEFAULT 'en_cours',
  `date_ajout` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `liste_lecture`
--

INSERT INTO `liste_lecture` (`id`, `id_livre`, `id_lecteur`, `date_emprunt`, `date_retour`, `statut`, `date_ajout`) VALUES
(1, 1, 1, '2024-01-15', '2024-02-01', 'termine', '2025-11-10 23:44:33'),
(2, 3, 1, '2024-02-10', NULL, 'en_cours', '2025-11-10 23:44:33'),
(3, 5, 1, '2024-01-20', '2024-02-05', 'termine', '2025-11-10 23:44:33'),
(4, 2, 2, '2024-02-01', NULL, 'en_cours', '2025-11-10 23:44:33'),
(5, 4, 2, '2024-01-25', '2024-02-10', 'termine', '2025-11-10 23:44:33'),
(6, 7, 3, '2024-02-05', NULL, 'en_cours', '2025-11-10 23:44:33'),
(7, 8, 4, '2024-01-30', NULL, 'en_cours', '2025-11-10 23:44:33'),
(8, 6, 5, '2024-02-08', NULL, 'en_cours', '2025-11-10 23:44:33'),
(9, 9, 6, '2024-02-03', NULL, 'en_cours', '2025-11-10 23:44:33'),
(10, 10, 7, '2024-01-28', '2024-02-12', 'termine', '2025-11-10 23:44:33'),
(11, 6, 1, '2025-11-11', NULL, 'en_cours', '2025-11-10 23:51:07'),
(12, 13, 1, '2025-11-11', NULL, 'en_cours', '2025-11-11 01:21:07'),
(13, 11, 1, '2025-11-11', NULL, 'en_cours', '2025-11-11 01:33:09');

-- --------------------------------------------------------

--
-- Structure de la table `livres`
--

CREATE TABLE `livres` (
  `id` int(11) NOT NULL,
  `titre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `auteur` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `maison_edition` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nombre_exemplaire` int(11) DEFAULT '1',
  `date_ajout` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `livres`
--

INSERT INTO `livres` (`id`, `titre`, `auteur`, `description`, `maison_edition`, `nombre_exemplaire`, `date_ajout`) VALUES
(1, 'L\'Étranger', 'Albert Camus', 'Roman existentialiste qui suit Meursault, un homme indifférent à tout sauf aux sensations physiques. Publié en 1942, ce roman est une œuvre majeure de la littérature française du XXe siècle.', 'Gallimard', 5, '2025-11-10 23:44:33'),
(2, '1984', 'George Orwell', 'Dystopie politique dépeignant un régime totalitaire où la liberté individuelle n\'existe plus. Une critique virulente des régimes totalitaires et une réflexion sur la surveillance de masse.', 'Penguin Books', 3, '2025-11-10 23:44:33'),
(3, 'Le Petit Prince', 'Antoine de Saint-Exupéry', 'Conte poétique et philosophique qui suit les voyages d\'un jeune prince à travers l\'univers. Un classique de la littérature jeunesse avec une profondeur philosophique.', 'Gallimard', 8, '2025-11-10 23:44:33'),
(4, 'Harry Potter à l\'École des Sorciers', 'J.K. Rowling', 'Premier tome de la saga Harry Potter, racontant la découverte du monde magique par un jeune sorcier. Une aventure fantastique qui a captivé des millions de lecteurs.', 'Bloomsbury', 7, '2025-11-10 23:44:33'),
(5, 'Madame Bovary', 'Gustave Flaubert', 'Roman réaliste qui suit la vie d\'Emma Bovary, une femme insatisfaite de sa vie provinciale et de son mariage. Une critique de la bourgeoisie du XIXe siècle.', 'Michel Lévy', 4, '2025-11-10 23:44:33'),
(6, 'Les Misérables', 'Victor Hugo', 'Fresque historique et sociale qui suit plusieurs personnages français sur une vingtaine d\'années au début du XIXe siècle. Un plaidoyer pour les déshérités.', 'A. Lacroix', 6, '2025-11-10 23:44:33'),
(7, 'Le Seigneur des Anneaux', 'J.R.R. Tolkien', 'Épopée fantasy qui suit la quête de Frodon Sacquet pour détruire l\'Anneau Unique. Une œuvre fondatrice de la fantasy moderne.', 'Allen & Unwin', 5, '2025-11-10 23:44:33'),
(8, 'Orgueil et Préjugés', 'Jane Austen', 'Roman qui explore les questions de mariage, de morale et d\'éducation dans la société anglaise du début du XIXe siècle. Une satire des mœurs de l\'époque.', 'T. Egerton', 4, '2025-11-10 23:44:33'),
(9, 'Cent ans de solitude', 'Gabriel García Márquez', 'Roman qui raconte l\'histoire de la famille Buendía sur plusieurs générations dans le village fictif de Macondo. Chef-d\'œuvre du réalisme magique.', 'Editorial Sudamericana', 3, '2025-11-10 23:44:33'),
(10, 'Crime et Châtiment', 'Fiodor Dostoïevski', 'Roman psychologique qui suit Raskolnikov, un étudiant qui commet un meurtre et doit faire face à sa culpabilité. Une plongée dans la psyché humaine.', 'The Russian Messenger', 2, '2025-11-10 23:44:33'),
(11, 'L\'Ã‰tranger', 'Albert Camus', 'Roman existentialiste qui suit Meursault, un homme indiffÃ©rent Ã  tout sauf aux sensations physiques. PubliÃ© en 1942, ce roman est une Å“uvre majeure de la littÃ©rature franÃ§aise du XXe siÃ¨cle.', 'Gallimard', 5, '2025-11-11 00:37:37'),
(12, '1984', 'George Orwell', 'Dystopie politique dÃ©peignant un rÃ©gime totalitaire oÃ¹ la libertÃ© individuelle n\'existe plus. Une critique virulente des rÃ©gimes totalitaires et une rÃ©flexion sur la surveillance de masse.', 'Penguin Books', 3, '2025-11-11 00:37:37'),
(13, 'Le Petit Prince', 'Antoine de Saint-ExupÃ©ry', 'Conte poÃ©tique et philosophique qui suit les voyages d\'un jeune prince Ã  travers l\'univers. Un classique de la littÃ©rature jeunesse avec une profondeur philosophique.', 'Gallimard', 8, '2025-11-11 00:37:37'),
(14, 'Harry Potter Ã  l\'Ã‰cole des Sorciers', 'J.K. Rowling', 'Premier tome de la saga Harry Potter, racontant la dÃ©couverte du monde magique par un jeune sorcier. Une aventure fantastique qui a captivÃ© des millions de lecteurs.', 'Bloomsbury', 7, '2025-11-11 00:37:37'),
(15, 'Madame Bovary', 'Gustave Flaubert', 'Roman rÃ©aliste qui suit la vie d\'Emma Bovary, une femme insatisfaite de sa vie provinciale et de son mariage. Une critique de la bourgeoisie du XIXe siÃ¨cle.', 'Michel LÃ©vy', 4, '2025-11-11 00:37:37'),
(16, 'Les MisÃ©rables', 'Victor Hugo', 'Fresque historique et sociale qui suit plusieurs personnages franÃ§ais sur une vingtaine d\'annÃ©es au dÃ©but du XIXe siÃ¨cle. Un plaidoyer pour les dÃ©shÃ©ritÃ©s.', 'A. Lacroix', 6, '2025-11-11 00:37:37'),
(17, 'Le Seigneur des Anneaux', 'J.R.R. Tolkien', 'Ã‰popÃ©e fantasy qui suit la quÃªte de Frodon Sacquet pour dÃ©truire l\'Anneau Unique. Une Å“uvre fondatrice de la fantasy moderne.', 'Allen & Unwin', 5, '2025-11-11 00:37:37'),
(18, 'Orgueil et PrÃ©jugÃ©s', 'Jane Austen', 'Roman qui explore les questions de mariage, de morale et d\'Ã©ducation dans la sociÃ©tÃ© anglaise du dÃ©but du XIXe siÃ¨cle. Une satire des mÅ“urs de l\'Ã©poque.', 'T. Egerton', 4, '2025-11-11 00:37:37'),
(19, 'Cent ans de solitude', 'Gabriel GarcÃ­a MÃ¡rquez', 'Roman qui raconte l\'histoire de la famille BuendÃ­a sur plusieurs gÃ©nÃ©rations dans le village fictif de Macondo. Chef-d\'Å“uvre du rÃ©alisme magique.', 'Editorial Sudamericana', 3, '2025-11-11 00:37:37'),
(20, 'Crime et ChÃ¢timent', 'Fiodor DostoÃ¯evski', 'Roman psychologique qui suit Raskolnikov, un Ã©tudiant qui commet un meurtre et doit faire face Ã  sa culpabilitÃ©. Une plongÃ©e dans la psychÃ© humaine.', 'The Russian Messenger', 2, '2025-11-11 00:37:37'),
(21, 'Romain essai', 'Lifero', 'Juste un essai de livre', 'RUE 102', 1, '2025-11-11 01:58:24'),
(22, 'Romain essai', 'Lifero', 'Juste un essai de livre', 'RUE 102', 1, '2025-11-11 01:58:45');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `lecteurs`
--
ALTER TABLE `lecteurs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_nom` (`nom`),
  ADD KEY `idx_email` (`email`);

--
-- Index pour la table `liste_lecture`
--
ALTER TABLE `liste_lecture`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_livre_lecteur` (`id_livre`,`id_lecteur`),
  ADD KEY `idx_lecteur` (`id_lecteur`),
  ADD KEY `idx_date_emprunt` (`date_emprunt`);

--
-- Index pour la table `livres`
--
ALTER TABLE `livres`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_titre` (`titre`),
  ADD KEY `idx_auteur` (`auteur`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `lecteurs`
--
ALTER TABLE `lecteurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT pour la table `liste_lecture`
--
ALTER TABLE `liste_lecture`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT pour la table `livres`
--
ALTER TABLE `livres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `liste_lecture`
--
ALTER TABLE `liste_lecture`
  ADD CONSTRAINT `liste_lecture_ibfk_1` FOREIGN KEY (`id_livre`) REFERENCES `livres` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `liste_lecture_ibfk_2` FOREIGN KEY (`id_lecteur`) REFERENCES `lecteurs` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

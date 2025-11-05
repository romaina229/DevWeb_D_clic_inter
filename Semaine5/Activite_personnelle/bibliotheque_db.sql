-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mer. 05 nov. 2025 à 00:12
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
-- Base de données :  `bibliotheque_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `livres`
--

CREATE TABLE `livres` (
  `id` int(11) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `auteur` varchar(255) NOT NULL,
  `annee_publication` int(11) DEFAULT NULL,
  `categorie` varchar(50) DEFAULT NULL,
  `image` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `livres`
--

INSERT INTO `livres` (`id`, `titre`, `auteur`, `annee_publication`, `categorie`, `image`) VALUES
(1, 'Vingt mille lieues sous les mers', 'Jules Verne', 1870, 'Science-fiction', 'vingt_mille_lieues.jpg'),
(2, 'Le Tour du monde en 80 jours', 'Jules Verne', 1872, 'Aventure', 'l_etranger.jpg'),
(3, 'Fondation', 'Isaac Asimov', 1951, 'Science-fiction', 'fondation.jpg'),
(4, 'Vingt mille lieues sous les mers', 'Jules Verne', 1870, 'Science-fiction', 'vingt_mille_lieues.jpg'),
(5, 'Dune', 'Frank Herbert', 1965, 'Science-fiction', 'dune.jpg'),
(6, 'le petit prince', 'Frank Herbert', 1965, 'Science-fiction', 'le_petit_prince.jpg'),
(7, 'Fondation', 'Isaac Asimov', 1951, 'Science-fiction', 'fondation.jpg'),
(8, 'Les Trois Mousquetaires', 'Alexandre Dumas', 1844, 'Romans historiques', 'trois_mousquetaires.jpg'),
(9, '1984', 'George Orwell', 1949, 'Dystopie', '1984.jpg'),
(10, 'Harry Potter à l école des sorciers', 'J.K. Rowling', 2001, 'Fantasy', 'harry_potter.jpg'),
(11, 'Fondation', 'Lifero GUEKPON', 2025, 'PoÃ©sie', 'les_miserabble.jpg'),
(12, 'Fondation', 'Lifero GUEKPON', 2025, 'PoÃ©sie', 'les_miserabble.jpg');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `livres`
--
ALTER TABLE `livres`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `livres`
--
ALTER TABLE `livres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

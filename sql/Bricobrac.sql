-- phpMyAdmin SQL Dump
-- version 5.2.1deb1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : lun. 30 oct. 2023 à 13:30
-- Version du serveur : 10.11.4-MariaDB-1~deb12u1
-- Version de PHP : 8.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `Bricobrac`
--

-- --------------------------------------------------------

--
-- Structure de la table `Articles`
--

CREATE TABLE `Articles` (
  `articlesId` int(11) NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `references` int(8) DEFAULT NULL,
  `prixHT` decimal(10,2) DEFAULT NULL,
  `TVA` int(2) DEFAULT NULL,
  `pourcentagePromotion` int(2) DEFAULT NULL,
  `nouveaute` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Articles`
--

INSERT INTO `Articles` (`articlesId`, `nom`, `references`, `prixHT`, `TVA`, `pourcentagePromotion`, `nouveaute`) VALUES
(1, 'marteau de menuisier bois verni', 81968453, 8.90, 20, NULL, 0),
(2, 'marteau massette fibre de verre', 80166978, 21.90, 20, NULL, 0),
(3, 'maillet de menuisier bois', 82039106, 14.90, 20, NULL, 0),
(4, 'marteau arrache-clou', 81968500, 12.90, 20, NULL, 0),
(5, 'tournevis électricien plat', 74936295, 1.95, 20, NULL, 1),
(6, 'tournevis électricien isolé plat', 67337361, 5.10, 20, NULL, 0),
(7, 'tournevis testeur de tension plat', 76292503, 2.90, 20, NULL, 0),
(8, 'tournevis sans fil', 81900760, 40.00, 20, NULL, 0),
(9, 'jeu de tournevis', 73923500, 34.90, 20, NULL, 1),
(10, 'tournevis cruciforme', 74936246, 3.20, 20, NULL, 0),
(11, 'jeu de tournevis torx', 74936372, 17.90, 20, 15, 0),
(12, 'tournevis boule cruciforme', 73708264, 3.95, 20, NULL, 0),
(13, 'scie de carreleur', 18850476, 9.95, 20, NULL, 0),
(14, 'lot de 2 lames pour scie à métaux', 70709401, 2.50, 20, 10, 0),
(15, 'scie à métaux', 70907452, 8.90, 20, NULL, 0),
(16, 'scie égoïne de charpentier', 70907354, 10.90, 20, NULL, 0),
(17, 'boîte à onglet manuelle', 70709653, 9.90, 20, NULL, 1),
(18, 'scie japonaise', 67998931, 18.90, 20, NULL, 0),
(19, 'scie à bûche', 63732655, 15.60, 20, NULL, 0),
(20, 'scie universelle', 70720265, 2.05, 20, NULL, 0),
(21, 'fourreau pour scie', 70709345, 3.90, 20, NULL, 0),
(22, 'scie à chantourner de plaquiste', 73550442, 5.99, 20, NULL, 0),
(23, 'pince coupante', 69241060, 39.00, 20, NULL, 0),
(24, 'pince à sertir les rails', 80150490, 24.90, 20, NULL, 0),
(25, 'pince à agraphage des profiles', 80124107, 55.00, 20, NULL, 0),
(26, 'pince à dénuder', 80125159, 8.90, 20, NULL, 0),
(27, 'pince-clé multiprise', 69587994, 49.90, 20, NULL, 1),
(28, 'pince coupe-mosaïque', 18699366, 19.90, 20, NULL, 0),
(29, 'pince perroquet', 18699345, 14.90, 20, NULL, 0),
(30, 'pince à cosse isolée', 70059913, 25.90, 20, NULL, 0),
(31, 'pince coupe-carrelage', 18699310, 9.90, 20, NULL, 0),
(32, 'pince à cintrer', 74669791, 20.40, 20, NULL, 0),
(33, 'pince coupe-boulons coupante', 80125144, 20.90, 20, NULL, 0),
(34, 'cisaille à tôle à ardoise coupe devant', 80125135, 10.90, 20, NULL, 0),
(35, 'pince pour collier de fixation', 66502576, 17.35, 20, NULL, 0),
(36, 'pince à bec', 80125154, 10.90, 20, NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `Users`
--

CREATE TABLE `Users` (
  `usersId` int(255) NOT NULL,
  `group` varchar(255) DEFAULT NULL,
  `mail` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `UsersInfos`
--

CREATE TABLE `UsersInfos` (
  `usersInfosId` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `surname` varchar(30) NOT NULL,
  `states` varchar(100) NOT NULL,
  `city` varchar(255) NOT NULL,
  `number` int(11) NOT NULL,
  `phone` int(10) NOT NULL,
  `accountCreation` date NOT NULL,
  `birthdate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Articles`
--
ALTER TABLE `Articles`
  ADD PRIMARY KEY (`articlesId`);

--
-- Index pour la table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`usersId`);

--
-- Index pour la table `UsersInfos`
--
ALTER TABLE `UsersInfos`
  ADD PRIMARY KEY (`usersInfosId`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `Articles`
--
ALTER TABLE `Articles`
  MODIFY `articlesId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT pour la table `Users`
--
ALTER TABLE `Users`
  MODIFY `usersId` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `UsersInfos`
--
ALTER TABLE `UsersInfos`
  MODIFY `usersInfosId` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `Users`
--
ALTER TABLE `Users`
  ADD CONSTRAINT `Users_ibfk_1` FOREIGN KEY (`usersId`) REFERENCES `UsersInfos` (`usersInfosId`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

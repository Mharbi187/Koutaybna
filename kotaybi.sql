-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Client: 127.0.0.1
-- Généré le: Dim 27 Avril 2025 à 20:29
-- Version du serveur: 5.5.27-log
-- Version de PHP: 5.4.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `kotaybi`
--

-- --------------------------------------------------------

--
-- Structure de la table `contact_messages`
--

CREATE TABLE IF NOT EXISTS `contact_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `listes`
--

CREATE TABLE IF NOT EXISTS `listes` (
  `id_liste` int(11) NOT NULL AUTO_INCREMENT,
  `nom_liste` varchar(100) NOT NULL,
  `id_createur` int(11) NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_modification` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_liste`),
  KEY `id_createur` (`id_createur`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `liste_partagee`
--

CREATE TABLE IF NOT EXISTS `liste_partagee` (
  `id_liste` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `role` enum('lecture','edition') NOT NULL DEFAULT 'lecture',
  `date_partage` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_liste`,`id_user`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `liste_produit`
--

CREATE TABLE IF NOT EXISTS `liste_produit` (
  `id_liste` int(11) NOT NULL,
  `id_produit` int(11) NOT NULL,
  `quantite` int(11) NOT NULL DEFAULT '1',
  `coche` tinyint(1) NOT NULL DEFAULT '0',
  `date_ajout` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_liste`,`id_produit`),
  KEY `id_produit` (`id_produit`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

CREATE TABLE IF NOT EXISTS `produits` (
  `id_produit` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `categorie` varchar(50) DEFAULT NULL,
  `photo-prod` blob NOT NULL,
  PRIMARY KEY (`id_produit`),
  UNIQUE KEY `nom` (`nom`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id_user`, `nom`, `email`, `mot_de_passe`, `role`, `date_creation`) VALUES
(1, 'Admin', 'admin@kotaybi.com', '$2y$10$YOUR_HASHED_PASSWORD', 'admin', '2025-04-27 04:01:19'),
(2, 'ala', 'amara.ala404@gmail.com', '$2y$10$d4919c88ce4854698069ceVxZvspOHaGA3ziA2Tl/JibSZQvuFmZq', 'admin', '2025-04-27 15:19:01'),
(3, 'Test User', 'user@test.com', '$2y$10$3zX8z7z7z7z7z7z7z7z7zu', 'user', '2025-04-27 16:26:38'),
(4, 'Admin User', 'admin@test.com', '$2y$10$3zX8z7z7z7z7z7z7z7z7zu', 'admin', '2025-04-27 16:26:38');

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `listes`
--
ALTER TABLE `listes`
  ADD CONSTRAINT `listes_ibfk_1` FOREIGN KEY (`id_createur`) REFERENCES `utilisateurs` (`id_user`) ON DELETE CASCADE;

--
-- Contraintes pour la table `liste_partagee`
--
ALTER TABLE `liste_partagee`
  ADD CONSTRAINT `liste_partagee_ibfk_1` FOREIGN KEY (`id_liste`) REFERENCES `listes` (`id_liste`) ON DELETE CASCADE,
  ADD CONSTRAINT `liste_partagee_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `utilisateurs` (`id_user`) ON DELETE CASCADE;

--
-- Contraintes pour la table `liste_produit`
--
ALTER TABLE `liste_produit`
  ADD CONSTRAINT `liste_produit_ibfk_1` FOREIGN KEY (`id_liste`) REFERENCES `listes` (`id_liste`) ON DELETE CASCADE,
  ADD CONSTRAINT `liste_produit_ibfk_2` FOREIGN KEY (`id_produit`) REFERENCES `produits` (`id_produit`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

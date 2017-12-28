-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Lun 12 Décembre 2016 à 14:56
-- Version du serveur :  10.1.16-MariaDB
-- Version de PHP :  5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `projetesi`
--

-- --------------------------------------------------------

--
-- Structure de la table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(100) NOT NULL,
  `date` date NOT NULL,
  `start` time NOT NULL,
  `end` time NOT NULL,
  `login` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `id_famille` int(11) NOT NULL,
  `Status` int(11) NOT NULL,
  `conflit` int(11) NOT NULL,
  `validation` int(11) NOT NULL,
  `tarif_horaire` int(11) NOT NULL,
  `phone` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Note` int(11) NOT NULL DEFAULT '0',
  `commentaire` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

CREATE TABLE `commentaire` (
  `ID` int(11) NOT NULL COMMENT 'associé à la clé de la table primaire Users',
  `emmeteur` int(11) NOT NULL,
  `destinataire` int(11) NOT NULL,
  `message` text NOT NULL,
  `note` int(11) NOT NULL,
  `moderation` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `contrat`
--

CREATE TABLE `contrat` (
  `ID` int(11) NOT NULL COMMENT 'ID des contrats',
  `etudiant` text NOT NULL,
  `famille` text NOT NULL,
  `horaire` date NOT NULL COMMENT 'plage horaire du contrat',
  `conflit` tinyint(1) NOT NULL COMMENT 'Conflit / Pas conflit'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Table contenant les missions effectué';

-- --------------------------------------------------------

--
-- Structure de la table `taux_site`
--

CREATE TABLE `taux_site` (
  `ID` int(11) NOT NULL,
  `periode` text NOT NULL,
  `valeur` float(10,1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `taux_site`
--

INSERT INTO `taux_site` (`ID`, `periode`, `valeur`) VALUES
(1, 'Nuit', 1.0),
(2, 'Fériés', 1.2),
(3, 'Commissions', 200.0),
(5, 'Week-end', 4.0),
(6, 'Enfant', 1.2);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `ID` int(255) NOT NULL COMMENT 'ID des users',
  `user_type` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT 'Type d''utilisateur ( Admin/ Etudiants / Famille)',
  `nom` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT 'Nom',
  `prenom` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT 'Prenom',
  `email` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT 'adresse email de l''utilisateur',
  `mdp` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT 'Mot de passe de l''utilisateur, doit etre crypté',
  `naissance` date DEFAULT NULL COMMENT 'Date de naissance de l''utilisateur, le système calculera et affichera l''age',
  `code_postal` text,
  `adresse` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT 'Adresse de l''utilisateur',
  `telephone` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT 'Numero de téléphone de l''utilisateur',
  `tarif` int(11) DEFAULT NULL COMMENT 'Tarif renseigné par l''étudiant. Le tarif affiché sera modifié grâce à la table taux',
  `id_edt` int(11) DEFAULT NULL COMMENT 'renvoi à la table EdT de l''étudiant',
  `cni` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT 'Numero carte d''identité de l''étudiant',
  `etudes` text,
  `permis` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT 'L''étudiant renseigne s''il a le permis',
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT 'Description personnel des utilisateurs',
  `enfants` int(11) DEFAULT NULL COMMENT 'Nb d''enfants',
  `date_enfants` date DEFAULT NULL COMMENT 'Date de naissance',
  `contrats_acceptes` int(11) NOT NULL DEFAULT '0' COMMENT 'Nb de contrat accepté',
  `contrats_annules` int(11) NOT NULL DEFAULT '0' COMMENT 'Nb de contrat annulé',
  `image` text NOT NULL,
  `moderation` bit(1) NOT NULL DEFAULT b'1',
  `tempsreponse` int(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`ID`, `user_type`, `nom`, `prenom`, `email`, `mdp`, `naissance`, `code_postal`, `adresse`, `telephone`, `tarif`, `id_edt`, `cni`, `etudes`, `permis`, `description`, `enfants`, `date_enfants`, `contrats_acceptes`, `contrats_annules`, `image`, `moderation`, `tempsreponse`) VALUES
(29, 'Famille', 'Marley', NULL, 'Bob@mail.com', '$2y$10$foyh/IIy2kXFelidjU7VHOuBVWMm8hqJszVrqmU/wF6zXwc36p5xO', NULL, '06525', ' 4 rue pignouf', '4545454545', NULL, NULL, NULL, NULL, NULL, '  ', 4, '0000-00-00', 0, 0, '3661295563508881479230268.png', b'0', 0),
(30, 'Super', NULL, NULL, 'titi@titi.com', '$2y$10$N.kTUm5v37BxtPZbU0xOmOp5e3KlfSwCWPAWVjjII8eW1jVC9mfKm', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '', b'1', 0),
(33, 'Etudiant', 'chagall', 'mark', 'mark@mark.com', '$2y$10$2z0mXdlGuoX/155h.8itCevltu.H7poLFIdCENv/PCKzFzvyA4mDi', '1924-11-13', '06500', '13 rue du fusin', '0500000089', 23, NULL, '23412341', '54', 'test', 'Description personnelle ...', NULL, NULL, 0, 0, '649999322602231479565119.png', b'0', 3),
(47, 'Etudiant', 'Malcom', 'Reese', 'Reese@mail.com', '$2y$10$19wE/4xjBAJ981N0XaYsfuxFAmU6KriuPxd6PniSnJHstTLQyh5mC', '1994-12-05', '06525', '75 Avenue de la Souris', '80085', 12, NULL, '2', 'Doctorant', 'Trotinette', 'Au chômage', NULL, NULL, 0, 0, '4299933969356201479812424.png', b'0', 0),
(48, 'Famille', 'Les Tuches', NULL, 'tuchesftw@mail.com', '$2y$10$EplR7GndRPeDy0uzo8eKuObqRROgwuWbsBxnLbHViYeGsv6HCzXO6', NULL, '98000', '1 Bd Larvotoo', '00377', NULL, NULL, NULL, NULL, NULL, 'On a gagné au loto ! ', 4, NULL, 0, 0, '8262726758542761479915847.jpeg', b'0', 0),
(51, 'Famille', 'Grunig', 'Hubert', 'hubert.grunig06@orange.fr', '$2y$10$ADGnxd8b0EeL3K24igFj2.pYK7bLBj2pj5rAyrDda.Zx7uIVyJdYO', '1991-07-29', '06000', '25 Bd Carabacel', '0672803184', NULL, NULL, '111111', 'bac+2', 'tank', '', 2, NULL, 0, 0, '8640217923772161480242103.jpeg', b'0', 0),
(54, 'Etudiant', 'Cherry', 'Blossom', 'cherry@mail.com', '$2y$10$Ioi9YVnYSs709JADbY1FLegS7YRAcPDMlL5X5KgYDIi1SeThkhVOu', '1986-02-28', '06555', '4 Rue du piaf', '6565654', 12, NULL, '5465654', '', '', '', NULL, NULL, 0, 0, '5669975635568631480763015.png', b'0', 9),
(55, 'Etudiant', 'joe', 'latruite', 'lol@lol.com', '$2y$10$I7OtHAWqRjLdTdH8DwH7S.RI6uFfpxJF5dNhOgafwkelB.xmh75xe', '1991-01-01', '06000', '06', '060606060', 23, NULL, '111111111', 'bac+3', 'tank', '', NULL, NULL, 0, 0, '317262066175591480874869.', b'0', 1);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `taux_site`
--
ALTER TABLE `taux_site`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=343;
--
-- AUTO_INCREMENT pour la table `commentaire`
--
ALTER TABLE `commentaire`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'associé à la clé de la table primaire Users', AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT pour la table `taux_site`
--
ALTER TABLE `taux_site`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(255) NOT NULL AUTO_INCREMENT COMMENT 'ID des users', AUTO_INCREMENT=56;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

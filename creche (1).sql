-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 27 mai 2025 à 13:31
-- Version du serveur : 8.3.0
-- Version de PHP : 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `creche`
--

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20250513085747', '2025-05-13 08:59:19', 107),
('DoctrineMigrations\\Version20250513134554', '2025-05-13 13:46:30', 182),
('DoctrineMigrations\\Version20250514145047', '2025-05-14 14:50:55', 57),
('DoctrineMigrations\\Version20250515071425', '2025-05-15 07:14:51', 114);

-- --------------------------------------------------------

--
-- Structure de la table `enfant`
--

DROP TABLE IF EXISTS `enfant`;
CREATE TABLE IF NOT EXISTS `enfant` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_naissance` date NOT NULL,
  `allergies` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `enfant`
--

INSERT INTO `enfant` (`id`, `nom`, `prenom`, `date_naissance`, `allergies`) VALUES
(5, 'godart', 'dfs', '2025-05-05', 'dffff'),
(6, 'godart', 'lisa', '2008-02-06', 'son pere'),
(9, 'godart', 'sddq', '2025-05-05', 'dsd');

-- --------------------------------------------------------

--
-- Structure de la table `enfant_responsable`
--

DROP TABLE IF EXISTS `enfant_responsable`;
CREATE TABLE IF NOT EXISTS `enfant_responsable` (
  `enfant_id` int NOT NULL,
  `responsable_id` int NOT NULL,
  PRIMARY KEY (`enfant_id`,`responsable_id`),
  KEY `IDX_8DCF0627450D2529` (`enfant_id`),
  KEY `IDX_8DCF062753C59D72` (`responsable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `enfant_responsable`
--

INSERT INTO `enfant_responsable` (`enfant_id`, `responsable_id`) VALUES
(5, 1),
(6, 2),
(9, 5);

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

DROP TABLE IF EXISTS `messenger_messages`;
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `presence`
--

DROP TABLE IF EXISTS `presence`;
CREATE TABLE IF NOT EXISTS `presence` (
  `id` int NOT NULL AUTO_INCREMENT,
  `enfant_id` int NOT NULL,
  `date` date NOT NULL,
  `heure_debut` time NOT NULL,
  `heure_fin` time NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_6977C7A5450D2529` (`enfant_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `presence`
--

INSERT INTO `presence` (`id`, `enfant_id`, `date`, `heure_debut`, `heure_fin`) VALUES
(1, 5, '2025-05-05', '07:00:00', '08:00:00'),
(2, 6, '2025-05-04', '13:30:00', '15:00:00'),
(3, 6, '2025-05-13', '09:30:00', '15:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `responsable`
--

DROP TABLE IF EXISTS `responsable`;
CREATE TABLE IF NOT EXISTS `responsable` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `responsable`
--

INSERT INTO `responsable` (`id`, `nom`, `prenom`, `telephone`, `email`) VALUES
(1, 'dffffffff', 'dddddddddddd', 'dddddddddddd', 'fabienetbarbara@cegetel.net'),
(2, 'godart', 'barbara', 'qdf', 'dq@kkf.fr'),
(3, 'fds', 'fd', 'fsd', 'fds@hh.fr'),
(4, 'fds', 'fd', 'fsd', 'fds@hh.fr'),
(5, 'ssssss', 'dddddd', '05566', 'fds1255@hh.fr');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `roles`, `password`, `email`) VALUES
(3, '[]', '$2y$13$HWq3Eh4yvGOJbFy5X3pAruumxDfFjCH5AC5ne5rvGIwqHgVRtpqCq', 'fabienetbarbara@cegetel.net'),
(6, '[]', '$2y$13$pkiH4J0fZ0IC2prZHsZFpOCjvne.c6GfRoX4fcFJ/DEzO1hcW6zd.', 'fabien7669@gmail.com');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `enfant_responsable`
--
ALTER TABLE `enfant_responsable`
  ADD CONSTRAINT `FK_8DCF0627450D2529` FOREIGN KEY (`enfant_id`) REFERENCES `enfant` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_8DCF062753C59D72` FOREIGN KEY (`responsable_id`) REFERENCES `responsable` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `presence`
--
ALTER TABLE `presence`
  ADD CONSTRAINT `FK_6977C7A5450D2529` FOREIGN KEY (`enfant_id`) REFERENCES `enfant` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

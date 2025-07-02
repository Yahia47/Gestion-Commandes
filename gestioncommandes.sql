-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 02 juil. 2025 à 15:45
-- Version du serveur : 8.0.40
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestioncommandes`
--

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

CREATE TABLE `article` (
  `id_article` int NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  `prix_unitaire` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`id_article`, `description`, `prix_unitaire`) VALUES
(1, 'TV', 2500.07),
(3, 'Phone', 50000),
(4, 'Clavier', 300),
(10, 'Iphone 13 promax', 2255),
(12, 'samsung', 2500),
(14, 'LG SMART 5300 ', 20092.4),
(16, 'Lenovo 5300 ', 60000),
(17, 'ECran Full HD Samsung 1080P ', 65000),
(18, 'Souris  razer', 2400),
(30, 'PC DELL 3500', 820000),
(34, 'ASSUS 6230 PRO ', 120000),
(41, 'LG ', 50000),
(48, 'PS4', 2400),
(50, 'SAmsung Galaxy F22', 2255),
(52, 'HPz BOOk', 90000),
(53, 'Ecran Full Hd 50 pouce', 6000);

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `id_client` int NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `ville` varchar(255) DEFAULT NULL,
  `telephone` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `wilaya_id` int UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`id_client`, `nom`, `ville`, `telephone`, `wilaya_id`) VALUES
(4, 'Mohamed', 'Tiaret', '+2132221321', 2),
(5, 'Khaled za', 'Alger', '+1 (563) 348-1003', 16),
(7, 'Slimane', '1', '+1 (573) 561-7806', NULL),
(9, 'Sara SDL', 'ALGER', '+21356543215', 1),
(10, 'ALI DS', '25', '+213(762) 913-2384', 18),
(11, 'Sara Amel Bouzidi', NULL, '+21355023467', 35),
(12, 'Chadli Kaddi', NULL, '+213 (573) 561-7806', 15),
(13, 'Noureddine Yahia', NULL, '075477522', 42),
(20, 'Eum amet exercitati', NULL, '+1 (599) 434-9645', 34),
(23, 'Mona sara', NULL, '0595723489', 5),
(27, 'Saelm ali ', NULL, '0595723489', 46),
(29, 'Khaled asdda', NULL, '0595723489', 25),
(30, 'Khaled asdda', NULL, '0595723489', 25),
(31, 'Khaled asdda', NULL, '0595723489', 25),
(32, 'Khaled asdda', NULL, '0595723489', 25),
(33, 'Khaled asdda', NULL, '0595723489', 25),
(36, 'Khaled asdda', NULL, '0595723489', 25),
(37, 'Khaled asdda', NULL, '0595723489', 25),
(42, 'Id alias magna qui ', NULL, '+1 (139) 231-1935', 39),
(45, 'Abdou lw', NULL, '+1 (449) 722-4949', 15),
(46, 'Abdou lw', NULL, '+1 (449) 722-4949', 15),
(47, 'Abdou lw', NULL, '+1 (449) 722-4949', 15),
(48, 'Abdou lw', NULL, '+1 (449) 722-4949', 15),
(49, 'Abdou lw', NULL, '+1 (449) 722-4949', 15),
(50, 'Abdou lw', NULL, '+1 (449) 722-4949', 15),
(51, 'Abdou lw', NULL, '+1 (449) 722-4949', 15),
(52, 'Magna veniam sed do', NULL, '+1 (385) 556-1908', 41),
(53, 'Magna veniam sed do', NULL, '+1 (385) 556-1908', 41),
(54, 'Farouk BK', NULL, '+213(765) 936-1387', 15),
(55, 'Tahar dz', NULL, '+1 (573) 561-7806', 35);

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE `commande` (
  `id_commande` int NOT NULL,
  `date_commande` date DEFAULT NULL,
  `id_client` int DEFAULT NULL,
  `vues` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`id_commande`, `date_commande`, `id_client`, `vues`) VALUES
(1, '2025-06-14', 4, 12),
(2, '2025-06-12', 9, 8),
(3, '2025-06-18', 5, 1),
(10, '2025-06-20', 10, 2);

-- --------------------------------------------------------

--
-- Structure de la table `images`
--

CREATE TABLE `images` (
  `id_image` int NOT NULL,
  `nom_img` text NOT NULL,
  `chemin` text NOT NULL,
  `taille_img` int NOT NULL,
  `id_article` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `images`
--

INSERT INTO `images` (`id_image`, `nom_img`, `chemin`, `taille_img`, `id_article`) VALUES
(1, 'design-medium.jpg', 'images/design-medium.jpg', 650459, 52),
(2, 'design-small.jpg', 'images/images/1750460672_design-small.jpg', 64365, 53),
(12, 'samsung-galaxy-f22-2.jpg', 'images/1750720002_samsung-galaxy-f22-2.jpg', 42861, 50),
(14, 'samsung-galaxy-f22-2.jpg', 'images/1751321027_samsung-galaxy-f22-2.jpg', 42861, 3),
(18, 'Pc-P.014-768x768.jpeg', 'images/1751322364_Pc-P.014-768x768.jpeg', 23522, 30),
(20, 'téléchargement.jpg', 'images/1751322440_téléchargement.jpg', 5812, 30),
(22, 'TV.jpg', 'images/1751322740_TV.jpg', 6314, 1),
(23, 'Souris.jpg', 'images/1751322878_Souris.jpg', 6672, 18),
(24, 'clavier.jpg', 'images/1751322925_clavier.jpg', 8327, 4);

-- --------------------------------------------------------

--
-- Structure de la table `ligne_de_commande`
--

CREATE TABLE `ligne_de_commande` (
  `id_commande` int DEFAULT NULL,
  `id_article` int DEFAULT NULL,
  `quantite` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `ligne_de_commande`
--

INSERT INTO `ligne_de_commande` (`id_commande`, `id_article`, `quantite`) VALUES
(1, 1, 50),
(2, 14, 70),
(3, 14, 20),
(10, 12, 100);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id_user` int NOT NULL,
  `username` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(10000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id_user`, `username`, `email`, `password`) VALUES
(1, 'wuvanaqes', 'kasukino@mailinator.com', '$2y$10$h7sTF4/Y1F8rByJErl1gVeUfdTzC9uMxh3G4C/2zgA.c22ONSiXHi'),
(2, 'gypyhajyf', 'kicikec@mailinator.com', '$2y$10$gG4C5D3c8S5rPz4Kw0F/8eGZqY7gt7gGj9C2EjDAC78OKQKy08lje'),
(3, 'tuxofodiq', 'vorigan@mailinator.com', '$2y$10$FDXsFqssx0hzR76eZQKSaeLFIaEUze9XtMcp21W4IxM90KO5CyUIO'),
(4, 'Ahmed ', 'ahmed@gmail.com', '$2y$10$1GZcjWe4PdlTQh3PsylmMOS/m5sryYfEQkzIKWmPcsMksu6UDjohy'),
(5, 'Admin', 'admin@gmail.com', '$2y$10$l/QNlcciW32oT5t0jiOlYeGCkN/laMflKuiIgvgoW9XGfNRnA3TVG'),
(6, 'Yahia Nour', 'nourdineyahia77@gmail.com', '$2y$10$ZX96RyQtNuodhWJSjJeSa.Jjnp72/TN3lvWxiauohA0xYLJBUP3Cq');

-- --------------------------------------------------------

--
-- Structure de la table `wilayas`
--

CREATE TABLE `wilayas` (
  `id_wilaya` int UNSIGNED NOT NULL,
  `code` int NOT NULL,
  `nom_wilaya` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `wilayas`
--

INSERT INTO `wilayas` (`id_wilaya`, `code`, `nom_wilaya`) VALUES
(1, 1, 'Adrar'),
(2, 2, 'Chlef'),
(3, 3, 'Laghouat'),
(4, 4, 'Oum El Bouaghi'),
(5, 5, 'Batna'),
(6, 6, 'Béjaïa'),
(7, 7, 'Biskra'),
(8, 8, 'Béchar'),
(9, 9, 'Blida'),
(10, 10, 'Bouira'),
(11, 11, 'Tamanrasset'),
(12, 12, 'Tébessa'),
(13, 13, 'Tlemcen'),
(14, 14, 'Tiaret'),
(15, 15, 'Tizi Ouzou'),
(16, 16, 'Alger'),
(17, 17, 'Djelfa'),
(18, 18, 'Jijel'),
(19, 19, 'Sétif'),
(20, 20, 'Saïda'),
(21, 21, 'Skikda'),
(22, 22, 'Sidi Bel Abbès'),
(23, 23, 'Annaba'),
(24, 24, 'Guelma'),
(25, 25, 'Constantine'),
(26, 26, 'Médéa'),
(27, 27, 'Mostaganem'),
(28, 28, 'M\'Sila'),
(29, 29, 'Mascara'),
(30, 30, 'Ouargla'),
(31, 31, 'Oran'),
(32, 32, 'El Bayadh'),
(33, 33, 'Illizi'),
(34, 34, 'Bordj Bou Arreridj'),
(35, 35, 'Boumerdès'),
(36, 36, 'El Tarf'),
(37, 37, 'Tindouf'),
(38, 38, 'Tissemsilt'),
(39, 39, 'El Oued'),
(40, 40, 'Khenchela'),
(41, 41, 'Souk Ahras'),
(42, 42, 'Tipaza'),
(43, 43, 'Mila'),
(44, 44, 'Aïn Defla'),
(45, 45, 'Naâma'),
(46, 46, 'Aïn Témouchent'),
(47, 47, 'Ghardaïa'),
(48, 48, 'Relizane');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id_article`);

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id_client`),
  ADD KEY `fk_wilaya` (`wilaya_id`);

--
-- Index pour la table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`id_commande`),
  ADD KEY `id_client` (`id_client`);

--
-- Index pour la table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id_image`),
  ADD KEY `fk_img_article` (`id_article`);

--
-- Index pour la table `ligne_de_commande`
--
ALTER TABLE `ligne_de_commande`
  ADD KEY `id_commande` (`id_commande`),
  ADD KEY `id_article` (`id_article`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- Index pour la table `wilayas`
--
ALTER TABLE `wilayas`
  ADD PRIMARY KEY (`id_wilaya`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `article`
--
ALTER TABLE `article`
  MODIFY `id_article` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT pour la table `client`
--
ALTER TABLE `client`
  MODIFY `id_client` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT pour la table `commande`
--
ALTER TABLE `commande`
  MODIFY `id_commande` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `images`
--
ALTER TABLE `images`
  MODIFY `id_image` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `wilayas`
--
ALTER TABLE `wilayas`
  MODIFY `id_wilaya` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `client`
--
ALTER TABLE `client`
  ADD CONSTRAINT `fk_wilaya` FOREIGN KEY (`wilaya_id`) REFERENCES `wilayas` (`id_wilaya`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `commande_ibfk_1` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`);

--
-- Contraintes pour la table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `fk_img_article` FOREIGN KEY (`id_article`) REFERENCES `article` (`id_article`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `ligne_de_commande`
--
ALTER TABLE `ligne_de_commande`
  ADD CONSTRAINT `ligne_de_commande_ibfk_1` FOREIGN KEY (`id_commande`) REFERENCES `commande` (`id_commande`),
  ADD CONSTRAINT `ligne_de_commande_ibfk_2` FOREIGN KEY (`id_article`) REFERENCES `article` (`id_article`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

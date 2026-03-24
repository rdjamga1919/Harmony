-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Feb 03, 2026 at 02:55 PM
-- Server version: 8.0.40
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `campus_bien_etre`
--

-- --------------------------------------------------------

--
-- Table structure for table `categorie`
--

CREATE TABLE `categorie` (
  `id_categorie` int NOT NULL,
  `nom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categorie`
--

INSERT INTO `categorie` (`id_categorie`, `nom`, `description`) VALUES
(1, 'Stress et anxiété', 'Gestion du stress lié aux études, examens, pression académique'),
(2, 'Isolement social', 'Solitude, difficulté à créer du lien, éloignement familial'),
(3, 'Handicap invisible', 'TDAH, dyslexie, troubles anxieux, maladies chroniques'),
(4, 'Précarité étudiante', 'Difficultés financières, logement, alimentation'),
(5, 'S\'exprimer librement', 'Espace ouvert pour tous types de témoignages');

-- --------------------------------------------------------

--
-- Table structure for table `commentaire`
--

CREATE TABLE `commentaire` (
  `id_commentaire` int NOT NULL,
  `contenu` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_commentaire` datetime DEFAULT CURRENT_TIMESTAMP,
  `id_utilisateur` int NOT NULL,
  `id_poste` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `commentaire`
--

INSERT INTO `commentaire` (`id_commentaire`, `contenu`, `date_commentaire`, `id_utilisateur`, `id_poste`) VALUES
(1, 'Courage ! Perso j\'utilise la méthode Pomodoro : 25min travail, 5min pause. Ça m\'aide énormément à pas saturer.', '2026-01-29 20:09:48', 3, 1),
(2, 'Pareil pour moi l\'année dernière. N\'hésite pas à aller vers les gens même si c\'est difficile. Souvent ils sont aussi timides que toi !', '2026-01-29 20:09:48', 4, 2),
(3, 'J\'enregistre les cours avec mon tel et je réécoute après. Pour les notes en direct, juste les mots-clés. Sinon l\'app Notion est top pour organiser.', '2026-01-29 20:09:48', 2, 3),
(4, 'Regarde le CROUS pour les aides d\'urgence (FNAU). Et les épiceries solidaires sur ton campus aussi, ça aide vraiment.', '2026-01-29 20:09:48', 3, 4),
(5, 'Content pour toi ! C\'est important d\'en parler. Bravo pour le courage d\'avoir fait le pas.', '2026-01-29 20:09:48', 2, 5),
(6, 'Tu peux essayer aussi Forest ou Focus To-Do pour rester concentré. Ça gamifie la concentration, c\'est motivant !', '2026-01-29 20:09:48', 3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `poste`
--

CREATE TABLE `poste` (
  `id_poste` int NOT NULL,
  `titre` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contenu` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_poste` datetime DEFAULT CURRENT_TIMESTAMP,
  `est_anonyme` tinyint(1) DEFAULT '0',
  `id_utilisateur` int NOT NULL,
  `id_categorie` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `poste`
--

INSERT INTO `poste` (`id_poste`, `titre`, `contenu`, `date_poste`, `est_anonyme`, `id_utilisateur`, `id_categorie`) VALUES
(1, 'Je me sens submergé par les révisions', 'Entre les partiels qui approchent et mon job étudiant, je n\'arrive plus à tout gérer. Comment vous faites pour tenir le rythme ? Des conseils ?', '2026-01-29 20:09:48', 0, 2, 1),
(2, 'Difficulté à me faire des amis', 'Je suis en 1ère année loin de chez moi. Tout le monde a l\'air d\'avoir déjà son groupe... Je me sens vraiment seul. C\'est normal ?', '2026-01-29 20:09:48', 1, 3, 2),
(3, 'TDAH et prise de notes', 'Diagnostiqué TDAH récemment. Impossible de me concentrer en amphi. Quelqu\'un a des astuces pour la prise de notes ? Genre des apps ou des techniques ?', '2026-01-29 20:09:48', 0, 4, 3),
(4, 'Galère financière ce mois-ci', 'Ma bourse arrive en retard, je suis dans le rouge. Quelqu\'un connaît des aides d\'urgence ? J\'ai vraiment besoin d\'aide là...', '2026-01-29 20:09:48', 1, 2, 4),
(5, 'Merci à cette communauté', 'Juste pour dire merci. Grâce à vos conseils j\'ai osé consulter un psy étudiant. Ça va déjà mieux. Vous êtes géniaux !', '2026-01-29 20:09:48', 0, 3, 5);

-- --------------------------------------------------------

--
-- Table structure for table `reaction`
--

CREATE TABLE `reaction` (
  `id_reaction` int NOT NULL,
  `type` enum('soutien','merci','courage') COLLATE utf8mb4_unicode_ci DEFAULT 'soutien',
  `date_reaction` datetime DEFAULT CURRENT_TIMESTAMP,
  `id_utilisateur` int NOT NULL,
  `id_poste` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reaction`
--

INSERT INTO `reaction` (`id_reaction`, `type`, `date_reaction`, `id_utilisateur`, `id_poste`) VALUES
(1, 'soutien', '2026-01-29 20:09:48', 2, 1),
(2, 'courage', '2026-01-29 20:09:48', 3, 1),
(3, 'soutien', '2026-01-29 20:09:48', 4, 1),
(4, 'soutien', '2026-01-29 20:09:48', 2, 2),
(5, 'courage', '2026-01-29 20:09:48', 4, 2),
(6, 'merci', '2026-01-29 20:09:48', 2, 3),
(7, 'soutien', '2026-01-29 20:09:48', 3, 3),
(8, 'courage', '2026-01-29 20:09:48', 2, 4),
(9, 'soutien', '2026-01-29 20:09:48', 4, 4),
(10, 'merci', '2026-01-29 20:09:48', 2, 5),
(11, 'merci', '2026-01-29 20:09:48', 4, 5);

-- --------------------------------------------------------

--
-- Table structure for table `ressources`
--

CREATE TABLE `ressources` (
  `id_ressource` int NOT NULL,
  `titre` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `lien` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('lien','numero','contact') COLLATE utf8mb4_unicode_ci DEFAULT 'lien',
  `id_categorie` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ressources`
--

INSERT INTO `ressources` (`id_ressource`, `titre`, `description`, `lien`, `type`, `id_categorie`) VALUES
(1, 'Santé Psy Étudiant', 'Consultations psychologiques gratuites pour étudiants', 'https://santepsy.etudiant.gouv.fr', 'lien', 1),
(2, 'Nightline France', 'Service écoute nocturne par des étudiants bénévoles', 'https://www.nightline.fr', 'lien', 1),
(3, '3114 - Prévention suicide', 'Numéro national gratuit de prévention du suicide', '3114', 'numero', 1),
(4, 'Fil Santé Jeunes', 'Service information et orientation pour jeunes 12-25 ans', 'https://www.filsantejeunes.com', 'lien', 2),
(5, 'Aides CROUS', 'Informations bourses et aides financières étudiantes', 'https://www.crous.fr/aides-financieres', 'lien', 4),
(6, 'Aide au logement CAF', 'Simulateur et demande APL pour logement étudiant', 'https://www.caf.fr', 'lien', 4),
(7, 'AGEFIPH Handicap', 'Accompagnement handicap invisible études supérieures', 'https://www.agefiph.fr', 'lien', 3);

-- --------------------------------------------------------

--
-- Table structure for table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id_utilisateur` int NOT NULL,
  `pseudo` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mdp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('etudiant','admin') COLLATE utf8mb4_unicode_ci DEFAULT 'etudiant',
  `date_inscription` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `utilisateur`
--

INSERT INTO `utilisateur` (`id_utilisateur`, `pseudo`, `email`, `mdp`, `role`, `date_inscription`) VALUES
(1, 'admin', 'admin@adalo.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', '2026-01-29 20:09:48'),
(2, 'alex', 'alex@test.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'etudiant', '2026-01-29 20:09:48'),
(3, 'sarah', 'sarah@test.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'etudiant', '2026-01-29 20:09:48'),
(4, 'jordan', 'jordan@test.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'etudiant', '2026-01-29 20:09:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id_categorie`);

--
-- Indexes for table `commentaire`
--
ALTER TABLE `commentaire`
  ADD PRIMARY KEY (`id_commentaire`),
  ADD KEY `id_utilisateur` (`id_utilisateur`),
  ADD KEY `id_poste` (`id_poste`);

--
-- Indexes for table `poste`
--
ALTER TABLE `poste`
  ADD PRIMARY KEY (`id_poste`),
  ADD KEY `id_utilisateur` (`id_utilisateur`),
  ADD KEY `id_categorie` (`id_categorie`);

--
-- Indexes for table `reaction`
--
ALTER TABLE `reaction`
  ADD PRIMARY KEY (`id_reaction`),
  ADD UNIQUE KEY `unique_user_post` (`id_utilisateur`,`id_poste`),
  ADD KEY `id_poste` (`id_poste`);

--
-- Indexes for table `ressources`
--
ALTER TABLE `ressources`
  ADD PRIMARY KEY (`id_ressource`),
  ADD KEY `id_categorie` (`id_categorie`);

--
-- Indexes for table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id_utilisateur`),
  ADD UNIQUE KEY `pseudo` (`pseudo`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id_categorie` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `commentaire`
--
ALTER TABLE `commentaire`
  MODIFY `id_commentaire` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `poste`
--
ALTER TABLE `poste`
  MODIFY `id_poste` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `reaction`
--
ALTER TABLE `reaction`
  MODIFY `id_reaction` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `ressources`
--
ALTER TABLE `ressources`
  MODIFY `id_ressource` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id_utilisateur` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `commentaire`
--
ALTER TABLE `commentaire`
  ADD CONSTRAINT `commentaire_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`) ON DELETE CASCADE,
  ADD CONSTRAINT `commentaire_ibfk_2` FOREIGN KEY (`id_poste`) REFERENCES `poste` (`id_poste`) ON DELETE CASCADE;

--
-- Constraints for table `poste`
--
ALTER TABLE `poste`
  ADD CONSTRAINT `poste_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`) ON DELETE CASCADE,
  ADD CONSTRAINT `poste_ibfk_2` FOREIGN KEY (`id_categorie`) REFERENCES `categorie` (`id_categorie`) ON DELETE RESTRICT;

--
-- Constraints for table `reaction`
--
ALTER TABLE `reaction`
  ADD CONSTRAINT `reaction_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`) ON DELETE CASCADE,
  ADD CONSTRAINT `reaction_ibfk_2` FOREIGN KEY (`id_poste`) REFERENCES `poste` (`id_poste`) ON DELETE CASCADE;

--
-- Constraints for table `ressources`
--
ALTER TABLE `ressources`
  ADD CONSTRAINT `ressources_ibfk_1` FOREIGN KEY (`id_categorie`) REFERENCES `categorie` (`id_categorie`) ON DELETE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

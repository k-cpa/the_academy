-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : ven. 13 déc. 2024 à 15:42
-- Version du serveur : 8.0.35
-- Version de PHP : 8.2.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `academy`
--

-- --------------------------------------------------------

--
-- Structure de la table `elements`
--

CREATE TABLE `elements` (
  `element_id` int NOT NULL,
  `element_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `elements`
--

INSERT INTO `elements` (`element_id`, `element_name`) VALUES
(1, 'water'),
(2, 'fire'),
(3, 'light'),
(4, 'air');

-- --------------------------------------------------------

--
-- Structure de la table `monsters`
--

CREATE TABLE `monsters` (
  `monster_id` int NOT NULL,
  `monster_name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `user_id` int DEFAULT NULL,
  `type_id` int DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `monsters`
--

INSERT INTO `monsters` (`monster_id`, `monster_name`, `description`, `user_id`, `type_id`, `image`) VALUES
(2, 'Lymnara', 'Betrayed and sacrificed by her people, Lymnara was transformed into the immortal guardian of the lakes. Now, she protects the waters while punishing those who dare to defile them.', 1, 1, 'Image_675c150c5d3473.49074938.jpg'),
(4, 'Kappa', 'Once a peaceful marsh creature, the Kappa was corrupted by dark forces into a vengeful monster. It now roams the swamps, fiercely guarding its territory and attacking any intruders.', 1, 1, 'Image_675c30af67ce22.21720019.jpg'),
(5, 'Kirin', 'Once a noble guardian of the seas, Kirin was corrupted by an ancient, dark power. Now, it prowls the ocean depths, a terrifying force of nature, attacking any who dare enter its domain.', 1, 1, 'Image_675c314412ef36.35900714.jpg'),
(7, 'Iblisfyr', '\r\nIblisfyr, a fallen celestial guardian, was consumed by dark flames and transformed into a vengeful demon. He now scorches everything in his path, seeking revenge on the gods who betrayed him.', 2, 3, 'Image_675c3701829f32.66617555.jpg'),
(8, 'Succubus', 'Once a mortal woman, the Succubus was cursed to become an infernal demon, feeding on the souls of the living. She now lures victims with her irresistible charm.', 2, 3, 'Image_675c3754439018.80238452.jpg'),
(9, 'Morvul', 'Once a demon bound to the darkest pits, Morvul was twisted into a mindless ghoul by infernal magic. Now, it roams the forsaken lands, driven only by hunger and an insatiable thirst for destruction.', 2, 3, 'Image_675c37905e1808.23148757.jpg'),
(10, 'Aetheron', 'Aetheron, a mighty centaur, wields earth’s power with pure intent, yet his steps can reshape the land, for better or worse.', 3, 4, 'Image_675c37cb7c9483.71717062.jpg'),
(11, 'Gorgath', 'Gorgath, the wretched cyclops, roams desolate lands, driven by an insatiable hunger. With his grotesque form and single blazing eye, he devours all in his path, leaving ruin in his wake.', 3, 4, 'Image_675c37fb73dc88.29670735.jpg'),
(12, 'Seraphae', 'Seraphae, a once-malevolent harpy, vowed to do good after the tragic loss of her creator. Guided by remorse, she soars the skies, seeking to bring hope where despair once reigned.', 3, 4, 'Image_675c3822264f03.78837001.jpg'),
(13, 'Thalgron', 'Thalgron, a fearsome minotaur mercenary, fights only for the promise of glory. His battle cries echo across the fields, a testament to his unyielding thirst for immortal renown.', 3, 4, 'Image_675c3848227d89.44207768.png'),
(14, 'Ashenveil', 'Ashenveil, a ghost with a head consumed by the Flames of the Forgotten, seeks to destroy humanity. His only desire is to rule a world devoid of life, where silence reigns eternal.', 6, 2, 'Image_675c3910308ad0.29669219.jpg'),
(15, 'Erythma', 'Once a bearer of divine truths, Erythma is now cursed to wander as a damned sphinx. Twisted by her fate, she speaks only riddles of despair to those who dare seek her wisdom.', 6, 2, 'Image_675c395678a8d0.62572967.jpg'),
(16, 'Morgrave', 'Once a mindless zombie, Morgrave gained dark intellect and arcane mastery after being blessed by Ashenveil. Now a shadow mage, he weaves necrotic spells to expand his dominion over the living and the dead.', 6, 2, 'Image_675c39bf4e3889.89441232.jpg'),
(17, 'Kaelthorn', 'Once a soldier of Ashenveil, Kaelthorn was saved by Thalgon on a bloodied battlefield. Now he fights relentlessly for his savior, driven by loyalty and unyielding rage.', 6, 2, 'Image_675c3a1d1f7d66.33558055.jpg'),
(18, 'Cerberus', 'Cerberus, once Succubus&#039; loyal companion, was starved to death when she became a demon. Now, his vengeful spirit roams the underworld, driven by an insatiable hunger.', 2, 3, 'Image_675c4c91a8f057.07795868.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

CREATE TABLE `roles` (
  `role_id` int NOT NULL,
  `user_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `spells`
--

CREATE TABLE `spells` (
  `spell_id` int NOT NULL,
  `spell_name` varchar(255) DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `element_id` int DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `spells`
--

INSERT INTO `spells` (`spell_id`, `spell_name`, `user_id`, `element_id`, `image`, `description`) VALUES
(3, 'Fire Shield', 2, 2, 'Image_675c4dab224537.22112915.webp', 'Fire Shield surrounds the caster with flames, damaging nearby enemies and providing fire resistance.'),
(4, 'Fireball', 2, 2, 'Image_675c4dc394ebf2.49576977.webp', 'Fireball conjures a fiery sphere that explodes on impact, dealing damage to enemies in its blast radius.'),
(5, 'Celestial Armor', 2, 3, 'Image_675c4de783a231.25215071.webp', 'Envelops the caster in a protective aura, greatly reducing damage from both physical and magical attacks.'),
(6, 'Fire Elemental', 5, 2, 'Image_675c4e1d3ca888.63580416.webp', 'Summons a fiery being to fight for the caster, dealing burning damage to enemies within range.'),
(7, 'Immolation', 5, 2, 'Image_675c4e7e25d077.97526385.webp', 'Engulfs the caster in flames, causing them to deal fire damage to nearby enemies over time while taking damage themselves.'),
(8, 'Firestorm', 5, 2, 'Image_675c4e8f9ac754.45228857.webp', 'Summons a fierce storm of flames, dealing massive fire damage to all enemies in its area of effect.'),
(9, 'Ice Armor', 3, 1, 'Image_675c4ec9676fc0.87667933.webp', 'Ice Armor surrounds the caster with a protective shield of ice, reducing incoming damage and granting resistance to physical attacks.'),
(10, 'Blizzard', 3, 1, 'Image_675c4edf5b5570.36207819.webp', 'Blizzard summons a raging snowstorm, dealing cold damage to all enemies within its area of effect and slowing their movement.'),
(11, 'Light Elemental', 3, 3, 'Image_675c4f00d86bc9.45450662.webp', 'The Light Elemental conjures a radiant being of pure light, dealing holy damage to enemies and healing allies within its reach.'),
(12, 'Purification', 3, 3, 'Image_675c4f1d54cde6.70023603.webp', 'Purification cleanses allies of harmful effects, restoring their health and removing debuffs.'),
(13, 'Retribution', 3, 3, 'Image_675c4f3a428af2.96548511.webp', 'Retribution channels vengeful energy, dealing damage to enemies who have harmed the caster.'),
(14, 'Healing', 3, 3, 'Image_675c4f4e4d8b13.21730930.webp', 'Healing restores a portion of the caster&#039;s or ally&#039;s health, mending wounds and rejuvenating strength.');

-- --------------------------------------------------------

--
-- Structure de la table `type`
--

CREATE TABLE `type` (
  `type_id` int NOT NULL,
  `type_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `type`
--

INSERT INTO `type` (`type_id`, `type_name`) VALUES
(1, 'Aquatic'),
(2, 'Undead'),
(3, 'Demonic'),
(4, 'Half-beast');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `role_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `created_at`, `updated_at`, `role_id`) VALUES
(1, 'Anastasya', 'anastasya@gmail.com', '$2y$10$rvaAaXzqDy4494AeB26oYuEUJEWD7XbDIaxskJIm.pVqKnGyvBm1y', '2024-12-12 15:12:53', '2024-12-12 15:12:53', NULL),
(2, 'Kiril', 'kiril@gmail.com', '$2y$10$hfmK.k2EXNVrXfsoU2moJO1QRDal/i6eJJv2DB67bxqvPbHj79V.a', '2024-12-12 15:14:01', '2024-12-12 15:14:01', NULL),
(3, 'Anton', 'anton@gmail.com', '$2y$10$5xtXPvIKi5JfXJf2or3KnOROk/iIgPWUdDtbBKbRtaIjTV5Gx8iFa', '2024-12-12 15:16:08', '2024-12-12 15:16:08', NULL),
(4, 'Irina', 'irina@gmail.com', '$2y$10$9FPD8wJcMOA48nCksE8uPeDn6rA9i8iszQRkYVjvS/e.KIN0jkTE.', '2024-12-12 15:16:53', '2024-12-12 15:16:53', NULL),
(5, 'Jorgen', 'jorgen@gmail.com', '$2y$10$Y.UlX1/SwDI2BrBWFFnCyexFSEiwgObYtChCMM6aXKuxBQNshkcW2', '2024-12-12 15:17:16', '2024-12-12 15:17:16', NULL),
(6, 'Kalindra', 'kalindra@gmail.com', '$2y$10$bnbymZk.MuZ6nE40H9C1e.m.U8hx5Y/EgNDsO/xBLzY1cyepy4KJi', '2024-12-12 15:17:32', '2024-12-12 15:17:32', NULL),
(7, 'Bonjour', 'leknre@gmail.com', '$2y$10$kZVLt74M.yFHKy.LSr5C9.QqN4.e9X5TIbVX33sMFHXQ3wkDg.jLG', '2024-12-12 21:00:52', '2024-12-12 21:00:52', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `users_elements`
--

CREATE TABLE `users_elements` (
  `user_id` int DEFAULT NULL,
  `element_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users_elements`
--

INSERT INTO `users_elements` (`user_id`, `element_id`) VALUES
(1, 1),
(2, 2),
(2, 3),
(3, 1),
(3, 3),
(4, 1),
(4, 4),
(5, 2),
(6, 4),
(7, 1),
(7, 4);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `elements`
--
ALTER TABLE `elements`
  ADD PRIMARY KEY (`element_id`);

--
-- Index pour la table `monsters`
--
ALTER TABLE `monsters`
  ADD PRIMARY KEY (`monster_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `type_id` (`type_id`);

--
-- Index pour la table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `spells`
--
ALTER TABLE `spells`
  ADD PRIMARY KEY (`spell_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `element_id` (`element_id`);

--
-- Index pour la table `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`type_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Index pour la table `users_elements`
--
ALTER TABLE `users_elements`
  ADD UNIQUE KEY `unique_user_element` (`user_id`,`element_id`),
  ADD KEY `element_id` (`element_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `elements`
--
ALTER TABLE `elements`
  MODIFY `element_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `monsters`
--
ALTER TABLE `monsters`
  MODIFY `monster_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `spells`
--
ALTER TABLE `spells`
  MODIFY `spell_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `type`
--
ALTER TABLE `type`
  MODIFY `type_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `monsters`
--
ALTER TABLE `monsters`
  ADD CONSTRAINT `monsters_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `USERS` (`user_id`),
  ADD CONSTRAINT `monsters_ibfk_2` FOREIGN KEY (`type_id`) REFERENCES `type` (`type_id`);

--
-- Contraintes pour la table `roles`
--
ALTER TABLE `roles`
  ADD CONSTRAINT `roles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Contraintes pour la table `spells`
--
ALTER TABLE `spells`
  ADD CONSTRAINT `spells_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `spells_ibfk_2` FOREIGN KEY (`element_id`) REFERENCES `elements` (`element_id`);

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`);

--
-- Contraintes pour la table `users_elements`
--
ALTER TABLE `users_elements`
  ADD CONSTRAINT `users_elements_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `users_elements_ibfk_2` FOREIGN KEY (`element_id`) REFERENCES `elements` (`element_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

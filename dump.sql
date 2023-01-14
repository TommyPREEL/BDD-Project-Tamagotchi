-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : sam. 14 jan. 2023 à 17:55
-- Version du serveur : 5.7.36
-- Version de PHP : 8.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `livecampus_project_bdd_tamagotchi`
--
CREATE DATABASE IF NOT EXISTS `livecampus_project_bdd_tamagotchi` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `livecampus_project_bdd_tamagotchi`;

DELIMITER $$
--
-- Procédures
--
DROP PROCEDURE IF EXISTS `bedtime`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `bedtime` (IN `tamagotchi_id` TINYINT UNSIGNED)  BEGIN
  INSERT INTO actions (id_tamagotchis, type) VALUE (tamagotchi_id, 'sleep');
END$$

DROP PROCEDURE IF EXISTS `create_account`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `create_account` (IN `user` VARCHAR(50))  BEGIN
  DECLARE db_user_account VARCHAR(50);
  DECLARE username_length TINYINT;

  SELECT LENGTH(user) INTO username_length;

  IF (username_length = 0) THEN
    SIGNAL SQLSTATE '40000' SET MESSAGE_TEXT = 'Username cannot be null';
  END IF;

  SELECT username INTO db_user_account FROM users WHERE username = user LIMIT 1;

  -- Return a error 40000 'Bad Request'
  IF db_user_account IS NOT NULL THEN
    SIGNAL SQLSTATE '40000' SET MESSAGE_TEXT = 'Bad Request: User account already exist';
  END IF;

  INSERT INTO users (username) VALUE (user);
END$$

DROP PROCEDURE IF EXISTS `create_tamagotchi`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `create_tamagotchi` (IN `user_id` TINYINT UNSIGNED, IN `tamagotchi_name` VARCHAR(50))  BEGIN
  DECLARE tamagotchi_name_length TINYINT;

  -- Verify the length of the tamagotchi name
  SELECT LENGTH(tamagotchi_name) INTO tamagotchi_name_length;

  -- Return a error 40000 'Bad Request'
  IF (tamagotchi_name_length = 0) THEN
    SIGNAL SQLSTATE '40000' SET MESSAGE_TEXT = 'Bad Request: Tamagotchi name cannot be null';
  END IF;

  INSERT INTO tamagotchis (id_users, name)
  VALUES (user_id, tamagotchi_name);
END$$

DROP PROCEDURE IF EXISTS `drink`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `drink` (IN `tamagotchi_id` TINYINT UNSIGNED)  BEGIN
  INSERT INTO actions (id_tamagotchis, type) VALUE (tamagotchi_id, 'drink');
END$$

DROP PROCEDURE IF EXISTS `eat`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `eat` (IN `tamagotchi_id` TINYINT UNSIGNED)  BEGIN
  INSERT INTO actions (id_tamagotchis, type) VALUE (tamagotchi_id, 'eat');
END$$

DROP PROCEDURE IF EXISTS `enjoy`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `enjoy` (IN `tamagotchi_id` TINYINT UNSIGNED)  BEGIN
  INSERT INTO actions (id_tamagotchis, type) VALUE (tamagotchi_id, 'play');
END$$

DROP PROCEDURE IF EXISTS `set_death`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `set_death` (IN `tamagotchi_id` TINYINT UNSIGNED, IN `current_reason` VARCHAR(64))  BEGIN
  INSERT INTO deaths (id_tamagotchis, reason) VALUE (tamagotchi_id, current_reason);
END$$

DROP PROCEDURE IF EXISTS `update_tamagotchi_stats`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `update_tamagotchi_stats` (IN `tamagotchi_id` TINYINT UNSIGNED, IN `new_hungry` TINYINT, IN `new_drink` TINYINT, IN `new_sleep` TINYINT, IN `new_boredom` TINYINT, IN `current_action_type` ENUM('eat','drink','sleep','play','created'))  BEGIN
  DECLARE db_current_hungry TINYINT;
  DECLARE db_current_drink TINYINT;
  DECLARE db_current_sleep TINYINT;
  DECLARE db_current_boredom TINYINT;
  DECLARE tamagotchi_level TINYINT;

  -- Inject data into declared variables
  SELECT hungry, drink, sleep, boredom, get_level(tamagotchi_id)
  INTO db_current_hungry, db_current_drink, db_current_sleep, db_current_boredom, tamagotchi_level
  FROM tamagotchis
         JOIN historical_actions ha on tamagotchis.id = ha.id_tamagotchis
  WHERE tamagotchis.id = tamagotchi_id
  ORDER BY ha.creation_date DESC
  LIMIT 1;

  -- If one of the stars is equal to or greater than 80 then an error is returned to prevent the user from doing their action
  IF current_action_type = 'eat' AND db_current_hungry >= 80 THEN
    SIGNAL SQLSTATE '40004' SET MESSAGE_TEXT = 'The hunger stat is already at or above 80';
  ELSEIF current_action_type = 'drink' AND db_current_drink >= 80 THEN
    SIGNAL SQLSTATE '40004' SET MESSAGE_TEXT = 'The drink stat is already at or above 80';
  ELSEIF current_action_type = 'sleep' AND db_current_sleep >= 80 THEN
    SIGNAL SQLSTATE '40004' SET MESSAGE_TEXT = 'The sleep stat is already at or above 80';
  ELSEIF current_action_type = 'play' AND db_current_boredom >= 80 THEN
    SIGNAL SQLSTATE '40004' SET MESSAGE_TEXT = 'The boredom stat is already at or above 80';
  END IF;

  -- Control if a one stats of tamagotchi is equal to 0 return a error.
  IF db_current_hungry = 0 OR db_current_boredom = 0 OR db_current_sleep = 0 OR db_current_drink = 0 THEN
    SIGNAL SQLSTATE '40000' SET MESSAGE_TEXT =
        'Bad Request, The current tamagotchi already have a stats to 0 (already dead)';
  END IF;

  -- Subtracts 1 point from the level of the tamagotchis, to be able to add the level gain to the stats
  SET tamagotchi_level = tamagotchi_level - 1;

  -- Add tamagotchi level to the stats to add
  SET new_hungry = if(new_hungry < 0, new_hungry - tamagotchi_level, new_hungry + tamagotchi_level);
  SET new_drink = if(new_drink < 0, new_drink - tamagotchi_level, new_drink + tamagotchi_level);
  SET new_sleep = if(new_sleep < 0, new_sleep - tamagotchi_level, new_sleep + tamagotchi_level);
  SET new_boredom = if(new_boredom < 0, new_boredom - tamagotchi_level, new_boredom + tamagotchi_level);

  -- If the update of the statistic gives a result lower than 0, then we force its value to 0
  SET db_current_hungry = if(db_current_hungry + new_hungry < 0, 0, db_current_hungry + new_hungry);
  SET db_current_drink = if(db_current_drink + new_drink < 0, 0, db_current_drink + new_drink);
  SET db_current_sleep = if(db_current_sleep + new_sleep < 0, 0, db_current_sleep + new_sleep);
  SET db_current_boredom = if(db_current_boredom + new_boredom < 0, 0, db_current_boredom + new_boredom);

  -- If the update of the statistic gives a result greater than 100, then we force its value to 100
  SET db_current_hungry = if(db_current_hungry > 100, 100, db_current_hungry);
  SET db_current_drink = if(db_current_drink > 100, 100, db_current_drink);
  SET db_current_sleep = if(db_current_sleep > 100, 100, db_current_sleep);
  SET db_current_boredom = if(db_current_boredom > 100, 100, db_current_boredom);

  -- Insert action into historical_actions table
  INSERT INTO historical_actions (id_tamagotchis, hungry, drink, sleep, boredom, action_type)
    VALUE
    (
     tamagotchi_id,
     db_current_hungry,
     db_current_drink,
     db_current_sleep,
     db_current_boredom,
     current_action_type
      );
END$$

--
-- Fonctions
--
DROP FUNCTION IF EXISTS `get_level`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `get_level` (`id_tamagotchis` TINYINT UNSIGNED) RETURNS TINYINT(4) BEGIN
  DECLARE nb_actions TINYINT;

-- On compte le nombre de ligne dans la table actions pour un tamagotchi donné
  SELECT COUNT(*)
  into nb_actions
  FROM historical_actions ha
  WHERE ha.id_tamagotchis = id_tamagotchis AND ha.action_type != 'created';


-- Si le nombre d'actions est inférieurs à 10 il est niveau 1
  IF nb_actions < 10 THEN
    RETURN 1;
  ELSE
-- Si il a plus de 10 actions alors on (divise par 10) + 1 pour le décalage. Round() afin d'arrondir.
    RETURN FLOOR((nb_actions / 10) + 1);
  END IF;

END$$

DROP FUNCTION IF EXISTS `get_stats`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `get_stats` (`id_tamagotchi` TINYINT UNSIGNED, `stats_name` ENUM('hungry','drink','sleep','boredom')) RETURNS TINYINT(3) UNSIGNED BEGIN
  DECLARE value TINYINT UNSIGNED;

  IF stats_name = 'hungry' THEN

    SELECT hungry
    INTO value
    FROM historical_actions
    WHERE historical_actions.id_tamagotchis = id_tamagotchi
    ORDER BY creation_date DESC
    LIMIT 1;

  ELSEIF stats_name = 'drink' THEN

    SELECT drink
    INTO value
    FROM historical_actions
    WHERE historical_actions.id_tamagotchis = id_tamagotchi
    ORDER BY creation_date DESC
    LIMIT 1;

  ELSEIF stats_name = 'sleep' THEN

    SELECT sleep
    INTO value
    FROM historical_actions
    WHERE historical_actions.id_tamagotchis = id_tamagotchi
    ORDER BY creation_date DESC
    LIMIT 1;

  ELSE

    SELECT boredom
    INTO value
    FROM historical_actions
    WHERE historical_actions.id_tamagotchis = id_tamagotchi
    ORDER BY creation_date DESC
    LIMIT 1;
  END IF;

  RETURN value;
END$$

DROP FUNCTION IF EXISTS `is_alive`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `is_alive` (`id_tamagotchis` TINYINT UNSIGNED) RETURNS TINYINT(1) BEGIN
  DECLARE reason_death VARCHAR(50);
  DECLARE tamagotchi_name VARCHAR(50);

  SELECT deaths.reason, tamagotchis.name
  INTO reason_death, tamagotchi_name
  FROM tamagotchis
         LEFT JOIN deaths ON tamagotchis.id = deaths.id_tamagotchis
  WHERE tamagotchis.id = id_tamagotchis
  LIMIT 1;

  IF tamagotchi_name IS NULL THEN
    SIGNAL SQLSTATE '40001' SET MESSAGE_TEXT = 'The current tamagotchi does not exist';
  END IF;

  IF reason_death IS NULL THEN
    RETURN TRUE;
  ELSE
    RETURN FALSE;
  END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `actions`
--

DROP TABLE IF EXISTS `actions`;
CREATE TABLE IF NOT EXISTS `actions` (
  `id_tamagotchis` tinyint(3) UNSIGNED NOT NULL,
  `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` enum('eat','drink','sleep','play') NOT NULL,
  `creation_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_tamagotchis` (`id_tamagotchis`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déclencheurs `actions`
--
DROP TRIGGER IF EXISTS `after_action_tamagotchi_stats`;
DELIMITER $$
CREATE TRIGGER `after_action_tamagotchi_stats` AFTER INSERT ON `actions` FOR EACH ROW BEGIN
  IF NEW.type = 'eat' THEN
    CALL update_tamagotchi_stats(NEW.id_tamagotchis, 30, -10, -5, -5, NEW.type);

  ELSEIF NEW.type = 'drink' THEN
    CALL update_tamagotchi_stats(NEW.id_tamagotchis, -10, 30, -5, -5, NEW.type);

  ELSEIF NEW.type = 'sleep' THEN
    CALL update_tamagotchi_stats(NEW.id_tamagotchis, -10, -15, 30, -15, NEW.type);

  ELSE
    CALL update_tamagotchi_stats(NEW.id_tamagotchis, -5, -5, -5, 15, NEW.type);
  END IF;

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `alive_tamagotchis`
-- (Voir ci-dessous la vue réelle)
--
DROP VIEW IF EXISTS `alive_tamagotchis`;
CREATE TABLE IF NOT EXISTS `alive_tamagotchis` (
`user_id` tinyint(3) unsigned
,`id` tinyint(3) unsigned
,`name` varchar(50)
,`hungry` tinyint(3) unsigned
,`drink` tinyint(3) unsigned
,`sleep` tinyint(3) unsigned
,`boredom` tinyint(3) unsigned
,`level` tinyint(4)
);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `dead_tamagotchis`
-- (Voir ci-dessous la vue réelle)
--
DROP VIEW IF EXISTS `dead_tamagotchis`;
CREATE TABLE IF NOT EXISTS `dead_tamagotchis` (
`user_id` tinyint(3) unsigned
,`id` tinyint(3) unsigned
,`name` varchar(50)
,`level` tinyint(4)
,`reason` varchar(50)
,`creation_date` datetime
,`death_date` datetime
);

-- --------------------------------------------------------

--
-- Structure de la table `deaths`
--

DROP TABLE IF EXISTS `deaths`;
CREATE TABLE IF NOT EXISTS `deaths` (
  `id_tamagotchis` tinyint(3) UNSIGNED NOT NULL,
  `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  `reason` varchar(50) NOT NULL,
  `creation_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_tamagotchis` (`id_tamagotchis`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `historical_actions`
--

DROP TABLE IF EXISTS `historical_actions`;
CREATE TABLE IF NOT EXISTS `historical_actions` (
  `id_tamagotchis` tinyint(3) UNSIGNED NOT NULL,
  `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  `hungry` tinyint(4) NOT NULL,
  `drink` tinyint(4) NOT NULL,
  `sleep` tinyint(4) NOT NULL,
  `boredom` tinyint(4) NOT NULL,
  `action_type` enum('eat','drink','sleep','play','created') NOT NULL,
  `creation_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_tamagotchis` (`id_tamagotchis`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déclencheurs `historical_actions`
--
DROP TRIGGER IF EXISTS `after_update_tamagotchi_stats`;
DELIMITER $$
CREATE TRIGGER `after_update_tamagotchi_stats` AFTER INSERT ON `historical_actions` FOR EACH ROW BEGIN
  IF NEW.hungry = 0 THEN
    CALL set_death(NEW.id_tamagotchis, 'Starved to Death');

  ELSEIF NEW.drink = 0 THEN
    CALL set_death(NEW.id_tamagotchis, 'Death by Dehydration');

  ELSEIF NEW.sleep = 0 THEN
    CALL set_death(NEW.id_tamagotchis, 'Death from Sleep');

  ELSEIF NEW.boredom = 0 THEN
    CALL set_death(NEW.id_tamagotchis, 'Death of Boredom');
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `life_of_tamagotchis`
-- (Voir ci-dessous la vue réelle)
--
DROP VIEW IF EXISTS `life_of_tamagotchis`;
CREATE TABLE IF NOT EXISTS `life_of_tamagotchis` (
`id` tinyint(3) unsigned
,`name` varchar(50)
,`hungry` json
,`drink` json
,`boredom` json
,`sleep` json
);

-- --------------------------------------------------------

--
-- Structure de la table `tamagotchis`
--

DROP TABLE IF EXISTS `tamagotchis`;
CREATE TABLE IF NOT EXISTS `tamagotchis` (
  `id_users` tinyint(3) UNSIGNED DEFAULT NULL,
  `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `creation_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_users` (`id_users`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déclencheurs `tamagotchis`
--
DROP TRIGGER IF EXISTS `after_insert_tamagotchi_stats`;
DELIMITER $$
CREATE TRIGGER `after_insert_tamagotchi_stats` AFTER INSERT ON `tamagotchis` FOR EACH ROW BEGIN
  DECLARE default_stats TINYINT UNSIGNED DEFAULT 70;

  INSERT INTO historical_actions (id_tamagotchis, hungry, drink, sleep, boredom, action_type)
    VALUE (
           NEW.id,
           default_stats,
           default_stats,
           default_stats,
           default_stats,
           'created'
    );
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la vue `alive_tamagotchis`
--
DROP TABLE IF EXISTS `alive_tamagotchis`;

DROP VIEW IF EXISTS `alive_tamagotchis`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `alive_tamagotchis`  AS SELECT `users`.`id` AS `user_id`, `tamagotchis`.`id` AS `id`, `tamagotchis`.`name` AS `name`, `get_stats`(`tamagotchis`.`id`,'hungry') AS `hungry`, `get_stats`(`tamagotchis`.`id`,'drink') AS `drink`, `get_stats`(`tamagotchis`.`id`,'sleep') AS `sleep`, `get_stats`(`tamagotchis`.`id`,'boredom') AS `boredom`, `get_level`(`tamagotchis`.`id`) AS `level` FROM ((`tamagotchis` join `users` on((`users`.`id` = `tamagotchis`.`id_users`))) left join `deaths` on((`tamagotchis`.`id` = `deaths`.`id_tamagotchis`))) WHERE (`is_alive`(`tamagotchis`.`id`) is true) ORDER BY `tamagotchis`.`creation_date` DESC ;

-- --------------------------------------------------------

--
-- Structure de la vue `dead_tamagotchis`
--
DROP TABLE IF EXISTS `dead_tamagotchis`;

DROP VIEW IF EXISTS `dead_tamagotchis`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `dead_tamagotchis`  AS SELECT `users`.`id` AS `user_id`, `tamagotchis`.`id` AS `id`, `tamagotchis`.`name` AS `name`, `get_level`(`tamagotchis`.`id`) AS `level`, `deaths`.`reason` AS `reason`, `tamagotchis`.`creation_date` AS `creation_date`, `deaths`.`creation_date` AS `death_date` FROM ((`tamagotchis` join `users` on((`users`.`id` = `tamagotchis`.`id_users`))) left join `deaths` on((`tamagotchis`.`id` = `deaths`.`id_tamagotchis`))) WHERE (`is_alive`(`tamagotchis`.`id`) is false) ;

-- --------------------------------------------------------

--
-- Structure de la vue `life_of_tamagotchis`
--
DROP TABLE IF EXISTS `life_of_tamagotchis`;

DROP VIEW IF EXISTS `life_of_tamagotchis`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `life_of_tamagotchis`  AS SELECT `t`.`id` AS `id`, `t`.`name` AS `name`, json_arrayagg(`historical_actions`.`hungry`) AS `hungry`, json_arrayagg(`historical_actions`.`drink`) AS `drink`, json_arrayagg(`historical_actions`.`boredom`) AS `boredom`, json_arrayagg(`historical_actions`.`sleep`) AS `sleep` FROM (`historical_actions` join `tamagotchis` `t` on((`t`.`id` = `historical_actions`.`id_tamagotchis`))) GROUP BY `t`.`id`, `t`.`name` ORDER BY `t`.`id` ASC ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

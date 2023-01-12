-- MySQL dump 10.13  Distrib 8.0.28, for macos11 (x86_64)
--
-- Host: localhost    Database: livecampus_project_bdd_tamagotchi
-- ------------------------------------------------------
-- Server version	8.0.28

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

CREATE DATABASE IF NOT EXISTS livecampus_project_bdd_tamagotchi;

USE livecampus_project_bdd_tamagotchi;

--
-- Table structure for table `actions`
--

DROP TABLE IF EXISTS `actions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8 */;
CREATE TABLE `actions` (
  `id_tamagotchis` tinyint unsigned NOT NULL,
  `id` tinyint unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('eat','drink','sleep','play') NOT NULL,
  `creation_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_tamagotchis` (`id_tamagotchis`),
  CONSTRAINT `actions_ibfk_1` FOREIGN KEY (`id_tamagotchis`) REFERENCES `tamagotchis` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `after_action_tamagotchi_stats` AFTER INSERT ON `actions` FOR EACH ROW BEGIN
  IF NEW.type = 'eat' THEN
    CALL update_tamagotchi_stats(NEW.id_tamagotchis, 30, -10, -5, -5, NEW.type);

  ELSEIF NEW.type = 'drink' THEN
    CALL update_tamagotchi_stats(NEW.id_tamagotchis, -10, 30, -5, -5, NEW.type);

  ELSEIF NEW.type = 'sleep' THEN
    CALL update_tamagotchi_stats(NEW.id_tamagotchis, -10, -15, 30, -15, NEW.type);

  ELSE
    CALL update_tamagotchi_stats(NEW.id_tamagotchis, -5, -5, -5, 15, NEW.type);
  END IF;

END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Temporary view structure for view `alive_tamagotchis`
--

DROP TABLE IF EXISTS `alive_tamagotchis`;
/*!50001 DROP VIEW IF EXISTS `alive_tamagotchis`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8 */;
/*!50001 CREATE VIEW `alive_tamagotchis` AS SELECT 
 1 AS `user_id`,
 1 AS `id`,
 1 AS `name`,
 1 AS `hungry`,
 1 AS `drink`,
 1 AS `sleep`,
 1 AS `boredom`,
 1 AS `level`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `dead_tamagotchis`
--

DROP TABLE IF EXISTS `dead_tamagotchis`;
/*!50001 DROP VIEW IF EXISTS `dead_tamagotchis`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8 */;
/*!50001 CREATE VIEW `dead_tamagotchis` AS SELECT 
 1 AS `user_id`,
 1 AS `id`,
 1 AS `name`,
 1 AS `level`,
 1 AS `reason`,
 1 AS `creation_date`,
 1 AS `death_date`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `deaths`
--

DROP TABLE IF EXISTS `deaths`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8 */;
CREATE TABLE `deaths` (
  `id_tamagotchis` tinyint unsigned NOT NULL,
  `id` tinyint unsigned NOT NULL AUTO_INCREMENT,
  `reason` varchar(50) NOT NULL,
  `creation_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_tamagotchis` (`id_tamagotchis`),
  CONSTRAINT `deaths_ibfk_1` FOREIGN KEY (`id_tamagotchis`) REFERENCES `tamagotchis` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `historical_actions`
--

DROP TABLE IF EXISTS `historical_actions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8 */;
CREATE TABLE `historical_actions` (
  `id_tamagotchis` tinyint unsigned NOT NULL,
  `id` tinyint unsigned NOT NULL AUTO_INCREMENT,
  `hungry` tinyint NOT NULL,
  `drink` tinyint NOT NULL,
  `sleep` tinyint NOT NULL,
  `boredom` tinyint NOT NULL,
  `action_type` enum('eat','drink','sleep','play','created') NOT NULL,
  `creation_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_tamagotchis` (`id_tamagotchis`),
  CONSTRAINT `historical_actions_ibfk_1` FOREIGN KEY (`id_tamagotchis`) REFERENCES `tamagotchis` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `after_update_tamagotchi_stats` AFTER INSERT ON `historical_actions` FOR EACH ROW BEGIN
  IF NEW.hungry = 0 THEN
    CALL set_death(NEW.id_tamagotchis, 'Starved to Death');

  ELSEIF NEW.drink = 0 THEN
    CALL set_death(NEW.id_tamagotchis, 'Death by Dehydration');

  ELSEIF NEW.sleep = 0 THEN
    CALL set_death(NEW.id_tamagotchis, 'Death from Sleep');

  ELSEIF NEW.boredom = 0 THEN
    CALL set_death(NEW.id_tamagotchis, 'Death of Boredom');
  END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `tamagotchis`
--

DROP TABLE IF EXISTS `tamagotchis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8 */;
CREATE TABLE `tamagotchis` (
  `id_users` tinyint unsigned DEFAULT NULL,
  `id` tinyint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `creation_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_users` (`id_users`),
  CONSTRAINT `tamagotchis_ibfk_1` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `after_insert_tamagotchi_stats` AFTER INSERT ON `tamagotchis` FOR EACH ROW BEGIN
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
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` tinyint unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping routines for database 'livecampus_project_bdd_tamagotchi'
--
/*!50003 DROP FUNCTION IF EXISTS `get_level` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `get_level`(id_tamagotchis TINYINT UNSIGNED) RETURNS tinyint
    DETERMINISTIC
BEGIN
  DECLARE nb_actions TINYINT;

-- On compte le nombre de ligne dans la table actions pour un tamagotchi donné
  SELECT COUNT(*)
  into nb_actions
  FROM actions a
         INNER JOIN tamagotchis t ON t.id = a.id_tamagotchis
  WHERE id_tamagotchis = a.id_tamagotchis;


-- Si le nombre d'actions est inférieurs à 10 il est niveau 1
  IF nb_actions <= 10 THEN
    RETURN 1;
  ELSE
-- Si il a plus de 10 actions alors on (divise par 10) + 1 pour le décalage. Round() afin d'arrondir.
    RETURN round((nb_actions / 10) + 1);
  END IF;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `get_stats` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `get_stats`(
  id_tamagotchi TINYINT UNSIGNED,
  stats_name ENUM ('hungry', 'drink', 'sleep', 'boredom')
) RETURNS tinyint unsigned
    DETERMINISTIC
BEGIN
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
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `is_alive` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `is_alive`(id_tamagotchis TINYINT UNSIGNED) RETURNS tinyint(1)
    DETERMINISTIC
BEGIN
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
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `bedtime` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `bedtime`(IN tamagotchi_id TINYINT UNSIGNED)
BEGIN
  INSERT INTO actions (id_tamagotchis, type) VALUE (tamagotchi_id, 'sleep');
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `create_account` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `create_account`(IN user VARCHAR(50))
BEGIN
  DECLARE db_user_account VARCHAR(50);
  SELECT username INTO db_user_account FROM users WHERE username = user LIMIT 1;

  IF db_user_account IS NOT NULL THEN
    SIGNAL SQLSTATE '40000' SET MESSAGE_TEXT = 'User account already exist';
  END IF;

  INSERT INTO users (username) VALUE (user);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `create_tamagotchi` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `create_tamagotchi`(IN user_id TINYINT UNSIGNED, IN tamagotchi_name VARCHAR(50))
BEGIN
  INSERT INTO tamagotchis (id_users, name)
  VALUES (user_id, tamagotchi_name);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `drink` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `drink`(IN tamagotchi_id TINYINT UNSIGNED)
BEGIN
  INSERT INTO actions (id_tamagotchis, type) VALUE (tamagotchi_id, 'drink');
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `eat` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `eat`(IN tamagotchi_id TINYINT UNSIGNED)
BEGIN
  INSERT INTO actions (id_tamagotchis, type) VALUE (tamagotchi_id, 'eat');
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `enjoy` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `enjoy`(IN tamagotchi_id TINYINT UNSIGNED)
BEGIN
  INSERT INTO actions (id_tamagotchis, type) VALUE (tamagotchi_id, 'play');
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `set_death` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `set_death`(IN tamagotchi_id TINYINT UNSIGNED, IN current_reason VARCHAR(64))
BEGIN
  INSERT INTO deaths (id_tamagotchis, reason) VALUE (tamagotchi_id, current_reason);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `update_tamagotchi_stats` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `update_tamagotchi_stats`(IN tamagotchi_id TINYINT UNSIGNED,
                                         IN new_hungry TINYINT,
                                         IN new_drink TINYINT,
                                         IN new_sleep TINYINT,
                                         IN new_boredom TINYINT,
                                         IN current_action_type ENUM ('eat', 'drink', 'sleep', 'play', 'created'))
BEGIN
  DECLARE db_current_hungry TINYINT;
  DECLARE db_current_drink TINYINT;
  DECLARE db_current_sleep TINYINT;
  DECLARE db_current_boredom TINYINT;

  SELECT hungry, drink, sleep, boredom
  INTO db_current_hungry, db_current_drink, db_current_sleep, db_current_boredom
  FROM tamagotchis
         JOIN historical_actions ha on tamagotchis.id = ha.id_tamagotchis
  WHERE tamagotchis.id = tamagotchi_id
  ORDER BY ha.creation_date DESC
  LIMIT 1;

  IF db_current_hungry = 0 OR db_current_boredom = 0 OR db_current_sleep = 0 OR db_current_drink = 0 THEN
    SIGNAL SQLSTATE '40000' SET MESSAGE_TEXT =
        'Bad Request, The current tamagotchi already have a stats to 0 (already dead)';
  END IF;

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
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Final view structure for view `alive_tamagotchis`
--

/*!50001 DROP VIEW IF EXISTS `alive_tamagotchis`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `alive_tamagotchis` AS select `users`.`id` AS `user_id`,`tamagotchis`.`id` AS `id`,`tamagotchis`.`name` AS `name`,`get_stats`(`tamagotchis`.`id`,'hungry') AS `hungry`,`get_stats`(`tamagotchis`.`id`,'drink') AS `drink`,`get_stats`(`tamagotchis`.`id`,'sleep') AS `sleep`,`get_stats`(`tamagotchis`.`id`,'boredom') AS `boredom`,`get_level`(`tamagotchis`.`id`) AS `level` from ((`tamagotchis` join `users` on((`users`.`id` = `tamagotchis`.`id_users`))) left join `deaths` on((`tamagotchis`.`id` = `deaths`.`id_tamagotchis`))) where ((0 <> `is_alive`(`tamagotchis`.`id`)) is true) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `dead_tamagotchis`
--

/*!50001 DROP VIEW IF EXISTS `dead_tamagotchis`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `dead_tamagotchis` AS select `users`.`id` AS `user_id`,`tamagotchis`.`id` AS `id`,`tamagotchis`.`name` AS `name`,`get_level`(`tamagotchis`.`id`) AS `level`,`deaths`.`reason` AS `reason`,`tamagotchis`.`creation_date` AS `creation_date`,`deaths`.`creation_date` AS `death_date` from ((`tamagotchis` join `users` on((`users`.`id` = `tamagotchis`.`id_users`))) left join `deaths` on((`tamagotchis`.`id` = `deaths`.`id_tamagotchis`))) where ((0 <> `is_alive`(`tamagotchis`.`id`)) is false) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-01-12  9:34:55

CREATE DATABASE IF NOT EXISTS livecampus_project_bdd_tamagotchi;

USE livecampus_project_bdd_tamagotchi;

CREATE TABLE IF NOT EXISTS users
(
  id       TINYINT UNSIGNED AUTO_INCREMENT,
  username VARCHAR(50) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE (username)
);

CREATE TABLE IF NOT EXISTS tamagotchis
(
  id_users      TINYINT UNSIGNED,
  id            TINYINT UNSIGNED AUTO_INCREMENT,
  name           VARCHAR(50) NOT NULL,
  hungry        TINYINT     NOT NULL DEFAULT 70,
  thirsty       TINYINT     NOT NULL DEFAULT 70,
  sleep         TINYINT     NOT NULL DEFAULT 70,
  boredom       TINYINT     NOT NULL DEFAULT 70,
  level         TINYINT     NOT NULL DEFAULT 1,
  nb_action     TINYINT     NOT NULL DEFAULT 0,
  creation_date DATETIME    NOT NULL DEFAULT NOW(),
  dead_date     DATETIME,
  death_reason  VARCHAR(50),
  PRIMARY KEY (id),
  FOREIGN KEY (id_users) REFERENCES users (id)
);
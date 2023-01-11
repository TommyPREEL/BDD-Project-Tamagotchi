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
  name          VARCHAR(50) NOT NULL,
  creation_date DATETIME    NOT NULL DEFAULT NOW(),
  PRIMARY KEY (id),
  FOREIGN KEY (id_users) REFERENCES users (id)
);

CREATE TABLE IF NOT EXISTS actions
(
  id_tamagotchis TINYINT UNSIGNED                       NOT NULL,
  id             TINYINT UNSIGNED AUTO_INCREMENT        NOT NULL,
  type           ENUM ('eat', 'drink', 'sleep', 'play') NOT NULL,
  creation_date  DATETIME                               NOT NULL DEFAULT NOW(),
  PRIMARY KEY (id),
  FOREIGN KEY (id_tamagotchis) REFERENCES tamagotchis (id)
);

CREATE TABLE IF NOT EXISTS deaths
(
  id_tamagotchis TINYINT UNSIGNED                NOT NULL,
  id             TINYINT UNSIGNED AUTO_INCREMENT NOT NULL,
  reason         VARCHAR(50)                     NOT NULL,
  creation_date  DATETIME                        NOT NULL DEFAULT NOW(),
  PRIMARY KEY (id),
  FOREIGN KEY (id_tamagotchis) REFERENCES tamagotchis (id)
);

CREATE TABLE IF NOT EXISTS historical_actions
(
  id_tamagotchis TINYINT UNSIGNED                                     NOT NULL,
  id             TINYINT UNSIGNED AUTO_INCREMENT                      NOT NULL,
  hungry         TINYINT                                              NOT NULL,
  drink          TINYINT                                              NOT NULL,
  sleep          TINYINT                                              NOT NULL,
  boredom        TINYINT                                              NOT NULL,
  action_type    ENUM ('eat', 'drink', 'sleep', 'play', 'created') NOT NULL,
  creation_date  DATETIME                                             NOT NULL DEFAULT NOW(),
  PRIMARY KEY (id),
  FOREIGN KEY (id_tamagotchis) REFERENCES tamagotchis (id)
);
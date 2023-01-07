CREATE DATABASE IF NOT EXISTS livecampus_project_bdd_tamagotchi;

USE livecampus_project_bdd_tamagotchi;

CREATE TABLE Users(
   id INT AUTO_INCREMENT,
   login VARCHAR(50)  NOT NULL,
   PRIMARY KEY(id),
   UNIQUE(login)
);

CREATE TABLE Tamagotchis(
   id_1 INT,
   id INT AUTO_INCREMENT,
   name VARCHAR(50)  NOT NULL,
   hungry TINYINT NOT NULL,
   thirsty TINYINT NOT NULL,
   sleep TINYINT NOT NULL,
   boredom TINYINT NOT NULL,
   level TINYINT NOT NULL,
   nb_action TINYINT NOT NULL,
   creation_date DATETIME NOT NULL,
   dead_date DATETIME,
   death_reason VARCHAR(50) ,
   PRIMARY KEY(id_1, id),
   FOREIGN KEY(id_1) REFERENCES Users(id)
);
# | BDD Project Tamagotchi

### Revive your childhood by playing with Tamagotchis !

# Requirements

#### MYSQL version : 8
#### PHP version : 8.0.13

# Getting started

- Dependencies installation
- Import the SQL dump
- Configure the environment
- Start the project

## Dependencies installation

#### Install Composer on your computer, check the [documentation](https://getcomposer.org/doc/00-intro.md).

#### Open a terminal an type this following command :

``` 
composer install
```

## Import the database

#### You need a local server with Apache, severals solutions are available on [Windows](https://www.wampserver.com/) and [Mac](https://www.mamp.info/en/downloads/).

#### Now, you have **two ways** to create the database.
***(PRIORITIZE THE FIRST WAY: the second is in development)***

- 1 - Import the SQL dump

#### Open your local server, open your database manager then import the script **dump.sql** (available in this folder).

- 2 - By commands

***(WORKS ONLY ON THE TABLES FOR THIS MOMENT)***
#### Open a new terminal, then type :
```php
php ./migration.php next // To progress to the next migration
php ./migration.php previous // To cancel the last migration
php ./migration.php reset // To cancel all migrations
php ./migration.php migrate // To progress from the actual migration to the last migration
```
#### Now, you have to import manually the procedures, the functions, the triggers and the views

## Configure the environment

#### In the .env file, you have to change the credentials access to your database.

## Start the project
#### Open your navigator, type your local server address, open the project and enjoy !

# Data sets 

#### Import the file ***assets/sql/mock.sql*** if you want some data in your database.

# Documentation
#### Available in the folder ***documentation***, then open the ***index.html***.

#### Click on the tabs named ***Data Structures***, then click on all the dropdown menu with a ***N*** in a blue square to close subtitles.

#### All informations that you need about the classes are available in the dropdown menu with a ***C*** in a blue square.

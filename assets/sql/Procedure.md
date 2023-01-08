# Procédure

Utilisation des différentes procédures

## Users

### create_account

Fonction qui en entrée prend un argument :
- user VARCHAR(50)

Vérifie que l'utilisateur n'existe pas, et sinon envoie une erreur `User already exist` de code `40000`.

### get_account

Fonction qui en entrée prend un argument :
- user VARCHAR(50)

Vérifie que l'utilisateur existe, sinon envoie une erreur `User not exist` de code `40001`.

## Tamagotchis

### create_tamagotchis

Fonction qui crée un tamagotchi et prend deux arguments :
- user VARCHAR(50)
- tamagotchi_name VARCHAR(50)

Vérifie que l'utilisateur existe bien dans la BDD et en suite crée le tamagotchi et le lie à l'utilisateur correspondant.

### get_tamagotchis
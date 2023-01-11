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

Vérifie que l'utilisateur existe bien dans la BDD et en suite crée le tamagotchi et le lie à l'utilisateur
correspondant.

### set_death

Ne dois pas être appelé dans PHP, cette procedure est appelé uniquement par un trigger lors de la mise à jour d'un
tamagotchi.
Elle insert une ligne dans la table death pour faire correspondre ce tamagotchi à une mort certaine

### update_tamagotchis_stats

Met à jour les statistique d'un tamagotchi, ne doit pas être appelé depuis PHP.
Est utilisé depuis d'autre procédure afin de simplifier le controle des données et de tout réunir à un seul point.

## Actions

Chacune de ces action ajoute une ligne dans la table action, la mise à jour des stats sera appelé par un trigger

### bedtime

Fais dormir le tamagotchi et va mettre à jour ses stats à l'aide de `update_tamagotchis_stats`
Prends en paramètre l'id du tamagotchi

Exemple :

```SQL
CALL bedtime(1)
```

### drink

Fais boire le tamagotchi et va mettre à jour ses stats à l'aide de `update_tamagotchis_stats`
Prends en paramètre l'id du tamagotchi

Exemple :

```SQL
CALL drink(1)
```

### eat

Fais manger le tamagotchi et va mettre à jour ses stats à l'aide de `update_tamagotchis_stats`
Prends en paramètre l'id du tamagotchi

Exemple :

```SQL
CALL eat(1)
```

### enjoy

Fais jouer le tamagotchi et va mettre à jour ses stats à l'aide de `update_tamagotchis_stats`
Prends en paramètre l'id du tamagotchi

Exemple :

```SQL
CALL enjoy(1)
```

# Triggers

## after_action_tamagotchis_stats

Après l'ajout d'une ligne dans la table action, le tamagotchi correspondant à la ligne ajouter sera mis en jour en
fonction de son type d'action.

## after_update_tamagotchi_stats

Après avoir mis à jour un tamagotchi, le trigger vérifie si une des stats est à 0, si oui alors le tamagotchi est mort
et donc nous ajoutons une ligne dans la table deaths avec son id.

# Functions

## get_level

Récupère le nombre d'action et calcul le niveau actuel du tamagotchi

Prend en paramètre l'id du tamagotchi

## is_alive

Vérifie si le tamagotchi est vivant

Prend en paramètre l'id du tamagotchi
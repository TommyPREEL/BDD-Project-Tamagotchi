# Methods to apply in PHP

## create_account

@params :

- user VARCHAR(50)

```SQL
CALL create_account('username')
```

## create_tamagotchis

@params :

- user VARCHAR(50)
- tamagotchi_name VARCHAR(50)

```SQL
CALL create_tamagotchi('username', 'tamagotchi_name')
```

## Actions

### bedtime

@params :

- tamagotchi_id TINYINT UNSIGNED

```SQL
CALL bedtime(1)
```

### eat

@params :

- tamagotchi_id TINYINT UNSIGNED

```SQL
CALL eat(1)
```

### drink

@params :

- tamagotchi_id TINYINT UNSIGNED

```SQL
CALL drink(1)
```

### enjoy

@params :

- tamagotchi_id TINYINT UNSIGNED

```SQL
CALL enjoy(1)
```

## Views

Views to use to manage the displaying of tamagotchis

### Alive Tamagotchi

```SQL
SELECT *
FROM alive_tamagotchis;
```

### Dead Tamagotchi

```SQL
SELECT *
FROM dead_tamagotchis;
```
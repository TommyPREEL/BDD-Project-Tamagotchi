CREATE FUNCTION get_level(id_tamagotchis TINYINT UNSIGNED)
  RETURNS TINYINT
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

END;

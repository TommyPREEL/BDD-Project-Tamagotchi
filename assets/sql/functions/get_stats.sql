DELIMITER //

-- Get stat of tamagotchi
CREATE FUNCTION get_stats(
  id_tamagotchi TINYINT UNSIGNED,
  stats_name ENUM ('hungry', 'drink', 'sleep', 'boredom')
)
  RETURNS TINYINT UNSIGNED
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
END //

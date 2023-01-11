DELIMITER //
CREATE PROCEDURE update_tamagotchi_stats(IN tamagotchi_id TINYINT UNSIGNED,
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

  SET db_current_hungry = db_current_hungry + new_hungry;
  SET db_current_drink = db_current_drink + new_drink;
  SET db_current_sleep = db_current_sleep + new_sleep;
  SET db_current_boredom = db_current_boredom + new_boredom;

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
END //
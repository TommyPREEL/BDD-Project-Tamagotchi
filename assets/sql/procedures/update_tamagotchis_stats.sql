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
  DECLARE tamagotchi_level TINYINT;

  -- Inject data into declared variables
  SELECT hungry, drink, sleep, boredom, get_level(tamagotchi_id)
  INTO db_current_hungry, db_current_drink, db_current_sleep, db_current_boredom, tamagotchi_level
  FROM tamagotchis
         JOIN historical_actions ha on tamagotchis.id = ha.id_tamagotchis
  WHERE tamagotchis.id = tamagotchi_id
  ORDER BY ha.creation_date DESC
  LIMIT 1;

  -- If one of the stars is equal to or greater than 80 then an error is returned to prevent the user from doing their action
  IF current_action_type = 'hungry' AND db_current_hungry >= 80 THEN
    SIGNAL SQLSTATE '40004' SET MESSAGE_TEXT = 'The hunger stat is already at or above 80';
  ELSEIF current_action_type = 'drink' AND db_current_drink >= 80 THEN
    SIGNAL SQLSTATE '40004' SET MESSAGE_TEXT = 'The drink stat is already at or above 80';
  ELSEIF current_action_type = 'sleep' AND db_current_sleep >= 80 THEN
    SIGNAL SQLSTATE '40004' SET MESSAGE_TEXT = 'The sleep stat is already at or above 80';
  ELSEIF current_action_type = 'play' AND db_current_boredom >= 80 THEN
    SIGNAL SQLSTATE '40004' SET MESSAGE_TEXT = 'The boredom stat is already at or above 80';
  END IF;

  -- Control if a one stats of tamagotchi is equal to 0 return a error.
  IF db_current_hungry = 0 OR db_current_boredom = 0 OR db_current_sleep = 0 OR db_current_drink = 0 THEN
    SIGNAL SQLSTATE '40000' SET MESSAGE_TEXT =
        'Bad Request, The current tamagotchi already have a stats to 0 (already dead)';
  END IF;

  -- Subtracts 1 point from the level of the tamagotchis, to be able to add the level gain to the stats
  SET tamagotchi_level = tamagotchi_level - 1;

  -- Add tamagotchi level to the stats to add
  SET new_hungry = if(new_hungry < 0, new_hungry - tamagotchi_level, new_hungry + tamagotchi_level);
  SET new_drink = if(new_drink < 0, new_drink - tamagotchi_level, new_drink + tamagotchi_level);
  SET new_sleep = if(new_sleep < 0, new_sleep - tamagotchi_level, new_sleep + tamagotchi_level);
  SET new_boredom = if(new_boredom < 0, new_boredom - tamagotchi_level, new_boredom + tamagotchi_level);

  -- If the update of the statistic gives a result lower than 0, then we force its value to 0
  SET db_current_hungry = if(db_current_hungry + new_hungry < 0, 0, db_current_hungry + new_hungry);
  SET db_current_drink = if(db_current_drink + new_drink < 0, 0, db_current_drink + new_drink);
  SET db_current_sleep = if(db_current_sleep + new_sleep < 0, 0, db_current_sleep + new_sleep);
  SET db_current_boredom = if(db_current_boredom + new_boredom < 0, 0, db_current_boredom + new_boredom);

  -- If the update of the statistic gives a result greater than 100, then we force its value to 100
  SET db_current_hungry = if(db_current_hungry > 100, 100, db_current_hungry);
  SET db_current_drink = if(db_current_drink > 100, 100, db_current_drink);
  SET db_current_sleep = if(db_current_sleep > 100, 100, db_current_sleep);
  SET db_current_boredom = if(db_current_boredom > 100, 100, db_current_boredom);

  -- Insert action into historical_actions table
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
END
//
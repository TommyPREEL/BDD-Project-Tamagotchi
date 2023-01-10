CREATE PROCEDURE update_tamagotchi_stats(IN tamagotchi_id TINYINT UNSIGNED,
                                         IN new_hungry TINYINT,
                                         IN new_drink TINYINT,
                                         IN new_sleep TINYINT,
                                         IN new_boredom TINYINT)
BEGIN
  DECLARE db_current_hungry TINYINT;
  DECLARE db_current_drink TINYINT;
  DECLARE db_current_sleep TINYINT;
  DECLARE db_current_boredom TINYINT;

  SELECT hungry, drink, sleep, boredom
  INTO db_current_hungry, db_current_drink, db_current_sleep, db_current_boredom
  FROM tamagotchis
  WHERE id = tamagotchi_id
  LIMIT 1;

  IF db_current_hungry = 0 OR db_current_boredom = 0 OR db_current_sleep = 0 OR db_current_drink = 0 THEN
    SIGNAL SQLSTATE '40000' SET MESSAGE_TEXT =
        'Bad Request, The current tamagotchi already have a stats to 0 (already dead)';
  END IF;

  SET db_current_hungry = db_current_hungry + new_hungry;
  SET db_current_drink = db_current_drink + new_drink;
  SET db_current_sleep = db_current_sleep + new_sleep;
  SET db_current_boredom = db_current_boredom + new_boredom;

  UPDATE tamagotchis
  SET hungry  = if(db_current_hungry > 100, 100, if(db_current_hungry < 0, 0, db_current_hungry)),
      drink   = if(db_current_drink > 100, 100, if(db_current_drink < 0, 0, db_current_drink)),
      sleep   = if(db_current_sleep > 100, 100, if(db_current_sleep < 0, 0, db_current_sleep)),
      boredom = if(db_current_boredom > 100, 100, if(db_current_boredom < 0, 0, db_current_boredom))
  WHERE id = tamagotchi_id;
END;
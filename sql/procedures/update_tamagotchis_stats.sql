DELIMITER //

CREATE PROCEDURE update_tamagotchi_stats(IN tamagotchi_id TINYINT UNSIGNED,
                                         IN new_hungry TINYINT,
                                         IN new_thirsty TINYINT,
                                         IN new_sleep TINYINT,
                                         IN new_boredom TINYINT)
BEGIN
  DECLARE db_current_hungry TINYINT;
  DECLARE db_current_thirsty TINYINT;
  DECLARE db_current_sleep TINYINT;
  DECLARE db_current_boredom TINYINT;
  DECLARE db_current_action TINYINT;

  SELECT hungry, thirsty, sleep, boredom, nb_action
  INTO db_current_hungry, db_current_thirsty, db_current_sleep, db_current_boredom, db_current_action
  FROM tamagotchis
  WHERE id = tamagotchi_id
  LIMIT 1;

  UPDATE tamagotchis
  SET hungry  = db_current_hungry + new_hungry,
      thirsty = db_current_thirsty + new_thirsty,
      sleep   = db_current_sleep + new_sleep,
      boredom = db_current_boredom + new_boredom,
      nb_action = db_current_action + 1
  WHERE id = tamagotchi_id;
END //
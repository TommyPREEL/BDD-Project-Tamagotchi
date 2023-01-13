DELIMITER //
-- After a insert into historical_actions, we check if one of the tamagotchi statistics is equal to 0
-- If is true, we call set_death procedure to kill the current tamagotchi
CREATE TRIGGER after_update_tamagotchi_stats
  AFTER INSERT
  ON historical_actions
  FOR EACH ROW
BEGIN
  IF NEW.hungry = 0 THEN
    CALL set_death(NEW.id_tamagotchis, 'Starved to Death');

  ELSEIF NEW.drink = 0 THEN
    CALL set_death(NEW.id_tamagotchis, 'Death by Dehydration');

  ELSEIF NEW.sleep = 0 THEN
    CALL set_death(NEW.id_tamagotchis, 'Death from Sleep');

  ELSEIF NEW.boredom = 0 THEN
    CALL set_death(NEW.id_tamagotchis, 'Death of Boredom');
  END IF;
END//

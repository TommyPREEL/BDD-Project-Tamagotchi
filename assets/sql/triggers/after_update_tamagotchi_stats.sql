DELIMITER //
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

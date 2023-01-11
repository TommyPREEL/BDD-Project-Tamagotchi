CREATE TRIGGER after_update_tamagotchi_stats
  AFTER UPDATE
  ON tamagotchis
  FOR EACH ROW
BEGIN
  IF NEW.hungry = 0 THEN
    CALL set_death(NEW.id, 'Starved to Death');

  ELSEIF NEW.drink = 0 THEN
    CALL set_death(NEW.id, 'Death by Dehydration');

  ELSEIF NEW.sleep = 0 THEN
    CALL set_death(NEW.id, 'Death from Sleep');

  ELSEIF NEW.boredom = 0 THEN
    CALL set_death(NEW.id, 'Death of Boredom');
  END IF;
END;

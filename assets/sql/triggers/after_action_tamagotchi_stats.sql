DELIMITER //
CREATE TRIGGER after_action_tamagotchi_stats
  AFTER INSERT
  ON actions
  FOR EACH ROW
BEGIN
  IF NEW.type = 'eat' THEN
    CALL update_tamagotchi_stats(NEW.id_tamagotchis, 30, -10, -5, -5);

  ELSEIF NEW.type = 'drink' THEN
    CALL update_tamagotchi_stats(NEW.id_tamagotchis, -10, 30, -5, -5);

  ELSEIF NEW.type = 'sleep' THEN
    CALL update_tamagotchi_stats(NEW.id_tamagotchis, -10, -15, 30, -15);

  ELSE
    CALL update_tamagotchi_stats(NEW.id_tamagotchis, -5, -5, -5, 15);
  END IF;

END//

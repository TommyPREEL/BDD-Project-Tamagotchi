DELIMITER //

CREATE PROCEDURE make_action(IN tamagotchi_id TINYINT, IN action ENUM ('eat', 'drink', 'sleep', 'play'))
BEGIN
  IF action = 'eat' THEN
    CALL update_tamagotchi_stats(tamagotchi_id, 30, -10, -5, -5);

  ELSEIF action = 'drink' THEN
    CALL update_tamagotchi_stats(tamagotchi_id, -10, 30, -5, -5);

  ELSEIF action = 'sleep' THEN
    CALL update_tamagotchi_stats(tamagotchi_id, -10, -15, 30, -15);

  ELSEIF action = 'play' THEN
    CALL update_tamagotchi_stats(tamagotchi_id, -5, -5, -5, 15);

  ELSE
    SIGNAL SQLSTATE '40005' SET MESSAGE_TEXT = 'action is not in enum';
  END IF;
END //

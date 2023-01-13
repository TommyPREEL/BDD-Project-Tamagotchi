DELIMITER //
-- Function to validate if the tamagotchi is alive, THANKS CAPTAIN OBVIOUS
CREATE FUNCTION is_alive(id_tamagotchis TINYINT UNSIGNED)
  RETURNS BOOL
  DETERMINISTIC
BEGIN
  DECLARE reason_death VARCHAR(50);
  DECLARE tamagotchi_name VARCHAR(50);

  SELECT deaths.reason, tamagotchis.name
  INTO reason_death, tamagotchi_name
  FROM tamagotchis
         LEFT JOIN deaths ON tamagotchis.id = deaths.id_tamagotchis
  WHERE tamagotchis.id = id_tamagotchis
  LIMIT 1;

  IF tamagotchi_name IS NULL THEN
    SIGNAL SQLSTATE '40001' SET MESSAGE_TEXT = 'The current tamagotchi does not exist';
  END IF;

  IF reason_death IS NULL THEN
    RETURN TRUE;
  ELSE
    RETURN FALSE;
  END IF;
END//

DELIMITER //

CREATE PROCEDURE create_tamagotchi(IN user_id TINYINT UNSIGNED, IN tamagotchi_name VARCHAR(50))
BEGIN
  DECLARE tamagotchi_name_length TINYINT;

  -- Verify the length of the tamagotchi name
  SELECT LENGTH(tamagotchi_name) INTO tamagotchi_name_length;

  -- Return a error 40000 'Bad Request'
  IF (tamagotchi_name_length = 0) THEN
    SIGNAL SQLSTATE '40000' SET MESSAGE_TEXT = 'Bad Request: Tamagotchi name cannot be null';
  END IF;

  INSERT INTO tamagotchis (id_users, name)
  VALUES (user_id, tamagotchi_name);
END//

DELIMITER ;
DELIMITER //

CREATE PROCEDURE create_tamagotchi(IN user_id TINYINT UNSIGNED, IN tamagotchi_name VARCHAR(50))
BEGIN
  INSERT INTO tamagotchis (id_users, name)
  VALUES (user_id, tamagotchi_name);
END//

DELIMITER ;
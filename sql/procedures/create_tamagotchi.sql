CREATE PROCEDURE create_tamagotchi(IN user VARCHAR(50), IN tamagotchi_name VARCHAR(50))
BEGIN
  DECLARE db_user_account_name VARCHAR(50);
  DECLARE db_user_account_id TINYINT UNSIGNED;
  SELECT username, id INTO db_user_account_name, db_user_account_id FROM users WHERE username = user LIMIT 1;

  IF db_user_account_id IS NULL THEN
    SIGNAL SQLSTATE '40001' SET MESSAGE_TEXT = 'User account not exist';
  END IF;

  INSERT INTO tamagotchis (id_users, name)
  VALUES (db_user_account_id, tamagotchi_name);
END;

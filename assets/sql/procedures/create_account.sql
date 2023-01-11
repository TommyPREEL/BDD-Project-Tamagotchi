DELIMITER //

CREATE PROCEDURE create_account(IN user VARCHAR(50))
BEGIN
  DECLARE db_user_account VARCHAR(50);
  SELECT username INTO db_user_account FROM users WHERE username = user LIMIT 1;

  IF db_user_account IS NOT NULL THEN
    SIGNAL SQLSTATE '40000' SET MESSAGE_TEXT = 'User account already exist';
  END IF;

  INSERT INTO users (username) VALUE (user);
END//

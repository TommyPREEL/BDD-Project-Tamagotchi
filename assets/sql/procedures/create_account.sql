DELIMITER //

CREATE PROCEDURE create_account(IN user VARCHAR(50))
BEGIN
  DECLARE db_user_account VARCHAR(50);
  DECLARE username_length TINYINT;

  SELECT LENGTH(user) INTO username_length;

  IF (username_length = 0) THEN
    SIGNAL SQLSTATE '40000' SET MESSAGE_TEXT = 'Username cannot be null';
  END IF;

  SELECT username INTO db_user_account FROM users WHERE username = user LIMIT 1;

  -- Return a error 40000 'Bad Request'
  IF db_user_account IS NOT NULL THEN
    SIGNAL SQLSTATE '40000' SET MESSAGE_TEXT = 'Bad Request: User account already exist';
  END IF;

  INSERT INTO users (username) VALUE (user);
END//

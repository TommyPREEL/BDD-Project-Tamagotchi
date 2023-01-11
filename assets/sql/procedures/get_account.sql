DELIMITER //

CREATE PROCEDURE get_account(IN user VARCHAR(50))
BEGIN
  DECLARE db_user_account VARCHAR(50);
  SELECT username INTO db_user_account FROM users WHERE username = user LIMIT 1;

  IF db_user_account IS NULL THEN
    SIGNAL SQLSTATE '40001' SET MESSAGE_TEXT = 'User account not exist';
  END IF;
END//
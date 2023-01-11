CREATE PROCEDURE set_death(IN tamagotchi_id TINYINT UNSIGNED, IN current_reason VARCHAR(64))
BEGIN
  INSERT INTO deaths (id_tamagotchis, reason) VALUE (tamagotchi_id, current_reason);
END;
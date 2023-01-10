CREATE PROCEDURE bedtime(IN tamagotchi_id TINYINT UNSIGNED)
BEGIN
  INSERT INTO actions (id_tamagotchis, type) VALUE (tamagotchi_id, 'sleep');
END;
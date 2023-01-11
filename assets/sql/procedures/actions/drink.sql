CREATE PROCEDURE drink(IN tamagotchi_id TINYINT UNSIGNED)
BEGIN
  INSERT INTO actions (id_tamagotchis, type) VALUE (tamagotchi_id, 'drink');
END;
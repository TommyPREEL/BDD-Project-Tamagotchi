CREATE PROCEDURE make_action(
  IN tamagotchi_id TINYINT,
  IN action ENUM ('eat', 'drink', 'sleep', 'play')
)
BEGIN
  INSERT INTO actions (id_tamagotchis, type) VALUE (tamagotchi_id, action);
END;
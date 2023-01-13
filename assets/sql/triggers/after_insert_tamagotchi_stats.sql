-- After create a tamagotchi, we create his stats (add a line into historical_actions)
CREATE TRIGGER after_insert_tamagotchi_stats
  AFTER INSERT
  ON tamagotchis
  FOR EACH ROW
BEGIN
  DECLARE default_stats TINYINT UNSIGNED DEFAULT 70;

  INSERT INTO historical_actions (id_tamagotchis, hungry, drink, sleep, boredom, action_type)
    VALUE (
           NEW.id,
           default_stats,
           default_stats,
           default_stats,
           default_stats,
           'created'
    );
END;
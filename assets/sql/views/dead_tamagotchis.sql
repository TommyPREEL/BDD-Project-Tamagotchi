CREATE OR REPLACE VIEW dead_tamagotchis AS
SELECT users.id                  as user_id,
       tamagotchis.id,
       tamagotchis.name,
       get_level(tamagotchis.id) as level,
       deaths.reason,
       tamagotchis.creation_date as creation_date,
       deaths.creation_date      as death_date
FROM tamagotchis
       JOIN users on users.id = tamagotchis.id_users
       LEFT JOIN deaths on tamagotchis.id = deaths.id_tamagotchis
WHERE is_alive(tamagotchis.id) IS FALSE;
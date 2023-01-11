CREATE VIEW dead_tamagotchis AS
SELECT name,
       reason,
       tamagotchis.creation_date as creation_date,
       deaths.creation_date      as death_date,
       get_level(tamagotchis.id) as level
FROM tamagotchis
       JOIN users on users.id = tamagotchis.id_users
       LEFT JOIN deaths on tamagotchis.id = deaths.id_tamagotchis
WHERE is_alive(tamagotchis.id) IS FALSE;
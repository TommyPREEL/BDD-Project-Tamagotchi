-- Creation view to see all interesting column for the PHP backend
CREATE OR REPLACE VIEW alive_tamagotchis AS
SELECT users.id as user_id,
       tamagotchis.id,
       name,
       get_stats(tamagotchis.id, 'hungry')  as hungry,
       get_stats(tamagotchis.id, 'drink')   as drink,
       get_stats(tamagotchis.id, 'sleep')   as sleep,
       get_stats(tamagotchis.id, 'boredom') as boredom,
       get_level(tamagotchis.id)            as level
FROM tamagotchis
       JOIN users on users.id = tamagotchis.id_users
       LEFT JOIN deaths on tamagotchis.id = deaths.id_tamagotchis
WHERE is_alive(tamagotchis.id) IS TRUE;

CREATE VIEW dead_tamagotchis AS
SELECT username,
       nom,
       dead_date,
       death_reason,
       level
FROM tamagotchis
       JOIN users u on u.id = tamagotchis.id_users
WHERE dead_date IS NOT NULL;
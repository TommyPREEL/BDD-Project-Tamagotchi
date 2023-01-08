-- Creation view to see all interesting column for the PHP backend
CREATE VIEW alive_tamagotchis AS
SELECT username,
       nom,
       hungry,
       thirsty,
       sleep,
       boredom,
       level
FROM tamagotchis
       JOIN users u on u.id = tamagotchis.id_users
WHERE dead_date IS NULL;
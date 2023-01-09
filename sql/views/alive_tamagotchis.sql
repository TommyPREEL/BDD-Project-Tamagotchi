-- Creation view to see all interesting column for the PHP backend
CREATE VIEW alive_tamagotchis AS
SELECT username,
       name,
       hungry,
       drink,
       sleep,
       boredom
-- TODO : AJOUTER L'AFFICHAGE DU LEVEL DU TAMAGOTCHI
FROM tamagotchis
       JOIN users on users.id = tamagotchis.id_users
       LEFT JOIN deaths on tamagotchis.id = deaths.id_tamagotchis
WHERE is_alive(tamagotchis.id) IS TRUE;
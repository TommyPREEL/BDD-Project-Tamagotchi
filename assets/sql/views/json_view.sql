CREATE OR REPLACE VIEW life_of_tamagotchis AS
SELECT t.id,
       t.name,
       JSON_ARRAYAGG(hungry)  as hungry,
       JSON_ARRAYAGG(drink)   as drink,
       JSON_ARRAYAGG(boredom) as boredom,
       JSON_ARRAYAGG(sleep)   as sleep
FROM historical_actions
       JOIN tamagotchis t on t.id = historical_actions.id_tamagotchis
GROUP BY t.id, t.name
ORDER BY t.id;
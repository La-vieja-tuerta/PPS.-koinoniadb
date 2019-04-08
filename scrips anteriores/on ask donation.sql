use koinoniadb;

-- hay que hacer esta consulta por cada nodo del arbol que se obtiene
-- habria que hacer algo recursivo. Desde mysql no se puede porque no admite queries recursivas

select b.word from relation as r
join variant as a on a.synset = r.source
join variant as b on b.synset = r.target
where a.synset = ?;


select a.word, b.synset from relation as r
join variant as a on a.synset = r.source
join variant as b on b.synset = r.target
where a.word = "alimento";

WITH RECURSIVE ctepath AS (
  SELECT parentID FROM familytree WHERE childID=23             -- INDIVIDUAL’S FATHER
  UNION ALL
  SELECT f.parentID FROM familytree f                          -- AND THAT INDIVIDUAL’S FATHER ETC
  JOIN ctepath ON f.childID=ctepath.parentID
)
SELECT Group_Concat(parentID) As AncestorsOf23 FROM ctepath;

SHOW VARIABLES LIKE "%version%";
SHOW VARIABLES LIKE "secure_file_priv";
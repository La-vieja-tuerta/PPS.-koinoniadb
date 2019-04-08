use koinoniadb;
--show tables;
--SELECT getHyponimTree(77445);
--SELECT getMatchingResources(77430);
--SELECT targetSynset
--FROM resourceTree;
--SELECT FIND_IN_SET(3241,"1234, 3241, 1315");
--SELECT FORMAT("1234, 3241, 1315",-3);
-- la siguiente query selecciona aquellos id de resources_institutions
-- cuyos IDs representen resources que matcheen con algun recurso en el
-- arbol de hiperonimos

-- 01:12:08	SELECT getHyponimTree(77445) LIMIT 0, 1000	Error Code: 1292. Truncated incorrect
-- INTEGER value: '77447,77448,77450,77453,77454,77455,77456,77457,77458,77460,77461,77462,77463,77464,77465,77467,77471,78587'	0.000 sec



select count(*)
from variant;
 
select count(*)
from variant
group by synset,word
having count(*)=2;

SELECT id
FROM resources_institutions
WHERE id = ? -- ejemplo: id=77470 (comida) -> id=77445 (pasta) -> id=77449 (fideos)
      OR id IN
         (
           WITH RECURSIVE resourceTree AS (
             SELECT
               sourceSynset,
               targetSynset,
               1 as depth
             FROM hiponym_relations
             where sourceSynset = 77445

             -- WHERE sourceSynset= ? -- synset a buscar

             UNION ALL

             SELECT
               next.sourceSynset,
               next.targetSynset,
               depth + 1
             FROM resourceTree t
               INNER JOIN hiponym_relations next on t.targetSynset = next.sourceSynset
             WHERE t.targetSynset = next.sourceSynset
           )
           SELECT
             sourceSynset,
             targetSynset
           FROM resourceTree
         );

-- STORED PROCEDURE OPTION

--

/*

select *
from relation;

select  r1.source, r2.source, r2.target,r3.target,v1.word, v2.word, v3.word
from relation as r1
left outer join relation as r2 on r1.target = r2.source
left join relation as r3 on r2.target = r3.source

 join variant as v1 on r1.source = v1.synset
 join variant v2 on v2.synset = r2.source
 join variant v3 on v3.synset = r2.target
where v1.word = "alimento";
 

select word
from variant 
where synset = 77449;


select  r1.source,v1.word
from relation as r1
join variant as v1 on r1.source = v1.synset
where r1.target = 77445;
 

select word
from variant 
where synset = 77445;

SHOW VARIABLES LIKE "%version%";
SHOW VARIABLES LIKE "secure_file_priv";

*/
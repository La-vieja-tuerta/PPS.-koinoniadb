-- agrego clave autoincremental a synset:   `synset` INT AUTO_INCREMENT UNIQUE
-- para que cuando se carguen los datos se vaya creando la clave autoincremental

-- agrego a variant la clave de synset
-- agrego a relation source y targET

use koinonia;

ALTER TABLE `variant` ADD COLUMN synset INT;

UPDATE `variant` v
INNER JOIN `synset` s ON v.offset = s.offset 
SET v.synset = s.synset
;


ALTER TABLE `relation` ADD COLUMN ( source INT, target INT);

UPDATE `relation` r
INNER JOIN `synset` s ON r.sourceSynset = s.offset 
SET r.source = s.synset 
;

UPDATE `relation` r
INNER JOIN `synset` s ON r.targetSynset = s.offset 
SET r.target = s.synset 
;

ALTER TABLE `variant`
	DROP PRIMARY KEY,
	ADD PRIMARY KEY(`word`,`sense`,`synset`)
;

ALTER TABLE `relation`
	-- DROP PRIMARY KEY,
	ADD PRIMARY KEY(`source`,`target`)
;

select count(*)
from relation
;
-- DROP DATABASE IF EXISTS koinoniadb;

-- CREATE DATABASE koinoniadb CHARACTER SET utf8 COLLATE utf8_bin;

use koinoniadb;

show tables;

-- creacion de tablas
DROP TABLE IF EXISTS `to_ili`;
DROP TABLE IF EXISTS `relation`;
DROP TABLE IF EXISTS `synset`;
DROP TABLE IF EXISTS `variant`;
DROP TABLE IF EXISTS `ili_to_to`;
DROP TABLE IF EXISTS `resources_nueva`;

CREATE TABLE IF NOT EXISTS `to_ili` (
  `iliOffset` char(17) COLLATE utf8_bin NOT NULL,
  `pos` char(1) COLLATE utf8_bin NOT NULL,
  `offset` char(17) COLLATE utf8_bin NOT NULL,
  `iliWnId` char(6) COLLATE utf8_bin NOT NULL,
  `csco` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`iliOffset`,`pos`,`offset`,`iliWnId`),
  KEY `iliOffset` (`iliOffset`,`pos`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


CREATE TABLE IF NOT EXISTS `relation` (
  `relation` smallint(6) NOT NULL DEFAULT '0',
  `sourceSynset` char(17) COLLATE utf8_bin NOT NULL,
  `sourcePos` char(1) COLLATE utf8_bin NOT NULL,
  `targetSynset` char(17) COLLATE utf8_bin NOT NULL,
  `targetPos` char(1) COLLATE utf8_bin NOT NULL,
  `csco` float NOT NULL DEFAULT '0',
  `method` char(2) COLLATE utf8_bin NOT NULL,
  `version` char(1) COLLATE utf8_bin NOT NULL,
  `wnSource` char(4) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`relation`,`sourceSynset`,`sourcePos`,`targetSynset`,`targetPos`,`method`,`version`,`wnSource`),
  KEY `relation` (`relation`),
  KEY `targetSynset` (`targetSynset`,`targetPos`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE IF NOT EXISTS `synset` (
  `offset` varchar(17) COLLATE utf8_bin NOT NULL,
  `pos` char(1) COLLATE utf8_bin NOT NULL,
  `sons` int(1) NOT NULL DEFAULT '0',
  `status` enum('i','-') COLLATE utf8_bin NOT NULL DEFAULT '-',
  `lexical` enum('-','n') COLLATE utf8_bin NOT NULL DEFAULT '-',
  `instance` tinyint(1) NOT NULL DEFAULT '0',
  `gloss` text COLLATE utf8_bin,
  `level` int(1) NOT NULL DEFAULT '0',
  `levelFromTop` int(1) NOT NULL DEFAULT '0',
  `mark` varchar(20) COLLATE utf8_bin NOT NULL DEFAULT '------',
  `synset` INT AUTO_INCREMENT UNIQUE,
  PRIMARY KEY (`offset`,`pos`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


CREATE TABLE IF NOT EXISTS `variant` (
  `word` varchar(100) COLLATE utf8_bin NOT NULL DEFAULT '',
  `sense` int(1) NOT NULL DEFAULT '0',
  `offset` varchar(17) COLLATE utf8_bin NOT NULL,
  `pos` char(1) COLLATE utf8_bin NOT NULL DEFAULT '',
  `csco` float NOT NULL DEFAULT '0',
  `experiment` char(20) COLLATE utf8_bin DEFAULT NULL,
  `mark` char(20) COLLATE utf8_bin NOT NULL DEFAULT '------',
  PRIMARY KEY (`word`,`sense`,`pos`,`offset`),
  KEY `word` (`word`),
  KEY `offset` (`offset`,`pos`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE IF NOT EXISTS `ili_to_to` (
  `top` varchar(25) COLLATE utf8_bin NOT NULL,
  `iliOffset` varchar(17) COLLATE utf8_bin NOT NULL,
  `iliPos` char(1) COLLATE utf8_bin NOT NULL,
  `iliWnId` varchar(6) COLLATE utf8_bin NOT NULL,
  `modif` char(1) COLLATE utf8_bin NOT NULL DEFAULT '#',
  PRIMARY KEY (`top`,`iliOffset`,`iliPos`,`iliWnId`,`modif`),
  KEY `iliOffset` (`iliOffset`,`iliPos`,`iliWnId`),
  KEY `top` (`top`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- cargado de tablas

-- para cargar las tablas hay dos opciones
-- op1: ejecutar SHOW VARIABLES LIKE "secure_file_priv"; y poner los archivos tsv en la direccion especificada
-- op2: ir a C:\ProgramData\MySQL\MySQL Server 8.0, abrir my.ini, buscar secure_file_priv y comentarla, o darle el valor "". Luego reiniciar el servidor
LOAD DATA INFILE 'C:/KoinoniaData/synset.tsv' INTO TABLE `synset` (`offset`, `pos`, `sons`, `status`, `lexical`, `instance`, `gloss`, `level`,`levelFromTop`, `mark`);
-- para la tabla synset solo no cargo la clave auto incremental
LOAD DATA INFILE 'C:/KoinoniaData/to_ili.tsv' INTO TABLE `to_ili`;
LOAD DATA INFILE 'C:/KoinoniaData/relation.tsv' INTO TABLE `relation`;
LOAD DATA INFILE 'C:/KoinoniaData/variant.tsv' INTO TABLE `variant`;
LOAD DATA INFILE 'C:/KoinoniaData/ili_to_to.tsv' INTO TABLE `ili_to_to`;

-- actualizar tablas

-- actualizo indices para que se puedan reealizar las queries en un tiempo menor a la edad del universo

ALTER TABLE variant DROP INDEX word;
ALTER TABLE to_ili DROP INDEX iliOffset;

CREATE INDEX Index_to_ili
ON to_ili(offset);


CREATE INDEX Index_variant
ON variant(offset);

-- borro todos los synsets que no existen en variant

-- para que la tabla variant pese menos al final habria que pasar toda la tabla synset a otra tabla que tenga clave autoincremental para que se usen menos numeros (creo que terminaria pesanado lo mismo)

delete from synset
where offset
not in
(
select offset
from variant
)
;

-- borro todas las palabras que no son sustantivos y palabras basandome en la ontologia

delete -- select *
from `variant`
where pos != 'n' or offset in 
(	
	select a.offset 
	from`to_ili` as a 
    join ili_to_to as b on a.iliOffset = b.iliOffset
    where top NOT IN ("Part","Object","Substance","Liquid","Solid","Function","Building","Comestible","Container","Covering","Furniture","Garment","Instrument","Place","Representation","ImageRepresentation","Software","Vehicle","Artifact","Living","Animal","Plant")
) 
;

select *
from `variant`
where pos = 'n' AND offset  IN 
(
	select a.offset 
	from`to_ili` as a 
    join ili_to_to as b on a.iliOffset = b.iliOffset
    where top  IN ("Plant")-- "Living","Animal","Plant""Instrument","Place","Representation","ImageRepresentation","Software","Vehicle","Artifact","Natural","Living","Animal","Plant") ,"Group","Part","Object","Substance","Gas","Liquid","Solid","Function","Building","Comestible","Container","Covering","Furniture","Garment","Instrument","Place","Representation","ImageRepresentation","Software","Vehicle","Artifact","Natural","Living","Animal","Plant")
) 
;
-- de las siguentes categoria: "1stOrderEntity","Group","Part","Object","Substance","Gas","Liquid","Solid","Function","Building","Comestible","Container","Covering","Furniture","Garment","Instrument","Place","Representation","ImageRepresentation","Software","Vehicle","Artifact","Natural","Living","Animal","Plant")

-- Group , First-Order-Entity, Gas, Natural son candidatos a irse  


-- actualizo la tabla relation para dejar solo hiperonimos y relaciones entre sustantivos.

delete from `relation`
where relation!=12 or !(sourcePos=targetPos AND sourcePos='n') 
	or 	sourceSynset NOT IN (
								select offset
								from `variant`
							)
	or 	targetSynset NOT IN (
								select offset
								from `variant`
							)
;

-- actualizo la estructura de las tablas y borro tablas y columnas que no voy a usar

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
	DROP PRIMARY KEY,
	ADD PRIMARY KEY(`source`,`target`)
;

ALTER TABLE `variant`
	DROP COLUMN sense, 
	DROP COLUMN pos,
    DROP COLUMN csco,
    DROP COLUMN experiment,
    DROP COLUMN mark,
    DROP COLUMN offset
;


ALTER TABLE `relation`
    DROP COLUMN sourceSynset,
    DROP COLUMN targetSynset,
    DROP COLUMN relation,
    DROP COLUMN sourcePos,
    DROP COLUMN targetPos,
    DROP COLUMN csco,
    DROP COLUMN method,
    DROP COLUMN version,
    DROP COLUMN wnSource
;

DROP TABLE IF EXISTS ili_to_to;
DROP TABLE IF EXISTS synset;
DROP TABLE IF EXISTS to_ili;

-- actualizo indices


CREATE INDEX Index_variant
ON variant(synset);

CREATE INDEX Index_relation1
ON relation(source);

CREATE INDEX Index_relation2
ON relation(target);

-- borro sustantivos propios y palabras por el style
-- QUE COMIENZE LA PODA

delete FROM variant 
where word REGEXP '.*[1-9].*';

-- reemplazo guiones por espacios
update variant set word = replace(word, '_', ' ');

-- borra palabras que comiencen en mayuscula
delete from variant
where word REGEXP '^[A-Z].*(\_[A-Z].*)*$';

-- borro de relation las relaciones entre words que ya no existen en variant
delete  from relation
where 
source NOT IN (SELECT DISTINCT synset FROM variant)
OR
target NOT IN (SELECT DISTINCT synset FROM variant)
;

-- paso todas las words a minuscula para que no haya problemas de key en entornos non key sensitive
SELECT * FROM variant;
 CREATE TABLE IF NOT EXISTS `resources_nueva` (
`name` varchar(100) NOT NULL,
`idw` BIGINT(20) NOT NULL,
PRIMARY KEY (`name`,`idw`));

-- IGNORE ignora las rows que puedan llegar a causar problemas restriccion de integridad de primary-key
INSERT IGNORE INTO `resources_nueva` (idw,name)
SELECT synset, lower(word)
FROM variant;

-- exporting data as tsv
SELECT * 
FROM resources_nueva
INTO OUTFILE "recurso.tsv"
FIELDS TERMINATED BY '\t'
LINES TERMINATED BY '\n';

SELECT * 
FROM relation
INTO OUTFILE "relacion.tsv"
FIELDS TERMINATED BY '\t' 
LINES TERMINATED BY '\n'
;

-- C:\ProgramData\MySQL\MySQL Server 8.0\Data\koinoniadb
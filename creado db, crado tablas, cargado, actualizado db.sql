DROP DATABASE IF EXISTS koinoniadb;

CREATE DATABASE koinoniadb CHARACTER SET utf8 COLLATE utf8_bin;

use koinoniadb;

-- creacion de tablas
DROP TABLE IF EXISTS `to_ili`;
DROP TABLE IF EXISTS `relation`;
DROP TABLE IF EXISTS `synset`;
DROP TABLE IF EXISTS `variant`;


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
  `experiment` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `mark` varchar(20) COLLATE utf8_bin NOT NULL DEFAULT '------',
  PRIMARY KEY (`word`,`sense`,`pos`,`offset`),
  KEY `word` (`word`),
  KEY `offset` (`offset`,`pos`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


-- cargado de tablas

LOAD DATA LOCAL INFILE 'C:/KoinoniaData/spaWN/to_ili.tsv' INTO TABLE `to_ili`;
LOAD DATA LOCAL INFILE 'C:/KoinoniaData/spaWN/relation.tsv' INTO TABLE `relation`;
LOAD DATA LOCAL INFILE 'C:/KoinoniaData/spaWN/synset.tsv' INTO TABLE `synset`;
LOAD DATA LOCAL INFILE 'C:/KoinoniaData/spaWN/variant.tsv' INTO TABLE `variant`;


-- actualizar tablas

delete from `variant` 
where pos!='n';

delete from synset
where offset
not in
(
select offset
from variant
)
;

delete from `synset` 
where !(offset = ANY (select a.offset from `variant` as a))
;

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
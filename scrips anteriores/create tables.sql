SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
use koinonia;
--
-- Base de dades: `mcr9`
--
DROP TABLE IF EXISTS `to_ili`;
DROP TABLE IF EXISTS `relation`;
DROP TABLE IF EXISTS `synset`;
DROP TABLE IF EXISTS `variant`;


-- --------------------------------------------------------
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





CREATE TABLE IF NOT EXISTS `ili_to_sumo` (
  `iliOffset` varchar(17) COLLATE utf8_bin NOT NULL,
  `iliPos` char(1) COLLATE utf8_bin NOT NULL,
  `iliWnId` varchar(6) COLLATE utf8_bin NOT NULL DEFAULT 'en16',
  `SUMO` varchar(120) COLLATE utf8_bin NOT NULL,
  `modif` char(3) COLLATE utf8_bin NOT NULL DEFAULT '',
  PRIMARY KEY (`iliOffset`,`iliPos`,`iliWnId`,`SUMO`,`modif`),
  KEY `SUMO` (`SUMO`),
  KEY `iliOffset` (`iliOffset`,`iliPos`,`iliWnId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='SUMO';

CREATE TABLE IF NOT EXISTS `sumo_relations` (
  `relacio` varchar(50) COLLATE utf8_bin NOT NULL,
  `target` varchar(50) COLLATE utf8_bin NOT NULL,
  `source` varchar(50) COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;




CREATE TABLE IF NOT EXISTS `ili_to_blc` (
  `blc` varchar(25) COLLATE utf8_bin NOT NULL,
  `iliOffset` varchar(17) COLLATE utf8_bin NOT NULL,
  `iliPos` char(1) COLLATE utf8_bin NOT NULL,
  `iliWnId` varchar(6) COLLATE utf8_bin NOT NULL,
  `modif` char(1) COLLATE utf8_bin NOT NULL DEFAULT '#',
  `represent` int(1) NOT NULL,
  `relations` int(11) NOT NULL,
  PRIMARY KEY (`blc`,`iliOffset`,`iliPos`,`iliWnId`,`modif`),
  KEY `iliOffset` (`iliOffset`,`iliPos`,`iliWnId`),
  KEY `blc` (`blc`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;




CREATE TABLE IF NOT EXISTS `relations` (
  `id` smallint(6) NOT NULL DEFAULT '0',
  `name` varchar(25) COLLATE utf8_bin NOT NULL,
  `props` varchar(4) COLLATE utf8_bin NOT NULL,
  `inverse` varchar(25) COLLATE utf8_bin NOT NULL,
  `grup` int(11) DEFAULT NULL,
  `note` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;




CREATE TABLE IF NOT EXISTS `domains` (
  `target` varchar(25) COLLATE utf8_bin NOT NULL,
  `source` varchar(25) COLLATE utf8_bin DEFAULT NULL,
  `type` char(1) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`target`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


CREATE TABLE IF NOT EXISTS `ili_to_domains` (
  `domain` varchar(25) COLLATE utf8_bin NOT NULL,
  `iliOffset` varchar(17) COLLATE utf8_bin NOT NULL,
  `iliPos` char(1) COLLATE utf8_bin NOT NULL,
  `iliWnId` varchar(6) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`domain`,`iliOffset`,`iliPos`,`iliWnId`),
  KEY `iliOffset` (`iliOffset`,`iliPos`)
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



CREATE TABLE IF NOT EXISTS `to_record` (
  `top` varchar(25) COLLATE utf8_bin NOT NULL,
  `gloss` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`top`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE IF NOT EXISTS `to_relations` (
  `relation` varchar(25) COLLATE utf8_bin NOT NULL,
  `source` varchar(25) COLLATE utf8_bin NOT NULL,
  `target` varchar(25) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`relation`,`source`,`target`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


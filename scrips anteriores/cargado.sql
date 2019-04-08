-- WordNets. Catalan, English, Basque, Galician, Portuguese and Spanish
use koinonia;

LOAD DATA LOCAL INFILE 'C:/KoinoniaData/spaWN/to_ili.tsv' INTO TABLE `to_ili`;
LOAD DATA LOCAL INFILE 'C:/KoinoniaData/spaWN/relation.tsv' INTO TABLE `relation`;
LOAD DATA LOCAL INFILE 'C:/KoinoniaData/spaWN/synset.tsv' INTO TABLE `synset`;
LOAD DATA LOCAL INFILE 'C:/KoinoniaData/spaWN/variant.tsv' INTO TABLE `variant`;

-- AdimenSUMO

LOAD DATA LOCAL INFILE 'C:/KoinoniaData/AdimenSUMO/ili_to_sumo.tsv' INTO TABLE `ili_to_sumo`;
LOAD DATA LOCAL INFILE 'C:/KoinoniaData/AdimenSUMO/sumo_relations.tsv' INTO TABLE `sumo_relations`;

-- BLCs

LOAD DATA LOCAL INFILE 'C:/KoinoniaData/BLC/ili_to_blc.tsv' INTO TABLE `ili_to_blc`;

-- data

LOAD DATA LOCAL INFILE 'C:/KoinoniaData/data/relations.tsv' INTO TABLE `relations`;

-- Domains

LOAD DATA LOCAL INFILE 'C:/KoinoniaData/Domains/domains.tsv' INTO TABLE `domains`;
LOAD DATA LOCAL INFILE 'C:/KoinoniaData/Domains/ili_to_domains.tsv' INTO TABLE `ili_to_domains`;

-- Top Ontology

LOAD DATA LOCAL INFILE 'C:/KoinoniaData/TopOntology/ili_to_to.tsv' INTO TABLE `ili_to_to`;
LOAD DATA LOCAL INFILE 'C:/KoinoniaData/TopOntology/to_record.tsv' INTO TABLE `to_record`;
LOAD DATA LOCAL INFILE 'C:/KoinoniaData/TopOntology/to_relations.tsv' INTO TABLE `to_relations`;
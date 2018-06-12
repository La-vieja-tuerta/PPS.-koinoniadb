-- script de borrado de palabras para optimizar las busquedas y actualizaciones

/*
	tablas a modificar:
    variant -> relation
*/

/* 

`wei_spa-30_variant` tiene inicialmente 146.261, 
borrando adverbios verbos y adjetivos queda en 100.788

*/

use koinoniadb;

/*
select count(*)
from `variant` 
;

select count(*) 
from `variant` 
where pos!='n'
;
*/


delete from `variant` 
where pos!='n';

/* 

`wei_spa-30_variant` tiene ahora 100.788, 
utilizando Top Ontology se eliminan todos los sustantivos que esten relacionados a 2nd o 3rd Entity, ya que nunca podrian ser donados, ademas de 1rd entity se eleiminan todos las palabras que no podrian ser donados
quedan ahora 

las etiquetas aceptadas son "1stOrderEntity","Group","Part","Object","Substance","Gas","Liquid","Solid","Function","Building","Comestible","Container","Covering","Furniture","Garment","Instrument","Place","Representation","ImageRepresentation","Software","Vehicle","Artifact","Natural","Living","Animal","Plant"

`wei_ili_to_to` tiene 340.433
1stOrderEntity: 25.251
2ndOrderEntity: 120
3rdOrderEntity: 5819
alguna de las 3 entidades: 31190


-- al parecer hay synsets que no aparecen en variant asi que los elimino (para que no use clave de mas cuando las cambie por la autoincremental)
*/
delete from synset
where offset
not in
(
select offset
from variant
)
;

-- hago lo mismo con to_ili

delete from to_ili
where offset
not in
(
select offset
from variant
)
;

-- y con ili_to_to

delete from ili_to_to
where ilioffset
not in
(
select ilioffset
from to_ili
)
;

/*
select count(*) 
from to_ili as a 
join ili_to_to as b on a.iliOffset = b.iliOffset
where a.iliOffset NOT IN
(
	SELECT c.ilioffset
    from ili_to_to as c
)
;

select count(distinct(offset))
from variant;    

select count(*)
from synset;

select count(*)
from to_ili a 
where a.offset NOT IN
(
	select b.offset
    from variant as b
)
;

select *
from synset
order by offset;

-- ahora borro de ili_to_to todos los ili que no pertenecen a categorias que pueden ser donadas
*/

delete from `ili_to_to`
where top NOT IN ("1stOrderEntity","Group","Part","Object","Substance","Gas","Liquid","Solid","Function","Building","Comestible","Container","Covering","Furniture","Garment","Instrument","Place","Representation","ImageRepresentation","Software","Vehicle","Artifact","Natural","Living","Animal","Plant")
;


delete from `to_ili`
where iliOffset not in 
(
	select a.iliOffset
    from `ili_to_to` as a
)
;   

delete -- select count(*)
from `variant` 
where pos!='n' or offset not in 
(
	select a.offset
    from `to_ili` as a
)
;

-- me quedan 69263 filas en variant;

EXPLAIN select count(*) from `ili_to_to`
where top NOT IN ("1stOrderEntity","Group","Part","Object","Substance","Gas","Liquid","Solid","Function","Building","Comestible","Container","Covering","Furniture","Garment","Instrument","Place","Representation","ImageRepresentation","Software","Vehicle","Artifact","Natural","Living","Animal","Plant")
;


EXPLAIN select count(*) from `to_ili`
where iliOffset not in 
(
	select a.iliOffset
    from `ili_to_to` as a
)
;   


ALTER TABLE variant DROP INDEX word;
ALTER TABLE to_ili DROP INDEX iliOffset;
-- ALTER TABLE variant DROP INDEX

CREATE INDEX Index_to_ili
ON to_ili(offset);


CREATE INDEX Index_variant
ON variant(offset);



EXPLAIN select count(*) from `variant` 
where offset not in 
(
	select a.offset
    from `to_ili` as a
)
;

delete -- select count(*) word
from `variant`
where pos != 'n' or offset not in 
(
	select a.offset 
	from`to_ili` as a 
    join ili_to_to as b on a.iliOffset = b.iliOffset
    where top IN ("1stOrderEntity","Group","Part","Object","Substance","Gas","Liquid","Solid","Function","Building","Comestible","Container","Covering","Furniture","Garment","Instrument","Place","Representation","ImageRepresentation","Software","Vehicle","Artifact","Natural","Living","Animal","Plant")
) 
;
-- me quedan 68263 filas en variant

/*

borro de synset todos aquellos que no aparecen en variant. `synset`	tiene 119096. Luego de la eliminacion tiene 78958

borro de relation 'relation' todas las filas que no relacionen adjetivos con adjetivos o que uno de los sustantivos no exista, o aquellos que no sean de la relacion 12
pasa de 685848 registros a  25459


select count(*)
from `synset`
;
*/
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



-- *********************************************************************************************************************************************************************

-- borrado de columnas 

-- de variant


-- me quedo solo con word y offset 

ALTER TABLE `variant`
	DROP COLUMN pos,
    DROP COLUMN csco,
    DROP COLUMN experiment,
    DROP COLUMN mark,
    DROP COLUMN offset -- IMPORTANTE: este drop debe hacerse luego de haber ejecutado el script para cambiar la clave de synset asi ocupa menos espacio y permite añadir mas palabras
;

-- de relation

select * from `relation`
;

-- me quedosynset con souceSynset y posSynset

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
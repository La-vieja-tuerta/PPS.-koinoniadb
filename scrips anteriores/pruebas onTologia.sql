select a.word,b.offset,c.iliOffset
from `wei_spa-30_variant` as a
join `wei_spa-30_synset` as b on a.offset=b.offset
join `wei_spa-30_to_ili`as c on b.offset=c.offset
order by a.word desc
 ;
 
 select *
 from `wei_ili_record`;

-- ******************************************************************************************************************************


-- prueba con Domains

select a.word,a.offset, b.iliOffset, c.domain,d.source,d.target 
from `wei_spa-30_variant` as a 
join `wei_spa-30_to_ili` as b on a.offset = b.offset
join `wei_ili_to_domains`as c on b.iliOffset = c.iliOffset
join `wei_domains` as d on c.domain=d.source
where a.word="manta"
;

/*
reducir el nivel de polisemia
de las palabras y agrupar aquellos sentidos que
pertenecen al mismo dominio. Por ejemplo, para
la palabra bank (banco, en ingl´es), siete de sus
diez sentidos en WordNet no comparten dominio,
reduciendo de este modo la polisemia.
*/

-- http://wndomains.fbk.eu/

-- ******************************************************************************************************************************

-- prueba con AdimenSUMO

select * from `wei_sumo_relations`;

select a.word,a.sense, a.pos, a.offset, c.iliOffset, c.SUMO,e.source,e.target ,d.examples
from `wei_spa-30_variant` as a 
join `wei_spa-30_to_ili` as b on a.offset = b.offset
join `wei_ili_to_sumo`as c on b.iliOffset = c.iliOffset
left join `wei_spa-30_examples` as d on d.word = a.word
join `wei_sumo_relations` as e on e.source=c.SUMO
-- join `wei_sumo_relations` as f on f.target=c.SUMO
where a.word="sandwich"
order by a.sense
;

-- prueba para seleccionar las palabras de una jerarquia superior junto con las de una jerarquia inmediatamente inferior

select a.source, f.word, f.sense, a.target, h.word

from `wei_sumo_relations` as a 

join `wei_ili_to_sumo` as c on a.source = c.SUMO
join `wei_ili_to_sumo` as d on a.target = d.SUMO

join `wei_spa-30_to_ili` as e on c.iliOffset=e.iliOffset
join `wei_spa-30_variant` as f on e.offset=f.offset

join `wei_spa-30_to_ili` as g on d.iliOffset=g.iliOffset
join `wei_spa-30_variant` as h on g.offset=h.offset

where f.pos = "n" and h.pos = "n"
;


-- para obtener palabras que forman parte de una categoria en AdimenSUMO

select *
from `wei_ili_to_sumo` as a
join `wei_spa-30_to_ili` as b on b.iliOffset = a.iliOffset
join `wei_spa-30_variant` as c on c.offset = b.offset

;

-- prueba con BLC

select a.word,c.relations,c.modif
from `wei_spa-30_variant` as a 
join `wei_spa-30_to_ili` as b on a.offset = b.offset
join `wei_ili_to_blc`as c on b.iliOffset = c.iliOffset
order by c.relations DESC
;
/*
Representar tantos conceptos como sea posible.
Representar tantas caracter´ısticas como sea
posible.
As´ı, los BLC t´ıpicamente deber´ıan ocurrir en
niveles de abstracci´on medios, es decir, en posiciones
intermedias de las jerarqu´ıas.
*/

/*
AdimenSUMO
puede ser utilizada para el razonamiento formal
por demostradores de teoremas de lógicas de primer
orden
*/

-- ******************************************************************************************************************************

-- prueba con Top Ontology

select a.word, c.top
from `wei_spa-30_variant` as a 
join `wei_spa-30_to_ili` as b on a.offset = b.offset
join `wei_ili_to_to`as c on b.iliOffset = c.iliOffset
;

select * 
from `wei_to_relations`;

/*
1stOrderEntity (corresponde a objetos y sustancias
concretas y perceptibles)
2ndOrderEntity (estados, situaciones y
eventos)
3rdOrderEntitiy (entidades mentales como
las ideas, conceptos y conocimientos)
*/

-- para obtener sinonimos de una palabra

select a.word, a.sense, b.word
from `wei_spa-30_variant` as a
join `wei_spa-30_variant` as b on a.offset = b.offset
where a.word = "pito" 
;

/*
http://projects.illc.uva.nl/EuroWordNet/corebcs/ewnTopOntology.html
*/

-- ******************************************************************************************************************************

-- prueba con BLC
	
/*
Los Basic Level Concepts (Rosch e Lloyd,
1978) (a partir de ahora BLC) son el resultado
de un compromiso entre dos principios de caracterizaci
´on opuestos:
Representar tantos conceptos como sea posible.
Representar tantas caracter´ısticas como sea
posible.
*/

-- the following query shows the childs and father of the word `cama` for the blc hierarchy
select a.word as `word`, b.word as `blc`, g.word as `blc padre`
from ili_to_blc as i

join to_ili as c on i.iliOffset=c.iliOffset
join variant as a on a.offset = c.offset

join to_ili as d on i.blc=d.iliOffset
join variant as b on b.offset = d.offset


join ili_to_blc as e on d.iliOffset=e.iliOffset
join to_ili as f on e.blc=f.iliOffset
join variant as g on g.offset = f.offset

where b.word = "abrigo"
;

-- marks 

select *
from `mark_values_variant`;

-- marcas para los synsets

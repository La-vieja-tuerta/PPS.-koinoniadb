
-- la siguiente querry muestra los arboles de hiperonimia de 3 niveles

select v1.word as `nivel 1`, v2.word as `nivel 2`, v3.word as `nivel 3`-- , v4.word as `nivel 4`, v5.word as `nivel 5`
from `variant` as v1
join `relation` as r on v1.offset = r.sourceSynset
join `variant` as v2 on r.targetSynset = v2.offset

left join `relation` as r2 on r.targetSynset = r2.sourceSynset
join `variant` as v3 on r2.targetSynset = v3.offset

/*
join `relation` as r3 on r2.targetSynset = r3.sourceSynset
join `variant` as v4 on r3.targetSynset = v4.offset

join `relation` as r4 on r3.targetSynset = r4.sourceSynset
join `variant` as v5 on r4.targetSynset = v5.offset
*/

join `to_ili` as t on t.offset=v1.offset
join `ili_to_to` as i on t.iliOffset=i.iliOffset
where i.top="Object" 
ORDER BY v1.word, v2.word,v3.word
;
-- Los arboles de hiponimia pueden tener mas de 5 niveles (ES MUCHO!!!)


select v1.word,v1.offset ,v2.word,v2.offset
from `variant` as v1
join `relation` as r on v1.offset = r.sourceSynset
join `variant` as v2 on r.targetSynset = v2.offset

 where v1.word="casa"
;

select distinct count(offset)
from `variant`;

select b.word, a.synset, b.synset
from `variant` as a
join `variant` as b on a.synset = b.synset 
where a.word = "casa"
;

select v.word, v.sense, t.top, r.gloss
from `variant` as v
-- join `variant` as v2 on v.offset = v2.offset
join `to_ili` as i on v.offset = i.offset
join `ili_to_to` as t on i.iliOffset = t.iliOffset
join `to_record` as r on t.top = r.top
where v.word="entrada"
order by v.sense
;

-- la palabra que pertenece a la mayor cantidad de synsets es Entrada, tiene 26 sentidos
select count(*)
from `synset`;

select * from `synset`
order by synset
;

select *
from relation
;

select *
from relation
;



repair table variant;
/*
Buenas, tengo una duda sobre las relaciones de hiponimos e hiperonimos en el Wordnet español. Cuando busco que relaciones de tipo 
hipo o hiperonimia hay en dicho wordnet usando la base de datos en mi servidos de mysql no encuentro ninguno, mientras que si uso 
la interface de WEI para buscar este tipo de wordnets sí las hay. Mi pregunta es, que consultas tengo que hacer  en la base de 
datos para obtener este tipo de relaciones entre synsets del WordNet español, debo buscar primero en el WordNet ingles y 
relacionarlo con el español? 

Hola,

Cada wordnet tiene sus propias relaciones (básicamente son cópia de las del WordNet en inglés). Las del wordnet español se 
encuentran en wei_spa-30_relation. Pero fíjate que las relaciones simétricas (como hiponimia o hiperonimia) están codificadas una 
sola vez.

Si miras el fichero MCR-relations.pdf del paquete con la distribución del MCR Release 2016 encontrarás que el MCR sólo codifica la 
relación 12 has-hyponym ... la relación simétrica no la guardamos ya que si tenemos A has-hyponym B, el hiperónimo de B es A.

Hasta pronto,

German 


((((((((((((((((((((((((((((((((((((((((((

Ademas de hiperonimia e hiponimia se pueden chaquear las relaciones de tipo 8, cuando un objeto es parte de otro

*/


use koinoni


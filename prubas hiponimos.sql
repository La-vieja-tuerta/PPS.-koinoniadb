select d.word,e.word,b.name,a.relation
from `wei_spa-30_relation` as a
join `wei_spa-30_variant` as d on a.sourceSynset=d.offset
join `wei_spa-30_variant` as e on a.targetSynset=e.offset
join `wei_relations` as b on a.relation = b.id
where (d.word="cama" or e.word="cama")
;

select a.pos -- 100788 palabras
from `wei_spa-30_variant` as a
where a.pos='n';

-- muchas palabras? se puede achicar a partir de las ontologias
-- cosas que no se van a donar? sacar a partir de Top Ontology, dejar solo las de 1era entidad
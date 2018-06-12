select b.word as `palabra que pertenece al synset `, b.synset as `id synset` 
from variant as a 
join variant as b on a.synset = b.synset
where a.word="casa" and b.word!=a.word -- lo que esta dsp del and es porque siempre te va a mostrar a casa sino
order by b.synset;
use koinoniadb;
select a.word, b.word, a.synset from variant as a
join relation as c on a.synset = c.source
join variant as b on c.target=b.synset
where a.word = 'alimento';



use koinoniadb;

show tables;

-- if 
-- sirve para preguntar si tal usuario ya dono tal recurso(syset) 
SELECT EXISTS(SELECT 1 FROM donacion WHERE userID = ? and synset = ?);

-- si la query de arriba da fase entonces hay que agregar la row con la nueva donacion. 
INSERT INTO donacion VALUES(?,?); 

-- el problema de no manejar cantidades es que si una organizacion dona algo dos veces solo va a aparecer una vez, es una chotada.
-- habria que preguntarles a ellos que tabla estan usando para esto.
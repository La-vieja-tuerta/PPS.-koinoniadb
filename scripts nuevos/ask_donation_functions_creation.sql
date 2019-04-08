DELIMITER $$

DROP FUNCTION IF EXISTS `getMatchingResources` $$
CREATE FUNCTION `getMatchingResources`(synsetResource INT)
  RETURNS varchar(1024) CHARSET latin1
DETERMINISTIC
  BEGIN
    DECLARE done INT DEFAULT FALSE;
    DECLARE matchings, tree VARCHAR(1024);
    DECLARE pos, resource_id INT;
    DECLARE donations CURSOR FOR (SELECT id
                                  FROM resources_institutions);
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

    SET matchings = '';
    SET tree = getHyponimTree(synsetResource);

    OPEN donations;

    -- loopeo sobre todos los recursos donados y me quedo con la interseccion delete
    -- arbol de hiponimos y los recursos donados
    check_matching_loop: LOOP
      FETCH donations
      INTO resource_id;
      IF done
      THEN
        LEAVE check_matching_loop;
      END IF;
      SET pos = find_in_set(CONCAT("", resource_id), tree);
      IF (pos != 0)
      THEN
        IF LENGTH(matchings) = 0
        THEN
          SET matchings = resource_id;
        ELSE
          SET matchings = CONCAT(matchings, ',', resource_id);
        END IF;
      END IF;
    END LOOP;

    CLOSE donations;

    RETURN matchings;

  END $$

DROP FUNCTION IF EXISTS `getHyponimTree` $$

CREATE FUNCTION `getHyponimTree`(synsetResource INT)
  RETURNS varchar(1024) CHARSET latin1
DETERMINISTIC
  BEGIN

    DECLARE q, queue, queue_children, result VARCHAR(1024);
    DECLARE queue_length, front_id, pos INT;

    SET queue = synsetResource;
    SET result = synsetResource;
    SET queue_length = 1;


    WHILE queue_length > 0 DO
      SELECT CAST(SUBSTRING_INDEX(queue, ",", 1) AS UNSIGNED)
      INTO front_id;
      -- SET front_id = FORMAT(queue,0);
      -- si la cola tiene solo un elemento la dejo vacia, sino con substring le saco el primer synset
      IF queue_length = 1
      THEN
        SET queue = '';
      ELSE
        SET pos = LOCATE(',', queue) + 1;
        SET q = SUBSTR(queue, pos);
        SET queue = q;
      END IF;
      SET queue_length = queue_length - 1;

      -- queue es donde se van guardando los synset que falta averiguar si tienen hiponimos
      -- queue children es donde se guardan los synset hijos que encontre de id_front
      -- en result voy guardando el resultado

      SELECT IFNULL(qc, '')
      INTO queue_children
      FROM (SELECT GROUP_CONCAT(targetSynset) qc
            FROM hiponym_relations
            WHERE sourceSynset = front_id) A;

      IF LENGTH(queue_children) = 0
      THEN
        IF LENGTH(queue) = 0
        THEN
          SET queue_length = 0;
        END IF;
      ELSE
        SET result = CONCAT(result, ',', queue_children);
        IF LENGTH(queue) = 0
        THEN
          SET queue = queue_children;
        ELSE
          SET queue = CONCAT(queue, ',', queue_children);
        END IF;
        SET queue_length = LENGTH(queue) - LENGTH(REPLACE(queue, ',', '')) + 1;
      END IF;
    END WHILE;
    RETURN result;
  END $$

<?php
require_once 'SistemaFCE/util/DbUpdaterBase.class.php';
/**
 * Created by PhpStorm.
 * User: lucas.vidaguren
 * Date: 06/12/16
 * Time: 14:32
 */
class AyudargDbUpdater extends DbUpdaterBase
{
    static public $expectedDBVersion = 9;


    public function updateDb($fromVersion = null, $toVersion = null)
    {
        if($fromVersion==0 && !$this->tableExists('configurationproperty')) {
            $this->executeQuery("CREATE TABLE configurationproperty
                                    (   property VARCHAR(50) PRIMARY KEY NOT NULL,
                                        value TEXT
                                    );");
        }
        return parent::updateDb($fromVersion, $toVersion);
    }

    protected function triggerExists($tableName,$triggerName) {
        $rs = $this->executeQuery("SHOW TRIGGERS LIKE '{$tableName}'");
        if($rs->NumRows()>0)
        {
            while($trig = $rs->FetchRow()) {
                if($trig['Trigger']==$triggerName)
                    return true;
            }
        }
        return false;
    }


    protected function changesVersion1() {
        /*  TODO: Acá se podría poner los chequeos de
            la creación de cada una de las tablas
            de la logica de negocio */
    }

    protected function changesVersion2() {
        $this->executeQuery("
        ALTER TABLE `users` 
            CHANGE COLUMN `website` `website` VARCHAR(100)  NULL ,
            CHANGE COLUMN `timezone` `timezone` VARCHAR(10) NULL DEFAULT NULL ;

        ");
    }

    protected function changesVersion3() {
        if(!$this->columnExists('users','ayuda'))
            $this->executeQuery("
            ALTER TABLE `users` 
                ADD COLUMN `ayuda`  VARCHAR(1)  NULL  DEFAULT '1';
            ");
    }

    protected function changesVersion4() {
        $this->disableForeignKeyChecks();
        $this->disableUniqueKeyChecks();
        if(!$this->tableExists('envio')) {
            $this->executeQuery("CREATE TABLE `envio` (
                  `id_envio` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                  `donante` BIGINT(20) NOT NULL,
                  `receptor` BIGINT(20) NOT NULL,
                  `entregado` tinyint(1) NOT NULL,
                  `numero_seguimiento` varchar(45) NOT NULL,
                  `nombre_donante` varchar(45) NOT NULL,
                  `nombre_receptor` varchar(45) NOT NULL,
                  `address_donante` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                  `latitude_donante` float DEFAULT NULL,
                  `longitude_donante` float DEFAULT NULL,
                  `address_receptor` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                  `latitude_receptor` float DEFAULT NULL,
                  `longitude_receptor` float DEFAULT NULL,
                  `fecha_envio` date NOT NULL,
                  `fecha_recepcion` date DEFAULT NULL,
                  `descripcion` varchar(200) NOT NULL,
                  PRIMARY KEY (`id_envio`),
                  UNIQUE KEY `id_envio` (`id_envio`),
                  KEY `fk_donante_id_` (`donante`),
                  KEY `fk_receptor_id` (`receptor`),
                  CONSTRAINT `fk_donante_id_` FOREIGN KEY (`donante`) REFERENCES `users` (`id`),
                  CONSTRAINT `fk_receptor_id` FOREIGN KEY (`receptor`) REFERENCES `users` (`id`)
                );");
        }
        $this->reseteUniqueKeyChecks();
        $this->resetForeignKeyChecks();
    }

    function changesVersion4_1() {
        $this->disableUniqueKeyChecks();
        $this->disableForeignKeyChecks();
        if($this->columnExists('envio','nombre_donante')) {
            $this->executeQuery(
                "ALTER TABLE envio MODIFY receptor BIGINT(20);
                ALTER TABLE envio ALTER COLUMN entregado SET DEFAULT 0;
                ALTER TABLE envio MODIFY address_donante VARCHAR(45);
                ALTER TABLE envio MODIFY descripcion VARCHAR(200);
                ALTER TABLE envio DROP nombre_donante;
                ALTER TABLE envio DROP nombre_receptor;
                ALTER TABLE envio DROP longitude_donante;
                ALTER TABLE envio DROP latitude_donante;
                ALTER TABLE envio DROP address_receptor;");
        }

        if(!$this->columnExists('envio','id_institucion_receptor_fk')) {
            $this->executeQuery(
                "ALTER TABLE envio ADD id_institucion_receptor_fk BIGINT NOT NULL;
                ALTER TABLE envio
                ADD CONSTRAINT envio_institutions_id_fk
                FOREIGN KEY (id_institucion_receptor_fk) REFERENCES institutions (id)");
        }
        //me aseguro que users e institutions sean inno
        $this->executeQuery("ALTER TABLE users ENGINE=InnoDB;
        ALTER TABLE institutions ENGINE=InnoDB;");

        $this->resetForeignKeyChecks();
        $this->reseteUniqueKeyChecks();
    }

    protected function changesVersion4_2() {
        if(!$this->columnExists('resources','estado'))
            $this->executeQuery("ALTER TABLE resources ADD estado VARCHAR(5) NULL;");
    }

    protected function changesVersion5()
    {
        if (!$this->tableExists('resources_parents'))
            $this->executeQuery("CREATE TABLE `resources_parents` (
                `id` BIGINT(5) NOT NULL AUTO_INCREMENT,
                `resource_id` BIGINT(5) NOT NULL,
                `parent_id` BIGINT(5) NOT NULL,
                PRIMARY KEY (`id`)
                ) ENGINE=InnoDB AUTO_INCREMENT=4300 DEFAULT CHARSET=utf8;");
    }

    protected function changesVersion5_1() {
        if($this->columnExists('resources','codigo'))
            $this->executeQuery("ALTER TABLE `resources` CHANGE `codigo` `codigo` BIGINT( 5 ) NULL DEFAULT NULL ;");

        if($this->columnExists('resources','id'))
            $this->executeQuery("ALTER TABLE `resources` CHANGE `id` `id` BIGINT( 5 ) UNSIGNED NOT NULL AUTO_INCREMENT ;");

        if($this->columnExists('resources_institutions','resource_id'))
            $this->executeQuery("ALTER TABLE `resources_institutions` CHANGE `resource_id` `resource_id` BIGINT( 5 ) UNSIGNED NOT NULL ;");

    }


    protected function changesVersion6() {
        if(!$this->triggerExists('resources','addCodigo'))
            $this->getDb()->execute("            
            CREATE TRIGGER addCodigo
                BEFORE INSERT ON resources
                FOR EACH ROW
                BEGIN
                   DECLARE next_id INT;
                   SET next_id = (SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='resources');
                   SET NEW.codigo = IF(ISNULL(NEW.codigo),next_id,NEW.codigo) ;
                END;
              ");
    }

    protected function changesVersion7() {
        $this->disableUniqueKeyChecks();
        $this->disableForeignKeyChecks();
        $this->setSqlMode('TRADITIONAL,ALLOW_INVALID_DATES');

        $this->executeQuery(
            "ALTER TABLE `attachments` CHANGE COLUMN `user_id` `user_id` BIGINT(20) NOT NULL");
        if(!$this->indexExists('attachments','fk_attachments_users1_idx'))
            $this->executeQuery(
                "ALTER TABLE `attachments` ADD INDEX `fk_attachments_users1_idx` (`user_id` ASC);");


        $this->executeQuery(
            "ALTER TABLE `conversations` CHANGE COLUMN `user_id` `user_id` BIGINT(20) NOT NULL ;");

        $this->executeQuery(
            "ALTER TABLE `conversations_users` CHANGE COLUMN `user_id` `user_id` BIGINT(20) NOT NULL ;");

        if (!$this->indexExists('departments','fk_departments_provinces1_idx'))
        $this->executeQuery(
            "ALTER TABLE `departments` ADD INDEX `fk_departments_provinces1_idx` (`province_id` ASC);");

        if (!$this->indexExists('distances_institutions','fk_distances_institutions_institutions1_idx'))
        $this->executeQuery(
            "ALTER TABLE `distances_institutions`
                    ADD INDEX `fk_distances_institutions_institutions1_idx` (`id_origin` ASC),
                    ADD INDEX `fk_distances_institutions_institutions2_idx` (`id_destinations` ASC);");

        if (!$this->indexExists('institutions','fk_institutions_parent_idx'))
        $this->executeQuery(
            "ALTER TABLE `institutions`
        ADD INDEX `fk_institutions_parent_idx` (`parent_id` ASC),
        ADD INDEX `fk_institutions_locations1_idx` (`location_id` ASC);");

        $this->executeQuery(
            "ALTER TABLE `institutions_users` CHANGE COLUMN `user_id` `user_id` BIGINT(20) NOT NULL ;");

        if (!$this->indexExists('locations','fk_locations_departments1_idx'))
        $this->executeQuery(
                    "ALTER TABLE `locations` ADD INDEX `fk_locations_departments1_idx` (`department_id` ASC);");

        $this->executeQuery(
            "ALTER TABLE `logs` CHANGE COLUMN `user_id` `user_id` BIGINT(20) NULL DEFAULT NULL");

        if (!$this->indexExists('logs','fk_logs_users1_idx'))
        $this->executeQuery(
            "ALTER TABLE `logs` ADD INDEX `fk_logs_users1_idx` (`user_id` ASC);");

        $this->executeQuery(
            "ALTER TABLE `messages` CHANGE COLUMN `user_id` `user_id` BIGINT(20) NOT NULL ;");

        if (!$this->indexExists('notifications','fk_notifications_users1_idx'))
            $this->executeQuery(
                "ALTER TABLE `notifications` ADD INDEX `fk_notifications_users1_idx` (`user_id` ASC);");

        if (!$this->indexExists('preferences','fk_preferences_users1_idx'))
            $this->executeQuery(
                    "ALTER TABLE `preferences`  ADD INDEX `fk_preferences_users1_idx` (`user_id` ASC);");

        $this->executeQuery(
            "ALTER TABLE `projects` CHANGE COLUMN `user_id` `user_id` BIGINT(20) NOT NULL ;");

        $this->executeQuery(
            "ALTER TABLE `requisitions` CHANGE COLUMN `user_id` `user_id` BIGINT(20) NOT NULL COMMENT 'a quien se envia' ");
        if (!$this->indexExists('requisitions','fk_requisitions_users1_idx'))
            $this->executeQuery(
                "ALTER TABLE `requisitions` ADD INDEX `fk_requisitions_users1_idx` (`user_id` ASC),
              ADD INDEX `fk_requisitions_institutions1_idx` (`institution_id` ASC);");

        $this->executeQuery(
            "ALTER TABLE resource_route MODIFY id_resource BIGINT(5) UNSIGNED NOT NULL,
                    MODIFY id_origen BIGINT(20) NOT NULL,
                    MODIFY id_destino BIGINT(20) NOT NULL;");

        if (!$this->indexExists('resource_route','fk_resource_route_institutions1_idx'))
            $this->executeQuery(
            "ALTER TABLE `resource_route`
            ADD INDEX `fk_resource_route_institutions1_idx` (`id_origen` ASC),
            ADD INDEX `fk_resource_route_institutions2_idx` (`id_destino` ASC),
            ADD INDEX `fk_resource_route_resources1_idx` (`id_resource` ASC);");

        if (!$this->indexExists('resources','fk_resources_units1_idx'))
            $this->executeQuery(
                    "ALTER TABLE `resources` ADD INDEX `fk_resources_units1_idx` (`id_unidad` ASC);");

        $this->executeQuery(
            "ALTER TABLE resources_parents 
                        MODIFY resource_id bigint(5) UNSIGNED NOT NULL,
                        MODIFY parent_id bigint(5) UNSIGNED NOT NULL;");

        if (!$this->indexExists('resources_parents','fk_resources_parents_resources1_idx'))
            $this->executeQuery(
                "ALTER TABLE `resources_parents`
            ADD INDEX `fk_resources_parents_resources1_idx` (`resource_id` ASC),
            ADD INDEX `fk_resources_parents_resources2_idx` (`parent_id` ASC);");

        $this->executeQuery(
            "ALTER TABLE resources_track MODIFY id_resource bigint(5) UNSIGNED NOT NULL;");

        if (!$this->indexExists('users','fk_users_roles1_idx'))
        $this->executeQuery(
                    "ALTER TABLE `users`
            ADD INDEX `fk_users_roles1_idx` (`role_id` ASC),
            ADD INDEX `fk_users_locations1_idx` (`location_id` ASC);");

        $this->executeQuery(
            "ALTER TABLE `resources` CHANGE COLUMN `id_unidad` `id_unidad` INT(10) NOT NULL");

        $this->executeQuery(
                    "ALTER TABLE `users_institutions`
        CHANGE COLUMN `user_id` `user_id` BIGINT(20) NOT NULL ,
        COMMENT = 'Seguidores de la institución - Recibirán notificaciones de altas/bajas de proyectos o tareas de la institución' ;");


        $rs = $this->executeQuery("SHOW KEYS FROM `units` WHERE Key_name = 'PRIMARY'");

        if($rs->RowCount()==0)
            $this->executeQuery("ALTER TABLE units ADD PRIMARY KEY (id)");

        $this->executeQuery(
                    "ALTER TABLE `users_projects` CHANGE COLUMN `user_id` `user_id` BIGINT(20) NOT NULL ;");

        $this->executeQuery(
                    "ALTER TABLE `users_resources` CHANGE COLUMN `user_id` `user_id` BIGINT(20) NOT NULL ;");

        if(!$this->foreignKeyExists('attachments','fk_attachments_users1'))
            $this->executeQuery(
                "ALTER TABLE `attachments`
        ADD CONSTRAINT `fk_attachments_users1`
          FOREIGN KEY (`user_id`)
          REFERENCES `users` (`id`)
          ON DELETE NO ACTION
          ON UPDATE NO ACTION;");

        if(!$this->foreignKeyExists('conversations','fk_conversations_users1'))
            $this->executeQuery(
                "ALTER TABLE `conversations`
        ADD CONSTRAINT `fk_conversations_users1`
          FOREIGN KEY (`user_id`)
          REFERENCES `users` (`id`)
          ON DELETE NO ACTION
          ON UPDATE NO ACTION;");

        if(!$this->foreignKeyExists('conversations_users','fk_conversations_users_users1'))
        $this->executeQuery(
                    "ALTER TABLE `conversations_users`
        ADD CONSTRAINT `fk_conversations_users_users1`
          FOREIGN KEY (`user_id`)
          REFERENCES `users` (`id`)
          ON DELETE NO ACTION
          ON UPDATE NO ACTION,
        ADD CONSTRAINT `fk_conversations_users_conversations1`
          FOREIGN KEY (`conversation_id`)
          REFERENCES `conversations` (`id`)
          ON DELETE NO ACTION
          ON UPDATE NO ACTION;");

        if(!$this->foreignKeyExists('departments','fk_departments_provinces1'))
            $this->executeQuery(
                    "ALTER TABLE `departments`
        ADD CONSTRAINT `fk_departments_provinces1`
          FOREIGN KEY (`province_id`)
          REFERENCES `provinces` (`id`)
          ON DELETE NO ACTION
          ON UPDATE NO ACTION;");

        if(!$this->foreignKeyExists('distances_institutions','fk_distances_institutions_institutions1'))
            $this->executeQuery(
                    "ALTER TABLE `distances_institutions`
        ADD CONSTRAINT `fk_distances_institutions_institutions1`
          FOREIGN KEY (`id_origin`)
          REFERENCES `institutions` (`id`)
          ON DELETE NO ACTION
          ON UPDATE NO ACTION,
        ADD CONSTRAINT `fk_distances_institutions_institutions2`
          FOREIGN KEY (`id_destinations`)
          REFERENCES `institutions` (`id`)
          ON DELETE NO ACTION
          ON UPDATE NO ACTION;");

        if(!$this->foreignKeyExists('eventhistories','fk_eventhistories_resources1'))
            $this->executeQuery(
                    "ALTER TABLE `eventhistories`
        ADD CONSTRAINT `fk_eventhistories_resources1`
          FOREIGN KEY (`resource_id`)
          REFERENCES `resources` (`id`)
          ON DELETE NO ACTION
          ON UPDATE NO ACTION,
        ADD CONSTRAINT `fk_eventhistories_subprojects1`
          FOREIGN KEY (`subproject_id`)
          REFERENCES `subprojects` (`id`)
          ON DELETE NO ACTION
          ON UPDATE NO ACTION;");

        if(!$this->foreignKeyExists('institutions','fk_institutions_types1'))
            $this->executeQuery(
                    "ALTER TABLE `institutions`
        ADD CONSTRAINT `fk_institutions_types1`
          FOREIGN KEY (`type_id`)
          REFERENCES `types` (`id`)
          ON DELETE NO ACTION
          ON UPDATE NO ACTION,
        ADD CONSTRAINT `fk_institutions_parent`
          FOREIGN KEY (`parent_id`)
          REFERENCES `institutions` (`id`)
          ON DELETE NO ACTION
          ON UPDATE NO ACTION,
        ADD CONSTRAINT `fk_institutions_locations1`
          FOREIGN KEY (`location_id`)
          REFERENCES `locations` (`id`)
          ON DELETE NO ACTION
          ON UPDATE NO ACTION,
        ADD CONSTRAINT `fk_institutions_sectors1`
          FOREIGN KEY (`sector_id`)
          REFERENCES `sectors` (`id`)
          ON DELETE NO ACTION
          ON UPDATE NO ACTION;");

        if(!$this->foreignKeyExists('institutions_users','fk_institutions_users_institutions1'))
            $this->executeQuery(
                    "ALTER TABLE `institutions_users`
        ADD CONSTRAINT `fk_institutions_users_institutions1`
          FOREIGN KEY (`institution_id`)
          REFERENCES `institutions` (`id`)
          ON DELETE NO ACTION
          ON UPDATE NO ACTION,
        ADD CONSTRAINT `fk_institutions_users_users1`
          FOREIGN KEY (`user_id`)
          REFERENCES `users` (`id`)
          ON DELETE NO ACTION
          ON UPDATE NO ACTION;");

        if(!$this->foreignKeyExists('locations','fk_locations_departments1'))
        $this->executeQuery(
                    "ALTER TABLE `locations`
        ADD CONSTRAINT `fk_locations_departments1`
          FOREIGN KEY (`department_id`)
          REFERENCES `departments` (`id`)
          ON DELETE NO ACTION
          ON UPDATE NO ACTION;");

        if(!$this->foreignKeyExists('logs','fk_logs_users1'))
        $this->executeQuery(
                    "ALTER TABLE `logs`
        ADD CONSTRAINT `fk_logs_users1`
          FOREIGN KEY (`user_id`)
          REFERENCES `users` (`id`)
          ON DELETE NO ACTION
          ON UPDATE NO ACTION;");

        if(!$this->foreignKeyExists('messages','fk_messages_users1'))
        $this->executeQuery(
                    "ALTER TABLE `messages`
        ADD CONSTRAINT `fk_messages_users1`
          FOREIGN KEY (`user_id`)
          REFERENCES `users` (`id`)
          ON DELETE NO ACTION
          ON UPDATE NO ACTION,
        ADD CONSTRAINT `fk_messages_conversations1`
          FOREIGN KEY (`conversation_id`)
          REFERENCES `conversations` (`id`)
          ON DELETE NO ACTION
          ON UPDATE NO ACTION;");

        if(!$this->foreignKeyExists('notifications','fk_notifications_users1'))
        $this->executeQuery(
                    "ALTER TABLE `notifications`
        ADD CONSTRAINT `fk_notifications_users1`
          FOREIGN KEY (`user_id`)
          REFERENCES `users` (`id`)
          ON DELETE NO ACTION
          ON UPDATE NO ACTION;");

        if(!$this->foreignKeyExists('preferences','fk_preferences_users1'))
        $this->executeQuery(
                    "ALTER TABLE `preferences`
        ADD CONSTRAINT `fk_preferences_users1`
          FOREIGN KEY (`user_id`)
          REFERENCES `users` (`id`)
          ON DELETE NO ACTION
          ON UPDATE NO ACTION;");

        if(!$this->foreignKeyExists('projects','fk_projects_users1'))
        $this->executeQuery(
                    "ALTER TABLE `projects`
        ADD CONSTRAINT `fk_projects_users1`
          FOREIGN KEY (`user_id`)
          REFERENCES `users` (`id`)
          ON DELETE NO ACTION
          ON UPDATE NO ACTION;");

        if(!$this->foreignKeyExists('projects_institutions','fk_projects_institutions_institutions1'))
        $this->executeQuery(
                    "ALTER TABLE `projects_institutions`
        ADD CONSTRAINT `fk_projects_institutions_institutions1`
          FOREIGN KEY (`institution_id`)
          REFERENCES `institutions` (`id`)
          ON DELETE NO ACTION
          ON UPDATE NO ACTION,
        ADD CONSTRAINT `fk_projects_institutions_projects1`
          FOREIGN KEY (`project_id`)
          REFERENCES `projects` (`id`)
          ON DELETE NO ACTION
          ON UPDATE NO ACTION;");

        if(!$this->foreignKeyExists('requisitions','fk_requisitions_users1'))
        $this->executeQuery(
                    "ALTER TABLE `requisitions`
        ADD CONSTRAINT `fk_requisitions_users1`
          FOREIGN KEY (`user_id`)
          REFERENCES `users` (`id`)
          ON DELETE NO ACTION
          ON UPDATE NO ACTION,
        ADD CONSTRAINT `fk_requisitions_institutions1`
          FOREIGN KEY (`institution_id`)
          REFERENCES `institutions` (`id`)
          ON DELETE NO ACTION
          ON UPDATE NO ACTION;");

        if(!$this->foreignKeyExists('resource_route','fk_resource_route_institutions1'))
        $this->executeQuery(
                    "ALTER TABLE `resource_route`
        ADD CONSTRAINT `fk_resource_route_institutions1`
          FOREIGN KEY (`id_origen`)
          REFERENCES `institutions` (`id`)
          ON DELETE NO ACTION
          ON UPDATE NO ACTION,
        ADD CONSTRAINT `fk_resource_route_institutions2`
          FOREIGN KEY (`id_destino`)
          REFERENCES `institutions` (`id`)
          ON DELETE NO ACTION
          ON UPDATE NO ACTION,
        ADD CONSTRAINT `fk_resource_route_resources1`
          FOREIGN KEY (`id_resource`)
          REFERENCES `resources` (`id`)
          ON DELETE NO ACTION
          ON UPDATE NO ACTION;");

        if(!$this->foreignKeyExists('resources','fk_resources_units1'))
        $this->executeQuery(
                    "ALTER TABLE `resources`
        ADD CONSTRAINT `fk_resources_units1`
          FOREIGN KEY (`id_unidad`)
          REFERENCES `units` (`id`)
          ON DELETE NO ACTION
          ON UPDATE NO ACTION;");

        if(!$this->foreignKeyExists('resources_institutions','fk_resources_institutions_resources1'))
        $this->executeQuery(
                    "ALTER TABLE `resources_institutions`
        ADD CONSTRAINT `fk_resources_institutions_resources1`
          FOREIGN KEY (`resource_id`)
          REFERENCES `resources` (`id`)
          ON DELETE NO ACTION
          ON UPDATE NO ACTION,
        ADD CONSTRAINT `fk_resources_institutions_institutions1`
          FOREIGN KEY (`institution_id`)
          REFERENCES `institutions` (`id`)
          ON DELETE NO ACTION
          ON UPDATE NO ACTION;");

        if(!$this->foreignKeyExists('resources_parents','fk_resources_parents_resources1'))
        $this->executeQuery(
                    "ALTER TABLE `resources_parents`
        ADD CONSTRAINT `fk_resources_parents_resources1`
          FOREIGN KEY (`resource_id`)
          REFERENCES `resources` (`id`)
          ON DELETE NO ACTION
          ON UPDATE NO ACTION,
        ADD CONSTRAINT `fk_resources_parents_resources2`
          FOREIGN KEY (`parent_id`)
          REFERENCES `resources` (`id`)
          ON DELETE NO ACTION
          ON UPDATE NO ACTION;");

        if(!$this->foreignKeyExists('resources_subprojects','fk_resources_subprojects_resources1'))
        $this->executeQuery(
                    "ALTER TABLE `resources_subprojects`
        ADD CONSTRAINT `fk_resources_subprojects_resources1`
          FOREIGN KEY (`resource_id`)
          REFERENCES `resources` (`id`)
          ON DELETE NO ACTION
          ON UPDATE NO ACTION,
        ADD CONSTRAINT `fk_resources_subprojects_subprojects1`
          FOREIGN KEY (`subproject_id`)
          REFERENCES `subprojects` (`id`)
          ON DELETE NO ACTION
          ON UPDATE NO ACTION;");

        if(!$this->foreignKeyExists('resources_track','fk_resources_track_resources1'))
        $this->executeQuery(
                    "ALTER TABLE `resources_track`
        ADD CONSTRAINT `fk_resources_track_resources1`
          FOREIGN KEY (`id_resource`)
          REFERENCES `resources` (`id`)
          ON DELETE NO ACTION
          ON UPDATE NO ACTION;");

        if(!$this->foreignKeyExists('users','fk_users_roles1'))
        $this->executeQuery(
                    "ALTER TABLE `users`
        ADD CONSTRAINT `fk_users_roles1`
          FOREIGN KEY (`role_id`)
          REFERENCES `roles` (`id`)
          ON DELETE NO ACTION
          ON UPDATE NO ACTION,
        ADD CONSTRAINT `fk_users_locations1`
          FOREIGN KEY (`location_id`)
          REFERENCES `locations` (`id`)
          ON DELETE NO ACTION
          ON UPDATE NO ACTION;");

        if(!$this->foreignKeyExists('users_institutions','fk_users_institutions_users1'))
        $this->executeQuery(
                    "ALTER TABLE `users_institutions`
        ADD CONSTRAINT `fk_users_institutions_users1`
          FOREIGN KEY (`user_id`)
          REFERENCES `users` (`id`)
          ON DELETE NO ACTION
          ON UPDATE NO ACTION,
        ADD CONSTRAINT `fk_users_institutions_institutions1`
          FOREIGN KEY (`institution_id`)
          REFERENCES `institutions` (`id`)
          ON DELETE NO ACTION
          ON UPDATE NO ACTION;");

        if(!$this->foreignKeyExists('users_projects','fk_users_projects_users1'))
        $this->executeQuery(
                    "ALTER TABLE `users_projects`
        ADD CONSTRAINT `fk_users_projects_users1`
          FOREIGN KEY (`user_id`)
          REFERENCES `users` (`id`)
          ON DELETE NO ACTION
          ON UPDATE NO ACTION,
        ADD CONSTRAINT `fk_users_projects_projects1`
          FOREIGN KEY (`project_id`)
          REFERENCES `projects` (`id`)
          ON DELETE NO ACTION
          ON UPDATE NO ACTION;");

        if(!$this->foreignKeyExists('users_resources','fk_users_resources_users1'))
        $this->executeQuery(
                    "ALTER TABLE `users_resources`
        ADD CONSTRAINT `fk_users_resources_users1`
          FOREIGN KEY (`user_id`)
          REFERENCES `users` (`id`)
          ON DELETE NO ACTION
          ON UPDATE NO ACTION,
        ADD CONSTRAINT `fk_users_resources_resources1`
          FOREIGN KEY (`resource_id`)
          REFERENCES `resources` (`id`)
          ON DELETE NO ACTION
          ON UPDATE NO ACTION;");


        $this->resetSqlMode();
        $this->resetForeignKeyChecks();
        $this->reseteUniqueKeyChecks();
    }

    protected function changesVersion8() {
        $this->getDb()->execute("ALTER TABLE `institutions` 
            CHANGE COLUMN `website` `website` VARCHAR(150) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL ,
            CHANGE COLUMN `timezone` `timezone` VARCHAR(10) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL DEFAULT '0' ,
            CHANGE COLUMN `fax` `fax` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL DEFAULT '';");

    }


    protected function changesVersion8_1() {

        $this->disableForeignKeyChecks();
        $this->disableUniqueKeyChecks();
        $this->executeQuery("ALTER TABLE `resources` 
            DROP FOREIGN KEY `fk_resources_units1`;
            ALTER TABLE `resources` 
            CHANGE COLUMN `id_unidad` `id_unidad` INT(10) NOT NULL DEFAULT 0 ;");

        if(!$this->foreignKeyExists('resources','fk_resources_units1'))
            $this->executeQuery("ALTER TABLE `resources` 
                ADD CONSTRAINT `fk_resources_units1`
                  FOREIGN KEY (`id_unidad`)
                  REFERENCES `units` (`id`)
                  ON DELETE NO ACTION
                  ON UPDATE NO ACTION;");
        $this->reseteUniqueKeyChecks();
        $this->resetForeignKeyChecks();


    }

    protected function changesVersion9() {

        $this->disableForeignKeyChecks();
        $this->disableUniqueKeyChecks();


        if ($this->tableExists('resources')) {

            $this->executeQuery("DELETE FROM resources_parents WHERE resource_id NOT IN  (SELECT id from resources)");

            if (!$this->tableExists('resources_nueva')) {
                $this->executeQuery("
                    CREATE TABLE IF NOT EXISTS `resources_nueva` (
                        `name` varchar(100) NOT NULL,
                        `idw` BIGINT(20) NOT NULL,
                        PRIMARY KEY (`name`,`idw`));");
            }
            /*
             * word
             */

           /* if(!$this->indexExists('resources_nueva','resources_id_index'))
            {
                $this->executeQuery("CREATE INDEX resources_id_index ON resources_nueva (idw);");
            }*/

            if (!$this->tableExists('hiponym_relations')) {
                $this->executeQuery("CREATE TABLE IF NOT EXISTS hiponym_relations (
                sourceSynset BIGINT(20) NOT NULL, 
                targetSynset BIGINT(20) NOT NULL,
                PRIMARY KEY (sourceSynset,targetSynset));");



            }



// agua de Colonia	51617 de la linea 311
//aparejo Bermuda	48617 de la linea 921
//mantequilla Bercy-78324 de la linea 10057
//regalo de Navidad	106386 de la linea 13848
//salsa Louis-78307 de la linea 14443
//salsa Newburg	78574 de la linea 14444
//vitamina d	116512 de la linea 17047
//vitamina e	116513 de la linea 17048
//vitamina k-116515 de la linea 17049
//            $this->executeQuery("
//            LOAD DATA INFILE 'C:/xampp/htdocs/ayudarg-pqn/application/utils/sql-scripts/recurso.tsv' INTO TABLE `resources_nueva`;");
//            LOAD DATA INFILE 'C:/xampp/htdocs/ayudarg-pqn/application/utils/sql-scritps/recurso.tsv' INTO TABLE `resources_nueva`
//            $this->executeQuery("
//            LOAD DATA INFILE 'C:/xampp/htdocs/ayudarg-pqn/application/utils/sql-scripts/relacion.tsv' INTO TABLE `hiponym_relations`;");

            /**/ $this->executeQuery("
             LOAD DATA INFILE '".str_replace('\\','/',__DIR__)."/sql-scripts/recurso.tsv' INTO TABLE `resources_nueva`;
             LOAD DATA INFILE '".str_replace('\\','/',__DIR__)."/sql-scripts/relacion.tsv' INTO TABLE `hiponym_relations`;
         ");/**/

            if (!$this->columnExists('resources_nueva','created')) {
                /*$this->executeQuery("ALTER TABLE  `resources_nueva` ADD `description` TEXT NULL , ADD `id_unidad` INT(10) DEFAULT '0' NOT NULL ,
ADD `codigo` BIGINT( 20 )  NULL , ADD `tags` VARCHAR(255) NULL , ADD  `created` DATETIME NOT NULL , ADD  `updated` DATETIME NOT NULL , 
ADD  `estado` VARCHAR( 5 ) NULL ,
 ADD  `id` BIGINT( 20 ) NOT NULL AUTO_INCREMENT FIRST , ADD INDEX `id_idx` (`id` ASC)");*/

                $this->executeQuery("ALTER TABLE  `resources` ADD `idw` BIGINT(20) NOT NULL");

                $this->executeQuery("CREATE INDEX resources_idw_index ON resources (idw);");

                $this->executeQuery("INSERT INTO `resources`(`name`, `description`, `id_unidad`, `created`, `updated`, `codigo`, `tags`, `estado`, `idw`) SELECT name,name,'0','2018-07-05 02:46:10','2018-07-05 02:46:10','-1',null,'ACTIV', idw FROM `resources_nueva` WHERE 1 ");

                if ($this->tableExists('hiponym_relations')) {

                    $this->executeQuery("ALTER TABLE `hiponym_relations`
                    ADD CONSTRAINT `fk_hiponym_relations_resources_nueva1`
                      FOREIGN KEY (`sourceSynset`)
                      REFERENCES `resources` (`idw`)
                      ON DELETE CASCADE
                      ON UPDATE CASCADE,
                    ADD CONSTRAINT `fk_hiponym_relations_resources_nueva2`
                      FOREIGN KEY (`targetSynset`)
                      REFERENCES `resources` (`idw`)
                      ON DELETE CASCADE
                      ON UPDATE CASCADE;");
                }

                $this->executeQuery("UPDATE  `resources` SET  `codigo` =  `id`  WHERE  `codigo` =  '-1'");




                /*
                 * borrar los parent que despues voy a borrar los resoruces
                 */
                $this->executeQuery("delete from resources_parents where parent_id in (select id from resources where idw='0' and name in (SELECT name FROM `resources_nueva`) and ( id not in (select resource_id from resources_subprojects ) or id not in ( select id_resource from resources_track)  or id not in ( select id_resource from resource_route)  or id not in (select resource_id from users_resources ) or id not in (select resource_id from resources_institutions ) ) and id = codigo)" );

                $this->executeQuery("delete from resources_parents where resource_id in (select id from resources where idw='0' and name in (SELECT name FROM `resources_nueva`) and ( id not in (select resource_id from resources_subprojects ) or id not in ( select id_resource from resources_track)  or id not in ( select id_resource from resource_route)  or id not in (select resource_id from users_resources ) or id not in (select resource_id from resources_institutions ) ) and id = codigo)" );

                /*
                 * borro recursos repetidos y no referenciados
                 */
                $this->executeQuery("delete from resources where idw='0' and name in (SELECT name FROM `resources_nueva`) and ( id not in (select resource_id from resources_subprojects ) or id not in ( select id_resource from resources_track)  or id not in ( select id_resource from resource_route)  or id not in (select resource_id from users_resources ) or id not in (select resource_id from resources_institutions ) ) and id = codigo");

                $this->executeQuery("UPDATE  `resources` SET   `idw` =  `id` WHERE  `idw` =  '0'");




            }
        }

        /* voy a mantener los recursos referenciados */

        $this->resetForeignKeyChecks();
        $this->reseteUniqueKeyChecks();

/*
 * SELECT COUNT( * ) AS cantidad, id, GROUP_CONCAT( word ) AS words
FROM  `resources_nueva`
GROUP BY id
HAVING cantidad >1
ORDER BY COUNT( * ) DESC
LIMIT 0 , 30
 */
    }

   /* protected function changesVersion9_1() {
        $this->disableForeignKeyChecks();
        $this->disableUniqueKeyChecks();

        $this->executeQuery("
                CREATE TABLE IF NOT EXISTS `resources` (
                    `word` varchar(100) NOT NULL,
                    `id` BIGINT(20) NOT NULL,
                    PRIMARY KEY (`word`,`id`));
                    
                ALTER TABLE resources_subprojects MODIFY resource_id bigint(20) unsigned NOT NULL;
                ALTER TABLE resources_parents MODIFY resource_id bigint(20) unsigned NOT NULL;
                ALTER TABLE resources_parents MODIFY parent_id bigint(20) unsigned NOT NULL;                
                ALTER TABLE resources_track MODIFY id_resource bigint(20) unsigned NOT NULL;
                ALTER TABLE users_resources MODIFY resource_id bigint(20) unsigned zerofill NOT NULL;
                ALTER TABLE resources_institutions MODIFY resource_id bigint(20) unsigned NOT NULL;
                ALTER TABLE resource_route MODIFY id_resource bigint(20) unsigned NOT NULL;");

        if (!$this->tableExists('hiponym_relations'))
            $this->executeQuery("
            CREATE TABLE IF NOT EXISTS `hiponym_relations` (
            `sourceSynset` BIGINT(20) NOT NULL,
            `targetSynset` BIGINT(20) NOT NULL,
            PRIMARY KEY (`sourceSynset`,`targetSynset`),
            FOREIGN KEY (sourceSynset) REFERENCES resources(id) ON DELETE CASCADE ON UPDATE CASCADE,
            FOREIGN KEY (targetSynset) REFERENCES resources(id) ON DELETE CASCADE ON UPDATE CASCADE
        ");

        $this->executeQuery("
            LOAD DATA INFILE '".__DIR__."/sql-scritps/recurso.tsv' INTO TABLE `resources`;
            LOAD DATA INFILE '".__DIR__."/sql-scritps/relacion.tsv' INTO TABLE `hiponym_relations`;
        ");




$this->executeQuery(\"DELETE FROM resources_subprojects WHERE NOT resource_id IS NULL\");
            $this->executeQuery(\"DELETE FROM resources_parents WHERE NOT resource_id IS NULL or NOT parent_id IS NULL \");
            $this->executeQuery(\"DELETE FROM resources_track WHERE NOT id_resource IS NULL\");
            $this->executeQuery(\"DELETE FROM users_resources WHERE NOT resource_id IS NULL\");
            $this->executeQuery(\"DELETE FROM resources_institutions WHERE NOT resource_id IS NULL\");
            $this->executeQuery(\"DELETE FROM resource_route WHERE NOT id_resource IS NULL\");


            //TODO: borrar foreing key de estas tablas y ver:

            $this->executeQuery(\"ALTER TABLE  resources_subprojects DROP FOREIGN KEY  fk_resources_subprojects_resources1\" );
            $this->executeQuery(\"ALTER TABLE  resources_parents DROP FOREIGN KEY  fk_resources_parents_resources1\" );
            $this->executeQuery(\"ALTER TABLE  resources_parents DROP FOREIGN KEY  fk_resources_parents_resources2\" );
            $this->executeQuery(\"ALTER TABLE  resources_track DROP FOREIGN KEY  fk_resources_track_resources1\" );
            $this->executeQuery(\"ALTER TABLE  users_resources DROP FOREIGN KEY  fk_users_resources_resources1\" );
            $this->executeQuery(\"ALTER TABLE  resources_institutions DROP FOREIGN KEY  fk_resources_institutions_resources1\" );
            $this->executeQuery(\"ALTER TABLE  resource_route DROP FOREIGN KEY  fk_resource_route_resources1\" );



            $this->executeQuery(\"DROP TABLE resources;\");



            $this->executeQuery(\"ALTER TABLE  resources_subprojects ADD CONSTRAINT  fk_resources_subprojects_resources1 FOREIGN KEY (  resource_id ) REFERENCES  resources ( id ) ON DELETE NO ACTION ON UPDATE NO ACTION \");
            $this->executeQuery(\"ALTER TABLE  resources_parents ADD CONSTRAINT  fk_resources_parents_resources1 FOREIGN KEY (  resource_id ) REFERENCES  resources ( id ) ON DELETE NO ACTION ON UPDATE NO ACTION \");
            $this->executeQuery(\"ALTER TABLE  resources_parents ADD CONSTRAINT  fk_resources_parents_resources2 FOREIGN KEY (  parent_id ) REFERENCES  resources ( id ) ON DELETE NO ACTION ON UPDATE NO ACTION \");
            $this->executeQuery(\"ALTER TABLE  resources_track ADD CONSTRAINT  fk_resources_track_resources1 FOREIGN KEY (  id_resource ) REFERENCES  resources ( id ) ON DELETE NO ACTION ON UPDATE NO ACTION \");
            $this->executeQuery(\"ALTER TABLE  users_resources ADD CONSTRAINT  fk_users_resources_resources1 FOREIGN KEY (  resource_id ) REFERENCES  resources ( id ) ON DELETE NO ACTION ON UPDATE NO ACTION \");
            $this->executeQuery(\"ALTER TABLE  resources_institutions ADD CONSTRAINT  fk_resources_institutions_resources1 FOREIGN KEY (  resource_id ) REFERENCES  resources ( id ) ON DELETE NO ACTION ON UPDATE NO ACTION \");
            $this->executeQuery(\"ALTER TABLE  resource_route ADD CONSTRAINT  fk_resource_route_resources1 FOREIGN KEY (  id_resource ) REFERENCES  resources ( id ) ON DELETE NO ACTION ON UPDATE NO ACTION \");







        $this->resetForeignKeyChecks();
        $this->reseteUniqueKeyChecks();

    }*/


}
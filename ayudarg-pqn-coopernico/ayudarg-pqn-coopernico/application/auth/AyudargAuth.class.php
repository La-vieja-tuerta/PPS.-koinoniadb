<?php
require_once "auth/mdb2IdAuth.class.php";
/**
 * Created by PhpStorm.
 * User: lucas
 * Date: 29/03/17
 * Time: 09:36
 */
class AyudargAuth extends Mdb2IdAuth
{
    function AyudargAuth($loginFunction = "",$showLogin = false) {

        $this->id_label       = "id";
        $this->username_label = "username";
        $this->password_label = "password";

        $this->userTable      = "users";


        $this->dbms           = Configuracion::getDBMS();
        $this->dbHost         = Configuracion::getDbHost();
        $this->dbName         = Configuracion::getDbName();
        $this->dbUser         = Configuracion::getDbUser();
        $this->dbPassword     = Configuracion::getDbPassword();

        return parent::__construct($loginFunction,$showLogin);
    }

    function disconnectDB() {
        if(isset($this->storage->db) && !PEAR::isError($this->storage->db))
        {
            $this->storage->db->disconnect();
        }
    }
}
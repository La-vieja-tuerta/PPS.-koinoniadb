<?php
require_once "SistemaFCE/dao/DaoBase.class.php";
class DaoResourcesInstitutions extends DaoBase{

    public function findConfirmados() {
        $c = $this->getCriterioBase();
        $c->add(Restricciones::not(Restricciones::like('description',"%(REGISTRO TEMPORARIO%")));
        $lista = $this->findBy($c);
        foreach($lista as $elem) {
            $listaSimple[$elem->getResourceId()] = $elem;
        }
        return $listaSimple;
    }
}
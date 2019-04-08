<?php
require_once "SistemaFCE/dao/DaoBase.class.php";
class DaoResources extends DaoBase{

    public function findByCodigo($codigo)
    {
        $c = $this->getCriterioBase();
        $c->add(Restricciones::eq('codigo',$codigo));

        return $this->findFirst($c);
    }
    public function findByName($name)
    {
        $c = $this->getCriterioBase();
        $c->add(Restricciones::eq('name',$name));

        return $this->findFirst($c);
    }
}
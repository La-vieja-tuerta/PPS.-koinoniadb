<?php
require_once "SistemaFCE/dao/DaoBase.class.php";
class DaoResourcesParents extends DaoBase{

    public function findByResourceId($resourceId)
    {
        $c = $this->getCriterioBase();
        $c->add(Restricciones::eq('resource_id',$resourceId));

        return $this->findFirst($c);
    }
}
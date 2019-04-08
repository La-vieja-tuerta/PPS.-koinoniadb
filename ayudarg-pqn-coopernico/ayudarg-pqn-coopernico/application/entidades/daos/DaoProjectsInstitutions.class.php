<?php
require_once "SistemaFCE/dao/DaoBase.class.php";
class DaoProjectsInstitutions extends DaoBase{

    function findByProjectId($projectId) {
        $c = $this->getCriterioBase();
        $c->add(Restricciones::eq('project_id',$projectId));

        return $this->findBy($c);

    }
}
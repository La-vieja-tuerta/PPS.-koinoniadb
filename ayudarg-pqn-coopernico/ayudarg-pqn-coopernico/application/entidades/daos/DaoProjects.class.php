<?php
require_once "SistemaFCE/dao/DaoBase.class.php";
class DaoProjects extends DaoBase{

    public function getCantidadPorStatusByProject($idProject) {
            $sql = "SELECT 
                      pro.id as proid, COUNT(rs.status) cantStatus, rs.status 
                        FROM projects pro 
                            LEFT JOIN subprojects sp ON pro.id = sp.project_id 
                            JOIN resources_subprojects rs ON rs.subproject_id = sp.id
                            	
                        WHERE pro.id = {$idProject}
                        GROUP BY pro.id, rs.status";

            $row = $this->getDb()->execute($sql);
            return $row;

    }
}
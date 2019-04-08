<?php
require_once "SistemaFCE/entidad/Entidad.class.php";
class ProjectsInstitutions extends Entidad {
/* propiedades */
	private $id;
	private $projectId;
	private $institutionId;

/* metodos */

	public function getId(){
		return $this->id;
	}

	public function setId($newId){
		$this->id = $newId;
	}
	public function getProjectId(){
		return $this->projectId;
	}

	public function setProjectId($newProjectId){
		$this->projectId = $newProjectId;
	}
	public function getInstitutionId(){
		return $this->institutionId;
	}

	public function setInstitutionId($newInstitutionId){
		$this->institutionId = $newInstitutionId;
	}

    public function getInstutionName() {
	    $insti = $this->getEntidadRelacionada($this->institutionId,'Institutions');
	    return $insti->getNameMostrar();
    }
}
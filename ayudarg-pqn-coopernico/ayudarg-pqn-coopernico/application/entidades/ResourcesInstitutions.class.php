<?php
require_once "SistemaFCE/entidad/Entidad.class.php";
class ResourcesInstitutions extends Entidad {
/* propiedades */
	private $id;
	private $resourceId;
	private $institutionId;
	private $cantidad;
	private $description;

/* metodos */

	public function getId(){
		return $this->id;
	}

	public function setId($newId){
		$this->id = $newId;
	}
	public function getResourceId(){
		return $this->resourceId;
	}

	public function setResourceId($newResourceId){
		$this->resourceId = $newResourceId;
	}
	public function getInstitutionId(){
		return $this->institutionId;
	}

	public function setInstitutionId($newInstitutionId){
		$this->institutionId = $newInstitutionId;
	}
	public function getCantidad(){
		return $this->cantidad;
	}

	public function setCantidad($newCantidad){
		$this->cantidad = $newCantidad;
	}
	public function getDescription(){
		return $this->description;
	}

	public function setDescription($newDescription){
		$this->description = $newDescription;
	}

	public function getResource() {
	    return $this->getEntidadRelacionada($this->resourceId,'Resources');
    }
}
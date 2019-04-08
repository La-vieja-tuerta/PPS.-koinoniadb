<?php
require_once "SistemaFCE/entidad/Entidad.class.php";
class Eventhistories extends Entidad {
/* propiedades */
	private $id;
	private $resourceId;
	private $subprojectId;
	private $created;
	private $updated;

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
	public function getSubprojectId(){
		return $this->subprojectId;
	}

	public function setSubprojectId($newSubprojectId){
		$this->subprojectId = $newSubprojectId;
	}
	public function getCreated(){
		return $this->created;
	}

	public function setCreated($newCreated){
		$this->created = $newCreated;
	}
	public function getUpdated(){
		return $this->updated;
	}

	public function setUpdated($newUpdated){
		$this->updated = $newUpdated;
	}
}
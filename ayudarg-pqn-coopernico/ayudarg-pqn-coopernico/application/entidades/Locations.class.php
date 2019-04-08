<?php
require_once "SistemaFCE/entidad/Entidad.class.php";
class Locations extends Entidad {
/* propiedades */
	private $id;
	private $departmentId;
	private $name;

/* metodos */

	public function getId(){
		return $this->id;
	}

	public function setId($newId){
		$this->id = $newId;
	}
	public function getDepartmentId(){
		return $this->departmentId;
	}

	public function setDepartmentId($newDepartmentId){
		$this->departmentId = $newDepartmentId;
	}
	public function getName(){
		return $this->name;
	}

	public function setName($newName){
		$this->name = $newName;
	}
}
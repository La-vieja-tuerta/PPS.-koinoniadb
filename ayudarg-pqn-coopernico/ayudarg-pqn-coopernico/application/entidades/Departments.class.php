<?php
require_once "SistemaFCE/entidad/Entidad.class.php";
class Departments extends Entidad {
/* propiedades */
	private $id;
	private $provinceId;
	private $name;

/* metodos */

	public function getId(){
		return $this->id;
	}

	public function setId($newId){
		$this->id = $newId;
	}
	public function getProvinceId(){
		return $this->provinceId;
	}

	public function setProvinceId($newProvinceId){
		$this->provinceId = $newProvinceId;
	}
	public function getName(){
		return $this->name;
	}

	public function setName($newName){
		$this->name = $newName;
	}
}
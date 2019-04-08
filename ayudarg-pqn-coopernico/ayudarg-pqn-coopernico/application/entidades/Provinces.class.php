<?php
require_once "SistemaFCE/entidad/Entidad.class.php";
class Provinces extends Entidad {
/* propiedades */
	private $id;
	private $name;

/* metodos */

	public function getId(){
		return $this->id;
	}

	public function setId($newId){
		$this->id = $newId;
	}
	public function getName(){
		return $this->name;
	}

	public function setName($newName){
		$this->name = $newName;
	}
}
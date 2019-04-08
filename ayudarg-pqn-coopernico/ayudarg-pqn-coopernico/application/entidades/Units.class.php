<?php
require_once "SistemaFCE/entidad/Entidad.class.php";
class Units extends Entidad {
/* propiedades */
	private $id;
	private $tipo;

/* metodos */

	public function getId(){
		return $this->id;
	}

	public function setId($newId){
		$this->id = $newId;
	}
	public function getTipo(){
		return $this->tipo;
	}

	public function setTipo($newTipo){
		$this->tipo = $newTipo;
	}
}
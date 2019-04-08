<?php
require_once "SistemaFCE/entidad/Entidad.class.php";
class Resourcesleafs extends Entidad {
/* propiedades */
	private $codigo;
	private $id;
	private $name;
	private $parentId;
	private $idUnidad;
	private $tipo;

/* metodos */

	public function getCodigo(){
		return $this->codigo;
	}

	public function setCodigo($newCodigo){
		$this->codigo = $newCodigo;
	}
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
	public function getParentId(){
		return $this->parentId;
	}

	public function setParentId($newParentId){
		$this->parentId = $newParentId;
	}
	public function getIdUnidad(){
		return $this->idUnidad;
	}

	public function setIdUnidad($newIdUnidad){
		$this->idUnidad = $newIdUnidad;
	}
	public function getTipo(){
		return $this->tipo;
	}

	public function setTipo($newTipo){
		$this->tipo = $newTipo;
	}
}
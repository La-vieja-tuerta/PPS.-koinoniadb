<?php
require_once "SistemaFCE/entidad/Entidad.class.php";
class Roles extends Entidad {
/* propiedades */
	private $id;
	private $title;
	private $alias;
	private $created;
	private $updated;

/* metodos */

	public function getId(){
		return $this->id;
	}

	public function setId($newId){
		$this->id = $newId;
	}
	public function getTitle(){
		return $this->title;
	}

	public function setTitle($newTitle){
		$this->title = $newTitle;
	}
	public function getAlias(){
		return $this->alias;
	}

	public function setAlias($newAlias){
		$this->alias = $newAlias;
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
<?php
require_once "SistemaFCE/entidad/Entidad.class.php";
class UsersResources extends Entidad {
/* propiedades */
	private $id;
	private $userId;
	private $resourceId;
	private $cantidad;
	private $description;

/* metodos */

	public function getId(){
		return $this->id;
	}

	public function setId($newId){
		$this->id = $newId;
	}
	public function getUserId(){
		return $this->userId;
	}

	public function setUserId($newUserId){
		$this->userId = $newUserId;
	}
	public function getResourceId(){
		return $this->resourceId;
	}

	public function setResourceId($newResourceId){
		$this->resourceId = $newResourceId;
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
}
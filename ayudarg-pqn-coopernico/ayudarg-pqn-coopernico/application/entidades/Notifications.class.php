<?php
require_once "SistemaFCE/entidad/Entidad.class.php";
class Notifications extends Entidad {
/* propiedades */
	private $id;
	private $model;
	private $userId;
	private $row;
	private $title;
	private $description;
	private $status;
	private $created;
	private $updated;

/* metodos */

	public function getId(){
		return $this->id;
	}

	public function setId($newId){
		$this->id = $newId;
	}
	public function getModel(){
		return $this->model;
	}

	public function setModel($newModel){
		$this->model = $newModel;
	}
	public function getUserId(){
		return $this->userId;
	}

	public function setUserId($newUserId){
		$this->userId = $newUserId;
	}
	public function getRow(){
		return $this->row;
	}

	public function setRow($newRow){
		$this->row = $newRow;
	}
	public function getTitle(){
		return $this->title;
	}

	public function setTitle($newTitle){
		$this->title = $newTitle;
	}
	public function getDescription(){
		return $this->description;
	}

	public function setDescription($newDescription){
		$this->description = $newDescription;
	}
	public function getStatus(){
		return $this->status;
	}

	public function setStatus($newStatus){
		$this->status = $newStatus;
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
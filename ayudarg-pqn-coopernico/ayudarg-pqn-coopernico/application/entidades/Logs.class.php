<?php
require_once "SistemaFCE/entidad/Entidad.class.php";
class Logs extends Entidad {
/* propiedades */
	private $id;
	private $title;
	private $description;
	private $model;
	private $modelId;
	private $action;
	private $userId;
	private $change;
	private $created;

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
	public function getDescription(){
		return $this->description;
	}

	public function setDescription($newDescription){
		$this->description = $newDescription;
	}
	public function getModel(){
		return $this->model;
	}

	public function setModel($newModel){
		$this->model = $newModel;
	}
	public function getModelId(){
		return $this->modelId;
	}

	public function setModelId($newModelId){
		$this->modelId = $newModelId;
	}
	public function getAction(){
		return $this->action;
	}

	public function setAction($newAction){
		$this->action = $newAction;
	}
	public function getUserId(){
		return $this->userId;
	}

	public function setUserId($newUserId){
		$this->userId = $newUserId;
	}
	public function getChange(){
		return $this->change;
	}

	public function setChange($newChange){
		$this->change = $newChange;
	}
	public function getCreated(){
		return $this->created;
	}

	public function setCreated($newCreated){
		$this->created = $newCreated;
	}
}
<?php
require_once "SistemaFCE/entidad/Entidad.class.php";
class Preferences extends Entidad {
/* propiedades */
	private $id;
	private $userId;
	private $appMenuCanMove;
	private $created;
	private $updated;

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
	public function getAppMenuCanMove(){
		return $this->appMenuCanMove;
	}

	public function setAppMenuCanMove($newAppMenuCanMove){
		$this->appMenuCanMove = $newAppMenuCanMove;
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
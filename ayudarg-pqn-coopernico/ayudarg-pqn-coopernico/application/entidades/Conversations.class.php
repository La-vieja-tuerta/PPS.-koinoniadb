<?php
require_once "SistemaFCE/entidad/Entidad.class.php";
class Conversations extends Entidad {
/* propiedades */
	private $id;
	private $title;
	private $userId;
	private $messageCount;
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
	public function getUserId(){
		return $this->userId;
	}

	public function setUserId($newUserId){
		$this->userId = $newUserId;
	}
	public function getMessageCount(){
		return $this->messageCount;
	}

	public function setMessageCount($newMessageCount){
		$this->messageCount = $newMessageCount;
	}
	public function getCreated(){
		return $this->created;
	}

	public function setCreated($newCreated){
		$this->created = $newCreated;
	}
}
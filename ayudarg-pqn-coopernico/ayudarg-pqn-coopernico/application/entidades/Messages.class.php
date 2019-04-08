<?php
require_once "SistemaFCE/entidad/Entidad.class.php";
class Messages extends Entidad {
/* propiedades */
	private $id;
	private $conversationId;
	private $userId;
	private $message;
	private $created;
	private $updated;

/* metodos */

	public function getId(){
		return $this->id;
	}

	public function setId($newId){
		$this->id = $newId;
	}
	public function getConversationId(){
		return $this->conversationId;
	}

	public function setConversationId($newConversationId){
		$this->conversationId = $newConversationId;
	}
	public function getUserId(){
		return $this->userId;
	}

	public function setUserId($newUserId){
		$this->userId = $newUserId;
	}
	public function getMessage(){
		return $this->message;
	}

	public function setMessage($newMessage){
		$this->message = $newMessage;
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
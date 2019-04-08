<?php
require_once "SistemaFCE/entidad/Entidad.class.php";
class ConversationsUsers extends Entidad {
/* propiedades */
	private $id;
	private $readFlag;
	private $lastMessageReadId;
	private $userId;
	private $conversationId;
	private $borradoLogico;

/* metodos */

	public function getId(){
		return $this->id;
	}

	public function setId($newId){
		$this->id = $newId;
	}
	public function getReadFlag(){
		return $this->readFlag;
	}

	public function setReadFlag($newReadFlag){
		$this->readFlag = $newReadFlag;
	}
	public function getLastMessageReadId(){
		return $this->lastMessageReadId;
	}

	public function setLastMessageReadId($newLastMessageReadId){
		$this->lastMessageReadId = $newLastMessageReadId;
	}
	public function getUserId(){
		return $this->userId;
	}

	public function setUserId($newUserId){
		$this->userId = $newUserId;
	}
	public function getConversationId(){
		return $this->conversationId;
	}

	public function setConversationId($newConversationId){
		$this->conversationId = $newConversationId;
	}
	public function getBorradoLogico(){
		return $this->borradoLogico;
	}

	public function setBorradoLogico($newBorradoLogico){
		$this->borradoLogico = $newBorradoLogico;
	}
}
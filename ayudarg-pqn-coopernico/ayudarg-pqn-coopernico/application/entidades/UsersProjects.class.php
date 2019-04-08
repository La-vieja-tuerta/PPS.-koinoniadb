<?php
require_once "SistemaFCE/entidad/Entidad.class.php";
class UsersProjects extends Entidad {
/* propiedades */
	private $id;
	private $userId;
	private $projectId;

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
	public function getProjectId(){
		return $this->projectId;
	}

	public function setProjectId($newProjectId){
		$this->projectId = $newProjectId;
	}
}
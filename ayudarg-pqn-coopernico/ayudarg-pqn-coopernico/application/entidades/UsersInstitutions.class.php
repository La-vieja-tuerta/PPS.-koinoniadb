<?php
require_once "SistemaFCE/entidad/Entidad.class.php";
class UsersInstitutions extends Entidad {
/* propiedades */
	private $id;
	private $userId;
	private $institutionId;

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
	public function getInstitutionId(){
		return $this->institutionId;
	}

	public function setInstitutionId($newInstitutionId){
		$this->institutionId = $newInstitutionId;
	}
}
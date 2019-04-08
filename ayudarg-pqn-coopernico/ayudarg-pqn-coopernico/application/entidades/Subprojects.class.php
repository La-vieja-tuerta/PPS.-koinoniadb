<?php
require_once "SistemaFCE/entidad/Entidad.class.php";
class Subprojects extends Entidad {
/* propiedades */
	private $id;
	private $projectId;
	private $userId;
	private $name;
	private $description;
	private $status;
	private $startDate;
	private $endDate;
	private $created;
	private $updated;
	private $parentId;

/* metodos */

	public function getId(){
		return $this->id;
	}

	public function setId($newId){
		$this->id = $newId;
	}
	public function getProjectId(){
		return $this->projectId;
	}

	public function setProjectId($newProjectId){
		$this->projectId = $newProjectId;
	}
	public function getUserId(){
		return $this->userId;
	}

	public function setUserId($newUserId){
		$this->userId = $newUserId;
	}
	public function getName(){
		return $this->name;
	}

	public function setName($newName){
		$this->name = $newName;
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
	public function getStartDate(){
		return $this->startDate;
	}

	public function setStartDate($newStartDate){
		$this->startDate = $newStartDate;
	}
	public function getEndDate(){
		return $this->endDate;
	}

	public function setEndDate($newEndDate){
		$this->endDate = $newEndDate;
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
	public function getParentId(){
		return $this->parentId;
	}

	public function setParentId($newParentId){
		$this->parentId = $newParentId;
	}
}
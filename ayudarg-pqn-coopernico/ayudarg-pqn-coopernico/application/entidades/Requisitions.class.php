<?php
require_once "SistemaFCE/entidad/Entidad.class.php";
class Requisitions extends Entidad {
/* propiedades */
	private $id;
	private $model;
	private $userId;
	private $institutionId;
	private $row;
	private $requestId;
	private $description;
	private $status;
	private $statusRequisition;
	private $statusRequisitionAccomplishment;
	private $statusRequisitionAccomplishmentDescription;
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
	public function getInstitutionId(){
		return $this->institutionId;
	}

	public function setInstitutionId($newInstitutionId){
		$this->institutionId = $newInstitutionId;
	}
	public function getRow(){
		return $this->row;
	}

	public function setRow($newRow){
		$this->row = $newRow;
	}
	public function getRequestId(){
		return $this->requestId;
	}

	public function setRequestId($newRequestId){
		$this->requestId = $newRequestId;
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
	public function getStatusRequisition(){
		return $this->statusRequisition;
	}

	public function setStatusRequisition($newStatusRequisition){
		$this->statusRequisition = $newStatusRequisition;
	}
	public function getStatusRequisitionAccomplishment(){
		return $this->statusRequisitionAccomplishment;
	}

	public function setStatusRequisitionAccomplishment($newStatusRequisitionAccomplishment){
		$this->statusRequisitionAccomplishment = $newStatusRequisitionAccomplishment;
	}
	public function getStatusRequisitionAccomplishmentDescription(){
		return $this->statusRequisitionAccomplishmentDescription;
	}

	public function setStatusRequisitionAccomplishmentDescription($newStatusRequisitionAccomplishmentDescription){
		$this->statusRequisitionAccomplishmentDescription = $newStatusRequisitionAccomplishmentDescription;
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
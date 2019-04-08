<?php
require_once "SistemaFCE/entidad/Entidad.class.php";
class Projects extends Entidad {
/* propiedades */
	private $id;
	private $userId;
	private $name;
	private $beneficiary;
	private $description;
	private $startDate;
	private $endDate;
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
	public function getName(){
		return $this->name;
	}

	public function setName($newName){
		$this->name = $newName;
	}
	public function getBeneficiary(){
		return $this->beneficiary;
	}

	public function setBeneficiary($newBeneficiary){
		$this->beneficiary = $newBeneficiary;
	}
	public function getDescription(){
		return $this->description;
	}

	public function setDescription($newDescription){
		$this->description = $newDescription;
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

    public function getEstadosRecursos() {
        if(!isset($this->estadosRecursos))
            $this->estadosRecursos = DaoProjects::getInstance()->getCantidadPorStatusByProject($this->id);
        return $this->estadosRecursos;
    }

    public function getCantEstadosRecursos() {
	    $ers = $this->getEstadosRecursos();
	    $cant = 0;
        if(!empty($ers))
	    foreach ($ers as $er) {
	        $cant += $er['cantStatus'];
        }
	    return $cant;
    }

	public function getCantObtenido() {
        $ers = $this->getEstadosRecursos();
        if(!empty($ers))
        foreach ($ers as $er) {
            if($er['status'] == 'obtenido')
                return $er['cantStatus'];
        }
        return 0;
    }

    public function getCantCarencia() {
        $ers = $this->getEstadosRecursos();
        if(!empty($ers))
        foreach ($ers as $er) {
            if($er['status'] == 'carencia')
                return $er['cantStatus'];
        }
        return 0;
    }

    public function getInstitutionsNames() {
        $instis = DaoProjectsInstitutions::getInstance()->findByProjectId($this->id);
        if(!empty($instis))
            foreach($instis as $projInsti)
            {
                $intiNames[] = $projInsti->getInstutionName();
            }
            return $intiNames;
    }
}
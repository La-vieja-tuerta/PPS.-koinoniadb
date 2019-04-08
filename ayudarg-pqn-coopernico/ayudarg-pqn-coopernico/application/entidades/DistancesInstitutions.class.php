<?php
require_once "SistemaFCE/entidad/Entidad.class.php";
class DistancesInstitutions extends Entidad {
/* propiedades */
	private $id;
	private $idOrigin;
	private $idDestinations;
	private $distance;

/* metodos */

	public function getId(){
		return $this->id;
	}

	public function setId($newId){
		$this->id = $newId;
	}
	public function getIdOrigin(){
		return $this->idOrigin;
	}

	public function setIdOrigin($newIdOrigin){
		$this->idOrigin = $newIdOrigin;
	}
	public function getIdDestinations(){
		return $this->idDestinations;
	}

	public function setIdDestinations($newIdDestinations){
		$this->idDestinations = $newIdDestinations;
	}
	public function getDistance(){
		return $this->distance;
	}

	public function setDistance($newDistance){
		$this->distance = $newDistance;
	}
}
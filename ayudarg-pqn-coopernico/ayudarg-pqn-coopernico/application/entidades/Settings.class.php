<?php
require_once "SistemaFCE/entidad/Entidad.class.php";
class Settings extends Entidad {
/* propiedades */
	private $id;
	private $key;
	private $value;
	private $title;
	private $description;
	private $inputType;
	private $editable;
	private $weight;
	private $params;

/* metodos */

	public function getId(){
		return $this->id;
	}

	public function setId($newId){
		$this->id = $newId;
	}
	public function getKey(){
		return $this->key;
	}

	public function setKey($newKey){
		$this->key = $newKey;
	}
	public function getValue(){
		return $this->value;
	}

	public function setValue($newValue){
		$this->value = $newValue;
	}
	public function getTitle(){
		return $this->title;
	}

	public function setTitle($newTitle){
		$this->title = $newTitle;
	}
	public function getDescription(){
		return $this->description;
	}

	public function setDescription($newDescription){
		$this->description = $newDescription;
	}
	public function getInputType(){
		return $this->inputType;
	}

	public function setInputType($newInputType){
		$this->inputType = $newInputType;
	}
	public function getEditable(){
		return $this->editable;
	}

	public function setEditable($newEditable){
		$this->editable = $newEditable;
	}
	public function getWeight(){
		return $this->weight;
	}

	public function setWeight($newWeight){
		$this->weight = $newWeight;
	}
	public function getParams(){
		return $this->params;
	}

	public function setParams($newParams){
		$this->params = $newParams;
	}
}
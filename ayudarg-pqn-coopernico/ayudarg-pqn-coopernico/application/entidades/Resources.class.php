<?php
require_once "SistemaFCE/entidad/Entidad.class.php";
class Resources extends Entidad {
/* propiedades */
	private $id;
	private $name;
	private $description;
	private $idUnidad;
	private $created;
	private $updated;
	private $codigo;
	private $tags;
	private $estado;

/* metodos */

	public function getId(){
		return $this->id;
	}

	public function setId($newId){
		$this->id = $newId;
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
	public function getIdUnidad(){
		return $this->idUnidad;
	}

	public function setIdUnidad($newIdUnidad){
		$this->idUnidad = $newIdUnidad;
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
	public function getCodigo(){
		return $this->codigo;
	}

	public function setCodigo($newCodigo){
		$this->codigo = $newCodigo;
	}
	public function getTags(){
		return $this->tags;
	}

	public function setTags($newTags){
		$this->tags = $newTags;
	}

    /**
     * @return mixed
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * @param mixed $estado
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }


}
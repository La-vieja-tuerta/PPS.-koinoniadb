<?php
require_once "SistemaFCE/entidad/Entidad.class.php";
class Attachments extends Entidad {
/* propiedades */
	private $id;
	private $model;
	private $row;
	private $userId;
	private $dirname;
	private $basename;
	private $filename;
	private $originalFilename;
	private $extention;
	private $mimetype;
	private $group;
	private $size;
	private $width;
	private $height;
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
	public function getRow(){
		return $this->row;
	}

	public function setRow($newRow){
		$this->row = $newRow;
	}
	public function getUserId(){
		return $this->userId;
	}

	public function setUserId($newUserId){
		$this->userId = $newUserId;
	}
	public function getDirname(){
		return $this->dirname;
	}

	public function setDirname($newDirname){
		$this->dirname = $newDirname;
	}
	public function getBasename(){
		return $this->basename;
	}

	public function setBasename($newBasename){
		$this->basename = $newBasename;
	}
	public function getFilename(){
		return $this->filename;
	}

	public function setFilename($newFilename){
		$this->filename = $newFilename;
	}
	public function getOriginalFilename(){
		return $this->originalFilename;
	}

	public function setOriginalFilename($newOriginalFilename){
		$this->originalFilename = $newOriginalFilename;
	}
	public function getExtention(){
		return $this->extention;
	}

	public function setExtention($newExtention){
		$this->extention = $newExtention;
	}
	public function getMimetype(){
		return $this->mimetype;
	}

	public function setMimetype($newMimetype){
		$this->mimetype = $newMimetype;
	}
	public function getGroup(){
		return $this->group;
	}

	public function setGroup($newGroup){
		$this->group = $newGroup;
	}
	public function getSize(){
		return $this->size;
	}

	public function setSize($newSize){
		$this->size = $newSize;
	}
	public function getWidth(){
		return $this->width;
	}

	public function setWidth($newWidth){
		$this->width = $newWidth;
	}
	public function getHeight(){
		return $this->height;
	}

	public function setHeight($newHeight){
		$this->height = $newHeight;
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
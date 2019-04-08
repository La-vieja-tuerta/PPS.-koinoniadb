<?php
require_once "SistemaFCE/entidad/Entidad.class.php";
class Institutions extends Entidad {
/* propiedades */
	private $id;
	private $directorUserId;
	private $managerUserId;
	private $contactUserId;
	private $typeId;
	private $sectorId;
	private $locationId;
	private $attachmentId;
	private $name;
	private $address;
	private $phone;
	private $website;
	private $email;
	private $shortbio;
	private $bio;
	private $interest;
	private $timezone;
	private $fax;
	private $status;
	private $created;
	private $updated;
	private $parentId;
	private $latitude;
	private $longitude;
	private $namemostrar;

/* metodos */

	public function getId(){
		return $this->id;
	}

	public function setId($newId){
		$this->id = $newId;
	}
	public function getDirectorUserId(){
		return $this->directorUserId;
	}

	public function setDirectorUserId($newDirectorUserId){
		$this->directorUserId = $newDirectorUserId;
	}
	public function getManagerUserId(){
		return $this->managerUserId;
	}

	public function setManagerUserId($newManagerUserId){
		$this->managerUserId = $newManagerUserId;
	}
	public function getContactUserId(){
		return $this->contactUserId;
	}

	public function setContactUserId($newContactUserId){
		$this->contactUserId = $newContactUserId;
	}
	public function getTypeId(){
		return $this->typeId;
	}

	public function setTypeId($newTypeId){
		$this->typeId = $newTypeId;
	}
	public function getSectorId(){
		return $this->sectorId;
	}

	public function setSectorId($newSectorId){
		$this->sectorId = $newSectorId;
	}
	public function getLocationId(){
		return $this->locationId;
	}

	public function setLocationId($newLocationId){
		$this->locationId = $newLocationId;
	}
	public function getAttachmentId(){
		return $this->attachmentId;
	}

	public function setAttachmentId($newAttachmentId){
		$this->attachmentId = $newAttachmentId;
	}
	public function getName(){
		return $this->name;
	}

	public function setName($newName){
		$this->name = $newName;
	}
	public function getAddress(){
		return $this->address;
	}

	public function setAddress($newAddress){
		$this->address = $newAddress;
	}
	public function getPhone(){
		return $this->phone;
	}

	public function setPhone($newPhone){
		$this->phone = $newPhone;
	}
	public function getWebsite(){
		return $this->website;
	}

	public function setWebsite($newWebsite){
		$this->website = $newWebsite;
	}
	public function getEmail(){
		return $this->email;
	}

	public function setEmail($newEmail){
		$this->email = $newEmail;
	}
	public function getShortbio(){
		return $this->shortbio;
	}

	public function setShortbio($newShortbio){
		$this->shortbio = $newShortbio;
	}
	public function getBio(){
		return $this->bio;
	}

	public function setBio($newBio){
		$this->bio = $newBio;
	}
	public function getInterest(){
		return $this->interest;
	}

	public function setInterest($newInterest){
		$this->interest = $newInterest;
	}
	public function getTimezone(){
		return $this->timezone;
	}

	public function setTimezone($newTimezone){
		$this->timezone = $newTimezone;
	}
	public function getFax(){
		return $this->fax;
	}

	public function setFax($newFax){
		$this->fax = $newFax;
	}
	public function getStatus(){
		return $this->status;
	}

	public function setStatus($newStatus){
		$this->status = $newStatus;
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
	public function getLatitude(){
		return $this->latitude;
	}

	public function setLatitude($newLatitude){
		$this->latitude = $newLatitude;
	}
	public function getLongitude(){
		return $this->longitude;
	}

	public function setLongitude($newLongitude){
		$this->longitude = $newLongitude;
	}
	public function getNamemostrar(){
		return $this->namemostrar;
	}

	public function setNamemostrar($newNamemostrar){
		$this->namemostrar = $newNamemostrar;
	}
}
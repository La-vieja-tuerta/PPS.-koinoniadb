<?php
require_once "SistemaFCE/entidad/Entidad.class.php";
class Users extends Entidad {
/* propiedades */
	private $id;
	private $roleId;
	private $username;
	private $password;
	private $name;
	private $email;
	private $address;
	private $phone;
	private $locationId;
	private $website;
	private $activationKey;
	private $timezone;
	private $status;
	private $updated;
	private $created;
	private $latitude;
	private $longitude;

/* metodos */

	public function getId(){
		return $this->id;
	}

	public function setId($newId){
		$this->id = $newId;
	}
	public function getRoleId(){
		return $this->roleId;
	}

	public function setRoleId($newRoleId){
		$this->roleId = $newRoleId;
	}
	public function getUsername(){
		return $this->username;
	}

	public function setUsername($newUsername){
		$this->username = $newUsername;
	}
	public function getPassword(){
		return $this->password;
	}

	public function setPassword($newPassword){
		$this->password = $newPassword;
	}
	public function getName(){
		return $this->name;
	}

	public function setName($newName){
		$this->name = $newName;
	}
	public function getEmail(){
		return $this->email;
	}

	public function setEmail($newEmail){
		$this->email = $newEmail;
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
	public function getLocationId(){
		return $this->locationId;
	}

	public function setLocationId($newLocationId){
		$this->locationId = $newLocationId;
	}
	public function getWebsite(){
		return $this->website;
	}

	public function setWebsite($newWebsite){
		$this->website = $newWebsite;
	}
	public function getActivationKey(){
		return $this->activationKey;
	}

	public function setActivationKey($newActivationKey){
		$this->activationKey = $newActivationKey;
	}
	public function getTimezone(){
		return $this->timezone;
	}

	public function setTimezone($newTimezone){
		$this->timezone = $newTimezone;
	}
	public function getStatus(){
		return $this->status;
	}

	public function setStatus($newStatus){
		$this->status = $newStatus;
	}
	public function getUpdated(){
		return $this->updated;
	}

	public function setUpdated($newUpdated){
		$this->updated = $newUpdated;
	}
	public function getCreated(){
		return $this->created;
	}

	public function setCreated($newCreated){
		$this->created = $newCreated;
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

	public function tienePermiso($permiso) {
	    return true;
    }
}
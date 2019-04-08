<?php
require_once "SistemaFCE/entidad/Entidad.class.php";
class Envio extends Entidad {
/* propiedades */
	private $idEnvio;
	private $donante;
	private $receptor;
	private $entregado;
	private $numeroSeguimiento;
	private $addressDonante;
	private $latitudeReceptor;
	private $longitudeReceptor;
	private $fechaEnvio;
	private $fechaRecepcion;
	private $descripcion;
	private $idInstitucionReceptorFk;

/* metodos */

	public function getIdEnvio(){
		return $this->idEnvio;
	}

	public function setIdEnvio($newIdEnvio){
		$this->idEnvio = $newIdEnvio;
	}
	public function getDonante(){
		return $this->donante;
	}

	public function setDonante($newDonante){
		$this->donante = $newDonante;
	}
	public function getReceptor(){
		return $this->receptor;
	}

	public function setReceptor($newReceptor){
		$this->receptor = $newReceptor;
	}
	public function getEntregado(){
		return $this->entregado;
	}

	public function setEntregado($newEntregado){
		$this->entregado = $newEntregado;
	}
	public function getNumeroSeguimiento(){
		return $this->numeroSeguimiento;
	}

	public function setNumeroSeguimiento($newNumeroSeguimiento){
		$this->numeroSeguimiento = $newNumeroSeguimiento;
	}
	public function getNombreDonante(){
		return $this->nombreDonante;
	}

	public function setNombreDonante($newNombreDonante){
		$this->nombreDonante = $newNombreDonante;
	}
	public function getNombreReceptor(){
		return $this->nombreReceptor;
	}

	public function setNombreReceptor($newNombreReceptor){
		$this->nombreReceptor = $newNombreReceptor;
	}
	public function getAddressDonante(){
		return $this->addressDonante;
	}

	public function setAddressDonante($newAddressDonante){
		$this->addressDonante = $newAddressDonante;
	}
	public function getLatitudeDonante(){
		return $this->latitudeDonante;
	}

	public function setLatitudeDonante($newLatitudeDonante){
		$this->latitudeDonante = $newLatitudeDonante;
	}
	public function getLongitudeDonante(){
		return $this->longitudeDonante;
	}

	public function setLongitudeDonante($newLongitudeDonante){
		$this->longitudeDonante = $newLongitudeDonante;
	}
	public function getAddressReceptor(){
		return $this->addressReceptor;
	}

	public function setAddressReceptor($newAddressReceptor){
		$this->addressReceptor = $newAddressReceptor;
	}
	public function getLatitudeReceptor(){
		return $this->latitudeReceptor;
	}

	public function setLatitudeReceptor($newLatitudeReceptor){
		$this->latitudeReceptor = $newLatitudeReceptor;
	}
	public function getLongitudeReceptor(){
		return $this->longitudeReceptor;
	}

	public function setLongitudeReceptor($newLongitudeReceptor){
		$this->longitudeReceptor = $newLongitudeReceptor;
	}
	public function getFechaEnvio(){
		return $this->fechaEnvio;
	}

	public function setFechaEnvio($newFechaEnvio){
		$this->fechaEnvio = $newFechaEnvio;
	}
	public function getFechaRecepcion(){
		return $this->fechaRecepcion;
	}

	public function setFechaRecepcion($newFechaRecepcion){
		$this->fechaRecepcion = $newFechaRecepcion;
	}
	public function getDescripcion(){
		return $this->descripcion;
	}

	public function setDescripcion($newDescripcion){
		$this->descripcion = $newDescripcion;
	}

    /**
     * @return mixed
     */
    public function getIdInstitucionReceptorFk()
    {
        return $this->idInstitucionReceptorFk;
    }

    /**
     * @param mixed $idInstitucionReceptorFk
     */
    public function setIdInstitucionReceptorFk($idInstitucionReceptorFk)
    {
        $this->idInstitucionReceptorFk = $idInstitucionReceptorFk;
    }



    /**
     * @return Users el usuario donador
     */
	public function getDonanteUser() {
	    return $this->getEntidadRelacionada($this->donante,'Users');
    }

    /**
     * @return Users el usuario receptor
     */
    public function getReceptorUser() {
        return $this->getEntidadRelacionada($this->receptor,'Users');
    }

    /**
     * @return Institutions
     */
    public function getIntitucionReceptor() {
        return $this->getEntidadRelacionada($this->idInstitucionReceptorFk,'Institutions');
    }
}
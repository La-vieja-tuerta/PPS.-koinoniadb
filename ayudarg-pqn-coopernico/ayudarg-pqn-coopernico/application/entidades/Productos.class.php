<?php
require_once "SistemaFCE/entidad/Entidad.class.php";
class Productos extends Entidad {
/* propiedades */
	private $prodId;
	private $prodCatId;
	private $prodNombre;
	private $prodPrecio;
	private $prodFoto;
	private $prodStock;
	private $prodCosto;
	private $prodCodigob;

/* metodos */

	public function getProdId(){
		return $this->prodId;
	}

	public function setProdId($newProdId){
		$this->prodId = $newProdId;
	}
	public function getProdCatId(){
		return $this->prodCatId;
	}

	public function setProdCatId($newProdCatId){
		$this->prodCatId = $newProdCatId;
	}
	public function getProdNombre(){
		return $this->prodNombre;
	}

	public function setProdNombre($newProdNombre){
		$this->prodNombre = $newProdNombre;
	}
	public function getProdPrecio(){
		return $this->prodPrecio;
	}

	public function setProdPrecio($newProdPrecio){
		$this->prodPrecio = $newProdPrecio;
	}
	public function getProdFoto(){
		return $this->prodFoto;
	}

	public function setProdFoto($newProdFoto){
		$this->prodFoto = $newProdFoto;
	}
	public function getProdStock(){
		return $this->prodStock;
	}

	public function setProdStock($newProdStock){
		$this->prodStock = $newProdStock;
	}
	public function getProdCosto(){
		return $this->prodCosto;
	}

	public function setProdCosto($newProdCosto){
		$this->prodCosto = $newProdCosto;
	}
	public function getProdCodigob(){
		return $this->prodCodigob;
	}

	public function setProdCodigob($newProdCodigob){
		$this->prodCodigob = $newProdCodigob;
	}
}
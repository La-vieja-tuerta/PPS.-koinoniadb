<?php
/**
 * Created by PhpStorm.
 * User: lucas
 * Date: 25/10/17
 * Time: 18:42
 */

class ResourceRelated
{
    private $recurso;
    private $idEntidadRelacionada;
    private $cantidad;
    private $descripcion;

    /**
     * @return Resources
     */
    public function getRecurso()
    {
        return $this->recurso;
    }

    /**
     * @param Resources $recurso
     */
    public function setRecurso($recurso)
    {
        $this->recurso = $recurso;
    }

    /**
     * @return mixed
     */
    public function getIdEntidadRelacionada()
    {
        return $this->idEntidadRelacionada;
    }

    /**
     * @param mixed $idEntidadRelacionada
     */
    public function setIdEntidadRelacionada($idEntidadRelacionada)
    {
        $this->idEntidadRelacionada = $idEntidadRelacionada;
    }

    /**
     * @return mixed
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * @param mixed $cantidad
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;
    }

    /**
     * @return mixed
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * @param mixed $descripcion
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }



}
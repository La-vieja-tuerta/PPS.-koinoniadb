<?php

/**
 * Created by PhpStorm.
 * User: lucas.vidaguren
 * Date: 01/12/16
 * Time: 18:39
 */
class DonacionForm extends BaseForm
{

    protected function addElements()
    {
        $this->addElement('text','nombre','Nombre',array('required'=>'required'));
        $this->addElement('text','email','Email',array('required'=>'required'));
        $this->addElement('text','telefono','Telefono');
        $this->addElement('textarea','mensaje','Mensaje',array('required'=>'required'));
        //$this->addElement('text','direccion','direccion'); //MOISES hay que agregar

    }

    protected function addRules()
    {
        $this->addRule('nombre','El campo es requerido','required');
        $this->addRule('email','El campo es requerido','required');
        $this->addRule('direccion','El campo es requerido','required');//MOISES hay que agregar
        $this->addRule('mensaje','El campo es requerido','required');
        parent::addRules();
    }
}
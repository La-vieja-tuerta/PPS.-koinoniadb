<?php
/**
 * Created by PhpStorm.
 * User: lucas.vidaguren
 * Date: 26/10/17
 * Time: 15:38
 */
require_once 'modulos/Donacion/DonacionForm.class.php';
class RecibirForm extends DonacionForm
{
    protected function addElements()
    {
        $this->addElement('text','ONG','ONG');
        $this->addElement('text','ONGtelef','Teléfono');
        $this->addElement('text','ONGemail','Email');
        $this->addElement('text','ONGdireccion','Dirección');
        $this->addElement('textarea','ONGdescripcion','Descripción');
        $this->addElement('text','ONGproyecto','Proyecto');
        $this->addElement('text','startDate','Fecha Inicio Proyecto');
        $this->addElement('text','endDate','Fecha Fin Proyecto');
        $this->addElement('textarea','ONGdetalleproyecto','Detalle del Proyecto');

        parent::addElements();
    }

    protected function addRules()
    {
        $this->addRule('ONG','El campo es requerido','required');
        $this->addRule('ONGtelef','El campo es requerido','required');
        $this->addRule('ONGemail','El campo es requerido','required');
        $this->addRule('ONGdireccion','El campo es requerido','required');
        $this->addRule('ONGproyecto','El campo es requerido','required');
        $this->addRule('ONGdetalleproyecto','El campo es requerido','required');
        parent::addRules();
    }

}
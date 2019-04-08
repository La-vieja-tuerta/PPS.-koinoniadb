<?php
require_once 'SistemaFCE/util/properties/DaoConfigurationProperty.class.php';
/**
 * Created by PhpStorm.
 * User: lucas.vidaguren
 * Date: 05/12/16
 * Time: 16:33
 */
class ConfiguracionHelper implements PropertiesManager
{
    public static function getEmailContacto() {
        return self::getPropertyValue('emailContacto','info@proyectokoinonia.org.ar');
    }

    /**
     * Returns the value of a given property.
     * @param $propertyKey Property identifying key
     * @param $dafaultValue Default value returned if not exists property key
     */
    static public function getPropertyValue($propertyKey, $defaultValue = null)
    {

        $prop = DaoConfigurationProperty::getInstance()->findByKey($propertyKey);
        if(!isset($prop))
        {
            return $defaultValue;
        }
        return $prop->getValue();
    }

    /**
     * Set the value of a given property. If property key does not exist, it is created.
     * @param $propertyKey Property identifying key
     * @param $value Value of the property
     */
    static public function setPropertyValue($propertyKey, $value)
    {
        $prop = DaoConfigurationProperty::getInstance()->findByKey($propertyKey);
        if(!isset($prop))
        {
            $prop = new ConfigurationProperty();
            $prop->setProperty($propertyKey);
        }
        $prop->setValue($value);
        return DaoConfigurationProperty::getInstance()->save($prop);
    }

    /**
     * Delete a given property.
     * @param $propertyKey Property identifying key
     */
    static public function deleteProperty($propertyKey)
    {
        $prop = DaoConfigurationProperty::getInstance()->findByKey($propertyKey);
        if(isset($prop)) {
            $c = new Criterio();
            $c->add(Restricciones::eq('property',$propertyKey));

            return DaoConfigurationProperty::getInstance()->deleteBy($c);
        }
        return false;
    }

    /**
     * Determines the existence of a property.
     * @param $propertyKey
     * @return Bool Boolean value with the result
     */
    static public function existsProperty($propertyKey)
    {
        $prop = DaoConfigurationProperty::getInstance()->findByKey($propertyKey);
        return isset($prop);
    }

    static public function setMailAvisoQuiero($nuevoMail) {
        return self::setPropertyValue('mailAvisoQuiero',$nuevoMail);
    }

    static public function getMailAvisoQuiero() {
        return self::getPropertyValue('mailAvisoQuiero','info@proyectokoinonia.org.ar');
    }

    static public function setMailEnvios($nuevoMail) {
        return self::setPropertyValue('mailEnvios',$nuevoMail);
    }

    static public function getMailEnvios() {
        return self::getPropertyValue('mailEnvios','no-reply@proyectokoinonia.org.ar');
    }
}
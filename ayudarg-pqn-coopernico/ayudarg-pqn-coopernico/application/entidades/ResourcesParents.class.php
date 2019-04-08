<?php
require_once "SistemaFCE/entidad/Entidad.class.php";
/**
 * Created by PhpStorm.
 * User: lucas.vidaguren
 * Date: 25/10/17
 * Time: 15:35
 */

class ResourcesParents extends Entidad
{
    private  $id;
    private  $resourceId;
    private  $parentId;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getResourceId()
    {
        return $this->resourceId;
    }

    /**
     * @param mixed $resourceId
     */
    public function setResourceId($resourceId)
    {
        $this->resourceId = $resourceId;
    }

    /**
     * @return mixed
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * @param mixed $parentId
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;
    }


}
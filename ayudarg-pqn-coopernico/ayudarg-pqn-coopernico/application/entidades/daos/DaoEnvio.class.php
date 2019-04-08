<?php
require_once "SistemaFCE/dao/DaoBase.class.php";
class DaoEnvio extends DaoBase{

    public function findByNroSeguimiento($nroSeguimiento) {
        $c = $this->getCriterioBase();
        $c->add(Restricciones::eq('numero_seguimiento',$nroSeguimiento));

        return $this->findBy($c,'id_envio');
    }

    public function findNoEntregadosByReceptor($idUsuario) {
        $c = $this->getCriterioBase();
        $c->add(Restricciones::eq('entregado',false));
        $c->add(Restricciones::eq('receptor',$idUsuario));

        return $this->findBy($c,'id_envio');
    }

    /**
     * @param $nroSeguimiento
     * @return integer
     *
     */
    public function getMaxIdEnvioNumeroSeguimiento($nroSeguimiento) {
        $c = $this->getCriterioBase();
        $c->add(Restricciones::eq('numero_seguimiento',$nroSeguimiento));

        $sql = $this->getSql('MAX(id_envio) as idEnvio',$this->tableName,$c);
        $rs = $this->getDb()->execute($sql);

        return $rs->fields['idEnvio'];
    }

    /**
     * @param $nroSeguimiento
     * @return Envio
     */
    public function findUltimoEnvioNumeroSeguimiento($nroSeguimiento) {
        $c = $this->getCriterioBase();
        $idEnvio = $this->getMaxIdEnvioNumeroSeguimiento($nroSeguimiento);
        $c->add(Restricciones::eq('id_envio',$idEnvio));

        return $this->findFirst($c);
    }
}
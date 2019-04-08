<?php
require_once 'SistemaFCE/modulo/BaseAdminMod.class.php';
require_once 'utils/ConfiguracionHelper.class.php';
require_once 'utils/KoinoniaEmailsMod.class.php';
/**
 * Created by PhpStorm.
 * User: lucas.vidaguren
 * Date: 01/12/16
 * Time: 16:16
 */
class PaginasMod extends BaseAdminMod
{
    public function __construct($skinName = null)
    {
        parent::__construct('BaseForm', DaoInstitutions::getInstance(), $skinName,null,null, 'Default');
        $this->setTplVar('pQnHeaderTpl','common/header.tpl');
        $this->setTplVar('pQnFooterTpl','common/footer.tpl');
    }

    protected function accionInicio($req) {
        $this->mostrar('paginas/inicio.tpl');
    }

    protected function accionNoticias($req) {

        $this->addJsFile('js/Chart.js');
        $daoProy = DaoProjects::getInstance();
        $institutions = DaoInstitutions::getInstance()->findNoPersonales(10);
        $c = new Criterio();
        $c->add(Restricciones::ge('end_date',date('Y-m-d')));

        $proyectos = $daoProy->findBy($c,'created desc, name, id desc');

        $daoRec = DaoResources::getInstance();
        $recursosInst = DaoResourcesInstitutions::getInstance()->findConfirmados();

        $daoRecd = DaoResources::getInstance();
        $recursosSubp = DaoResourcesSubprojects::getInstance()->findDemandados();


        $this->setTplVar('proyectos',$proyectos);
        $this->setTplVar('institutions',$institutions);
        $this->setTplVar('recursosInstit',$recursosInst);
        $this->setTplVar('recursosSubpro',$recursosSubp);




        $this->mostrar('paginas/noticias.tpl');
    }

    protected function accionServicios($req) {

        $this->mostrar('paginas/servicios.tpl');
    }

    protected function accionContacto($req) {

        $emailParaContacto = ConfiguracionHelper::getEmailContacto();

        if(isset($_POST['accion'])) {
            $nombre = $req['nombre'];
            $email = $req['email'];

            if(!isset($email))
                $email = $emailParaContacto;

            $this->setTplVar('nombre',$nombre);
            $this->setTplVar('email',$email);
            $this->setTplVar('telefono',$req['telefono']);
            $this->setTplVar('mensaje',str_replace("\n","<br>\n",$req['mensaje']));
            $cuerpo = $this->smarty->fetch('mails/contacto.tpl');

            $this->setTplVar('enviado',KoinoniaEmailsMod::enviarMail($emailParaContacto,"Contacto desde Ayudarg de {$nombre}",$cuerpo,'Proyecto Koinonia <'.ConfiguracionHelper::getMailEnvios().'>'));
        }
        else
            $this->setTplVar('enviado',null);
        $this->mostrar('paginas/contacto.tpl');
    }

}
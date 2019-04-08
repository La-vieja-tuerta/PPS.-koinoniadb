<?php
require_once 'SistemaFCE/modulo/BaseAdminMod.class.php';
require_once 'modulos/Donacion/DonacionForm.class.php';
require_once 'modulos/Donacion/RecibirForm.class.php';
require_once 'utils/ResourceRelated.class.php';
require_once 'utils/KoinoniaEmailsMod.class.php';
/**
 * Created by PhpStorm.
 * User: lucas.vidaguren
 * Date: 01/12/16
 * Time: 17:34
 */
class DonacionMod extends BaseAdminMod
{
    public function __construct($skinName = null)
    {
        parent::__construct(new DonacionForm(), DaoInstitutions::getInstance(), $skinName, null , 'donacion/form.tpl', 'Default');
        $this->setTplVar('pQnHeaderTpl','common/header.tpl');
        $this->setTplVar('pQnFooterTpl','common/footer.tpl');

        $this->setJsModulo('donacion');
    }

    protected function form($req)
    {

        $this->addJsFile('/js/sistemafce/admin.js');

        $frase= $req['frase'];
        $nro = $req['nro'];
        $quiero = $req['quiero'];

        if(!isset($quiero)) $quiero = 'dar';
        if(!isset($frase))  $frase = "Su donación es nuestra prioridad y queremos su utilización en forma eficiente.";
        if(!isset($nro))    $nro = "01";

        $this->setTplVar('formDonacion',"donacion/form/{$quiero}.tpl");
        $this->setTplVar('introDonacion',"donacion/intro/{$quiero}.tpl");
        $this->setTplVar('frase',$frase);
        $this->setTplVar('quiero',$quiero);
        $this->setTplVar('nro',$nro);

        parent::form($req);
    }

    /**
     * @param Users $user
     * @param $loQueQuiero
     * @param $mensaje
     * @return bool|Messages
     */
    protected function enviarQuiero(Users $user, $loQueQuiero, $mensaje) {

        $emailParaContacto = ConfiguracionHelper::getMailAvisoQuiero();

        $nombre = $user->getName();
        $email = $user->getEmail();

       $this->setTplVar('nombre',$nombre);
        $this->setTplVar('email',$email);
        $this->setTplVar('telefono',$user->getPhone());

        $this->setTplVar('mensaje',str_replace("\n","<br>\n",$mensaje));
        $cuerpo = $this->smarty->fetch("mails/donacion/{$loQueQuiero}.tpl");

        $this->setTplVar('enviado',KoinoniaEmailsMod::enviarMail($emailParaContacto,"{$nombre} quiere {$loQueQuiero} (desde Ayud@rg)",$cuerpo,"Proyecto Koinonia <".ConfiguracionHelper::getMailEnvios().">"));

        return $this->crearMensaje($user,$loQueQuiero,$mensaje);
    }

    /**
     * Agrega un usuario como persona que trabaja con una institución
     * @param Users $user
     * @param Institutions $institution
     */
    protected function addUserToInstitution($user,$institution) {
        $institUser = new InstitutionsUsers();
        $institUser->setUserId($user->getId());
        $institUser->setInstitutionId($institution->getId());
        return DaoInstitutionsUsers::getInstance()->save($institUser);
    }
    /**
     * Crea un usuario con los datos dados y la institucion que usará para relacionarse
     * @param $nombre
     * @param $email
     * @param $telefono
     * @param $password de momento no se está utilizando,
     * @param int $locationID por defecto 887 id de Tandil
     * @param string $address
     * @return bool|Users
     */
    protected function crearUsuario($nombre, $email, $telefono, $password, $locationID=887, $address= ' ') {
        $user = new Users();
        $user->setName($nombre);
        $user->setEmail($email);
        $user->setRoleId(2); // 2 - Usuario registrado
        $user->setUsername($email);

        $user->setPassword(password_hash($password,PASSWORD_BCRYPT)); //'$2a$10$pHzYnbyY1QSaGg/SJk53nuQu.lwPeCEqbf/KWCpwsYOrJuwjxd1Ly'
        $user->setPhone($telefono);
        $user->setAddress($address);
        $user->setLocationId($locationID);
        $user->setActivationKey('');
        $user->setStatus(1);
        $ya = date('Y-m-d H:i:s');
        $user->setUpdated($ya);
        $user->setCreated($ya);


        if(DaoUsers::getInstance()->save($user)) {
            $instit = $this->crearInstitucion($user); //institución que representa el usuario
            $this->addUserToInstitution($user,$instit);
            return $user;
        }
        return false;
    }

    /**
     * Crea una institución que puede representar ONG o personas
     * @param Users $user
     * @param string $type
     * @param null $ONG
     * @return bool|Institutions
     */
    protected function crearInstitucion(Users $user,$type = 'User',$ONG=null) {
        $userId = $user->getId();
        $typeID = 3;
        $sectorID = 7;
        $name = $ONG['ONG'];
        $phone = '';

        if($type != 'ONG') {
            $typeID = 168;
            $sectorID = 5;
            $name = $user->getUsername();
            $phone = $user->getPhone();
            $mailu=$user->getEmail();
        }

        //como creo un usuario debo crear la institucion asociada al usuario
        $institucion = new Institutions();
        $institucion->setDirectorUserId($userId);
        $institucion->setManagerUserId($userId);
        $institucion->setContactUserId($userId);
        $institucion->setTypeId($typeID); //PNA
        $institucion->setSectorId($sectorID);
        $institucion->setLocationId(887); //Tandil
        $institucion->setName($name);
        $institucion->setWebsite('');





        if($type != 'ONG') {
            $institucion->setEmail($mailu);
            $institucion->setPhone($phone);
            $institucion->setShortbio($name);
            $institucion->setBio($name);
            $institucion->setInterest('PERSONAL');
            $institucion->setAddress(' ');
        }else{
            $institucion->setEmail($ONG['ONGemail']);
            $institucion->setPhone($ONG['ONGtelef']);
            $institucion->setShortbio($ONG['ONGdescripcion']);
            $institucion->setBio($ONG['ONGdescripcion']);
            $institucion->setInterest($name);
            $institucion->setAddress($ONG['ONGdireccion']);
        }



        $institucion->setTimezone(0);
        $institucion->setFax('');
        $institucion->setStatus(1);

        $ya = date('Y-m-d H:i:s');
        $institucion->setCreated($ya);
        $institucion->setUpdated($ya);
        $institucion->setLatitude(-37.313645);
        $institucion->setLongitude(-59.0981448);
        $institucion->setNamemostrar($name);

        //fin de como creo un usuario debo crear la institucion asociada al usuario

        if (DaoInstitutions::getInstance()->save($institucion)) {
            return $institucion;
        }
        return false;

    }

    /**
     * Asocia un proyecto a una institución
     * @param Projects $project
     * @param Institutions $instit
     * @return bool
     */
    protected function linkProjectToInstitution($project,$instit) {
        $projectinsti = new ProjectsInstitutions();
        $projectinsti->setProjectId($project->getId());
        $projectinsti->setInstitutionId($instit->getId());
        return DaoProjectsInstitutions::getInstance()->save($projectinsti);
    }

    /**
     * Crea un proyecto y su subproyecto inicial, asociado al director de la institucion
     * @param Institutions $instit
     * @return Subprojects
     */
    protected function crearProyecto(Institutions $instit, $req=null) {
        $ya = date('Y-m-d H:i:s');

        //le cargo un proyecto y subproyecto generico para que pueda solicitar recursos
        $project = new Projects();
        $project->setUserId($instit->getDirectorUserId());
        if ($req['ONGproyecto']){
            $project->setName($req['ONGproyecto']);
        }else{
            $project->setName('Solicitud de ayuda de: '. $instit->getName() );
        }
        $project->setBeneficiary('Solicitud de ayuda por web');
        if ($req['ONGdetalleproyecto']){
            $project->setDescription($req['ONGdetalleproyecto']);
        }else{
            $project->setDescription('Solicitud de ayuda por web');
        }

        $project->setStartDate($req['startDate']); $project->setEndDate($req['endDate']);
        $project->setCreated($ya);   $project->setUpdated($ya);

        $up = new UsersProjects();
        $up->setUserId($instit->getDirectorUserId());
        $up->setProjectId($project->getId());
        DaoUsersProjects::getInstance()->save($up);

        if(DaoProjects::getInstance()->save($project)) {
            $subproject = new Subprojects();
            $subproject->setProjectId($project->getId());
            $subproject->setUserId($instit->getDirectorUserId());
            $subproject->setName('Solicitud de ayuda de: '. $instit->getName() );
            $subproject->setDescription('Solicitud de ayuda por web');
            $subproject->setStatus('Iniciado');
            $subproject->setStartDate($req['startDate']);   $subproject->setEndDate($req['endDate']);
            $subproject->setCreated($ya);     $subproject->setUpdated($ya);
            DaoSubprojects::getInstance()->save($subproject);

            $this->linkProjectToInstitution($project,$instit);
        }
        return $subproject;
    }

    /**
     * Crea una conversación con un mensaje inicial
     * @param Users $fromUser
     * @param string $loQueQuiero  [Dar, Recibir, Voluntario]
     * @param string $mensaje mensaje recibido desde formulario
     * @return bool|Messages
     */
    protected function crearMensaje(Users $fromUser,$loQueQuiero,$mensaje) {
        $conv = new Conversations();
        $conv->setTitle("Quiero {$loQueQuiero}");

        $conv->setUserId($fromUser->getId());
        $conv->setMessageCount(1);
        $ya = date('Y-m-d H:i:s');
        $conv->setCreated($ya);

        DaoConversations::getInstance()->save($conv);

        $msg = new Messages();
        $msg->setConversationId($conv->getId());
        $msg->setMessage($mensaje);
        $msg->setUserId($fromUser->getId());
        $msg->setCreated($ya);
        $msg->setUpdated($ya);
        if(DaoMessages::getInstance()->save($msg))
            return $msg;

        return false;

    }

    protected function accionGetContenidoMensaje($req) {
        $token = $req['token'];
        $response = array();
        //if($token == md5('ObtenerMensajeDesdeAplicacion')) {
        //TODO: que acepte solo de localhost
             $m = DaoMessages::getInstance()->findById($req['id']);
             die(str_replace("\n",' ',$m->getMessage()));
        //}
        die("");
    }

    /**
     * Agrega un ResourceSubprojects a partir de datos que vienen en $related
     * @param ResourceRelated $related
     * @return bool|ResourcesSubprojects
     */
    protected function addResourceSubprojects(ResourceRelated $related) {
        $resS = new ResourcesSubprojects();
        $resS->setCantidad($related->getCantidad());
        $resS->setResourceId($related->getRecurso()->getId());
        $resS->setSubprojectId($related->getIdEntidadRelacionada());
        $resS->setStatus('carencia');
        if(DaoResourcesSubprojects::getInstance()->save($resS))
            return $resS;
        return false;
    }

    /**
     * Agrega un ResourcesInstitutions a partir de datos que vienen en $related
     * @param ResourceRelated $related
     * @return bool|ResourcesInstitutions
     */
    protected function addResourceInstitution(ResourceRelated $related) {
        $resI = new ResourcesInstitutions();
        $resI->setCantidad($related->getCantidad());
        if ($related->getCantidad() <= 0) {
            $resI->setCantidad(1);
        }
        $resI->setResourceId($related->getRecurso()->getId());
        $resI->setInstitutionId($related->getIdEntidadRelacionada());
        $resI->setDescription($related->getDescripcion() . ' (REGISTRO TEMPORARIO)' );

        if(DaoResourcesInstitutions::getInstance()->save($resI))
           return $resI;
        return false;
    }

    protected function analizeMessage(Messages $msg) {

        $jarFile = "/usr/local/bin/DETECTAR_RECURSOS.jar";
        $properties = "/usr/local/bin/DETECTAR_RECURSOS.properties";
        $url = "http://localhost/ayudarg/acc-getContenidoMensaje/{$msg->getId()}/";

        $command = "java -jar {$jarFile} $properties $url";

        exec("{$command}",$result);
        $result['recursos'] = json_decode($result[0]);

        //$result['recursos'] = json_decode('[{"recurso":"14402","descripcion":"MOISES","cantidad":-1},{"recurso":"3318","descripcion":"LADRILLO","cantidad":1}]');

        return $result;
    }

    /**
     * @param Resources $resource
     */
    protected function fixCodigoYParent($resource) {
        /* debo verificar si tiene codigo hno y si tiene padre */
        if ($resource->getCodigo()==null){
            $resource->setCodigo($resource->getId());
            DaoResources::getInstance()->save($resource);
        }
        if ($resource->getEstado()==null){
            $resource->setEstado("PENDI");
            DaoResources::getInstance()->save($resource);
        }
        $padres =  DaoResourcesParents::getInstance()->findByResourceId($resource->getId());
        if (is_null($padres)){
            $resourcetodacat = DaoResources::getInstance()->findByName("TODAS LAS CATEGORIAS");
            $padre = new ResourcesParents();
            $padre->setResourceId($resource->getId());
            $padre->setParentId($resourcetodacat->getId());
            DaoResourcesParents::getInstance()->save($padre);
        }
    }

    /**
     * Ejecuta el comando de procesamiento de mensajes externo, donde detecta por semantica los elementos de donacion
     * @param Messages $msg
     * @param $accion
     * @param $idObjRelacionado
     */
    protected function procesarMensaje(Messages $msg,$accion,$idObjRelacionado) {
        $jsonResult = $this->analizeMessage($msg);
        $jsonResult['tokenRelac'] = base64_encode($idObjRelacionado);
        $jsonResult['status'] = 'OK';
        if(!empty($jsonResult['recursos'])) {
            foreach ($jsonResult['recursos'] as $res) {
                $resource = DaoResources::getInstance()->findById($res->recurso);
                $this->fixCodigoYParent($resource);
                $related = new ResourceRelated();
                $related->setRecurso($resource);
                $related->setCantidad($res->cantidad);
                $related->setIdEntidadRelacionada($idObjRelacionado);
                if ($accion == 'recibir') {
                    $resourceSubproject = $this->addResourceSubprojects($related);
                } else {
                    $related->setDescripcion($res->descripcion);
                    $resourceInstit = $this->addResourceInstitution($related);
                }
            }
        }
        return $jsonResult;
    }

    /**
     * Busca la ONG dada, si no hay dada crea una con el director asociado
     * @param $req
     * @param $director
     * @return bool|Institutions|mixed|null
     */
    protected function getONG($req, $director)
    {
        if(isset($req['institution_id']))
            $instONG = DaoInstitutions::getInstance()->findById($req['institution_id']);
        else {
            //$instONG = $this->crearInstitucion($director, 'ONG', $req['ONG']);
            $instONG = $this->crearInstitucion($director, 'ONG', $req);
        }
        return $instONG;
    }

    /**
     * Obtiene un usuario dado, si no hay dado crea uno con los datos proporcionados en req
     * @param $req
     * @return bool|mixed|null|Users
     */
    protected function getCreateUsuario($req)
    {
        if(isset($req['user_id']))
            $user = DaoUsers::getInstance()->findById($req['user_id']);
        else
        {
            $factory = new RandomLib\Factory();

            $gen =  $factory->getMediumStrengthGenerator();
            $passwordProvisorio = $gen->generateString(8);
            if($user = $this->crearUsuario($req['nombre'],$req['email'],$req['telefono'],$passwordProvisorio)) {
                $ayudargBaseSite = 'http://proyectokoinonia.org.ar/';
                $this->setTplVar('ayudargBaseSite', $ayudargBaseSite);
                $this->setTplVar('ayudargSite', "{$ayudargBaseSite}operativa/");
                $this->setTplVar('username', $user->getUsername());
                $this->setTplVar('pass', $passwordProvisorio);

                $urlInstructivo = "files/ManualDelUsuarioAYUDARG.pdf";
                $this->setTplVar('linkInstructivo',$urlInstructivo);

                $cuerpo = $this->smarty->fetch("mails/nuevoUsuario.tpl");
                $para = $user->getEmail();
                $status = KoinoniaEmailsMod::enviarMail($para, "Usuario Creado en Ayud@rg", $cuerpo,'Proyecto Koinonia <'.ConfiguracionHelper::getMailEnvios().'>');
                if(!$status) {
                    error_log(KoinoniaEmailsMod::$lastError . " $para " . ConfiguracionHelper::getMailEnvios() ,0);
                }
            }
        }
        return $user;
    }

    protected function responseErrors() {
        $errors = $this->getForm()->_errors;
        $errores = "";
        foreach($errors as $campo => $error)
        {
            $errores .= "{$error} ({$campo})\n";
        }
        $response['status']='error';
        $response['errors']=$errores;
        $this->responseJson($response);
    }


    protected function accionDar($req) {
        $req['quiero'] = 'dar';
        $req['frase'] = 'Su donación es nuestra prioridad y queremos su utilización en forma eficiente.';
        $req['nro'] = '01';

        if(!$this->getForm()->isSubmitted()) {
            $this->accionAlta($req);
        }
        elseif(!$this->getForm()->validate()){
            $this->responseErrors();
        }

        if(isset($_POST['accion'])) {
            $user = $this->getCreateUsuario($req);
            if ($msg = $this->enviarQuiero($user, $req['accion'], $req['mensaje'])) ;
            {
                $institutionPersonal = DaoInstitutions::getInstance()->findPersonalesByUser($user);
                $response = $this->procesarMensaje($msg, $req['accion'], $institutionPersonal->getId());
                $this->responseJson($response);
            }
        }


    }

    protected function accionRecibir($req) {
        $req['quiero'] = 'recibir';
        $req['frase'] = 'Queremos ayudar a quienes ayudan. Se parte del proyecto.';
        $req['nro'] = '02';

        $this->_form = new RecibirForm();

        if(!$this->getForm()->isSubmitted()) {
            $this->accionAlta($req);
        }
        elseif(!$this->getForm()->validate()){
            $this->responseErrors();
        }

        if(isset($_POST['accion'])) {
            $user = $this->getCreateUsuario($req);

            $instONG = $this->getONG($req,$user);
            $subproj = $this->crearProyecto($instONG, $req);

            $this->addUserToInstitution($user,$instONG);

            $this->setTplVar('ONG',$req['ONG']);
            if($msg = $this->enviarQuiero($user,$req['accion'],$req['mensaje'])) {
                $response = $this->procesarMensaje($msg, $req['accion'], $subproj->getId());
                $this->responseJson($response);
            }
        }
    }

    protected function accionVoluntario($req) {
        $req['quiero'] = 'voluntario';
        $req['frase'] = 'Tu aporte siempre es necesario, y si de tu tiempo o servicio se trata ¡BIENVENIDO sea!';
        $req['nro'] = '03';

        if(!$this->getForm()->isSubmitted()) {
            $this->accionAlta($req);
        }
        elseif(!$this->getForm()->validate()){
            $this->responseErrors();
        }

        if(isset($_POST['accion'])) {
            $user = $this->getCreateUsuario($req);
            if($msg = $this->enviarQuiero($user,$req['accion'],$req['mensaje'])) {
                $institutionPersonal = DaoInstitutions::getInstance()->findPersonalesByUser($user);
                $response = $this->procesarMensaje($msg, $req['accion'], $institutionPersonal->getId());
                $this->responseJson($response);
            }
        }
    }

    protected function accionCheckDonante($req) {
        $usuarios = DaoUsers::getInstance()->findByNameOrEmail($req['nombre'],$req['email']);
        $usrs = array();
        foreach($usuarios as $u )
        {
            $a = array();
            $email = $u->getEmail();
            $a['name']  = $u->getName();
            $a['email'] = $email;
            $a['phone'] = $u->getPhone();
            $a['emailshow'] = substr($email,0,strpos($email,'@')).'@'.substr($email,strpos($email,'@')+1,2).'...'.substr($email,-3);
            $a['id']    = $u->getId();
            $usrs[] = $a;
        }
        $this->responseJson(array("usuarios"=>$usrs));
    }

    protected function accionCheckONG($req) {
        $ONGs = DaoInstitutions::getInstance()->findNoPersonalesByName($req['term']);
        $jsonOngs = array();
        foreach ($ONGs as $ONG) {
            $jsonOngs[] = array('id'=>$ONG->getId(),'value'=>$ONG->getName(),'label'=>$ONG->getName(),'email'=>$ONG->getEmail(),'telef'=>$ONG->getPhone(),'direccion'=>$ONG->getAddress(),'descripcion'=>$ONG->getShortbio());
        }
        $this->responseJson($jsonOngs);
    }

    protected function accionCheckUser($req) {
        $username = $req['username'];
        $password =  $req['password'];
        $response['status'] = 'error';
        $user = DaoUsers::getInstance()->findByUsernamePassword($username,$password);
        if($user!=null)
            $response['status'] = 'success';
        $this->responseJson($response);
    }


}
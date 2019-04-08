<?php
/**
 * Created by PhpStorm.
 * User: lucas.vidaguren
 * Date: 18/08/17
 * Time: 13:26
 */
require_once 'SistemaFCE/modulo/BaseAdminMod.class.php';
require_once 'utils/JWT.php';

class WebServiceMod extends BaseAdminMod
{

    static $jwtApiSecret = "v9EfNFUmjx7C3QTV9W5Dw46Kpak5GAXH";
    private $method;

    function __construct($skinName = null, $listaTplPath = null, $formTplPath = null, $tilePathName = 'Admin', $sessionHandler = null)
    {
        parent::__construct(new BaseForm(), DaoUsers::getInstance(), $skinName, $listaTplPath, $formTplPath, $tilePathName, $sessionHandler);
        $this->method = $_SERVER['REQUEST_METHOD'];
    }

    protected function accionLogin($req)
    {
        $email = $req['email'];
        $password = $req['pass'];

        $user = DaoUsers::getInstance()->findByUsernamePassword($email,$password);
        $response = array('status'=>'error');

        if($this->method == 'POST') {
            if(isset($user)) {
                $response['status'] = 'success';

                $persona = array();
                $persona['id'] = $user->getId();
                $persona['user'] = $user->getUsername();
                $persona['name'] = $user->getName();
                $persona['address'] = $user->getAddress();
                $persona['admin'] = $user->getRoleId()==1;
                $persona['loginTime'] = time();

                $response['token'] = JWT::encode($persona,self::$jwtApiSecret);
            }
        }
        else
            $response['message'] = "Método HTTP incorrecto";


        $this->responseJson($response);
    }

    protected function accionLocations($req) {
        $locations =  DaoLocations::getInstance()->findAll();
        $response = array('status'=>'error');
        $responseLocations = array();
        if(count($locations)>0) {
            $response['status'] = 'success';

            foreach ($locations as $loc) {
                $locat['id'] = $loc->getId();
                $locat['name'] = $loc->getName();
                $responseLocations[] = $locat;

                $response['locations'] = $responseLocations;
            }
        }

        $this->responseJson();
    }

    protected function accionRegister($req) {
        $response = array('status'=>'error','message'=>'');

        if($this->method == 'POST') {

            $per = new Users();

            $per->setUsername($req['user']);
            $per->setPassword($req['pass']);
            $per->setName($req['nombre']);
            $per->setEmail($req['email']);
            $per->setAddress($req['direccion']);
            $per->setPhone($req['telef']);
            $per->setWebsite($req['web']);
            $per->setEmail($req['email']);

            $per->setLatitude($req['lat']);
            $per->setLongitude($req['long']);

            $location = DaoLocations::getInstance()->findFirstByProperty('name', $req['location']);
            if (isset($location))
                $per->setLocationId($location->getId());

            if (DaoUsers::getInstance()->save($per)) {
                $response['message'] = 'El usuario se creó sin problemas';
                $response['status'] = 'success';
            } else
                $response['message'] = 'Problema al crear el usuario ' . DaoUsers::getInstance()->getLastError();

            $response['data'] = $per;
        }
        else
            $response['message'] = "Método HTTP incorrecto";

        $this->responseJson($response);
    }

    protected function accionGetEnviosProducto($req) {
        $token = $req['token'];
        $response = array('status'=>'error');
        $nroSeguimiento = $req['nroSeguimiento'];
        try {
            $userData = JWT::decode($token,self::$jwtApiSecret);
            $this->_usuario = DaoUsers::getInstance()->findById($userData->id);
            if($this->getUsuario()->tienePermiso('getEnviosProducto')) {
                if(isset($nroSeguimiento)) {

                    $envios = DaoEnvio::getInstance()->findByNroSeguimiento($nroSeguimiento);
                    if (!empty($envios)) {
                        $response['status'] = 'success';
                        foreach ($envios as $envio) {
                            $env['id_envio'] = $envio->getId();
                            $donante = $envio->getDonanteUser();
                            $receptor = $envio->getReceptorUser();
                            $env['nombre_donante'] = $donante->getName();
                            $env['nombre_receptor'] = $receptor->getName();
                            $env['address_donante'] = $donante->getAddress();
                            $env['address_receptor'] = $receptor->getAddress();
                            $env['fecha_envio'] = $envio->getFechaEnvio();
                            $env['fecha_recepcion'] = $envio->getFechaRecepcion();
                            $env['latitude_donante'] = $donante->getLatitude();
                            $env['longitude_donante'] = $donante->getLongitude();
                            $env['latitude_receptor'] = $receptor->getLatitude();
                            $env['longitude_receptor'] = $receptor->getLongitude();
                            $env['descripcion'] = $envio->getDescripcion();
                            $rEnvios[] = $env;
                        }
                        $response['envios'] = $rEnvios;
                    } else {
                        $response['message'] = "No se encuentran envios para seguimiento";
                    }
                } else {
                    $response['message'] = "Debe definir el numero de seguimiento";
                }
            }
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
        }
        $this->responseJson($response);
    }

    protected function accionEnviarProducto($req) {
        $token = $req['token'];
        $response = array('status'=>'error');
        $nroSeguimiento = $req['nroSeguimiento'];
        try {
            $userData = JWT::decode($token, self::$jwtApiSecret);
            $this->_usuario = DaoUsers::getInstance()->findById($userData->id);
            if($this->method == 'POST') {
                if ($this->getUsuario()->tienePermiso('enviarProducto')) {
                    $envio = new Envio();
                    $envio->setDonante($userData->id);
                    $envio->setFechaEnvio(date('Y-m-d'));
                    if (isset($req['idReceptor']))
                        $envio->setReceptor($req['idReceptor']);

                    $envio->setIdInstitucionReceptorFk($req['idReceptorInstit']);

                    $factory = new RandomLib\Factory();

                    $nroSeguimiento = $req['nroSeguimiento'];
                    if (empty($req['nroSeguimiento'])) {
                        $gen = $factory->getMediumStrengthGenerator();
                        $nroSeguimiento = $gen->generateString(8, RandomLib\Generator::CHAR_ALNUM);
                    }

                    $envio->setNumeroSeguimiento($nroSeguimiento);
                    $envio->setEntregado(0);

                    if (DaoEnvio::getInstance()->save($envio)) {
                        $response['nroSeguimiento'] = $nroSeguimiento;
                        $response['status'] = 'success';
                    } else {
                        $response['message'] = DaoEnvio::getInstance()->getLastError();
                    }

                }
            }
            else
                $response['message'] = "Método HTTP incorrecto";
        }
        catch (Exception $e) {
            $response['message'] = $e->getMessage();
        }

        $this->responseJson($response);
    }

    protected function accionRecibirProducto($req) {
        $token = $req['token'];
        $response = array('status'=>'error');
        $nroSeguimiento = $req['nroSeguimiento'];
        try {
            $userData = JWT::decode($token,self::$jwtApiSecret);
            $this->_usuario = DaoUsers::getInstance()->findById($userData->id);
            if($this->method == 'POST') {
                if ($this->getUsuario()->tienePermiso('recibirProducto')) {
                    if (isset($nroSeguimiento)) {
                        $envios = DaoEnvio::getInstance()->findByNroSeguimiento($nroSeguimiento);
                        if (!empty($envios)) {
                            $success = true;
                            foreach ($envios as $envio) {

                                $envio->setEntregado(true);
                                $envio->setLatitudeReceptor($req['lat']);
                                $envio->setLongitudeReceptor($req['long']);
                                $envio->setFechaRecepcion(date('Y-m-d'));
                                $envio->setReceptor($userData->id);
                                $success &= DaoEnvio::getInstance()->save($envio);
                            }
                            if ($success)
                                $response['status'] = 'success';
                            else
                                $response['message'] = "No se pudieron actualizar los adtos para envios de {$nroSeguimiento}";
                        }
                    } else {
                        $response['message'] = "Debe definir el numero de seguimiento";
                    }
                }
            }
            else
                $response['message'] = "Método HTTP incorrecto";
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
        }

        $this->responseJson($response);
    }

    protected function accionGetUltimoEnvioProducto($req) {
        $token = $req['token'];
        $response = array('status'=>'error');
        $nroSeguimiento = $req['nroSeguimiento'];
        try {
            $userData = JWT::decode($token,self::$jwtApiSecret);

            $this->_usuario = DaoUsers::getInstance()->findById($userData->id);
            if($this->getUsuario()->tienePermiso('getUltimoEnvioProducto')) {
                if (isset($nroSeguimiento)) {
                    $response['status'] = 'success';
                    $envio = DaoEnvio::getInstance()->findUltimoEnvioNumeroSeguimiento($nroSeguimiento);
                    $response['envio']['id_envio'] = $envio->getId();
                    $response['envio']['receptor'] = $envio->getReceptor();
                    $response['envio']['donante'] = $envio->getDonante();
                    $response['envio']['nombre_donante'] = $envio->getDonanteUser()->getName();
                    $response['envio']['address_donante'] = $envio->getDonanteUser()->getAddress();
                    $response['envio']['fecha_envio'] = $envio->getFechaEnvio();
                    $response['envio']['fecha_recepcion'] = $envio->getFechaRecepcion();
                    $response['envio']['descripcion'] = $envio->getDescripcion();
                }
                else
                {
                    $response['message'] = "Debe definir el numero de seguimiento";
                }
            }
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
        }

        $this->responseJson($response);
    }


    protected function accionGetUserData($req)
    {
        $token = $req['token'];
        $response = array('status' => 'error');
        try {
            $userData = JWT::decode($token, self::$jwtApiSecret);

            if (!isset($req['userId'])) {
                $uData['id'] = $userData->id;
                $uData['name'] = $userData->name;
            } else {
                $this->_usuario = DaoUsers::getInstance()->findById($userData->id);
                if ($this->getUsuario()->tienePermiso('getUserData')) {
                    $user = DaoUsers::getInstance()->findById($req['userId']);

                    $uData['name'] = $user->getName();
                    $uData['address'] = $user->getAddress();
                }
            }
            if(!empty($uData))
                $response['status'] = 'success';
            $response['userData'] = $uData;
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
        }
        $this->responseJson($response);
    }

}
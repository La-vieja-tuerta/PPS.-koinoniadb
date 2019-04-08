<?php
/**
 * Created by PhpStorm.
 * User: lucas.vidaguren
 * Date: 15/11/17
 * Time: 10:17
 */
require_once "SistemaFCE/modulo/EmailsMod.class.php";
class KoinoniaEmailsMod extends EmailsMod
{
    public static $lastError;
    public static function enviarMail($para,$asunto,$textoHTML,$de=null,$textoSimple=null,$cc=null,$bcc=null)
    {
        $mailer = new PHPMailer\PHPMailer\PHPMailer();

        $mailer->Subject = $asunto;
        $mailer->Body = $textoHTML;

        $para = self::emailSplit($para);
        $mailer->addAddress($para['address'],$para['name']);

        $de = self::emailSplit($de);

        if(isset($de))
            $mailer->setFrom($de['address'],$de['name']);
        else
            $mailer->setFrom($para['address'],$para['name']);

        if(isset($cc))
            $mailer->addCC($cc);
        if(isset($bcc))
            $mailer->addBCC($bcc);

        $mailer->Mailer = 'smtp';

        $mailer->isHTML(true);
        $mailer->Host = 'mail.proyectokoinonia.org.ar';
        $mailer->Port = 25;
        $mailer->SMTPAuth = true;
        $mailer->AuthType = 'PLAIN';
        $mailer->SMTPAutoTLS = false;
        $mailer->Username = 'no-reply@proyectokoinonia.org.ar';
        $mailer->Password = '@qKz15g1sI';

        /*
         $mailer->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);
         */

        $mailer->ContentType = 'text/html; charset=UTF-8';
        $mailer->CharSet = 'UTF-8';


        $mailer->Timeout = 50;

        $sent = $mailer->Send();
        if(!$sent)
            self::$lastError  =$mailer->ErrorInfo;

        return $sent;
    }

    /**
     * Splits "name <address>" into array with [name:,address:]
     * @param $str
     * @return array
     */
    static function emailSplit( $str ){
        $sPattern = "/([\w\s\'\"]+[\s]+)?(<)?(([\w-\.]+)@((?:[\w]+\.)+)([a-zA-Z]{2,4}))?(>)?/";
        preg_match($sPattern,$str,$aMatch);

        return array('name'=>$aMatch[1],'address'=>$aMatch[3]);
    }

}
<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/PHPMailer-master/src/SMTP.php';

require_once __DIR__. '/../environment.php';

class EmailHelper {

    private $mail;

    public function __construct() {
        $this->mail = new PHPMailer(true);
    }


    public  function sendMail($to, $toName, $subj, $msg){

        try {
            $this->mail->isSMTP();                                            
            $this->mail->Host       = $_ENV['SMTP_HOST'];                     
            $this->mail->SMTPAuth   = true;                                 
            $this->mail->Username   = $_ENV['SMTP_USERNAME'];                     
            $this->mail->Password   = $_ENV['SMTP_PASSWORD'];                               
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            
            $this->mail->Port       = $_ENV['SMTP_PORT'];  
            
            
    
            //Recipients
            $this->mail->setFrom($_ENV['SMTP_FROM'], $_ENV['SMTP_FROM_NAME']);
            $this->mail->addAddress($to, $toName);
            
            
    
            //Content
            $this->mail->isHTML(true);                                  
            $this->mail->Subject = $subj;
            $this->mail->Body    = $msg;
    
    
            $this->mail->send();
            return true;
        } catch (Exception $e) {
            echo $this->mail->ErrorInfo;
            return false;
        }

    }
}

function sendMail($to, $toName, $subj, $msg){
    $mail = new PHPMailer(true);

    
}
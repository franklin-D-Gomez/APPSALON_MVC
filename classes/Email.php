<?php

namespace Classes;

// PHPMailer
use PHPMailer\PHPMailer\PHPMailer;

class Email{

    public $email;
    public $nombre;
    public $token;
    
    public function __construct($email, $nombre , $token){
        
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;

    }

    public function enviarConfirmacion(){

        // crear el objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = 'e5d262fac852ff';
        $mail->Password = 'e2544e3aec1c17';

        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com' , 'AppSalon.com');
        $mail->Subject = 'confirma tu cuenta';

        // Set HTML
        $mail->isHTML(TRUE); // para que acepte el html
        $mail->CharSet = 'UTF-8'; // para que acepte el idioma español son sus tildes y demas.

        // Cuerpo del email
        $contenido = "<html>";
        $contenido .= "<p><strong> Hola " . $this->nombre . "</strong> has creado tu cuenta en App Salon
        , solo debes confirmarla presionando el siguiente enlace </p>";
        $contenido .= "<p> Presiona aqui: <a href='http://localhost:3000/confirmar-cuenta?token=" . $this->token ."'> Confirmar Cuenta </a> </p> ";
        $contenido .= "<p> Si tu no solicitas esta cuenta, puedes ignorar el mensaje</p>";
        $contenido .= "</html>";


        // agregando el el cuerpo al email
        $mail->Body = $contenido;

    
        // Enviando el Email
        $mail->send();
    }


    public function enviarInstrucciones(){
        // crear el objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = 'e5d262fac852ff';
        $mail->Password = 'e2544e3aec1c17';

        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com' , 'AppSalon.com');
        $mail->Subject = 'Restablece tu Password';

        // Set HTML
        $mail->isHTML(TRUE); // para que acepte el html
        $mail->CharSet = 'UTF-8'; // para que acepte el idioma español son sus tildes y demas.

        // Cuerpo del email
        $contenido = "<html>";
        $contenido .= "<p><strong> Hola " . $this->nombre . "</strong> Has solicitado cambiar tu password </p>";
        $contenido .= "<p> Presiona aqui para hacerlo : <a href='http://localhost:3000/recuperar?token=" . $this->token ."'> Reestablecer Password </a> </p> ";
        $contenido .= "<p> Si tu no solicitas esta cuenta, puedes ignorar el mensaje</p>";
        $contenido .= "</html>";


        // agregando el el cuerpo al email
        $mail->Body = $contenido;

    
        // Enviando el Email
        $mail->send();
    }
}


?>
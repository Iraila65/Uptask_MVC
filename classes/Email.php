<?php

namespace Classes; 

use PHPMailer\PHPMailer\PHPMailer;

class Email {

    public $email;
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
        
    }

    public function enviarConfirmacion() {
        
        // Crear una instancia de PHPMailer
        $mail = new PHPMailer();
        // Configurar SMTP (datos cogidos de MailTrap)
        $mail->isSMTP();
        $mail->Host = "smtp.mailtrap.io";
        $mail->SMTPAuth = true;
        $mail->Username = "af35e180f0076d";
        $mail->Password = "b11a29db5688c2";
        $mail->SMTPSecure = "tls";
        $mail->Port = 2525;

        // Configurar el contenido del email
        $mail->setFrom("cuentas@uptask.com");  // quién envía el email
        $mail->addAddress($this->email);       // quién lo recibe
        $mail->Subject = "Confirma tu cuenta";

        // Habilitar HTML
        $mail->isHTML(true);
        $mail->CharSet = "UTF-8";  // para que admita acentos y eñes

        // Definir el contenido
        $contenido = "<html> ";
        $contenido .= "<p><strong>Hola ".$this->nombre."</strong>. Has creado tu cuenta en UpTask. </p>";
        $contenido .= "<p>Debes confirmarla pulsando en el siguiente enlace: </p>";
        $contenido .= "<p> <a href='http://localhost:3000/confirmar-cuenta?token=".$this->token."'>Confirmar cuenta</a></p>";
        $contenido .= "<p>Si no has solicitado la cuenta puedes ignorar este mensaje. </p>";
        $contenido .= " </html>";
        
        $mail->Body = $contenido;
        $mail->AltBody = "Esto es texto alternativo sin HTML";

        // Enviar el email
        if($mail->send()) {
            $resultado = 7;
        } else {
            $resultado = 8;
        }           
    }

    public function enviarInstrucciones() {
        
        // Crear una instancia de PHPMailer
        $mail = new PHPMailer();
        // Configurar SMTP (datos cogidos de MailTrap)
        $mail->isSMTP();
        $mail->Host = "smtp.mailtrap.io";
        $mail->SMTPAuth = true;
        $mail->Username = "af35e180f0076d";
        $mail->Password = "b11a29db5688c2";
        $mail->SMTPSecure = "tls";
        $mail->Port = 2525;

        // Configurar el contenido del email
        $mail->setFrom("cuentas@appsalon.com");  // quién envía el email
        $mail->addAddress($this->email);         // quién lo recibe
        $mail->Subject = "Reestablece tu password";

        // Habilitar HTML
        $mail->isHTML(true);
        $mail->CharSet = "UTF-8";  // para que admita acentos y eñes

        // Definir el contenido
        $contenido = "<html> ";
        $contenido .= "<p><strong>Hola ".$this->nombre."</strong>. Has solicitado reestablecer tu password. </p>";
        $contenido .= "<p>Debes hacerlo pulsando en el siguiente enlace: </p>";
        $contenido .= "<p> <a href='http://localhost:3000/recuperar?token=".$this->token."'>Reestablecer password</a></p>";
        $contenido .= "<p>Si no lo has solicitado puedes ignorar este mensaje. </p>";
        $contenido .= " </html>";
        
        $mail->Body = $contenido;
        $mail->AltBody = "Esto es texto alternativo sin HTML";

        // Enviar el email
        if($mail->send()) {
            $resultado = 7;
        } else {
            $resultado = 8;
        }           
    }
}
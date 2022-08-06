<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email {
    
    protected $email;
    protected $nombre;
    protected $token;

    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion()
    {
    // Lo siguiente se saca de mailtrap
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = 'c6eefb86bece12';
        $mail->Password = '4879f675d94e10';

        $mail->setFrom('cuentas@uptask.com');
        $mail->addAddress('cuestas@uptask.com', 'uptask.com');
        $mail->Subject = 'Confirma tu cuenta';

        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $contenido = '<html>';
            $contenido .= "<p><strong>Hola, ".$this->nombre."</strong>, has creado tu cuenta en UpTask. </br>
            Confirmala en el siguiente enlace: </p>";    
            $contenido.= "<p>Presiona aqui: <a href='http://localhost:3000/confirmar?token=".$this->token."'>Confirmar cuenta.</a></p>";
            $contenido .= "<p>Si no creaste esta cuenta, puedes ignorar este mensaje.</p>";
        $contenido .= '</html>';

        $mail->Body = $contenido;

        // Enviar el email
        $mail->send();
    }

    public function enviarInstrucciones()
    {
    // Lo siguiente se saca de mailtrap
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = 'c6eefb86bece12';
        $mail->Password = '4879f675d94e10';

        $mail->setFrom('cuentas@uptask.com');
        $mail->addAddress('cuestas@uptask.com', 'uptask.com');
        $mail->Subject = 'Reestablece tu password.';

        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $contenido = '<html>';
            $contenido .= "<p><strong>Hola, ".$this->nombre."</strong>, 
            parece que has olvidado tu password. </br> Presiona en el siguiente enlace
            para recuperarlo.  </p>";    
            $contenido.= "<p>Presiona aqui: <a href='http://localhost:3000/reestablecer?token=".$this->token."'>Reestablecer Password.</a></p>";
            $contenido .= "<p>Si no creaste esta cuenta, puedes ignorar este mensaje.</p>";
        $contenido .= '</html>';

        $mail->Body = $contenido;

        // Enviar el email
        $mail->send();
    }
}

?>
<?php

namespace app\model;

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mail
{
    public static function sendMail()
    {
        // Load Composer's autoloader
        require 'vendor/autoload.php';

        // Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                    // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.hostinger.com.br';                // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'dev@robsonnatanael.com.br';            // SMTP username
            $mail->Password   = '#281885z##d';                          // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            $mail->CharSet = 'UTF-8';

            //Recipients
            $mail->setFrom('dev@robsonnatanael.com.br', 'Robson');
            $mail->addAddress('natanaelrobson@gmail.com', 'Natanael');  // Add a recipient
            /* $mail->addAddress('ellen@example.com');                  // Name is optional
                $mail->addReplyTo('info@example.com', 'Information');
                $mail->addCC('cc@example.com');
                $mail->addBCC('bcc@example.com'); */

            /* // Attachments
                $mail->addAttachment('/var/tmp/file.tar.gz');           // Add attachments
                $mail->addAttachment('/tmp/image.jpg', 'new.jpg');      // Optional name */

            // Content
            $mail->isHTML(true);                                        // Set email format to HTML
            $mail->Subject = 'Notificação de nova mensagem';
            //$mail->Body    = 'Você tem uma nova mensagem no Painel Administrativo.<br><a href="'.URI.'/index.php?page=admin">VER MENSAGEM<a>';
            $mail->Body    = 'Você tem uma nova mensagem no Painel Administrativo.<br><a href="http://projects/portfolio/contact_module/index.php?page=MensagensList">VER MENSAGEM<a>';
            /* $mail->AltBody = 'This is the body in plain text for non-HTML mail clients'; */

            $mail->send();
            //echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
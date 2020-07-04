<?php
    /**
     * 2020 - RN Comunicação & Marketing
     * 
     * * AVISO DE LICENÇA
     * 
     * Este arquivo de origem está sujeito à Licença ...
     * incluído neste pacote no arquivo LICENSE.txt.
     * Também está disponível na Internet neste URL:
     * https://opensource.org/licenses/MIT
     * 
     * @author Robson Natanael <contato@robsonnatanael.com.br>
     * @copyright 2020 - RN Comunicação & Marketing
     * @license MIT
     * 
     * @package Portfólio Painel de Mensagem
     */

    function validar_metodo_post() {
        if (count($_POST) > 0) {
            return true;
        }

        return false;
    }

    function reCAPTCHA() {
        $secretKey = SECRET_KEY;
        $responseKey = $_POST['g-recaptcha-response'];
        $userIP = $_SERVER['REMOTE_ADDR'];

        $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responseKey&remoteip=$userIP";
        $response = file_get_contents($url);
        $response = json_decode($response);

        return $response->success;
    }

    function sendEmail($content = '') {
        require_once __DIR__ . "/../../Lib/PHPMailer/PHPMailerAutoload.php";
        
        $email = new PHPMailer();

        $email->isSMTP();
        $email->Host = HOST;
        $email->Port = PORT;
        $email->SMTPSecure = SECURITY;
        $email->SMTPAuth = SMTP_AUTH;
        $email->Username = USERNAME;
        $email->Password = PASSWORD;
        $email->setFrom(USERNAME, NAME);
        $email->CharSet = 'UTF-8';

        // Digitar o e-mail do destinatário;
        $email->addAddress(EMAIL_NOTIFICACAO);

        if (!empty($content)) {
            $subject = $content->getAssunto();
            $text = $content->getMensagem();
        }
        else {
            $subject = 'Notificação de nova mensagem';
            $text = 'Você tem uma nova mensagem no Painel Administrativo.<br><a href="'.URI.'/index.php?page=admin">VER MENSAGEM<a>';
        }

        // Digitar o assunto do e-mail;
        $email->Subject = $subject;
        
        // Escrever o corpo do e-mail;
        $email->msgHTML($text);
        
        // Usar a opção de enviar o e-mail.
        $email->send();
    }

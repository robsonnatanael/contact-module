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

    function sendEmail($content = '') {
        require_once __DIR__ . "/../../libs/PHPMailer/PHPMailerAutoload.php";
        
        $email = new PHPMailer();

        $email->isSMTP();
        $email->Host = "smtp.hostinger.com.br";
        $email->Port = 587;
        $email->SMTPSecure = 'tls';
        $email->SMTPAuth = true;
        $email->Username = "dev@robsonnatanael.com.br";
        $email->Password = "#281885z##d";
        $email->setFrom("dev@robsonnatanael.com.br", "RN Comunicação & Marketing");

        // Digitar o e-mail do destinatário;
        $email->addAddress(EMAIL_NOTIFICACAO);

        if (!empty($content)) {
            $subject = $content->getAssunto();
            $text = $content->getMensagem();
        }
        else {
            $subject = 'Notificação de nova mensagem';
            $text = 'Você tem uma nova mensagem no Painel Administrativo.<br><a href="#">VER MENSAGEM<a>';
        }

        // Digitar o assunto do e-mail;
        $email->Subject = $subject;
        
        // Escrever o corpo do e-mail;
        $email->msgHTML($text);
        
        // Usar a opção de enviar o e-mail.
        $email->send();
    }

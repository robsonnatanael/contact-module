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
 * @author Robson Natanael <natanaelrobson@gmail.com>
 * @copyright 2020 - RN Comunicação & Marketing
 * @license MIT
 *
 * @package Contact Module
 */

use app\model\Chat;
use app\model\Mail;
use app\model\Message;
use app\model\Supplier;
use app\model\User;
use RNFactory\Controller\ReCaptcha;
use RNFactory\Database\Transaction;

try {

    if (count($_POST) > 0) {
        $validacao = true;
        $obrigatorio = array();
        $fornecedor = 1; // Criar regra de negócio para fornecedor

        $usuario = new User;
        if (strlen($_POST['name']) > 0) {
            $usuario->nome = $_POST['name'];
            $obrigatorio['name'] = $_POST['name'];
        } else {
            $validacao = false;
            $obrigatorio['erro_name'] = "O campo nome é obrigatório";
        }

        if (strlen($_POST['email']) > 0) {
            $usuario->email = $_POST['email'];
            $obrigatorio['email'] = $_POST['email'];
        } else {
            $validacao = false;
            $obrigatorio['erro_email'] = "O campo e-mail é obrigatório";
        }

        if (strlen($_POST['mensagem']) > 0) {
            $mensagem = new Message;
            $mensagem->mensagem = $_POST['mensagem'];
            $obrigatorio['message'] = $_POST['mensagem'];
        } else {
            $validacao = false;
            $obrigatorio['erro_message'] = "Mensagem obrigatória";
        }

        $validacao = ReCaptcha::reCAPTCHA();

        if ($validacao) {
            $usuario->fone = $_POST['fone'];
            Transaction::open('database');
            $usuario->id = $usuario->getIdUser($_POST['email']);

            $usuario->save();

            if ($usuario->id == 0) {
                $usuario->id = $usuario->getLastId();
            }

            $chat = new Chat;
            $chat->id_usuario = $usuario->id;
            $chat->id_fornecedor = $fornecedor;
            $chat->assunto = $_POST['assunto'];
            $chat->status = "Pendente"; // Enquanto não houver regra de negócio
            $chat->save();

            $chat->id = $chat->getLastId();

            $mensagem->chat = $chat;
            $mensagem->usuario = $usuario;
            $mensagem->date_send = date('Y-m-d');
            $mensagem->save();

            $fornecedor = Supplier::find($fornecedor);
            $usuario2 = User::find($fornecedor->id_usuario);

            Transaction::close();

            $user_mail = $usuario2->email;
            $user_name = $usuario2->nome;
            Mail::sendMail($user_mail, $user_name);

            echo "<script>alert('Mensagem enviada com sucesso!');</script>";
        }
    }

    require_once 'app/config/config.php';
    $obrigatorio['recaptcha'] = SITE_KEY;

    $loader = new \Twig\Loader\FilesystemLoader('app/view');
    $twig = new \Twig\Environment($loader);

    $template = $twig->load('formulario-contato.html');

    $parametros = $obrigatorio;

    echo $template->render($parametros);
} catch (Exception $e) {
    Transaction::rollback();
    print $e->getMessage();
}

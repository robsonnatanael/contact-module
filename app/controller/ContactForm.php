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
 * @package Contact Module
 */

use RNFactory\Database\Connection;
use RNFactory\Database\Transaction;
use RNFactory\Controller\ReCaptcha;
use app\model\Chat;
use app\model\Mail;
use app\model\Mensagem;
use app\model\Usuario;
use app\model\Fornecedor;

try {

    if (count($_POST) > 0) {
        $validacao = true;
        $fornecedor = 1; // Criar regra de negócio para fornecedor

        if (strlen($_POST['name']) > 0) {
            $usuario                = new Usuario;
            $usuario->nome          = $_POST['name'];
        } else {
            $validacao = false;
        };

        if (strlen($_POST['email']) > 0) {
            $usuario->email         = $_POST['email'];
        } else {
            $validacao = false;
        };

        if (strlen($_POST['mensagem']) > 0) {
            $mensagem               = new Mensagem;
            $mensagem->mensagem     = $_POST['mensagem'];
        } else {
            $validacao = false;
        };

        $validacao = ReCaptcha::reCAPTCHA();

        if ($validacao) {
            $usuario->fone = $_POST['fone'];
            Transaction::open('database');
            $usuario->id = $usuario->getIdUser($_POST['email']);

            $usuario->save();

            if ($usuario->id == 0) {
                $usuario->id = $usuario->getLastId();
            }

            $chat                   = new Chat;
            $chat->id_usuario       = $usuario->id;
            $chat->id_fornecedor    = $fornecedor;
            $chat->assunto          = $_POST['assunto'];
            $chat->status           = "Pendente"; // Enquanto não houver regra de negócio
            $chat->save();

            $chat->id = $chat->getLastId();

            $mensagem->chat         = $chat;
            $mensagem->usuario      = $usuario;
            $mensagem->date_send    = date('Y-m-d');
            $mensagem->save();

            $fornecedor = Fornecedor::find($fornecedor);
            $usuario2 = Usuario::find($fornecedor->id_usuario);

            Transaction::close();

            $user_mail = $usuario2->email;
            $user_name = $usuario2->nome;
            Mail::sendMail($user_mail, $user_name);

            echo "<script>alert('Mensagem enviada com sucesso!');</script>";
        } else {
            echo "<script>alert('Os campos obrigratórios devem ser preenchidos!');</script>";
        }
    };

    require_once __DIR__ . "/../view/formulario-contato.html";
} catch (Exception $e) {
    Transaction::rollback();
    print $e->getMessage();
}

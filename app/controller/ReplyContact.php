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
use app\model\Chat;
use app\model\Mensagem;
use app\model\Usuario;

try {

    if (strlen($_POST['message']) > 0) {

        $id_fornecedor = 1; // Enquanto existir apenas um fornecedor

        Transaction::open('database');
        $chat = Chat::find($_POST['id-chat']);

        $user = new Usuario;
        $user->id = 0;

        $message = new Mensagem;
        $message->chat          = $chat;
        $message->usuario       = $user;
        $message->mensagem      = $_POST['message'];
        $message->date_send     = date('Y-m-d');

        $message->save();

        $user = Usuario::find($chat->id_usuario);
        Transaction::close();

        var_dump($user);
    }
    //header('Location: index.php?page=MensagemView&id=' . $_POST['id-chat'] . '');
} catch (Exception $e) {
    Transaction::rollback();
    print $e->getMessage();
}

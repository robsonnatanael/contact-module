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
use app\model\Fornecedor;
use app\model\Mail;
use app\model\Message;
use app\model\User;
use RNFactory\Database\Transaction;

try {

    if (strlen($_POST['message']) > 0) {

        Transaction::open('database');
        $chat = Chat::find($_POST['id-chat']);
        $fornecedor = Fornecedor::find($chat->id_fornecedor);
        $user = new User;
        $user->id = $fornecedor->id_usuario;

        $message = new Message;
        $message->chat = $chat;
        $message->usuario = $user;
        $message->mensagem = $_POST['message'];
        $message->date_send = date('Y-m-d');

        $message->save();

        $user = User::find($chat->id_usuario);
        Transaction::close();

        $user_name = $user->nome;
        $user_mail = $user->email;

        Mail::sendMail($user_mail, $user_name);
    }
    header('Location: index.php?page=MensagemView&id=' . $_POST['id-chat'] . '');
} catch (Exception $e) {
    Transaction::rollback();
    print $e->getMessage();
}

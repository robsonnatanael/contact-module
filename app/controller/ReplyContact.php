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
use RNFactory\Database\Transaction;

try {

    if (strlen($_POST['message']) > 0) {

        Transaction::open('database');
        $chat = Chat::find($_POST['id-chat']);
        $supplier = Supplier::find($chat->id_supplier);
        $user = new User;
        $user->id = $supplier->id_user;

        $message = new Message;
        $message->chat = $chat;
        $message->user = $user;
        $message->message = $_POST['message'];
        $message->date_send = date('Y-m-d');

        $message->save();

        $user = User::find($chat->id_user);
        Transaction::close();

        $user_name = $user->name;
        $user_mail = $user->email;

        Mail::sendMail($user_mail, $user_name);
    }
    header('Location: index.php?page=MensagemView&id=' . $_POST['id-chat'] . '');
} catch (Exception $e) {
    Transaction::rollback();
    print $e->getMessage();
}

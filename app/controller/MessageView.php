<?php

/**
 * 2020 - RN Comunicação & Marketing
 *
 * AVISO DE LICENÇA
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
use app\model\Message;
use app\model\User;
use RNFactory\Database\Transaction;

Transaction::open('database');

$messages = Message::all('id_chat = ' . $_GET['id']);
$msg = array();
$msg['id_chat'] = $_GET['id'];

$chat = Chat::find($_GET['id']);

$msg['subject'] = $chat->subject;

$chat_view = array();
foreach ($messages as $message) {

    $user = User::find($message->id_user);
    $chat_view[$message->id]['id_user']      = $user->id;
    $chat_view[$message->id]['user']         = $user->name;
    $chat_view[$message->id]['message']      = $message->message;
    $chat_view[$message->id]['date_send']    = $message->date_send;
}

Transaction::close();
$msg['chat'] = $chat_view;

$loader = new \Twig\Loader\FilesystemLoader('app/view');
$twig = new \Twig\Environment($loader);

$template = $twig->load('message-view.html');

$parameters = $msg;

echo $template->render($parameters);

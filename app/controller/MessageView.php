<?php

/**
 * AVISO DE LICENÇA
 *
 * Este arquivo de origem está sujeito à Licença MIT
 * incluído neste pacote no arquivo LICENSE
 *
 * @copyright 2020 - Robson Natanael
 * @license https://opensource.org/licenses/MIT MIT License
 *
 * @package Contact Module
 * @author Robson Natanael <natanaelrobson@gmail.com>
 */

namespace app\controller;

use app\model\Chat;
use app\model\Message;
use app\model\User;
use RNFactory\Database\Transaction;

if (!defined('RN2020')) {
    header('Location: /');
    die('Página não encontrada!');
}

class MessageView
{
    public static function view()
    {

        Transaction::open('database');

        $messages = Message::all('id_chat = ' . $_GET['param']);
        $msg = array();
        $msg['id_chat'] = $_GET['param'];

        $chat = Chat::find($_GET['param']);

        $msg['subject'] = $chat->subject;

        $chat_view = array();
        foreach ($messages as $message) {

            $user = User::find($message->id_user);
            $chat_view[$message->id]['id_user'] = $user->id;
            $chat_view[$message->id]['user'] = $user->name;
            $chat_view[$message->id]['message'] = $message->message;
            $chat_view[$message->id]['date_send'] = $message->date_send;
        }

        Transaction::close();
        $msg['chat'] = $chat_view;

        $loader = new \Twig\Loader\FilesystemLoader('app/view');
        $twig = new \Twig\Environment($loader);

        $template = $twig->load('message-view.html');

        $parameters = $msg;

        echo $template->render($parameters);

    }
}

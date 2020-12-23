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

namespace app\controllers;

use app\core\AppLoader;
use app\models\Chat;
use app\models\Message;
use app\models\User;
use rnfactory\database\Transaction;

if (!defined('RN2020')) {
    header('Location: /');
    die('Página não encontrada!');
}

class Messages
{
    public static function list()
    {

        Transaction::open('database');
        $chat = Chat::all('id_supplier = 1'); // Implementar regra de negócio para saber qual fornecedor está visualizando chat

        $chat_list = array();

        foreach ($chat as $chats) {
            $user = User::find($chats->id_user);
            $message = Message::find($chats->id);

            $chat_list[$chats->id]['id'] = $chats->id;
            $chat_list[$chats->id]['name'] = $user->name;
            $chat_list[$chats->id]['subject'] = $chats->subject;
            $chat_list[$chats->id]['status'] = $chats->status;
            $chat_list[$chats->id]['id_message'] = $message->id;
            $chat_list[$chats->id]['date_send'] = $message->date_send;
        }

        Transaction::close();

        $parameters = array();
        $parameters['chat_list'] = $chat_list;

        AppLoader::load('messages.html', $parameters);
    }

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

        AppLoader::load('message-view.html', $msg);
    }
}

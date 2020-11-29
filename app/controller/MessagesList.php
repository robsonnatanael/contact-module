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

class MessagesList
{
    static function index()
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

        $loader = new \Twig\Loader\FilesystemLoader('app/view');
        $twig = new \Twig\Environment($loader);

        $template = $twig->load('messages.html');

        $parameters = array();
        $parameters['chat_list'] = $chat_list;

        echo $template->render($parameters);

    }
}

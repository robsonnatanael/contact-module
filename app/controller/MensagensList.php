<?php

/**
 * 2020 - RN Comunicação & Marketing
 * 
 * AVISO DE LICENÇA
 * 
 * Este arquivo de origem está sujeito à Licença ...
 * incluído neste pacote no arquivo LICENSE.
 * Também está disponível na Internet neste URL:
 * https://opensource.org/licenses/MIT
 * 
 * @author Robson Natanael <contato@robsonnatanael.com.br>
 * @copyright 2020 - RN Comunicação & Marketing
 * @license MIT 
 * 
 * @package Contact Module
 */

use RNFactory\Database\Transaction;
use app\model\Chat;
use app\model\Usuario;
use app\model\Mensagem;

Transaction::open('database');
$chat = Chat::all('id_fornecedor = 1'); // Implementar regra de negócio para saber qual fornecedor está visualizando chat

$chat_list = array();

foreach ($chat as $chats) {
    $usuario = Usuario::find($chats->id_usuario);
    $mensagem = Mensagem::find($chats->id);

    $chat_list[$chats->id]['id']            = $chats->id;
    $chat_list[$chats->id]['nome']          = $usuario->nome;
    $chat_list[$chats->id]['assunto']       = $chats->assunto;
    $chat_list[$chats->id]['status']        = $chats->status;
    $chat_list[$chats->id]['id_mensagem']   = $mensagem->id;
    $chat_list[$chats->id]['date_send']     = $mensagem->date_send;
}

Transaction::close();

$loader = new \Twig\Loader\FilesystemLoader('app/view');
$twig = new \Twig\Environment($loader);

$template = $twig->load('mensagens.html');

$parametros = array();
$parametros['chat_list'] = $chat_list;

echo $template->render($parametros);

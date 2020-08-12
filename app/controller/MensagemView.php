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

use app\model\Chat;
use app\model\Mensagem;
use app\model\User;
use RNFactory\Database\Transaction;

Transaction::open('database');

$mensagens = Mensagem::all('id_chat = ' . $_GET['id']);

$msg = array();
$msg['id_chat'] = $_GET['id'];

$chat = Chat::find($_GET['id']);
$msg['assunto'] = $chat->assunto;

$chat_view = array();
foreach ($mensagens as $mensagem) {

    $usuario = User::find($mensagem->id_usuario);

    $chat_view[$mensagem->id]['id_usuario'] = $usuario->id;
    $chat_view[$mensagem->id]['usuario'] = $usuario->nome;
    $chat_view[$mensagem->id]['mensagem'] = $mensagem->mensagem;
    $chat_view[$mensagem->id]['date_send'] = $mensagem->date_send;
}

Transaction::close();
$msg['chat'] = $chat_view;

$loader = new \Twig\Loader\FilesystemLoader('app/view');
$twig = new \Twig\Environment($loader);

$template = $twig->load('mensagem-view.html');

$parametros = $msg;

echo $template->render($parametros);

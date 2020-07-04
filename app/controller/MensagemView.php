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
use app\model\Usuario;
use app\model\Mensagem;

Transaction::open('database');

$mensagem = Mensagem::find($_GET['id']);

$usuario = Usuario::find($mensagem->id_usuario);

$chat = Chat::find($mensagem->id_chat);

$msg = array();
$msg['usuario']     = $usuario->nome;
$msg['assunto']     = $chat->assunto;
$msg['date_send']   = $mensagem->date_send;
$msg['mensagem']    = $mensagem->mensagem;

$mensagens = Mensagem::all('id_chat = ' . $chat->id);

Transaction::close();

$chat_view  = array();
foreach ($mensagens as $conversa) {
    if ($conversa->id_usuario == $usuario->id) {
        $chat_usuario = $usuario->nome;
    } else {
        $chat_usuario = "Fornecedor"; // Buscar fornecedor na varivel sessão
    }
    $chat_view[$conversa->id]['chat_usuario']   = $chat_usuario;
    $chat_view[$conversa->id]['chat_date']      = $conversa->date_send;
    $chat_view[$conversa->id]['chat_mensagem']  = $conversa->mensagem;
}

$msg['chat'] = $chat_view;

$loader = new \Twig\Loader\FilesystemLoader('app/view');
$twig = new \Twig\Environment($loader);

$template = $twig->load('mensagem-view.html');

$parametros = $msg;

echo $template->render($parametros);

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
     * @package Portfólio Painel de Mensagem
     */

    require_once "app/config/config.php";
    require_once "app/helper/banco.php";

    use app\model\RepositorioMensagem;
    use app\model\Mensagem;
    use app\model\Usuario;

    $repositorio = new RepositorioMensagem($pdo);
    
    if (isset($_GET['idChat'])) {
        $id = $_GET['idChat'];
    } else {
        $id = NULL;
    }
    
    $mensagem = $repositorio->getMsg('id='.$id);

    $msg = array();
    foreach ($mensagem as $m) {
        $msg['id'] = $m['id'];
        $msg['assunto'] = $m['assunto'];
        $msg['mensagem'] = $m['mensagem'];
        $msg['status'] = $m['status'];
        $msg['date_send'] = $m['date_send'];
        $msg['id_chat'] = $m['id_chat'];
        $msg['id_fornecedor'] = $m['id_fornecedor'];
        
        $usuario = $m['id_usuario'];
        $usuario = $repositorio->getUser('id='.$usuario);
       
        foreach ($usuario as $user) {
            $msg['id_user'] = $user['id'];
            $msg['user'] = $user['nome'];
        }
        
    }

$loader = new \Twig\Loader\FilesystemLoader('app/view');
$twig = new \Twig\Environment($loader);

$template = $twig->load('mensagem-view.html');

$parametros = array();
$parametros['mensagem'] = $msg;

echo $template->render($parametros);


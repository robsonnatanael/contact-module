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
    
    $repositorio = new RepositorioMensagem($pdo);
    
    // implementar busca de fornecedor
    $fornecedor = 1;
    // ***

    $msg = $repositorio->getMsg('id_fornecedor='.$fornecedor);

    // OBSERVAÇÃO: melhorar regra de negócio!
    $mensagens = array();
    $cont = 0;
    foreach ($msg as $msgs) {
        $id_usuario = $msgs['id_usuario'];
        $usuario = $repositorio->getUser("id=$id_usuario");
        $msgs['usuario'] = $usuario[0]['nome'];
        $mensagens[$cont] = $msgs;
        $cont++;
    }
    // ***

    $loader = new \Twig\Loader\FilesystemLoader('app/view');
    $twig = new \Twig\Environment($loader);

    $template = $twig->load('mensagens.html');   

    $parametros = array();
    $parametros['mensagem'] = $mensagens;

    echo $template->render($parametros);  

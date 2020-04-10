<?php
    /**
     * 2020 - RN Comunicação & Marketing
     * 
     * * AVISO DE LICENÇA
     * 
     * Este arquivo de origem está sujeito à Licença ...
     * incluído neste pacote no arquivo LICENSE.txt.
     * Também está disponível na Internet neste URL:
     * https://www.robsonnatanael.com.br/...
     * 
     * @author Robson Natanael <natanaelrobson@gmail.com>
     * @copyright 2020 - RN Comunicação & Marketing
     * @license 
     * 
     * @package Portfólio Painel de Mensagem
     */

    require_once "app/config/config.php";
    require_once "app/helper/banco.php";
    require_once "app/helper/Helper.php";
    require_once "app/model/Usuario.php";
    require_once "app/model/Mensagem.php";
    require_once "app/model/RepositorioMensagem.php";

    $repositorio = new RepositorioMensagem($pdo);

    // lê o conteúdo do template e armazena em uma variável
    $template = file_get_contents('app/template/estrutura.html');

    ob_start(); // Ativa o buffer de saída
        // verifica qual arquivo (rota) deve ser usado para tratar a requisição
        $pagina = "enviar-mensagem"; // rota padrão
    
        if (array_key_exists("pagina", $_GET)) {
            $pagina = $_GET["pagina"];
         }

        // inclui o aquivo que vai tratar a requisição
        if (is_file("app/controller/{$pagina}.php")) {
            require_once "app/controller/{$pagina}.php";
        } else {
            echo "Página não encontrada!";
        }
    
        $saida = ob_get_contents(); // retorna o conteúdo do buffer de saída
    ob_end_clean(); // Limpa (apaga) o buffer de saída e desativa o buffer de saída

    $templatePronto = str_replace('{{area_dinamica}}', $saida, $template);

    echo $templatePronto;

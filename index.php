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

    require_once "vendor/autoload.php";   

    // lê o conteúdo do template e armazena em uma variável
    $estrutura = file_get_contents('app/template/estrutura.html');

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

    $templatePronto = str_replace('{{area_dinamica}}', $saida, $estrutura);

    echo $templatePronto;

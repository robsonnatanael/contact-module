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
 * @author Robson Natanael <natanaelrobson@gmail.com>
 * @copyright 2020 - RN Comunicação & Marketing
 * @license MIT
 *
 * @package Contact Module
 */

session_start();

require_once "vendor/autoload.php";

// lê o conteúdo do template e armazena em uma variável
$structure = file_get_contents('app/template/structure.html');

ob_start(); // Ativa o buffer de saída
// verifica qual arquivo (rota) deve ser usado para tratar a requisição
$page = "ContactForm"; // rota padrão

if (array_key_exists("page", $_GET)) {
    $page = $_GET["page"];
}

// inclui o aquivo que vai tratar a requisição
if (is_file("app/controller/{$page}.php")) {
    require_once "app/controller/{$page}.php";
} else {
    echo "Página não encontrada!";
}

$loader = ob_get_contents(); // retorna o conteúdo do buffer de saída
ob_end_clean(); // Limpa (apaga) o buffer de saída e desativa o buffer de saída

$template = str_replace('{{ dynamic_area }}', $loader, $structure);

echo $template;

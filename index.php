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

session_start();
define('RN2020', true);

require_once 'vendor/autoload.php';

use app\core\AppLoader;

$structure = file_get_contents('app/template/structure.html');

ob_start();

$core = new AppLoader;
$page = $core->start($_GET);

$loader = ob_get_contents();
ob_end_clean();

$template = str_replace('{{ dynamic_area }}', $loader, $structure);

echo $template;

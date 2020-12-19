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

namespace app\controllers;

use app\core\AppLoader;

if (!defined('RN2020')) {
    header('Location: /');
    die('Página não encontrada!');
}

class Dashboard
{
    public static function index()
    {
        $parameters = array();

        AppLoader::load('dashboard.html', $parameters);
    }
}

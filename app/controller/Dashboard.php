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

namespace app\controller;

if (!defined('RN2020')) {
    header('Location: /');
    die('Página não encontrada!');
}

class Dashboard
{
    public static function index()
    {
        $loader = new \Twig\Loader\FilesystemLoader('app/view');
        $twig = new \Twig\Environment($loader, [
            'cache' => 'app/cache',
            'auto_reload' => true,
        ]);

        $template = $twig->load('dashboard.html');

        $parameters = array();
        $parameters['btn'] = 'Sair';

        echo $template->render($parameters);
    }
}

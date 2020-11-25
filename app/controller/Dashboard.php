<?php

/**
 * 2020 - RN Comunicação & Marketing
 *
 * AVISO DE LICENÇA
 *
 * Este arquivo de origem está sujeito à Licença MIT
 * incluído neste pacote no arquivo LICENSE.txt.
 * Também está disponível na Internet neste URL:
 * https://opensource.org/licenses/MIT
 *
 * @author Robson Natanael <natanaelrobson@gmail.com>
 * @copyright 2020 - RN Comunicação & Marketing
 * @license https://opensource.org/licenses/MIT MIT License
 *
 * @package Contact Module
 */

namespace app\controller;

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

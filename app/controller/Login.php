<?php

/**
 * 2020 - RN Comunicação & Marketing
 *
 * AVISO DE LICENÇA
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

class Login
{
    public $url;

    public function authentication()
    {
        echo 'Método authentication em execurção!';

        $loader = new \Twig\Loader\FilesystemLoader('app/view');
        $twig = new \Twig\Environment($loader, [
            'cache' => '/app/cache',
            'auto_reload' => true,
        ]);

        $template = $twig->load('login.html');

        echo $template->render();

    }

}

echo 'Teste';

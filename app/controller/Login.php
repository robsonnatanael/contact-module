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

use app\model\User;
use RNFactory\Database\Transaction;

class Login
{
    public static function index()
    {
        if (isset($_SESSION['logged'])) {
            header('Location: /index.php?class=Dashboard&method=index');
        }
        else {
            Login::authentication();
        }
    }

    public static function authentication()
    {
        $loader = new \Twig\Loader\FilesystemLoader('app/view');
        $twig = new \Twig\Environment($loader, [
            'cache' => 'app/cache',
            'auto_reload' => true,
        ]);

        $template = $twig->load('login.html');
        $parameters['error'] = $_SESSION['msg-error'] ?? null;

        echo $template->render($parameters);

    }

    public function check()
    {
        try {
            $user = new User;
            $user->email = $_POST['user_login'];
            $user->password = $_POST['user_pass'];

            Transaction::open('database');
            $user->validateLogin();

            Transaction::close();
            header('Location: /index.php?class=Dashboard&method=index');
            //header('Location: /index.php?class=MessagesList&method=index');

        } catch (\Exception $e) {
            $_SESSION['msg-error'] = $e->getMessage();
            header('Location: /index.php?class=Login&method=authentication');
        }
    }

    public function logout()
    {
        unset($_SESSION['logged']);
        session_destroy();
        header('Location: /index.php');
    }

}

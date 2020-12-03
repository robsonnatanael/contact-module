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

use app\core\AppLoader;
use app\model\User;
use RNFactory\Database\Transaction;

class Login
{
    public static function index()
    {
        if (isset($_SESSION['logged'])) {
            header('Location: /index.php?class=Dashboard');
        }
        else {
            $parameters = array();
            $parameters['error'] = $_SESSION['msg-error'] ?? null;
            unset($_SESSION['msg-error']);
            AppLoader::load('login.html', $parameters);
        }
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
            header('Location: /index.php?class=Dashboard');

        } catch (\Exception $e) {
            $_SESSION['msg-error'] = $e->getMessage();
            header('Location: /index.php?class=Login');
        }
    }

    public function logout()
    {
        unset($_SESSION['logged']);
        session_destroy();
        header('Location: /index.php');
    }
}

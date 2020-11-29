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

namespace app\core;

use Exception;

class AppLoader
{
    private $data;
    private $param = null;

    public function __set($property, $value)
    {
        $this->data[$property] = $value;
    }

    public function __get($property)
    {
        return $this->data[$property];
    }

    public function start($url)
    {
        try {
            if (!empty($url)) {

                if (array_key_exists('class', $_GET) && file_exists("app/controller/{$_GET['class']}.php")) {

                    $this->permission($_GET);
                    $controller = $this->urlController;
                    $method = $_GET['method'] ?? 'index';

                    return call_user_func(array("app\\controller\\$controller", $method), $this->param);

                } else {
                    throw new Exception('Página não encontrada!');
                }

            } else {
                return call_user_func(array("app\\controller\\ContactForm", 'index'));
            }

        } catch (Exception $e) {
            echo 'Erro 404: ' . $e->getMessage();
        }

    }

    private function permission($url)
    {

        $this->urlController = $url['class'];
        $pagePublic = ['ContactForm', 'Login'];

        if (in_array($this->urlController, $pagePublic)) {
            return $this->urlControlle = $url['class'];
        }

        $this->validLogin($url);
    }

    private function validLogin($url)
    {
        if (isset($_SESSION['logged'])) {
            return $this->urlControlle = $url['class'];
        }

        header('Location: /index.php?class=Login&method=index');
    }
}

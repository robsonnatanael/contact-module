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

namespace app\core;

use Exception;

class AppLoader
{
    private $data;
    private $param = null;
    private $error;

    public function __construct()
    {
        $this->error = $_SESSION['msg-erro'] ?? null;
        if (isset($this->error)) {
            unset($_SESSION['msg-error']);
        }
    }

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

                    foreach ($url as $key => $url) {

                        $this->$key = $url;

                    }

                    return call_user_func(array("app\\controller\\$this->class", $this->method), $this->param);

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
}

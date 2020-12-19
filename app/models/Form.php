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

namespace app\models;

class Form
{
    private $data;

    public function validateForm($form)
    {

        if (!count($form) > 0) {
            return $this->validate = false;
        }

        $required = array();

        foreach ($form as $key => $dataForm) {
            if (strlen($dataForm) > 0) {
                $form[$key] = $dataForm;
            } else {
                $validate = false;
                $required[$key] = 'Campo obrigatório!';
            }
        }

        $this->msgRequired = $required;
        $this->dataForm = $form;

        return $this->validate = $validate ?? true;

    }

    public function __set($propriety, $value)
    {
        $this->data[$propriety] = $value;
    }

    public function __get($propriety)
    {
        return $this->data[$propriety];
    }
}

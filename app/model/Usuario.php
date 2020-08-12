<?php

/**
 * 2020 - RN Comunicação & Marketing
 *
 * * AVISO DE LICENÇA
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

namespace app\model;

use RNFactory\Database\Transaction;
use PDO;

class Usuario
{
    private static $conn;
    private $data;

    public function __set($propriedade, $value)
    {
        $this->data[$propriedade] = $value;
    }

    public function __get($propriedade)
    {
        return $this->data[$propriedade];
    }

    public function getIdUser($email)
    {
        $sql = "SELECT id FROM usuarios WHERE email = '$email'";
        $conn = Transaction::get();
        $result = $conn->query($sql);
        $data = $result->fetch(PDO::FETCH_OBJ);
        if (isset($data->id)) {
            return $data->id;
        }
    }

    public static function find($id)
    {
        $sql = "SELECT * FROM usuarios WHERE id = '$id' ";
        $conn = Transaction::get();
        $result = $conn->query($sql);
        return $result->fetchObject(__CLASS__);
    }

    public function save()
    {
        if (empty($this->data['id'])) {
            $sql = "INSERT INTO usuarios (nome, email, fone) " .
                " VALUES ('{$this->nome}', " .
                "     '{$this->email}', " .
                "     '{$this->fone}')";
        } else {
            $sql = "UPDATE usuarios SET nome    = '{$this->nome}', " .
                "   email   = '{$this->email}', " .
                "   fone    = '{$this->fone}' " .
                " WHERE id  = '{$this->id}'";
        }
        $conn = Transaction::get();
        return $conn->exec($sql);
    }

    public function getLastId()
    {
        $sql = "SELECT max(id) as max FROM usuarios";
        $conn = Transaction::get();
        $result = $conn->query($sql);
        $data = $result->fetch(PDO::FETCH_OBJ);
        return $data->max;
    }
}

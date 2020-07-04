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
 * @author Robson Natanael <contato@robsonnatanael.com.br>
 * @copyright 2020 - RN Comunicação & Marketing
 * @license MIT
 * 
 * @package Contact Module
 */

namespace app\model;

use RNFactory\Database\Transaction;
use PDO;

class Chat
{
    private $data;

    function __set($property, $value)
    {
        $this->data[$property] = $value;
    }

    function __get($property)
    {
        return $this->data[$property];
    }

    public static function find($id)
    {
        $sql = "SELECT * FROM chat WHERE id = '$id' ";
        $conn = Transaction::get();
        $result = $conn->query($sql);
        return $result->fetchObject(__CLASS__);
    }

    public function getChat($condition = '')
    {
        $sql = "SELECT * FROM chat ";
        if ($condition) {
            $sql .= "WHERE $condition";
        }
        $conn = Transaction::get();
        $result = $conn->query($sql);
        return $result->fetchObject(__CLASS__);
    }

    public static function all($filter = '')
    {
        $sql = "SELECT * FROM chat ";
        if ($filter) {
            $sql .= "where $filter";
        }
        $conn = Transaction::get();
        $result = $conn->query($sql);
        return $result->fetchAll(PDO::FETCH_CLASS, __CLASS__);
    }

    public function save()
    {
        $sql = "INSERT INTO chat (id_usuario, id_fornecedor, assunto, status) " .
            " VALUE ('{$this->id_usuario}', " .
            "    '{$this->id_fornecedor}', " .
            "    '{$this->assunto}', " .
            "    '{$this->status}')";
        $conn = Transaction::get();
        return $conn->exec($sql);
    }

    public function getLastId()
    {
        $sql = "SELECT max(id) as max FROM chat";
        $conn = Transaction::get();
        $result = $conn->query($sql);
        $data = $result->fetch(PDO::FETCH_OBJ);
        return $data->max;
    }
}

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

namespace app\model;

use PDO;
use RNFactory\Database\Transaction;

class Chat
{
    private $data;

    public function __set($property, $value)
    {
        $this->data[$property] = $value;
    }

    public function __get($property)
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

    public static function all($filter = '')
    {
        $sql = "SELECT * FROM chat ";
        if ($filter) {
            $sql .= "WHERE $filter";
        }
        $conn = Transaction::get();
        $result = $conn->query($sql);

        return $result->fetchAll(PDO::FETCH_CLASS, __CLASS__);
    }

    public function save()
    {
        $sql = "INSERT INTO chat (id_user, id_supplier, subject, status) " .
            " VALUE ('{$this->id_user}', " .
            "    '{$this->id_supplier}', " .
            "    '{$this->subject}', " .
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

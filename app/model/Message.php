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

use PDO;
use RNFactory\Database\Transaction;

class Message
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
        $sql = "SELECT * FROM messages WHERE id = $id";
        $conn = Transaction::get();
        $result = $conn->query($sql);

        return $result->fetchObject(__CLASS__);
    }

    public static function all($filter = '')
    {
        $sql = "SELECT * FROM messages ";
        if ($filter) {
            $sql .= "where $filter";
        }
        $conn = Transaction::get();
        $result = $conn->query($sql);

        return $result->fetchAll(PDO::FETCH_CLASS, __CLASS__);
    }

    public function save()
    {
        if (empty($this->data['id'])) {
            $sql = "INSERT INTO messages (id_chat, id_user, id_supplier, message, date_send)" .
                " VALUES ('{$this->chat->id}', " .
                " '{$this->user->id}', " .
                " '{$this->chat->id_supplier}', " .
                " '{$this->message}', " .
                " '{$this->date_send}')";
        } else {
            $sql = "UPDATE messages SET id_chat        = '{$this->chat->id}', " .
                "id_user        = '{$this->user->id}', " .
                "id_supplier    = '{$this->chat->id_supplier}', " .
                "mesage         = '{$this->message}', " .
                "date_send      = '{$this->date_send}', " .
                " WHERE id      = '{$this->id}'";
        }
        $conn = Transaction::get();
        return $conn->exec($sql);
    }
}

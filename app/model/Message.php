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
        $sql = "SELECT * FROM mensagens WHERE id = '$id' ";
        $conn = Transaction::get();
        $result = $conn->query($sql);
        return $result->fetchObject(__CLASS__);
    }

    public static function all($filter = '')
    {
        $sql = "SELECT * FROM mensagens ";
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
            $sql = "INSERT INTO mensagens (id_chat, id_usuario, id_fornecedor, mensagem, date_send)" .
                " VALUES ('{$this->chat->id}', " .
                " '{$this->usuario->id}', " .
                " '{$this->chat->id_fornecedor}', " .
                " '{$this->mensagem}', " .
                " '{$this->date_send}')";
        } else {
            $sql = "UPDATE mensagens SET id_chat        = '{$this->chat->id}', " .
                "id_usuario     = '{$this->usuario->id}', " .
                "id_fornecedor  = '{$this->chat->id_fornecedor}', " .
                "mensagem       = '{$this->mensagem}', " .
                "date_send      = '{$this->date_send}', " .
                " WHERE id      = '{$this->id}'";
        }
        $conn = Transaction::get();
        return $conn->exec($sql);
    }
}

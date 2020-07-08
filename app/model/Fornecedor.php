<?php

namespace app\model;

use RNFactory\Database\Transaction;

class Fornecedor
{
    private static $conn;
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
        $sql = "SELECT * FROM fornecedores WHERE id = '$id' ";
        $conn = Transaction::get();
        $result = $conn->query($sql);
        return $result->fetchObject(__CLASS__);
    }
}

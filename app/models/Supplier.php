<?php

/**
 * AVISO DE LICENÇA
 *
 * Este arquivo de origem está sujeito à Licença MIT
 * incluído neste pacote no arquivo LICENSE
 *
 * @copyright 2020-2021 - Robson Natanael
 * @license https://opensource.org/licenses/MIT MIT License
 *
 * @package Contact Module
 * @author Robson Natanael <natanaelrobson@gmail.com>
 */

namespace app\models;

use rnfactory\database\Transaction;
use PDO;

class Supplier
{
    private static $conn;
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
        $sql = "SELECT * FROM suppliers WHERE id = '$id' ";
        $conn = Transaction::get();
        $result = $conn->query($sql);
        return $result->fetchObject(__CLASS__);
    }

    public static function all()
    {
        $sql = "SELECT * FROM suppliers";
        $conn = Transaction::get();
        $result = $conn->query($sql);
        return $result->fetchAll(PDO::FETCH_CLASS, __CLASS__);
    }

    public function save()
    {
        if (empty($this->data['id'])) {
            $sql = "INSERT INTO suppliers (id_user, plan, description) VALUES (:id_user, :plan, :description)";
        } else {
            $sql = "UPDATE suppliers SET id_user    = :id_user, " .
                    "   plan   = :plan, " .
                    "   description   = :description " .
                    " WHERE id  = '{$this->id}'";
        }

        $conn = Transaction::get();
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id_user', $this->id_user);
        $stmt->bindValue(':plan', $this->plan);
        $stmt->bindValue(':description', $this->description);
        return $stmt->execute();
    }

    public static function delete($id)
    {
        $sql = "DELETE FROM suppliers WHERE id = '$id'";
        $conn = Transaction::get();
        $result = $conn->exec($sql);
        return $result;
    }
}

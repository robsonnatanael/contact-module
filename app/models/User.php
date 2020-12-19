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

use rnfactory\database\Transaction;
use PDO;

class User
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

    public function getIdUser($email)
    {
        $sql = "SELECT id FROM users WHERE email = :email";
        $conn = Transaction::get();
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_OBJ);
        if (isset($data->id)) {
            return $data->id;
        }
    }

    public static function find($id)
    {
        $sql = "SELECT * FROM users WHERE id = '$id' ";
        $conn = Transaction::get();
        $result = $conn->query($sql);
        return $result->fetchObject(__CLASS__);
    }

    public function save()
    {
        if (empty($this->data['id'])) {
            $sql = "INSERT INTO users (name, email, phone) " .
                " VALUES (:name, " .
                "     :email, " .
                "     :phone)";
        } else {
            $sql = "UPDATE users SET name    = :name, " .
                "   email   = :email, " .
                "   phone   = :phone " .
                " WHERE id  = '{$this->id}'";
        }
        $conn = Transaction::get();
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':name', $this->name);
        $stmt->bindValue(':email', $this->email);
        $stmt->bindValue(':phone', $this->phone);
        return $stmt->execute();
    }

    public function getLastId()
    {
        $sql = "SELECT max(id) as max FROM users";
        $conn = Transaction::get();
        $result = $conn->query($sql);
        $data = $result->fetch(PDO::FETCH_OBJ);
        return $data->max;
    }

    public function validateLogin()
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        $conn = Transaction::get();
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':email', $this->email);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_OBJ);

        $password = $this->password;
        $passwordDb = $data->password;

        if (!empty($data) && password_verify($password, $passwordDb)) {

            $_SESSION['logged'] = true;
            $_SESSION['id-user'] = $data->id;
            $_SESSION['name'] = $data->name;

            return true;
        }

        throw new \Exception('Login invalido!');
    }
}

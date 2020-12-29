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

namespace app\controllers;

use app\core\AppLoader;
use app\models\Supplier;
use app\models\User;
use rnfactory\database\Transaction;

class Home
{
    public static function index()
    {
        $supplier = new Supplier;
        Transaction::open('database');
        $suppliers = $supplier->all();

        $parameters = array();

        if ($suppliers) {

            foreach ($suppliers as $sup) {
                $user = User::find($sup->id_user);
                $fornecedores[$sup->id] = ['id' => $sup->id, 'name' => $user->name, 'description' => $sup->description];
            }

            $parameters['fornecedores'] = $fornecedores;

        } else {
            $parameters['msg'] = 'Nenhum fornecedor cadastrado!';
        }

        Transaction::close();

        AppLoader::load('home.html', $parameters);
    }
}

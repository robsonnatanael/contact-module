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

namespace app\controllers;

use app\models\Supplier;
use app\models\User;
use rnfactory\database\Transaction;
use app\core\AppLoader;

class SupplierController
{
    public static function index()
    {
        $suppliers = self::list();

        $parameters['suppliers'] = $suppliers;

        AppLoader::load('supplier.html', $parameters);
    }

    public static function list() {
        Transaction::open('database');
        $suppliers = Supplier::all();

        foreach ($suppliers as $supplier) {

            $user = User::find($supplier->id_user);

            $userSupplier[$user->id]['id'] = $supplier->id;
            $userSupplier[$user->id]['name'] = $user->name;
            $userSupplier[$user->id]['email'] = $user->email;
            $userSupplier[$user->id]['phone'] = $user->phone;
            $userSupplier[$user->id]['description'] = $supplier->description;
            $userSupplier[$user->id]['plan'] = $supplier->plan;
        }

        Transaction::close();

        return $userSupplier;
    }

}

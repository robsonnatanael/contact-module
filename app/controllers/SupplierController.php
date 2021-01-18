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

use app\core\AppLoader;
use app\models\Form;
use app\models\Supplier;
use app\models\User;
use Exception;
use rnfactory\database\Transaction;

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

    public static function register()
    {
        $parameters = array();

        if (empty($_POST)) {
            return AppLoader::load('form-supplier.html', $parameters);
        }

        $form = new Form;
        $form->validateForm($_POST);

        if ($form->validate == false) {

            $parameters['value'] = $form->dataForm;
            $parameters['required'] = $form->msgRequired;

            return AppLoader::load('form-supplier.html', $parameters);
        }

        try {
            $user = new User;
            Transaction::open('database');
            $user->id = $user->getIdUser($_POST['email']);

            if (!$user->id) {
                echo 'Usuário não cadastrado!';
                $user->name = $_POST['name'];
                $user->email = $_POST['email'];
                $user->phone = $_POST['phone'];
                $user->save();
                $user->id = $user->getLastId();
            }

            $supplier = new Supplier;
            $supplier->id_user = $user->id;
            $supplier->plan = $_POST['plan'];
            $supplier->description = $_POST['description'];
            $supplier->save();

            Transaction::close();

            echo 'Fornecedor cadastrado com sucesso!'; // para debug

        } catch (Exception $e) {

        }

    }

    public static function view()
    {
        Transaction::open('database');
        $supplier = Supplier::find($_GET['param']);
        $supplier->user = User::find($supplier->id_user);

        Transaction::close();

        $param['id'] = $supplier->id;
        $param['plan'] = $supplier->plan;
        $param['description'] = $supplier->description;
        $param['name'] = $supplier->user->name;
        $param['email'] = $supplier->user->email;
        $param['phone'] = $supplier->user->phone;

        $parameters['supplier'] = $param;

        AppLoader::load('supplier-view.html', $parameters);
    }
}

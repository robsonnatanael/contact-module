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
use app\models\Chat;
use app\models\Form;
use app\models\Mail;
use app\models\Message;
use app\models\Supplier;
use app\models\User;
use rnfactory\controllers\ReCaptcha;
use rnfactory\database\Transaction;

class ContactForm
{
    public static function index()
    {
        $required['msg'] = $_SESSION['msg'] ?? '';
        unset($_SESSION['msg']);

        require_once 'app/config/config.php';
        $required['recaptcha'] = SITE_KEY;

        if (isset($_SESSION['required'])) {
            $required['form'] = $_SESSION['form'];
            $required['required'] = $_SESSION['required'];
            $required['msg'] = 'Erro ao enviar informações!';
            unset($_SESSION['required'], $_SESSION['form']);
        }

        $parameters = $required;

        AppLoader::load('form-contact.html', $parameters);
    }

    public static function check()
    {
        $form = new Form;
        $form->validateForm($_POST);

        if ($form->validate == false) {
            $_SESSION['required'] = $form->msgRequired;
            $_SESSION['form'] = $form->dataForm;
            return ContactForm::index();
        }

        ContactForm::save();

    }

    public static function save()
    {
        try {
            $supplier = 1; // Criar regra de negócio para fornecedor

            $user = new User;
            $user->name = $_POST['name'];
            $user->email = $_POST['email'];

            $message = new Message;
            $message->message = $_POST['message'];

            $validation = ReCaptcha::reCAPTCHA();

            if ($validation) {
                $user->phone = $_POST['phone'];
                Transaction::open('database');
                $user->id = $user->getIdUser($_POST['email']);

                $user->save();

                if ($user->id == 0) {
                    $user->id = $user->getLastId();
                }

                $chat = new Chat;
                $chat->id_user = $user->id;
                $chat->id_supplier = $supplier;
                $chat->subject = $_POST['subject'];
                $chat->status = "Pendente"; // Enquanto não houver regra de negócio
                $chat->save();

                $chat->id = $chat->getLastId();

                $message->chat = $chat;
                $message->user = $user;
                $message->date_send = date('Y-m-d');
                $message->save();

                $supplier = Supplier::find($supplier);
                $user2 = User::find($supplier->id_user);

                Transaction::close();

                $user_mail = $user2->email;
                $user_name = $user2->name;
                Mail::sendMail($user_mail, $user_name);

                $_SESSION['msg'] = 'Mensagem enviada com sucesso!';
                header('Location: /index.php?class=ContactForm');
            }

        } catch (Exception $e) {
            Transaction::rollback();
            print $e->getMessage();
        }
    }
}

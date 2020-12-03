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

namespace app\controller;

use app\core\AppLoader;
use app\model\Chat;
use app\model\Mail;
use app\model\Message;
use app\model\Supplier;
use app\model\User;
use RNFactory\Controller\ReCaptcha;
use RNFactory\Database\Transaction;

class ContactForm
{
    public static function index()
    {

        try {

            if (count($_POST) > 0) {
                $validation = true;
                $required = array();
                $supplier = 1; // Criar regra de negócio para fornecedor

                $user = new User;
                if (strlen($_POST['name']) > 0) {
                    $user->name = $_POST['name'];
                    $required['name'] = $_POST['name'];
                } else {
                    $validation = false;
                    $required['erro_name'] = "O campo nome é obrigatório";
                }

                if (strlen($_POST['email']) > 0) {
                    $user->email = $_POST['email'];
                    $required['email'] = $_POST['email'];
                } else {
                    $validation = false;
                    $required['erro_email'] = "O campo e-mail é obrigatório";
                }

                if (strlen($_POST['message']) > 0) {
                    $message = new Message;
                    $message->message = $_POST['message'];
                    $required['message'] = $_POST['message'];
                } else {
                    $validation = false;
                    $required['erro_message'] = "Mensagem obrigatória";
                }

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

                    $required['msg'] = 'Mensagem enviada com sucesso!';
                }
            }

            require_once 'app/config/config.php';
            $required['recaptcha'] = SITE_KEY;

            $parameters = $required;
            AppLoader::load('form-contact.html', $parameters);

        } catch (Exception $e) {
            Transaction::rollback();
            print $e->getMessage();
        }
    }
}

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
     * @author Robson Natanael <contato@robsonnatanael.com.br>
     * @copyright 2020 - RN Comunicação & Marketing
     * @license MIT
     * 
     * @package Portfólio Painel de Mensagem
     */

    require_once "app/config/config.php";
    require_once "app/helper/banco.php";
    require_once "app/helper/Helper.php";
    
    use app\model\Mensagem;
    use app\model\Usuario;
    use app\model\RepositorioMensagem;
    
    $repositorio = new RepositorioMensagem($pdo);

    $msg = new Mensagem;
    $usuario = new Usuario;

    $validacao = true;
    $campo = [];

    if (validar_metodo_post()) {

        if (strlen($_POST['nome']) > 0) {
            $usuario->nome = $_POST['nome'];
        } else {
            $validacao = false;
            $campo[0] = 'Nome';
        };

        if (strlen($_POST['email']) > 0) {
            $usuario->email = $_POST['email'];
        } else {
            $validacao = false;
            $campo[1] = 'E-mail';
        };

        if (strlen($_POST['mensagem']) > 0) {
            $msg->mensagem = $_POST['mensagem'];
        } else {
            $validacao = false;
            $campo[2] = 'Mensagem';
        };

        $validacao = reCAPTCHA();

        if (!$validacao) {
            
            $validar = '';    
            foreach ($campo as $campo) {
                $validar .= $campo.' ';
            }
            echo "<script>alert('Campos obrigratórios! {$validar}');</script>";

        } else {
            $usuario->fone          = $_POST['fone'];
            $msg->assunto           = $_POST['assunto'];
            $msg->status            = "Pendente";
            $msg->date_send         = date("Y-m-d");
            // Rever método que set Id Chat e Id Fornecedor
            $msg->id_chat           = 0;
            $msg->id_fornecedor     = 1;
            
            $id_usuario = $repositorio->getIdUser($_POST['email']);
            
            if (!$id_usuario) {
                $repositorio->salvarUsuario($usuario);
                $id_usuario = $repositorio->getLastId();
            } 
                    
            $usuario->id_usuario    = $id_usuario;
            $msg->usuario           = $usuario;

            $repositorio->salvar($msg);
            //sendEmail();
            echo "<script>alert('Mensagem enviada com sucesso!');</script>"; 
        }
    } 

    require_once __DIR__ . "/../view/formulario-contato.html"; 

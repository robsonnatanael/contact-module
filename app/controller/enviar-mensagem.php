<?php
    /**
     * 2020 - RN Comunicação & Marketing
     * 
     * * AVISO DE LICENÇA
     * 
     * Este arquivo de origem está sujeito à Licença ...
     * incluído neste pacote no arquivo LICENSE.txt.
     * Também está disponível na Internet neste URL:
     * https://www.robsonnatanael.com.br/...
     * 
     * @author Robson Natanael <natanaelrobson@gmail.com>
     * @copyright 2020 - RN Comunicação & Marketing
     * @license 
     * 
     * @package Portfólio Painel de Mensagem
     */

    if (validar_metodo_post()) {

        $msg = new Mensagem;
        $usuario = new Usuario;  

        $usuario->setNome($_POST['nome']);
        $usuario->setEmail($_POST['email']);
        $usuario->setFone($_POST['fone']);
         
        $msg->setAssunto($_POST['assunto']);
        $msg->setMensagem($_POST['mensagem']);
        $msg->setStatus("Pendente");
        $msg->setData(date("Y-m-d"));
        $msg->setUsuario($usuario);

        $id_usuario = $repositorio->consultarUsuario($usuario);

        if (!$id_usuario) {

            $repositorio->salvarUsuario($usuario);
            $id_usuario = $repositorio->consultarUsuario($usuario);

        } 

        $usuario->setId($id_usuario->getId());
        $repositorio->salvar($msg);

    } 

    require_once __DIR__ . "/../view/formulario-contato.html"; 

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

    class RepositorioMensagem
    {
        private $pdo;

        public function __construct($pdo)
        {
            $this->pdo = $pdo;
        } 

        public function salvar($msg) {

            $sqlGravar = "
                INSERT INTO mensagem
                (id_usuario, assunto, mensagem, status, data)
                VALUES
                (:id_usuario, :assunto, :mensagem, :status, :data)
            ";

            $query = $this->pdo->prepare($sqlGravar);

            $query->execute([
                'id_usuario' => $msg->getUsuario()->getId(),
                'assunto' => strip_tags($msg->getAssunto()),
                'mensagem' => strip_tags($msg->getMensagem()),
                'status' => strip_tags($msg->getStatus()),
                'data' => $msg->getData(),
            ]);

            // OBSERVAÇÃO: Ver lugar adequado para JavaScript
            echo "<script>alert('Mensagem enviada com sucesso!');</script>";
        }

        public function consultarUsuario(Usuario $usuario) {

            //MELHORIA: buscar apenas id
            $sqlBusca = "SELECT * FROM usuario WHERE email = :email";
            $query = $this->pdo->prepare($sqlBusca);
            $query->execute(['email' => $usuario->getEmail(),]);

            $usuario = $query->fetchObject('Usuario');

            return $usuario;
           
        }

        public function salvarUsuario($usuario) {
            
            $sqlGravar = "
                INSERT INTO usuario
                    (nome, email)
                    VALUES
                    (:nome, :email)
            ";

            $query = $this->pdo->prepare($sqlGravar);

            $query->execute([
                'nome' => $usuario->getNome(),
                'email' => $usuario->getEmail(),
            ]);

        }
    }
    
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
     * @author Robson Natanael <natanaelrobson@gmail.com>
     * @copyright 2020 - RN Comunicação & Marketing
     * @license MIT
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
        }

        public function getIdUser($email) {
            $sqlBusca = "SELECT id FROM usuario WHERE email = :email";
            $query = $this->pdo->prepare($sqlBusca);
            $query->execute(['email' => $email]);

            //$id = $query->fetch(PDO::FETCH_OBJ);
            $id = $query->fetch();
            if ($id) {
                return $id['id'];
            }            
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

        public function getLastId() {
            $sql = "SELECT max(id) as max FROM usuario";
            $query = $this->pdo->prepare($sql);
            $query->execute();
            $id = $query->fetch(PDO::FETCH_OBJ);
            return $id->max;
        }
    }
    
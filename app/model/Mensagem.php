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

    namespace app\model;

    class Mensagem
    {       
        private $id;
        private $assunto;
        private $mensagem;
        private $status;
        private $date_send;
        private $id_chat;
        private $id_fornecedor;
        private $usuario;

        public function setId($id) {
            $this->id = $id;
        }

        public function getId() {
            return $this->id;
        }

        public function setAssunto($assunto) {
            $this->assunto = $assunto;
        }

        public function getAssunto() {
            return $this->assunto;
        }

        public function setMensagem($mensagem) {
            $this->mensagem = $mensagem;
        }

        public function getMensagem() {
            return $this->mensagem;
        }

        public function setStatus($status)
        {
            $this->status = $status;
        }

        public function getStatus()
        {
            return $this->status;
        }

        public function setDateSend($date_send)
        {
            $this->date_send = $date_send;
        }

        public function getDateSend()
        {
            return $this->date_send;
        }

        public function setIdChat($id_chat)
        {
            $this->id_chat = $id_chat;
        }

        public function getIdChat()
        {
            return $this->id_chat;
        }

        public function setIdFornecedor($id_fornecedor)
        {
            $this->id_fornecedor = $id_fornecedor;
        }

        public function getIdFornecedor()
        {
            return $this->id_fornecedor;
        }

        public function setUsuario(Usuario $usuario) 
        {
            $this->usuario = $usuario;
        }

        public function getUsuario()
        {
            return $this->usuario;
        }
    }        

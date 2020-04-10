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

    class Mensagem
    {       
        private $id;
        private $assunto;
        private $mensagem;
        private $status;
        private $data;
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

        public function setData($data)
        {
            $this->data = $data;
        }

        public function getData()
        {
            return $this->data;
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

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

     class Usuario
    {       
        private $id;
        private $nome;
        private $email;
        private $fone;

        public function setId($id) {
            $this->id = $id;
        }

        public function getId() {
            return $this->id;
        }

        public function setNome($nome) {
            $this->nome = $nome;
        }

        public function getNome(){
            return $this->nome;
        }

        public function setEmail($email) {
            $this->email = $email;
        }

        public function getEmail() {
            return $this->email;
        }

        public function setFone($fone) {
            $this->fone = $fone;
        }

        public function getFone() {
            return $this->fone;
        }
    }        

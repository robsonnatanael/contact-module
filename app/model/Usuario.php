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

    namespace app\model;
    
    class Usuario
    {       
        private static $conn;
        private $data;
        
        public function __set($propriedade, $value) {
            $this->data[$propriedade] = $value;
        }

        public function __get($propriedade) {
            return $this->data[$propriedade];
        }
    }        

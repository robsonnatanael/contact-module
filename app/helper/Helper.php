<?php

    function validar_metodo_post(){
        if (count($_POST) > 0) {
            return true;
        }

        return false;
    }
    
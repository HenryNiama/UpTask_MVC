<?php

namespace Controllers;

class LoginController{

    public static function login(){
        echo "Desde Login";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            # code...
        }
    }

    public static function logout(){
       echo "Desde Login";
    
    }

    public static function crear(){
        echo "Desde Crear";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            # code...
        }
    }

    public static function olvide(){
        echo "Desde Olvide";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            # code...
        }
    }

    public static function reestablecer(){
        echo "Desde reestablecer";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            # code...
        }
    }

    public static function mensaje(){
        echo "Desde mensaje";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            # code...
        }
    }

    public static function confirmar(){
        echo "Desde confirmar";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            # code...
        }
    }
}

?>
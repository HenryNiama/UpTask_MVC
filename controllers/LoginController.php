<?php

namespace Controllers;

use MVC\Router;

class LoginController{

    public static function login(Router $router){

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            # code...
        }

        // Render a la vista
        $router->render('auth/login', [
            'titulo' => 'Log in'
        ]);
    }

    public static function logout(){
       echo "Desde Login";
    
    }

    public static function crear(Router $router){

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            # code...
        }

        // Render a la vista
        $router->render('auth/crear', [
            'titulo' => 'Sign Up!'
        ]);
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
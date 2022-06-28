<?php

namespace Controllers;

use Model\Usuario;
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
       echo "Desde Logout";
    
    }

    public static function crear(Router $router){

        $usuario = new Usuario;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);

            $alertas = $usuario->validarNuevaCuenta();

            debuguear($alertas);
        }

        // Render a la vista
        $router->render('auth/crear', [
            'titulo' => 'Sign Up!',
            'usuario' => $usuario
        ]);
    }

    public static function olvide(Router $router){

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            # code...
        }

        // Render a la vista
        $router->render('auth/olvide', [
            'titulo' => 'Forgot Password'
        ]);
    }

    public static function reestablecer(Router $router){       

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            # code...
        }

        // Render a la vista
        $router->render('auth/reestablecer', [
            'titulo' => 'Reestablecer Password...'
        ]);
    }

    public static function mensaje(Router $router){


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            # code...
        }

        $router->render('auth/mensaje', [
            'titulo' => 'Cuenta creada exitosamente'
        ]);
    }

    public static function confirmar(Router $router){

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            # code...
        }
        
        $router->render('auth/confirmar', [
            'titulo' => 'Confirma tu Cuenta'
        ]);
    }
}

?>
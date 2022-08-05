<?php

namespace Controllers;

use Classes\Email;
use MVC\Router;
use Model\Usuario;


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

        $alertas = [];
        $usuario = new Usuario;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();
            // debuguear($alertas);

            if (empty($alertas)) {
                $existeUsuario = Usuario::where('email', $usuario->email);
                // debuguear($existeUsuario);
                if ($existeUsuario) {
                    Usuario::setAlerta('error', 'El Usuario '. $usuario->nombre . ' ya esta registrado.');
                    $alertas = Usuario::getAlertas();
                }else{
                    // Hashear el password
                    $usuario->hashPassword();

                    // Eliminar password2
                    unset($usuario->password2);

                    // Generar el Token
                    $usuario->crearToken();

                    // debuguear($usuario);

                    // Crear nuevo usuario
                    $resultado = $usuario->guardar();

                    // Enviar email
                    // $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    // $email->enviarConfirmacion();
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarConfirmacion();

                    // debuguear($email);
                    
                    if ($resultado) {
                        header('Location: /mensaje');
                    }
                }
            }
        }

        // Render a la vista
        $router->render('auth/crear', [
            'titulo' => 'Sign Up!',
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    public static function olvide(Router $router){

        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = new Usuario($_POST);
            $alertas = $usuario->validarEmail();

            if (empty($alertas)) {
                # code...
            }
        }

        // Render a la vista
        $router->render('auth/olvide', [
            'titulo' => 'Forgot Password',
            'alertas' => $alertas
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

        $token = s($_GET['token']);
        // debuguear($token);

        // Si no hay un token, lo envio a la pagina principal
        if(!$token) header('Location: /');

        // Encontrar al usuario con este token
        $usuario = Usuario::where('token', $token);

        // debuguear($usuario);

        if(empty($usuario)){
            // No se encontro un usuario con ese token.
            Usuario::setAlerta('error', 'Token No Valido');
        }else{
            // Confirmar la cuenta
            $usuario->confirmado = 1;
            $usuario->token = null;
            unset($usuario->password2);

            $usuario->guardar();

            Usuario::setAlerta('exito', 'Cuenta comprobada correctamente.');
        }

        $alertas = Usuario::getAlertas();

        
        $router->render('auKth/confirmar', [
            'titulo' => 'Confirma tu Cuenta',
            'alertas'=> $alertas
        ]);
    }
}

?>
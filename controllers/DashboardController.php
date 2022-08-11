<?php

namespace Controllers;

use MVC\Router;
use Model\Proyecto;

class DashboardController{

    public static function index(Router $router){

        session_start();

        isAuth();

        $router->render('dashboard/index', [
            'titulo' => 'Proyectos'
        ]);
    }

    public static function crear_proyecto(Router $router)
    {
        session_start();

        isAuth();

        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $proyecto = new Proyecto($_POST);
            // debuguear($proyecto);

            // validacion
            $alertas = $proyecto->validarProyecto();
        }
        
        $router->render('dashboard/crear-proyecto', [
            'alertas' => $alertas,
            'titulo' => 'Crear Proyecto'
        ]);
    }

    public static function perfil(Router $router)
    {
        session_start();
        
        $router->render('dashboard/perfil', [
            'titulo' => 'Perfil'
        ]);
    }

}

?>
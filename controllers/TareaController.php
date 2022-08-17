<?php

namespace Controllers;

use Model\Tarea;
use Model\Proyecto;

class TareaController{

    public static function index()
    {
        
    }

    public static function crear()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            session_start();

            $urlProyecto = $_POST['url']; // Esta parte viene del JS agregarTarea()

            $proyecto = Proyecto::where('url', $urlProyecto);

            if (!$proyecto || $proyecto->propietarioId !== $_SESSION['id']) {

                $respuesta = [
                    'tipo' => 'error',
                    'mensaje' => 'Hubo un error al agregar la tarea.'
                ];

                echo json_encode($respuesta); 

                return;
            }

            $tarea = new Tarea($_POST);

            $tarea->proyectoId = $proyecto->id;

            $resultado = $tarea->guardar();

            $respuesta = [
                'tipo' => 'exito',
                'id' => $resultado['id'],
                'mensaje' => 'Tarea Creada correctamente.'
            ];

            echo json_encode($respuesta);
            // echo json_encode($tarea);
            

        }

    }

    public static function actualizar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            # code...
        }
    }

    public static function eliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            # code...
        }
    }
}

?>
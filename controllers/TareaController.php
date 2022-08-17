<?php

namespace Controllers;

use Model\Proyecto;

class TareaController{

    public static function index()
    {
        
    }

    public static function crear()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            session_start();

            $proyectoId = $_POST['proyectoId']; // Esta parte viene del JS agregarTarea()

            $proyecto = Proyecto::where('url', $proyectoId);

            if (!$proyecto || $proyecto->propietarioId !== $_SESSION['id']) {

                $respuesta = [
                    'tipo' => 'error',
                    'mensaje' => 'Hubo un error al agregar la tarea.'
                ];

                echo json_encode($respuesta); 

                return;
            }else {
                $respuesta = [
                    'tipo' => 'exito',
                    'mensaje' => 'Tarea agregada correctamente.'
                ];

                echo json_encode($respuesta); 
            }

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
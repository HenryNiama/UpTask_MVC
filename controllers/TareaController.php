<?php

namespace Controllers;

use Model\Tarea;
use Model\Proyecto;

class TareaController{

    public static function index()
    {

        session_start();

        $proyectoId = $_GET['id'];// En realidad es la url del proyecto, este esta en la url de la pagina como id

        if (!$proyectoId) header('Location: /dashboard');

        $proyecto = Proyecto::where('url', $proyectoId);

        if(!$proyecto || $proyecto->propietarioId !== $_SESSION['id']) header('Location: /404');

        $tareas = Tarea::belongsTo('proyectoId', $proyecto->id);

        // debuguear($tareas);
        
        echo json_encode(['tareas' => $tareas]);
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
                'mensaje' => 'Tarea Creada correctamente.',
                'proyectoId' => $proyecto->id
            ];

            echo json_encode($respuesta);
            // echo json_encode($tarea);
        }

    }

    public static function actualizar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validar que el proyecto exista
            $proyecto = Proyecto::where('url', $_POST['url']);

            session_start();

            if (!$proyecto || $proyecto->propietarioId !== $_SESSION['id']) {

                $respuesta = [
                    'tipo' => 'error',
                    'mensaje' => 'Hubo un error al actualizar la tarea.'
                ];

                echo json_encode($respuesta); 
                return;
            }

            $tarea = new Tarea($_POST);
            $tarea->proyectoId = $proyecto->id;

            $resultado = $tarea->guardar();

            if ($resultado) {

                $respuesta = [
                    'tipo' => 'exito',
                    'id' => $tarea->id,
                    'proyectoId' => $proyecto->id,
                    'mensaje' => 'Actualizado correctamente'
                ];

                echo json_encode(['respuesta' => $respuesta]);
            }

        }
    }

    public static function eliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Validar que el proyecto exista
            $proyecto = Proyecto::where('url', $_POST['url']);

            session_start();

            if (!$proyecto || $proyecto->propietarioId !== $_SESSION['id']) {

                $respuesta = [
                    'tipo' => 'error',
                    'mensaje' => 'Hubo un error al actualizar la tarea.'
                ];

                echo json_encode($respuesta); 
                return;
            }

            $tarea = new Tarea($_POST);

            $respuesta = $tarea->eliminar();

            $resultado = [
                'resultado' => $respuesta,
                'mensaje' => 'Eliminado correctamente',
                'tipo' => 'exito'
            ];

            echo json_encode($resultado);
        }
    }
}

?>
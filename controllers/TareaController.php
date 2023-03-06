<?php

namespace Controllers;

use Model\Proyecto;
use Model\Tarea;


class TareaController {

    public static function index() {
        isAuth();
        $url = $_GET['url'];
        if (!$url) header('Location: /dashboard');
        $proyecto = Proyecto::where('url', $url);
        if (!$proyecto || $proyecto->propietarioId !== $_SESSION['id']) header('Location: /notfn');

        $tareas = Tarea::belongsTo('proyectoId', $proyecto->id);
        echo json_encode(['tareas' => $tareas]);
    }

    public static function crear() {
        isAuth();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $url = $_POST['url'];
            $proyecto = Proyecto::where('url', $url);
            if(!$proyecto || $proyecto->propietarioId !== $_SESSION['id']) {
                $respuesta = [
                    'tipo' => 'error',
                    'mensaje' => 'Hubo un error porque no se encontró el proyecto'
                ];
            } else {
                // Agregar la tarea a la BD
                $tarea = new Tarea($_POST);
                $tarea->proyectoId = $proyecto->id;
                $resultado = $tarea->guardar();
                if ($resultado) {
                    $respuesta = [
                        'tipo' => 'exito',
                        'mensaje' => 'Tarea agregada correctamente',
                        'id' => $resultado['id'],
                        'proyectoId' => $proyecto->id
                    ];
                } else {
                    $respuesta = [
                        'tipo' => 'error',
                        'mensaje' => 'Hubo un error al agregar la tarea'
                    ];
                }
            }
            echo json_encode($respuesta);   
        }
    }

    public static function actualizar() {
        isAuth();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validar que el proyecto exista
            $proyecto = Proyecto::where('url', $_POST['url']);
            
            if(!$proyecto || $proyecto->propietarioId !== $_SESSION['id']) {
                $respuesta = [
                    'tipo' => 'error',
                    'mensaje' => 'Hubo un error al actualizar la tarea'
                ];
            } else {
                // Actualizar la tarea en la BD
                $tarea = new Tarea($_POST);
                $resultado = $tarea->guardar();
                if ($resultado) {
                    $respuesta = [
                        'tipo' => 'exito',
                        'mensaje' => 'Tarea actualizada correctamente',
                        'id' => $tarea->id,
                        'proyectoId' => $proyecto->id
                    ];
                } else {
                    $respuesta = [
                        'tipo' => 'error',
                        'mensaje' => 'Hubo un error al actualizar la tarea'
                    ];
                }
            }
            echo json_encode($respuesta); 
        }
    }

    public static function eliminar() {
        isAuth();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validar que el proyecto exista
            $proyecto = Proyecto::where('url', $_POST['url']);
            
            if(!$proyecto || $proyecto->propietarioId !== $_SESSION['id']) {
                $respuesta = [
                    'tipo' => 'error',
                    'mensaje' => 'Hubo un error al eliminar la tarea'
                ];
            } else {
                // Eliminar la tarea en la BD
                $tarea = new Tarea($_POST);
                $resultado = $tarea->eliminar();
                if ($resultado) {
                    $respuesta = [
                        'tipo' => 'exito',
                        'mensaje' => 'Tarea eliminada correctamente',
                        'id' => $tarea->id,
                        'proyectoId' => $proyecto->id
                    ];
                } else {
                    $respuesta = [
                        'tipo' => 'error',
                        'mensaje' => 'Hubo un error al eliminar la tarea'
                    ];
                }
            }
            echo json_encode($respuesta);
        }
    }

    
}
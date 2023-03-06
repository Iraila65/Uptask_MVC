<?php

namespace Controllers;

use Model\Proyecto;
use MVC\Router;
use Model\Usuario;

class DashboardController {

    public static function index(Router $router) {
        isAuth();

        $proyectos = Proyecto::belongsTo('propietarioId', $_SESSION['id']);

        $router->render('dashboard/index', [
            'titulo' => 'Proyectos',
            'nombre' => $_SESSION['nombre'],
            'proyectos' => $proyectos
        ]);
    }

    public static function crear(Router $router) {
        isAuth();
        $alertas = [];
        $proyecto = new Proyecto();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $proyecto = new Proyecto ($_POST);
            $alertas = $proyecto->validar();
            if (empty($alertas)) {
                // Generar una url única
                $proyecto->url = md5(uniqid());

                // Almacenar el id del propietario
                $proyecto->propietarioId = $_SESSION['id'];

                $proyecto->guardar();
                Header('Location:/proyecto?url='.$proyecto->url);
            }

        }

        $router->render('dashboard/crear-proyecto', [
            'titulo' => 'Crear Proyecto',
            'nombre' => $_SESSION['nombre'],
            'alertas'=> $alertas,
            'proyecto' => $proyecto
        ]);
    }

    public static function proyecto(Router $router) {
        isAuth();
        $alertas = [];

        // Leer el proyecto de la base de datos
        $token = $_GET['url'];
        if (!$token) header('Location: /dashboard');
        $proyecto = Proyecto::where('url', $token);
        // Validar que la persona que visita el proyecto es quien lo creó
        if ($proyecto->propietarioId !== $_SESSION['id']) {
            header('Location: /dashboard');
        }

        $router->render('dashboard/proyecto', [
            'titulo' => $proyecto->proyecto,
            'nombre' => $_SESSION['nombre'],
            'alertas'=> $alertas,
            'proyecto' => $proyecto
        ]);
    }

    public static function perfil($router) {
        isAuth();
        $alertas = [];
        $usuario = Usuario::find($_SESSION['id']);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $usuario->sincronizar($_POST);
            
            $alertas = $usuario->validarPerfil();
            if (empty($alertas)) {
                $usuario->guardar();

                // Reescribimos la sesión con los cambios
                $_SESSION['nombre'] = $usuario->nombre." ".$usuario->apellido;
                $_SESSION['usuario'] = $usuario->email;

                Usuario::setAlerta('exito', 'Cambios realizados correctamente');
                
            }            
        }

        $alertas = Usuario::getAlertas();
        $router->render('dashboard/perfil', [
            'titulo' => 'Perfil',
            'nombre' => $_SESSION['nombre'], 
            'alertas' => $alertas,
            'usuario' => $usuario
        ]);
    }

    public static function cambiarPass($router) {
        isAuth();
        $alertas = [];
        $usuario = Usuario::find($_SESSION['id']);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $usuario->sincronizar($_POST);
            
            $alertas = $usuario->validarNuevoPass();
            if (empty($alertas)) {
                $alertas = $usuario->validarPassActual();
            
                if (empty($alertas)) {
                    // Hashear la nueva password
                    $usuario->password = $usuario->new_pass;
                    $usuario->hashPasword();

                    // Los eliminamos para que no queden en memoria
                    unset($usuario->pass_actual);
                    unset($usuario->new_pass);

                    $resultado = $usuario->guardar();
                    if ($resultado) {
                        Usuario::setAlerta('exito', 'Password cambiada correctamente');
                    } else {
                        Usuario::setAlerta('error', 'Hubo un error al guardar la Password, inténtelo de nuevo');
                    }
                    
                }                
            }            
        }

        $alertas = Usuario::getAlertas();
        $router->render('dashboard/cambiar-pass', [
            'titulo' => 'Cambiar Password',
            'nombre' => $_SESSION['nombre'], 
            'alertas' => $alertas,
            'usuario' => $usuario
        ]);
    }

}
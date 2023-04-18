<?php

namespace Controllers;

// Pasamos llamamos el router

use Classes\Email;
use MVC\Router;
use Model\Usuario;

class CitaControllers{
    public static function index(Router $router){

        // si no  hemos iniciado sesion, lo inisiamos
        if(!isset($_SESSION)) {
            session_start();
        }

        //caso tal no este iniciado session se manda al login
        isAuth();

        if (!isset($_SESSION['nombre'])){
            header('Location: /');
        }


        // Pasamos a la vista
        $router->render('cita/index',[
            'nombre' => $_SESSION['nombre'],
            'id' => $_SESSION['id']
        ]);
    }
}
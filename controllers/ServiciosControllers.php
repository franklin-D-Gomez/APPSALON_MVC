<?php

namespace Controllers;

use Model\Servicio;
use MVC\Router;

class ServiciosControllers{
    public static function index(Router $router){
        // echo "desde servicios";

        isAdmin();

        // Traernos todos los servicios
        $servicios = Servicio::all();
        
        // la vista
        $router->render('servicios/index',[
            'nombre' => $_SESSION['nombre'],
            'servicios' => $servicios
        ]);
    }

    public static function crear(Router $router){
        // echo "desde crear";
        isAdmin();
        $servicio = new Servicio(); // el modelo de servicio vacio
        $alertas = []; // definimos la variable

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $servicio->sincronizar($_POST); // Leyendo los datos del post para que se queden en el campo 
        
            $alertas = $servicio->validar(); // alertas de validacion de los campos llenados correctamente
        
            if(empty($alertas)){

                $servicio->guardar(); // guardamos el nuevo servicio 
                
                header('Location: /servicios');

            }
        }

        $router->render('servicios/crear',[
            'nombre' => $_SESSION['nombre'],
            'servicio' => $servicio,
            'alertas' => $alertas
        ]);
    }

    public static function actualizar(Router $router){
        //echo "desde actualizar";
        isAdmin();

        if(!is_numeric($_GET['id'])) return;
        $servicio = servicio::find($_GET['id']); // el modelo con la informacion del id que buscamos
        $alertas = [];

        

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
           
            $servicio->sincronizar($_POST); //sincronizar el ultimo valor

            $alertas = $servicio->validar();  // Validar las alertas

            if(empty($alertas)){ // si no tenemos errores en $alertas.
                $servicio->guardar();
                header('Location:/servicios');
            }

        }

        $router->render('servicios/actualizar',[
            'nombre' => $_SESSION['nombre'],
            'alertas' => $alertas,
            'servicio'=> $servicio

        ]);
    }
    

    public static function eliminar(){
        // echo "desde eliminar";
        isAdmin();

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //debuguear($_POST); // nos mostrara el id del  servicio seleccionado

            $id = $_POST['id']; // recogemos el id 

            $servicio = Servicio::find($id);// usando el id buscamos el objeto del servicio

            $servicio->eliminar(); // lo eliminamos de la base de datos

            header('Location:/servicios'); // rediccionaremos 
        }
    }

}
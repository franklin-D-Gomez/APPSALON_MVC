<?php

namespace Controllers;

use Model\Cita;
use Model\CitaServicio;
use Model\Servicio;

class APIControllers{
    public static function index(){

        // nos traemos un arreglo que contendra los objetos de todos los servicios
        $servicios = Servicio::all();
        echo json_encode($servicios);

    }

    // Informacion que vamos a guardar para luego mandar a la base de datos
    public static function guardar(){
        //objeto de cita
        $cita = new Cita($_POST);
        //Almacena la Cita y devuelve el id
        $resultado = $cita->guardar();

        $id = $resultado['id'];  // extraemos id de la cita
        //Almacena la cita y el servicio

        $idServicios = explode("," , $_POST['servicios']);

        // // almacena los servicios con el id de la cita
        foreach($idServicios as $idServicio){
            $args = [
                'citaId' => $id,
                'servicioId' => $idServicio
            ];

            $citaServicio = new CitaServicio($args); // guardamos el id de la cita y el id de servicio en nuestro modelo
            $citaServicio->guardar(); //  guardamos el mondelo en la base de datos
        }
        
        //vemos el resultado de la base de datos
        echo json_encode(['resultado' => $resultado]);

    }

    public static function eliminar(){
        
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            
            $id = $_POST['id']; // Recogemos y almacenamos  el $id
            $cita = Cita::find($id); // Buscamos nuestro $id en la base de dats
            $cita->eliminar(); // eliminamos esa cita por  id 
            header('Location:' . $_SERVER['HTTP_REFERER']); // Redireccionamos al usuario
        
        }

    }

}
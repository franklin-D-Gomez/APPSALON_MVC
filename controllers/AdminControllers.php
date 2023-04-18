<?php   

namespace Controllers;

use Model\AdminCita;
use MVC\Router;

class AdminControllers{

    public static function index ( Router $router){
        
        //Comprobamos que es adminm
        isAdmin();

        // debuguear($_GET); // verificamos que ya nos traimos las fechas

        $fecha = $_GET['fecha'] ?? Date('Y-m-d'); // almacenamos la fecha
        $fechas = explode('-',$fecha); // separamos la fecha en tres arreglos
        // debuguear($fechas);
        if( !checkdate($fechas[1], $fechas[2], $fechas[0])){ // validamos la fecha
            header('Location: /404 ');
        }

        // estraemos la fecha del servidor con el formato de nuestra base de datos
        
 
        // Consultar la base de datos
        $consulta = "SELECT citas.id, citas.hora, CONCAT( usuarios.nombre, ' ', usuarios.apellido) as cliente, ";
        $consulta .= " usuarios.email, usuarios.telefono, servicios.nombre as servicio, servicios.precio  ";
        $consulta .= " FROM citas  ";
        $consulta .= " LEFT OUTER JOIN usuarios ";
        $consulta .= " ON citas.usuarioId=usuarios.id  ";
        $consulta .= " LEFT OUTER JOIN citasServicios ";
        $consulta .= " ON citasServicios.citaId=citas.id ";
        $consulta .= " LEFT OUTER JOIN servicios ";
        $consulta .= " ON servicios.id=citasServicios.servicioId ";
        $consulta .= " WHERE fecha =  '$fecha' ";

        $citas = AdminCita::SQL($consulta);

        // debuguear($citas);

        $router -> render('admin/index',[
            'nombre' => $_SESSION['nombre'],
            'citas' => $citas,
            'fecha' => $fecha
        ]);
    }

}

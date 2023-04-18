<?php

namespace Controllers;

// Pasamos llamamos el router

use Classes\Email;
use MVC\Router;
use Model\Usuario;

class LoginControllers{
    public static function login(Router $router){

        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $auth = new Usuario($_POST);

            $alertas = $auth->validarLogin();

            // Como los campos del login estan llenos, $alertas estara vacio
            if(empty($alertas)){
                // Comprobar que exista el usuario por medio del email
                $usuario = Usuario::where('email', $auth->email);

                if($usuario){
                    // Verificar el password
                    if ( $usuario->comprobarPasswordAndVerificado($auth->password) ){
                        // Autenticar el usuario
                        session_start();

                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;

                        //Redireccionamiento
                        if($usuario->admin === "1"){
                            // si es admin
                            $_SESSION['admin'] = $usuario->admin ?? null;
                            // Redireccionamiento
                            header('Location: /admin');
                        } else {
                            // si es cliente
                            // Redireccionamiento
                            header('Location: /cita');
                        }
 
                        debuguear($_SESSION);

                    }

                }else{
                    // si el usuario no se encuentra manda error
                    Usuario::setAlerta('error', 'Usuario No Se encontro');
                }

            }

            $alertas = Usuario::getAlertas();

        }

        // Pasando a la vista
        $router -> render ('/auth/login',[
            'alertas' => $alertas
        ]);
    }

    // Cerrar sesion
    public static function logout(){
        // si no  hemos iniciado sesion, lo inisiamos
        if(!isset($_SESSION)) {
            session_start();
        }
        
        $_SESSION = [];

        header('Location: /');
    }

    // Para cambiar Contraseña
    public static function olvide(Router $router){

        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $auth = new Usuario($_POST);

            $alertas = $auth->validarEmail();

            // Validar usuario exista y este confirmado
            if(empty($alertas)){
                // Buscamos la informacion del usuario a traves del correo ingresado
                $usuario = Usuario::where('email', $auth->email);

                // Si incontramos el usuario y tiene confirmado en 1
                if($usuario && $usuario->confirmado === "1" ){
                    // Generar un nuevo token para poder cambiar contraseña
                    $usuario->crearToken();
                    
                    // Como tenemos id actualizamos el usuario
                    $usuario->guardar();

                    // Enviar el email e instrucciones
                    $email = new Email( $usuario->email , $usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();
                    // alerta de exito
                    Usuario::setAlerta('exito', 'Revisa tu email'); // Set para agregar alertas
                    
                }else{

                    // en caso  de que el usuario no fue encontrado o no este confirmado
                    Usuario::setAlerta('error', 'El usuario no existe o no esta Confirmado'); // Set para agregar alertas
                
                }

            }

        }

        $alertas = Usuario::getAlertas(); // Obtener las alertas

        // Pasando a la vista
        $router -> render ('/auth/olvide-password',[
            'alertas' => $alertas
        ]);
    }

    public static function recuperar(Router $router){
        
        $alertas = [];
        $error = false;

        // leer el token 
        $token = s($_GET['token']);

        // Buscar usuario por su token
        $usuario = Usuario::where('token',$token);

        // Si no encontramos el usuario
        if(empty($usuario)){
            Usuario::setAlerta('error', 'Token no valido');
            $error = true;
        } 

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            // leer el nuevo password y guardarlo

            // Guardando el nuevo password 
            $password = new Usuario($_POST);

            // validando el password
            $alertas = $password->validarPassword();

            if(empty($alertas)){
                //eliminamos el password viejo del usuario
                $usuario->password = null;

                //agregar la nueva password al objeto de usuario
                $usuario->password = $password->password;

                //hasehamos el nuevo password
                $usuario->hashPassword();

                //Eliminamos el token
                $usuario->token = null;

                //actualizamos la base de datos
                $resultado = $usuario->guardar();

                //habiendo cambiado la password redireccionamos al usuario al login
                if($resultado){
                    header('Location: /');
                }
            }

        }

        //obtener las alertas
        $alertas = Usuario::getAlertas();

        // Pasando a la vista
        $router -> render ('/auth/recuperar-password',[
            'alertas' => $alertas,
            'error' => $error
        ]);
    }

    public static function crear(Router $router){
        
        // Instanciar usuario
        $usuario = new Usuario;

        // Alertas Vacias
        $alertas = [];
        
        // cuando se le da en el boton de crear cuenta
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            //guardando lo que esta en memoria en nuestra variable de usuario
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();
            

            // Revisar que alerta este vacio
            if(empty($alertas)){
                // Verificar que el usuario no este registrado 
                $resultado = $usuario->existeUsuario();

                // si el usuario esta registrado
                if( $resultado->num_rows ){
                    // tuvimos que crear instanciar usuario por que $alerta esta en modo protectec
                    $alertas = Usuario::getAlertas();
                } else {
                    // no esta registrado
                    $usuario->hashPassword();

                    //Generear un Token unico
                    $usuario->crearToken();

                    // Instanciar el email
                    $email = new Email($usuario->email , $usuario->nombre, $usuario->token);
                    
                    // Mandar el email 
                    $email->enviarConfirmacion();

                    // Crear el usuario
                    $resultado = $usuario->guardar();

                    
                    // si se guardo correctamente
                    if($resultado){
                        header('Location:/mensaje');
                    }
                }
            }

        }
        
        // Pasando a la vista
        $router -> render ('/auth/crear-cuenta',[
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    public static function mensaje(Router $router){
        
        // Pasando a la vista
        $router -> render ('/auth/mensaje',[

        ]);

    }

    public static function confirmar(Router $router){

        $alertas = [];

        //recolectamos el token de la URL's
        $token = s($_GET['token']);

        // Busca en la base de datos
        $usuario = Usuario::where('token', $token);

        if(empty($usuario)){
            // Mostrar mensaje de error
            Usuario::setAlerta('error','Token no Valido'); // creamos la alertas

        } else {
            // Modificar a usuario confirmado
            $usuario->confirmado = '1'; // como es valido lo confirmamos
            $usuario->token = ""; // eliminamos el token del usuario
            $usuario->guardar();
            Usuario::setAlerta('exito','Cuenta Comprobada Correctamente');
        }

        // leemos la alerta 
        $alertas = Usuario::getAlertas();

        // Renderizar la vista
        $router->render('auth/confirmar-cuenta',[
            'alertas' => $alertas // mostramos la alerta
        ]);
    }

}
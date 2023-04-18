<?php

namespace Model;


// clase de usuario hereda de ActiveRecord
class Usuario extends ActiveRecord{
    // Base de datos
    protected static $tabla = 'usuarios'; // tabla en la que va a encontrar los datos
    protected static $columnasDB = ['id','nombre','apellido','email','password',
    'telefono','admin','confirmado','token']; // normalizar los datos, va a recorrer e insertar los datos


    // Creando un atributo por cada columna
    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;

    // Creando el construct para la nueva instancia
    public function __construct(  $args = [] ){
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '0';
        $this->telefono = $args['telefono'] ?? '';
        $this->admin = $args['admin'] ?? '0';
        $this->confirmado = $args['confirmado'] ?? '0';
        $this->token = $args['token'] ?? '';
    }

    // Mensajes de validacion para la creacion de una cuenta
    public function validarNuevaCuenta(){
        //this hace referencia a este mismo objeto, self para hacer uso de $alertas que se hereda de activerecord
        if(!$this->nombre){ // si el campo esta vacio
            self::$alertas['error'][] = 'El nombre es obligatorio';
        }

        if(!$this->apellido){
            self::$alertas['error'][] = 'El apellido es obligatorio';
        }

        if(!$this->telefono){
            self::$alertas['error'][] = 'El telefono es obligatorio';
        }

        if(!$this->email){
            self::$alertas['error'][] = 'El email es obligatorio';
        }

        if(!$this->password){
            self::$alertas['error'][] = 'El password es obligatorio';
        }

        if(strlen($this->password) < 6 ){ // strlen nos devuelve la longitud
            self::$alertas['error'][] = 'El password debe contener al menos 6 caracteres';
        }

        return self::$alertas;

    }

    public function validarLogin(){

        if(!$this->email){ // si el campo esta vacio
            self::$alertas['error'][] = 'El email es obligatorio';
        }

        if(!$this->password){
            self::$alertas['error'][] = 'El password es obligatorio';
        }

        return self::$alertas;
    }


    public function validarEmail(){
        if(!$this->email){ // si el campo esta vacio
            self::$alertas['error'][] = 'El email es obligatorio';
        }

        return self::$alertas;
    }

    public function validarPassword(){
        if(!$this->password){
            self::$alertas['error'][] = 'El password es obligatorio';
        }

        if(strlen($this->password) < 6 ){ // strlen nos devuelve la longitud
            self::$alertas['error'][] = 'El password debe contener al menos 6 caracteres';
        }

        return self::$alertas;
    }

    // Revisa si el usuario ya existe
    public function existeUsuario(){
        $query = " SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";

        // le pasamos el comando a la base de datos
        $resultado = self:: $db->query($query);

        if($resultado->num_rows){
            self::$alertas['error'][] = 'El Usuario ya esta registrado';
        }

        return $resultado;
    }

    // Hashear password
    public function hashPassword(){
        $this->password = password_hash($this->password , PASSWORD_BCRYPT);
    }

    // Crear el token por usuario
    public function crearToken(){
        $this->token = uniqid();
    }

    public function comprobarPasswordAndVerificado($password){
        //Comparamos ambas password    
        $resultado = password_verify($password, $this->password);

        // Varificar si esta confirmado o no 
        if(!$resultado || !$this->confirmado){
            self::$alertas['error'][] = 'Password Incorrecto o tu cuenta no ha sido confirmada';
        }else{
            return true;
        }

    }

}
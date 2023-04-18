<?php

namespace Model;

class AdminCita extends ActiveRecord{
    protected static $tabla = 'citasservicios';
    protected static $columnasDB = ['id','hora','cliente','email','telefono','servicio','precio'];

    // Atributos
    public $id;
    public $hora;
    public $cliente;
    public $email;
    public $telefono;
    public $servicio;
    public $precio;

    // constructor
    public function __construct($args = []){

        $this->id = $args['id'] ?? null;
        $this->hora = $args['hora'] ?? '';
        $this->cliente = $args['cliente'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->servicio = $args['servicio'] ?? '';
        $this->precio = $args['precio'] ?? '';
    
    }

}
<?php



require __DIR__ . '/../vendor/autoload.php';

//  Como leer nuestro archivo de .env con las credenciales 
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__); //forma de usar el dotenv
$dotenv->safeload(); // si el archivo no existe no nos marcara error

require 'funciones.php';
require 'database.php';


// Conectarnos a la base de datos
use Model\ActiveRecord;
ActiveRecord::setDB($db);
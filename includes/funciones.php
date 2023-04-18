<?php

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

// detecta el ultimo elemento
function esUltimo(string $actual, string $proximo): bool {

    if($actual != $proximo){
        return true;
    }
    return false;
}   


// Funcion que revisa que el usuario esta autenticado
function isAuth(): void{
    // sino esta definido esta variable de login lo mandad para login por que no esta autenticado
    if(!isset($_SESSION['login'])){
        header('Location: /');
    }
}

function isAdmin() : void{
    if(!isset($_SESSION['admin'])){
        header('Location: /');
    }
}
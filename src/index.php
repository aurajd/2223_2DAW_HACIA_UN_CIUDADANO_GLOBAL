<?php 

require_once __DIR__.'/php/config/config.php';
require_once __DIR__.'/php/config/configdb.php';


if(isset($_GET["controller"])) {
    $nombreControlador = $_GET["controller"];
} else{
    //Si no se ha enviado un controlador por url se toma el controlador por defecto (el menú principal)
    $nombreControlador = constant("DEFAULT_CONTROLLER");
}


$nombreMetodo = $_GET["action"] ?? '';

$rutaControlador = __DIR__.'/php/controladores/'.$nombreControlador.'.php';

/* Comprueba que el controlador enviado por url existe y si no utiliza el controlador por defecto */
if(!file_exists($rutaControlador)){
    $rutaControlador = __DIR__.'/php/controladores/'.constant("DEFAULT_CONTROLLER").'.php';
    $nombreControlador = constant("DEFAULT_CONTROLLER");
}


// Carga el controlador
require_once $rutaControlador;
$nombreClaseControlador = $nombreControlador.'Controller';
$controlador = new $nombreClaseControlador();

// Si el método existe lo llama y guarda lo que devuelve en una variable
$dataToView["data"] = array();
if(method_exists($controlador,$nombreMetodo)) $dataToView["data"] = $controlador->{$nombreMetodo}();

/* Carga las vistas */
require_once __DIR__.'/php/vistas/template/header.php';
require_once __DIR__.'/php/vistas/'.$controlador->view.'.php';
require_once __DIR__.'/php/vistas/template/footer.php';


?>
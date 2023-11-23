<?php 

require_once __DIR__.'/php/config/config.php';
require_once __DIR__.'/php/config/configdb.php';


if(isset($_GET["controller"])) {
    $nombreControlador = $_GET["controller"];
} else{
    //Si no se ha enviado un controlador por url se toma el controlador por defecto (el menú principal)
    $nombreControlador = constant("DEFAULT_CONTROLLER");
}

if(isset($_GET["action"])) {
    $nombreMetodo = $_GET["action"];
} else{
    //Si no se ha enviado un método por url se toma el método que se encuentra como constante en el  (el menú principal)
    $nombreMetodo = constant("DEFAULT_ACTION");
}

$rutaControlador = __DIR__.'/php/controladores/'.$nombreControlador.'.php';

// Carga el controlador
require_once $rutaControlador;
$nombreClaseControlador = $nombreControlador.'Controller';
$controlador = new $nombreClaseControlador();

/* Check if method is defined */

$dataToView["data"] = array();
if(method_exists($controlador,$nombreMetodo)) $dataToView["data"] = $controlador->{$nombreMetodo}();


/* Load views */
require_once __DIR__.'/php/vistas/template/header.php';
require_once __DIR__.'/php/vistas/'.$controlador->view.'.php';
require_once __DIR__.'/php/vistas/template/footer.php';


?>
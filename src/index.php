<?php 

require_once __DIR__.'/php/config/config.php';
require_once __DIR__.'/php/config/configdb.php';


if(!isset($_GET["controller"])) $_GET["controller"] = constant("DEFAULT_CONTROLLER");
if(!isset($_GET["action"])) $_GET["action"] = constant("DEFAULT_ACTION");

$controller_path = 'controladores/'.$_GET["controller"].'.php';

/* Check if controller exists */
if(!file_exists($controller_path)) $controller_path = __DIR__.'/php/controladores/'.constant("DEFAULT_CONTROLLER").'.php';

/* Load controller */
require_once $controller_path;
$controllerName = $_GET["controller"].'Controller';
$controller = new $controllerName();

/* Check if method is defined */

$dataToView["data"] = array();
if(method_exists($controller,$_GET["action"])) $dataToView["data"] = $controller->{$_GET["action"]}();


/* Load views */
require_once __DIR__.'/php/vistas/'.$controller->view.'.php';

?>
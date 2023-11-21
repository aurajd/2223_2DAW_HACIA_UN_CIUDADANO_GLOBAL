<?php
// Incluye el archivo del modelo que se utiliza en este controlador
require_once __DIR__.'/../modelos/problema.php';

/**
 * Clase Controlador para manejar la lógica de negocio relacionada con situaciones o problemas.
 */
class situacionController{

    // Propiedades de la clase
    public $view;

    // Constructor de la clase que inicializa el modelo
    public function __construct() {
    }

    function menu(){
        $this->view = "menu_situacion";
    }

    
}

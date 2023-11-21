<?php
// Incluye el archivo del modelo que se utiliza en este controlador
require_once __DIR__.'/../modelos/conflicto.php';

/**
 * Clase Controlador para manejar la lógica de negocio relacionada con situaciones o problemas.
 */
class conflictoController{

    // Propiedades de la clase
    public $modelo;
    public $view;

    // Constructor de la clase que inicializa el modelo
    public function __construct() {
        $this->modelo = new conflictoModel();
    }

    function menu(){
        $this->view = "menu_conflicto";
    }

    function listar(){
        $this->view = "listar_conflicto";
        return $this->modelo->listar();
    }
}

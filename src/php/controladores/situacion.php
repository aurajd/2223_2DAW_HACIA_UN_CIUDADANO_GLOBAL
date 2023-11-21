<?php
// Incluye el archivo del modelo que se utiliza en este controlador
require_once __DIR__.'/../modelos/situacion.php';

/**
 * Clase Controlador para manejar la lógica de negocio relacionada con situaciones o problemas.
 */
class situacionController{

    // Propiedades de la clase
    public $titulo;
    public $controladorVolver;
    public $accionVolver;
    public $modelo;
    public $view;

    // Constructor de la clase que inicializa el modelo
    public function __construct() {
        $this->modelo = new situacionModel();
        $this->titulo = '';
        $this->controladorVolver = "";
        $this->accionVolver = "";
    }

    function menu(){
        $this->view = "menu_situacion";
        $this->titulo = 'Menú situaciones';
    }

    
}

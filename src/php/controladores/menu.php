<?php


/**
 * Clase Controlador para manejar la lógica de negocio relacionada con situaciones o problemas.
 */
class menuController{

    // Propiedades de la clase
    public $titulo;
    public $view;

    // Constructor de la clase que inicializa el modelo
    public function __construct() {
        
        $this->titulo = 'Menú Principal';
        $this->view = "menu_principal";
    }

    
}

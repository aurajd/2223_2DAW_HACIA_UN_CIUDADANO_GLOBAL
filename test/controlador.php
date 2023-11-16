<?php

require_once 'modelo.php';

class Controlador{

    public $modelo;

    public function __construct() {
        $this->modelo = new Modelo();
    }

    function insertar($titulo, $informacion, $reflexion, $imagen){
        if (!empty($titulo) && !empty($informacion) && !empty($reflexion))
            $this->modelo->insertar_situacion($titulo, $informacion, $reflexion);
    }

}
<?php

require_once __DIR__.'/../modelos/m_situacion_problema.php';

class Controlador{

    public $modelo;
    public $nombreImagen;

    public function __construct() {
        $this->modelo = new Modelo();
    }

    function insertar($titulo, $informacion, $reflexion, $imagen){
        if (!empty($titulo) && !empty($informacion) && !empty($reflexion))
            $this->modelo->insertar_situacion($titulo, $informacion, $reflexion, $imagen);

    }

    function borrar($id){
        if (!empty($id)){
            $this->modelo->borrar_situacion($id);
        }
    }

    function modificar($id, $titulo, $informacion, $reflexion, $imagen){
        if(!empty($titulo) && !empty($informacion) && !empty($reflexion) && !empty($id)){
            $this->modelo->modificar_fila($id, $titulo, $informacion, $reflexion, $imagen);
        }
    }

    function borrar_fila($id, $img){
        if (!empty($id) && !empty($img)) {
            $this->modelo->borrar_situacion($id, $img);
        }
    }
    
}
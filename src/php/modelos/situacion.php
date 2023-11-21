<?php
require_once __DIR__.'/conexion.php';
/**
 * Clase problemaModel: Proporciona métodos para interactuar con la base de datos en relación con situaciones y problemas.
 */
class situacionModel extends Conexion{
    /**
     * Constructor de la clase que establece la conexión a la base de datos.
     */
    public function __construct() {
        parent::__construct();
    }
}
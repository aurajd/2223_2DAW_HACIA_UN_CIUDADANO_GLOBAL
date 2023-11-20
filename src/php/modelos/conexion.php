<?php


class Conexion{
    /** @var mysqli|null Conexión a la base de datos */
    protected $conexion = null;

    public function __construct(){
        include __DIR__.'/../config/configdb.php';
        $this->conexion = new mysqli($servidorbd, $usuario, $contraseña, $basedatos);
        $this->conexion->set_charset("utf8");
        
        $controlador = new mysqli_driver();
        $controlador->report_mode = MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT;
    }
}

?>
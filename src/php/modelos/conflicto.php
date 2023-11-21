<?php
require_once __DIR__.'/conexion.php';
/**
 * Clase conflictoModel: Proporciona métodos para interactuar con la base de datos en relación con situaciones y problemas.
 */
class conflictoModel extends Conexion{

    

    /**
     * Constructor de la clase que establece la conexión a la base de datos.
     */
    public function __construct() {
        parent::__construct();
    }

    function listar(){
        $sql = "SELECT s.idSituacion, s.titulo, s.informacion, s.imagen, c.fechaInicio
                FROM situacion s
                INNER JOIN conflicto c ON s.idSituacion = c.idConflicto;";
        $resultado = $this->conexion->query($sql);
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

}

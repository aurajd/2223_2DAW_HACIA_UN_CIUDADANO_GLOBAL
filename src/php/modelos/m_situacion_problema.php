<?php

class Modelo{

    public $conexion = null;
    public $nombreImagen = null;

    public function __construct() {
        require_once __DIR__.'/../config/configdb.php';
        $this->conexion = new mysqli($servidorbd, $usuario, $contraseña, $basedatos);
    }

    function insertar_situacion($titulo, $info, $reflexion, $imagen){
        
        $sql = "INSERT INTO situacion(titulo, informacion)
        VALUES ('$titulo', '$info');";
        
        $this->conexion->query($sql);

        // Recogemos la idSituacion de la inserción realizada
        $id = $this->conexion->insert_id;

        $sql = "INSERT INTO problema(idProblema, reflexion)
        VALUES ('$id','$reflexion');";

        $this->conexion->query($sql);

        if (isset($imagen)) {
            // Metemos el nombre de la imagen en una variable
            $nombreImagen = $imagen['name'];

            $sql = "UPDATE situacion 
            SET imagen = '$nombreImagen'
            WHERE idSituacion = $id;";

            $this->conexion->query($sql);
            
            // Ruta de destino para mover el archivo
            $directorio_destino = __DIR__.'/../../img';

            // Obtener información del archivo subido
            $ruta_temporal = $imagen["tmp_name"];

            // Construir la ruta de destino completa
            $ruta_destino = $directorio_destino . DIRECTORY_SEPARATOR . $nombreImagen;

            // Mover el archivo a la nueva ubicación
            if (move_uploaded_file($ruta_temporal, $ruta_destino)) {
                echo "El archivo se ha subido correctamente.";
            } else {
                echo "Error al mover el archivo.";
            }
        }

        $this->conexion->close();
    }

    function borrar_situacion($id){
        $sql = "DELETE FROM problema
        WHERE idProblema = $id;";

        $this->conexion->query($sql);

        $sql = "DELETE FROM situacion
        WHERE idSituacion = $id;";

        $this->conexion->query($sql);
        //Falta borrar imágen del servidor

        $this->conexion->close();
    }

    function listar(){
        $sql = "SELECT s.idSituacion, s.titulo, s.informacion, s.imagen, p.reflexion
        FROM situacion s
        INNER JOIN problema p ON s.idSituacion = p.idProblema;";

        $resultado = $this->conexion->query($sql);
        $this->conexion->close();
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

}
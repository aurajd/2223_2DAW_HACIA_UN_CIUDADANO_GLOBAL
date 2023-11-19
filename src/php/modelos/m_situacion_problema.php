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
            $ruta_temporal = $imagen["tmp_name"];

            // Ruta de destino completa
            $ruta_destino = $directorio_destino . DIRECTORY_SEPARATOR . $nombreImagen;

            // Mover el archivo a la nueva ubicación
            move_uploaded_file($ruta_temporal, $ruta_destino);
        }

        $this->conexion->close();
    }

    function borrar_situacion($id, $img){
        $sql = "DELETE FROM problema
        WHERE idProblema = $id;";

        $this->conexion->query($sql);

        $sql = "DELETE FROM situacion
        WHERE idSituacion = $id;";

        $this->conexion->query($sql);
        $this->conexion->close();

        unlink(__DIR__."/../../img/".$img);
    }

    function listar(){
        $sql = "SELECT s.idSituacion, s.titulo, s.informacion, s.imagen, p.reflexion
        FROM situacion s
        INNER JOIN problema p ON s.idSituacion = p.idProblema;";

        $resultado = $this->conexion->query($sql);
        $this->conexion->close();
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }
    
    function listar_fila($id){
        $sql = "SELECT s.titulo, s.informacion, s.imagen, p.reflexion
        FROM situacion s
        INNER JOIN problema p ON s.idSituacion = p.idProblema
        WHERE s.idSituacion = $id;";

        $resultado = $this->conexion->query($sql);
        $this->conexion->close();
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    function modificar_fila($id, $titulo, $informacion, $reflexion, $imagen){

        //Modificamos los datos por los nuevos
        $sql = "UPDATE situacion
        SET titulo = '$titulo', informacion = '$informacion'
        WHERE idSituacion = $id;";

        $this->conexion->query($sql);

        $sql = "UPDATE problema
        SET reflexion = '$reflexion'
        WHERE idProblema = $id;";

        $this->conexion->query($sql);

        if (!empty($imagen['name'])) {
            // Borramos imagen del fichero
            $sql = "SELECT s.imagen
            FROM situacion s
            WHERE s.idSituacion = $id;";

            $resultado = $this->conexion->query($sql);
            $fila = $resultado->fetch_assoc();

            if (!empty($fila['imagen']) && file_exists(__DIR__."/../../img/".$fila['imagen'])) {
                unlink(__DIR__."/../../img/".$fila['imagen']);
            }

            // Metemos el nombre de la imagen en una variable
            $nombreImagen = $imagen['name'];

            // Actualizamos el nombre en la BBDD
            $sql = "UPDATE situacion 
            SET imagen = '$nombreImagen'
            WHERE idSituacion = $id;";

            $this->conexion->query($sql);
            
            // Ruta de destino para mover el archivo
            $directorio_destino = __DIR__.'/../../img';
            $ruta_temporal = $imagen["tmp_name"];

            // Ruta de destino completa
            $ruta_destino = $directorio_destino . DIRECTORY_SEPARATOR . $nombreImagen;

            move_uploaded_file($ruta_temporal, $ruta_destino);
        }

    }

}
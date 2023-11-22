<?php
require_once __DIR__.'/conexion.php';
/**
 * Clase conflictoModel: Proporciona métodos para interactuar con la base de datos en relación con situaciones y problemas.
 */
class conflictoModel extends Conexion{

    public $error;

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

    function listar_fila($id){
        $sql = "SELECT s.idSituacion, s.titulo, s.informacion, s.imagen, c.fechaInicio
                FROM situacion s
                INNER JOIN conflicto c ON s.idSituacion = c.idConflicto
                WHERE s.idSituacion = ".$id.";";
        $resultado = $this->conexion->query($sql);
        return $resultado->fetch_assoc();
    }

    function listar_conflicto_motivo($id){
        $sql = "SELECT c.idConflicto, c.numMotivo, s.titulo, s.informacion, s.imagen, c.fechaInicio
                FROM situacion s
                INNER JOIN conflicto c ON s.idSituacion = c.idConflicto
                WHERE s.idSituacion = ".$id.";";
        $resultado = $this->conexion->query($sql);
        $conflicto = $resultado->fetch_assoc();

        $sql = "SELECT numMotivo, textoMotivo
                FROM motivo  
                WHERE idConflicto = ".$id.";";
        $resultado = $this->conexion->query($sql);
        $arrayMotivos = $resultado->fetch_all(MYSQLI_ASSOC);

        $conflictoMotivos = array(
            "conflicto" => $conflicto,
            "motivos" => $arrayMotivos
        );
        return $conflictoMotivos;
    }

    function insertar_conflicto($titulo, $informacion, $fecha, $imagen, $motivoCorrecto, $motivos){
      
        if(file_exists($imagen["tmp_name"])){
            $ext = pathinfo($imagen["name"], PATHINFO_EXTENSION);
            $nombreImagen = uniqid().".".$ext;
            $imagenSQL = "'".$nombreImagen."'";
        } else{
            $imagenSQL = "NULL";
        }

        try {
            $sql = "SET autocommit = 0;";
            $this->conexion->query($sql);

            $sql = "START TRANSACTION;";
            $this->conexion->query($sql);

            // Consulta SQL para insertar en la tabla 'situacion'
            //real_escape_string escapa los carácteres especiales.
            $sql = "INSERT INTO situacion(titulo, informacion,imagen) 
            VALUES ('".$this->conexion->real_escape_string($titulo)."', 
            '".$this->conexion->real_escape_string($informacion)."',
            ".$imagenSQL.");";

            $this->conexion->query($sql);

            // Recogemos la idSituacion de la inserción realizada
            $id = $this->conexion->insert_id;
            // Consulta SQL para insertar en la tabla 'conflicto'
            $sql = "INSERT INTO conflicto(idConflicto, fechaInicio) 
            VALUES (".$id.",'".$fecha."');";
            $this->conexion->query($sql);

            foreach($motivos as $indice => $motivo){
                $sql = "INSERT INTO motivo(idConflicto, numMotivo, textoMotivo) 
                VALUES ('$id','$indice','".$this->conexion->real_escape_string($motivo)."');";
                $this->conexion->query($sql);
                if($indice==$motivoCorrecto){
                    $sql = "UPDATE conflicto SET numMotivo = ".$indice." where idConflicto = ".$id.";";
                    $this->conexion->query($sql);
                }
            }

            // Si hay una imagen, actualizamos la ruta en la tabla 'situacion'
            if (file_exists($imagen["tmp_name"])) {
                // Ruta de destino para mover el archivo
                $directorio_destino = __DIR__."/../../img";
                $ruta_temporal = $imagen["tmp_name"];   
                $ruta_destino = $directorio_destino . DIRECTORY_SEPARATOR . $nombreImagen;

                // Mover el archivo a la nueva ubicación
                move_uploaded_file($ruta_temporal, $ruta_destino);
            }

        } catch (mysqli_sql_exception $e) {
            if($e->getCode()==1406){
                $this->error = "Uno de los campos excede el límite de carácteres.";
            }else{
                $this->error = "Error inesperado contacte con el administrador.";
            }
            $sql = "ROLLBACK;";
            $this->conexion->query($sql);
            return false;
        }

        $sql = "COMMIT;";
        $this->conexion->query($sql);
        return true;
        
    }

    function modificar_conflicto($id,$titulo, $informacion, $fecha, $imagen, $motivoCorrecto, $motivos){
        
        try {
            $sql = "SET autocommit = 0;";
            $this->conexion->query($sql);

            $sql = "START TRANSACTION;";
            $this->conexion->query($sql);

            // Modificamos los datos de la tabla 'situacion'
            $sql = "UPDATE situacion 
            SET titulo = '".$this->conexion->real_escape_string($titulo)."', 
            informacion = '".$this->conexion->real_escape_string($informacion)."' 
            WHERE idSituacion = ".$id.";";
            $this->conexion->query($sql);

            // Modificamos los datos de la tabla 'conflicto'
            $sql = "UPDATE conflicto SET numMotivo = NULL, fechaInicio = '".$fecha."' WHERE idConflicto = ".$id.";";
            $this->conexion->query($sql);

            //Eliminamos todos los motivos asociados a la fila
            $sql = "DELETE FROM motivo WHERE idConflicto = ".$id.";";
            $this->conexion->query($sql);

            //Y metemos los nuevos motivos modificados
            foreach($motivos as $indice => $motivo){
                $sql = "INSERT INTO motivo(idConflicto, numMotivo, textoMotivo) 
                VALUES ('$id','$indice','".$this->conexion->real_escape_string($motivo)."');";
                $this->conexion->query($sql);
                if($indice==$motivoCorrecto){
                    $sql = "UPDATE conflicto SET numMotivo = ".$indice." where idConflicto = ".$id.";";
                    $this->conexion->query($sql);
                }
            }


            if (file_exists($imagen["tmp_name"])) {
                // Borramos imagen del fichero
                $sql = "SELECT s.imagen FROM situacion s WHERE s.idSituacion = ".$id.";";
                $resultado = $this->conexion->query($sql);
                $fila = $resultado->fetch_assoc();

                if (!is_null($fila['imagen']) && file_exists(__DIR__."/../../img/".$fila['imagen'])) {
                    unlink(__DIR__."/../../img/".$fila['imagen']);
                }

                // Metemos el nombre de la imagen en una variable
                $ext = pathinfo($imagen["name"], PATHINFO_EXTENSION);
                $nombreImagen = uniqid().".".$ext;

                // Actualizamos el nombre en la BBDD
                $sql = "UPDATE situacion SET imagen = '".$nombreImagen."' WHERE idSituacion = ".$id.";";
                $this->conexion->query($sql);
                
                // Ruta de destino para mover el archivo
                $directorio_destino = __DIR__.'/../../img';
                $ruta_temporal = $imagen["tmp_name"];

                // Ruta de destino completa
                $ruta_destino = $directorio_destino . DIRECTORY_SEPARATOR . $nombreImagen;

                move_uploaded_file($ruta_temporal, $ruta_destino);
            }
        }catch (mysqli_sql_exception $e) {
            if($e->getCode()==1406){
                $this->error = "Uno de los campos excede el límite de carácteres.";
            }else{
                $this->error = "Error inesperado contacte con el administrador.";
            }
            $sql = "ROLLBACK;";
            $this->conexion->query($sql);
            return false;
        }

        $sql = "COMMIT;";
        $this->conexion->query($sql);
        return true;
    }

    function borrar_conflicto($id){
        //Obtiene el valor de la imagen
        $sql = "SELECT imagen FROM situacion WHERE idSituacion = ".$id.";";
        $resultado = $this->conexion->query($sql);
        $img = $resultado->fetch_assoc();

        // Consulta SQL para borrar un problema, lo eliminamos de la tabla situación y se borra en cascada
        $sql = "DELETE FROM situacion WHERE idSituacion = $id;";
        $this->conexion->query($sql);

        // Borrar la imagen del servidor
        if(!is_null($img["imagen"]))
            unlink(__DIR__."/../../img/".$img["imagen"]);
    }
}

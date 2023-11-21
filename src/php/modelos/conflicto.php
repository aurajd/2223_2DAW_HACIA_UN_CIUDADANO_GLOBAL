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
            $sql = "INSERT INTO situacion(titulo, informacion,imagen) VALUES ('".$titulo."', '".$informacion."',".$imagenSQL.");";

            $this->conexion->query($sql);

            // Recogemos la idSituacion de la inserción realizada
            $id = $this->conexion->insert_id;
            // Consulta SQL para insertar en la tabla 'conflicto'
            $sql = "INSERT INTO conflicto(idConflicto, fechaInicio) VALUES (".$id.",'".$fecha."');";
            $this->conexion->query($sql);

            foreach($motivos as $indice => $motivo){
                $sql = "INSERT INTO motivo(idConflicto, numMotivo, textoMotivo) VALUES ('$id','$indice','".$motivo."');";
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

}

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
        $lista = $resultado->fetch_all(MYSQLI_ASSOC);
        $resultado->close();
        $this->conexion->close();
        return $lista;
    }

    function listar_conflicto($id){
        $sql = "SELECT s.idSituacion, c.numMotivo, s.titulo, s.informacion, s.imagen, c.fechaInicio
        FROM situacion s
        INNER JOIN conflicto c ON s.idSituacion = c.idConflicto
        WHERE s.idSituacion = ?;";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param('i',$id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $stmt->close();
        $conflicto = $resultado->fetch_assoc();
        $resultado->close();
        return $conflicto;
    }

    function listar_conflicto_motivo($id){
        $conflicto = $this->listar_conflicto($id);

        $sql = "SELECT numMotivo, textoMotivo
        FROM motivo  
        WHERE idConflicto = ?;";
                
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param('i',$id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $stmt->close();
        $arrayMotivos = $resultado->fetch_all(MYSQLI_ASSOC);
        $resultado->close();
        $this->conexion->close();
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
        } else{
            $nombreImagen = null;
        }

        try {
            $this->conexion->autocommit(false);

            $this->conexion->begin_transaction();

            // Consulta SQL para insertar en la tabla 'situacion'
            //real_escape_string escapa los carácteres especiales.
            $sql = "INSERT INTO situacion(titulo, informacion,imagen) 
            VALUES (?,?,?);";

            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("sss",$titulo,$informacion,$nombreImagen);
            $stmt->execute();

            // Recogemos la idSituacion de la inserción realizada
            $id = $stmt->insert_id;
            // Consulta SQL para insertar en la tabla 'conflicto'
            $sql = "INSERT INTO conflicto(idConflicto, fechaInicio) 
            VALUES (?,?);";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param('is',$id,$fecha);
            $stmt->execute();

            $sql = "INSERT INTO motivo(idConflicto, numMotivo, textoMotivo) 
            VALUES (?,?,?);";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param('iis',$id,$indice,$motivo);

            foreach($motivos as $indice => $motivo){
                $stmt->execute();
                if($indice==$motivoCorrecto){
                    $sql = "UPDATE conflicto SET numMotivo = ? where idConflicto = ?;";
                    $actualizacion = $this->conexion->prepare($sql);
                    $actualizacion->bind_param('ii',$motivoCorrecto,$id);
                    $actualizacion->execute();
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
            $this->conexion->rollback();
            $this->error = "Error ".$e->getCode().": Contacte con el administrador.";
            return false;
        } finally {
            $stmt->close();
        }

        $this->conexion->commit();
        return true;
        
    }

    function modificar_conflicto($id,$titulo, $informacion, $fecha, $imagen, $motivoCorrecto, $motivos){
        
        try {
            $this->conexion->autocommit(false);

            $this->conexion->begin_transaction();

            // Modificamos los datos de la tabla 'situacion'
            $sql = "UPDATE situacion 
            SET titulo = ?, informacion = ? 
            WHERE idSituacion = ?;";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param('ssi',$titulo,$informacion,$id);
            $stmt->execute();


            // Modificamos los datos de la tabla 'conflicto'
            $sql = "UPDATE conflicto SET numMotivo = NULL, fechaInicio = ? WHERE idConflicto = ?;";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param('si',$fecha,$id);
            $stmt->execute();

            //Eliminamos todos los motivos asociados a la fila
            $sql = "DELETE FROM motivo WHERE idConflicto = ?;";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param('i',$id);
            $stmt->execute();

            $sql = "INSERT INTO motivo(idConflicto, numMotivo, textoMotivo) 
            VALUES (?,?,?);";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param('iis',$id,$indice,$motivo);
            //Y metemos los nuevos motivos modificados
            foreach($motivos as $indice => $motivo){
                $stmt->execute();
                if($indice==$motivoCorrecto){
                    $sql = "UPDATE conflicto SET numMotivo = ? where idConflicto = ?;";
                    $actualizacion = $this->conexion->prepare($sql);
                    $actualizacion->bind_param('ii',$motivoCorrecto,$id);
                    $actualizacion->execute();
                }
            }


            if (file_exists($imagen["tmp_name"])) {
                // Borramos imagen del fichero
                $sql = "SELECT imagen FROM situacion WHERE idSituacion = ?;";
                $stmt = $this->conexion->prepare($sql);
                $stmt->bind_param('i',$id);
                $stmt->execute();
                $stmt->bind_result($imagenBorrar);
                $stmt->fetch();
                $stmt->free_result();


                if (!is_null($imagenBorrar) && file_exists(__DIR__."/../../img/".$imagenBorrar)) {
                    unlink(__DIR__."/../../img/".$imagenBorrar);
                }

                // Metemos el nombre de la imagen en una variable
                $ext = pathinfo($imagen["name"], PATHINFO_EXTENSION);
                $nombreImagen = uniqid().".".$ext;

                // Actualizamos el nombre en la BBDD
                $sql = "UPDATE situacion SET imagen = ? WHERE idSituacion = ?;";
                $stmt = $this->conexion->prepare($sql);
                $stmt->bind_param('si',$nombreImagen,$id);
                $stmt->execute();

                
                // Ruta de destino para mover el archivo
                $directorio_destino = __DIR__.'/../../img';
                $ruta_temporal = $imagen["tmp_name"];

                // Ruta de destino completa
                $ruta_destino = $directorio_destino . DIRECTORY_SEPARATOR . $nombreImagen;

                move_uploaded_file($ruta_temporal, $ruta_destino);
            }
        }catch (mysqli_sql_exception $e) {
            $this->conexion->rollback();
            $this->error = "Error ".$e->getCode().": Contacte con el administrador.";
            return false;
        }finally {
            $stmt->close();
        }

        $this->conexion->commit();
        return true;
    }

    function borrar_conflicto($id){
        //Obtiene el valor de la imagen
        $sql = "SELECT imagen FROM situacion WHERE idSituacion = ?;";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param('i',$id);
        $stmt->execute();
        $stmt->bind_result($img);
        $stmt->fetch();
        $stmt->free_result();

        // Consulta SQL para borrar un problema, lo eliminamos de la tabla situación y se borra en cascada
        $sql = "DELETE FROM situacion WHERE idSituacion = ?;";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param('i',$id);
        $stmt->execute();

        $stmt->close();

        // Borrar la imagen del servidor
        if(!is_null($img))
            unlink(__DIR__."/../../img/".$img);
    }

    function comprobarExisteConflicto($id){
        $sql = "SELECT idSituacion
        FROM situacion 
        INNER JOIN conflicto
        on idSituacion = idConflicto
        WHERE idSituacion = ?";
        $stmt = $this->conexion->prepare($sql);

        $stmt->bind_param("i",$id);
        $stmt->execute();
        
        // Almacenamos el resultado para determinar el número de filas devueltas
        $stmt->store_result();
        //si el numero de filas devueltas por esta consulta es mayor a 0 existe un conflicto con esta id y devuelve true,
        // si no, devuelve false
        $existe = $stmt->num_rows()>0 ? true : false;
        $stmt->close();
        return $existe;
    }
}

<?php
require_once __DIR__.'/conexion.php';
/**
 * Clase problemaModel: Proporciona métodos para interactuar con la base de datos en relación con situaciones y problemas.
 */
class problemaModel extends Conexion{

    /**
     * @var string|null $error Mensaje de error en caso de excepciones.
     */
    public $error;

    /**
     * Constructor de la clase que establece la conexión a la base de datos.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Inserta una nueva situación con su problema asociado en la base de datos.
     *
     * @param string $titulo Título del problema.
     * @param string $info Información del problema.
     * @param string $reflexion Reflexión asociada al problema.
     * @param array $imagen Información de la imagen asociada al problema.
     * @return bool Devuelve true si la operación fue exitosa, false en caso contrario.
     */
    function insertar_problema($titulo, $informacion, $reflexion, $imagen){
        if (file_exists($imagen["tmp_name"])) {
            $ext = pathinfo($imagen["name"], PATHINFO_EXTENSION);
            $nombreImagen = uniqid() . "." . $ext;
        } else {
            $nombreImagen = null;
        }

        try {
            $this->conexion->autocommit(false);

            // Consulta SQL para insertar en la tabla 'situacion'
            $sql = "INSERT INTO situacion(titulo, informacion, imagen) VALUES (?, ?, ?);";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("sss", $titulo, $informacion, $nombreImagen);
            $stmt->execute();

            // Recogemos la idSituacion de la inserción realizada
            $id = $stmt->insert_id;

            // Consulta SQL para insertar en la tabla 'problema'
            $sql = "INSERT INTO problema(idProblema, reflexion) VALUES (?, ?);";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param('is', $id, $reflexion);
            $stmt->execute();

            // Si hay una imagen, actualizamos la ruta en la tabla 'situacion'
            if (file_exists($imagen["tmp_name"])) {
                $directorio_destino = __DIR__ . "/../../img";
                $ruta_temporal = $imagen["tmp_name"];
                $ruta_destino = $directorio_destino . DIRECTORY_SEPARATOR . $nombreImagen;

                move_uploaded_file($ruta_temporal, $ruta_destino);
            }
        } catch (mysqli_sql_exception $e) {
            $this->conexion->rollback();
            $this->error = "Error " . $e->getCode() . ": Contacte con el administrador.";
            return false;
        } finally {
            $stmt->close();
        }

        $this->conexion->commit();
        return true;
    }

    /**
     * Borra un problema de la base de datos.
     *
     * @param int $id ID del problema a borrar.
     * @return void
     */
    function borrar_situacion($id){
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

    /**
     * Obtiene la lista de todos los problemas.
     *
     * @return array Lista de problemas.
     */
    function listar(){
        $sql = "SELECT s.idSituacion, s.titulo, s.informacion, s.imagen, p.reflexion
                FROM situacion s
                INNER JOIN problema p ON s.idSituacion = p.idProblema;";
        $resultado = $this->conexion->query($sql);
        $this->conexion->close();
        $lista = $resultado->fetch_all(MYSQLI_ASSOC);
        $resultado->close();
        return $lista;
    }
    
    /**
     * Obtiene la información de un problema específico.
     *
     * @param int $id ID del problema.
     * @return array Información del problema.
     */
    function listar_fila($id){
        $sql = "SELECT s.idSituacion, s.titulo, s.informacion, s.imagen, p.reflexion
                FROM situacion s
                INNER JOIN problema p ON s.idSituacion = p.idProblema
                WHERE s.idSituacion = ?;";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param('i',$id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $stmt->close();
        $problema = $resultado->fetch_assoc();
        $resultado->close();
        return $problema;
    }

    /**
     * Modifica un conflicto existente en la base de datos.
     *
     * @param int $id ID del problema a modificar.
     * @param string $titulo Nuevo título del problema.
     * @param string $informacion Nueva información asociada al problema.
     * @param string $reflexion Nueva reflexión asociada al problema.
     * @param array $imagen Datos de la nueva imagen (si se proporciona).
     * @return bool Retorna true si la operación fue exitosa, false en caso contrario.
     */
    function modificar_fila($id, $titulo, $informacion, $reflexion, $imagen){
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


            // Modificamos los datos de la tabla 'problema'
            $sql = "UPDATE problema 
            SET reflexion = ? 
            WHERE idProblema = ?;";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param('si',$reflexion,$id);
            $stmt->execute();

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

    /**
     * Verifica si un problema con la ID dada existe en la base de datos.
     *
     * @param int $id ID del problema a verificar.
     * @return bool Devuelve true si el problema existe, false en caso contrario.
     */
    function comprobarExisteProblema($id){
        $sql = "SELECT idSituacion
        FROM situacion 
        INNER JOIN problema
        on idSituacion = idProblema
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
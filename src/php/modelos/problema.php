<?php
require_once __DIR__.'/conexion.php';
/**
 * Clase problemaModel: Proporciona métodos para interactuar con la base de datos en relación con situaciones y problemas.
 */
class problemaModel extends Conexion{

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
     * @param string $titulo Título de la situación.
     * @param string $info Información de la situación.
     * @param string $reflexion Reflexión asociada al problema.
     * @param array|null $imagen Datos de la imagen (si se proporciona).
     */
    function insertar_problema($titulo, $info, $reflexion, $imagen){

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
            $sql = "INSERT INTO situacion(titulo, informacion,imagen) VALUES ('".$titulo."', '".$info."',".$imagenSQL.");";

            $this->conexion->query($sql);

            // Recogemos la idSituacion de la inserción realizada
            $id = $this->conexion->insert_id;
            
            // Consulta SQL para insertar en la tabla 'problema'
            $sql = "INSERT INTO problema(idProblema, reflexion) VALUES ('$id','$reflexion');";
            $this->conexion->query($sql);

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

    /**
     * Borra una situación y su problema asociado por ID, además de borrar la imagen del servidor.
     *
     * @param int $id ID de la situación a borrar.
     * @param string $img Nombre de la imagen asociada.
     */
    function borrar_situacion($id){
        //Obtiene el valor de la imagen
        $sql = "SELECT imagen FROM situacion WHERE idSituacion = ".$id.";";
        $resultado = $this->conexion->query($sql);
        $img = $resultado->fetch_assoc();

        // Consulta SQL para borrar un problema, lo eliminamos de la tabla situación y se borra en cascada
        $sql = "DELETE FROM situacion WHERE idSituacion = ".$id.";";
        $this->conexion->query($sql);

        // Borrar la imagen del servidor
        if(!is_null($img["imagen"]))
            unlink(__DIR__."/../../img/".$img["imagen"]);
    }

    /**
     * Lista todas las situaciones con sus problemas asociados desde la base de datos.
     *
     * @return array Arreglo asociativo con los datos de las situaciones y sus problemas.
     */
    function listar(){
        $sql = "SELECT s.idSituacion, s.titulo, s.informacion, s.imagen, p.reflexion
                FROM situacion s
                INNER JOIN problema p ON s.idSituacion = p.idProblema;";
        $resultado = $this->conexion->query($sql);
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }
    
    /**
     * Obtiene los detalles de una situación y su problema asociado por ID desde la base de datos.
     *
     * @param int $id ID de la situación a obtener detalles.
     * @return array Arreglo asociativo con los detalles de la situación y su problema.
     */
    function listar_fila($id){
        $sql = "SELECT s.idSituacion, s.titulo, s.informacion, s.imagen, p.reflexion
                FROM situacion s
                INNER JOIN problema p ON s.idSituacion = p.idProblema
                WHERE s.idSituacion = ".$id.";";
        $resultado = $this->conexion->query($sql);
        return $resultado->fetch_assoc();
    }

    /**
     * Modifica los datos de una situación y su problema asociado por ID en la base de datos.
     *
     * @param int $id ID de la situación a modificar.
     * @param string $titulo Nuevo título de la situación.
     * @param string $informacion Nueva información de la situación.
     * @param string $reflexion Nueva reflexión asociada al problema.
     * @param array $imagen Datos de la nueva imagen (si se proporciona).
     */
    function modificar_fila($id, $titulo, $informacion, $reflexion, $imagen){
        try {
            $sql = "SET autocommit = 0;";
            $this->conexion->query($sql);

            $sql = "START TRANSACTION;";
            $this->conexion->query($sql);

            // Modificamos los datos de la tabla 'situacion'
            $sql = "UPDATE situacion SET titulo = '".$titulo."', informacion = '".$informacion."' WHERE idSituacion = ".$id.";";
            $this->conexion->query($sql);

            // Modificamos los datos de la tabla 'problema'
            $sql = "UPDATE problema SET reflexion = '".$reflexion."' WHERE idProblema = ".$id.";";
            $this->conexion->query($sql);

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

}

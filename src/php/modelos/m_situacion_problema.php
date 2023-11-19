<?php

/**
 * Clase Modelo: Proporciona métodos para interactuar con la base de datos en relación con situaciones y problemas.
 */
class Modelo{

    /** @var mysqli|null Conexión a la base de datos */
    public $conexion = null;

    /** @var string|null Nombre de la imagen (aparentemente no se utiliza en el código proporcionado) */
    public $nombreImagen = null;

    /**
     * Constructor de la clase que establece la conexión a la base de datos.
     */
    public function __construct() {
        require_once __DIR__.'/../config/configdb.php';
        $this->conexion = new mysqli($servidorbd, $usuario, $contraseña, $basedatos);
    }

    /**
     * Inserta una nueva situación con su problema asociado en la base de datos.
     *
     * @param string $titulo Título de la situación.
     * @param string $info Información de la situación.
     * @param string $reflexion Reflexión asociada al problema.
     * @param array|null $imagen Datos de la imagen (si se proporciona).
     */
    function insertar_situacion($titulo, $info, $reflexion, $imagen){
        // Consulta SQL para insertar en la tabla 'situacion'
        $sql = "INSERT INTO situacion(titulo, informacion) VALUES ('$titulo', '$info');";
        $this->conexion->query($sql);

        // Recogemos la idSituacion de la inserción realizada
        $id = $this->conexion->insert_id;

        // Consulta SQL para insertar en la tabla 'problema'
        $sql = "INSERT INTO problema(idProblema, reflexion) VALUES ('$id','$reflexion');";
        $this->conexion->query($sql);

        // Si hay una imagen, actualizamos la ruta en la tabla 'situacion'
        if (isset($imagen)) {
            $nombreImagen = $imagen['name'];
            $sql = "UPDATE situacion SET imagen = '$nombreImagen' WHERE idSituacion = $id;";
            $this->conexion->query($sql);

            // Ruta de destino para mover el archivo
            $directorio_destino = __DIR__.'/../../img';
            $ruta_temporal = $imagen["tmp_name"];
            $ruta_destino = $directorio_destino . DIRECTORY_SEPARATOR . $nombreImagen;

            // Mover el archivo a la nueva ubicación
            move_uploaded_file($ruta_temporal, $ruta_destino);
        }

        // Cerrar la conexión a la base de datos
        $this->conexion->close();
    }

    /**
     * Borra una situación y su problema asociado por ID, además de borrar la imagen del servidor.
     *
     * @param int $id ID de la situación a borrar.
     * @param string $img Nombre de la imagen asociada.
     */
    function borrar_situacion($id, $img){
        // Consulta SQL para borrar de la tabla 'problema'
        $sql = "DELETE FROM problema WHERE idProblema = $id;";
        $this->conexion->query($sql);

        // Consulta SQL para borrar de la tabla 'situacion'
        $sql = "DELETE FROM situacion WHERE idSituacion = $id;";
        $this->conexion->query($sql);

        // Cerrar la conexión a la base de datos
        $this->conexion->close();

        // Borrar la imagen del servidor
        unlink(__DIR__."/../../img/".$img);
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
        $this->conexion->close();
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }
    
    /**
     * Obtiene los detalles de una situación y su problema asociado por ID desde la base de datos.
     *
     * @param int $id ID de la situación a obtener detalles.
     * @return array Arreglo asociativo con los detalles de la situación y su problema.
     */
    function listar_fila($id){
        $sql = "SELECT s.titulo, s.informacion, s.imagen, p.reflexion
                FROM situacion s
                INNER JOIN problema p ON s.idSituacion = p.idProblema
                WHERE s.idSituacion = $id;";
        $resultado = $this->conexion->query($sql);
        $this->conexion->close();
        return $resultado->fetch_all(MYSQLI_ASSOC);
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
        // Modificamos los datos de la tabla 'situacion'
        $sql = "UPDATE situacion SET titulo = '$titulo', informacion = '$informacion' WHERE idSituacion = $id;";
        $this->conexion->query($sql);

        // Modificamos los datos de la tabla 'problema'
        $sql = "UPDATE problema SET reflexion = '$reflexion' WHERE idProblema = $id;";
        $this->conexion->query($sql);

        if (!empty($imagen['name'])) {
            // Borramos imagen del fichero
            $sql = "SELECT s.imagen FROM situacion s WHERE s.idSituacion = $id;";
            $resultado = $this->conexion->query($sql);
            $fila = $resultado->fetch_assoc();

            if (!empty($fila['imagen']) && file_exists(__DIR__."/../../img/".$fila['imagen'])) {
                unlink(__DIR__."/../../img/".$fila['imagen']);
            }

            // Metemos el nombre de la imagen en una variable
            $nombreImagen = $imagen['name'];

            // Actualizamos el nombre en la BBDD
            $sql = "UPDATE situacion SET imagen = '$nombreImagen' WHERE idSituacion = $id;";
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

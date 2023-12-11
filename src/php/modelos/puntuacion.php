<?php
require_once __DIR__.'/conexion.php';
/**
 * Clase puntuacionModel: Proporciona métodos para interactuar con la base de datos en relación con situaciones y problemas.
 */
class puntuacionModel extends Conexion{

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
     * @param string $nombre Título del problema.
     * @param int $puntuacion Puntuación obtenida por el jugador.
     * @return bool Devuelve true si la operación fue exitosa, false en caso contrario.
     */
    function insertar_puntuacion($nombre, $puntuacion){
        try {
            // Consulta SQL para insertar en la tabla 'situacion'
            $sql = "INSERT INTO ranking(puntuacion,nombreJugador) 
            VALUES (?,?);";

            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("is",$puntuacion,$nombre);
            $stmt->execute();
        }catch(mysqli_sql_exception $e){
            $this->error = "Error ".$e->getCode().": Contacte con el administrador.";
            return false;
        }finally {
            $stmt->close();
            $this->conexion->close();
        }

        return true;
    }

    function devolver_top_5(){
        $sql = "SELECT puntuacion, nombreJugador
        FROM ranking
        ORDER BY puntuacion DESC
        LIMIT 5;";
        $resultado = $this->conexion->query($sql);
        $this->conexion->close();
        $top5 = $resultado->fetch_all(MYSQLI_ASSOC);
        return $top5;
    }

    function listar_puntuaciones(){
        $sql = "SELECT puntuacion, nombreJugador
        FROM ranking
        ORDER BY puntuacion DESC";
        $resultado = $this->conexion->query($sql);
        $this->conexion->close();
        $puntuaciones = $resultado->fetch_all(MYSQLI_ASSOC);
        return $puntuaciones;
    }

    function borrar_puntuaciones(){
        $sql = "DELETE FROM ranking";
        $this->conexion->query($sql);
    }
}
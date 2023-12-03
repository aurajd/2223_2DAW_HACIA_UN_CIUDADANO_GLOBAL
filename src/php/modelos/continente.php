<?php
require_once __DIR__.'/conexion.php';

class ContinenteModel extends Conexion {
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
     * Obtiene la lista de todos los continentes.
     *
     * @return array Lista de continentes.
     */
    function listar_continentes() {
        $sql = "SELECT * FROM continente;";
        $resultado = $this->conexion->query($sql);

        if ($resultado) {
            $lista = $resultado->fetch_all(MYSQLI_ASSOC);
            $resultado->close();
            return $lista;
        } else {
            $this->error = "Error en la consulta: " . $this->conexion->error;
            return false;
        }
    }

     /**
     * Obtiene la información de un continente específico.
     *
     * @param int $id ID del continente.
     * @return array|null Información del continente o null si hay un error.
     */
    function obtener_informacion_continente($id) {
        $sql = "SELECT * FROM continente WHERE idContinente = ?;";
        $stmt = $this->conexion->prepare($sql);

        if (!$stmt) {
            $this->error = "Error en la preparación de la consulta: " . $this->conexion->error;
            return null;
        }

        $stmt->bind_param('i', $id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $stmt->close();

        if (!$resultado) {
            $this->error = "Error en la ejecución de la consulta: " . $this->conexion->error;
            return null;
        }

        $continente = $resultado->fetch_assoc();
        $resultado->close();

        return $continente;
    }

    // Agregado para obtener mensajes de error
    function getError() {
        return $this->error;
    }

    /**
     * Comprueba si un continente existe en la base de datos.
     *
     * @param int $id ID del continente a verificar.
     * @return bool Retorna true si el continente existe, false en caso contrario.
     */
    function comprobar_existe_continente($id) {
        $sql = "SELECT COUNT(*) FROM continente WHERE idContinente = ?;";
        $stmt = $this->conexion->prepare($sql);

        if (!$stmt) {
            $this->error = "Error en la preparación de la consulta: " . $this->conexion->error;
            return false;
        }

        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        return $count > 0;
    }


    /**
    * Modifica un continente existente en la base de datos.
    *
    * @param int $id ID del continente a modificar.
    * @param string $informacion Nueva información del continente.
    * @param string $resumenInfo Nuevo resumen de la información del continente.
    * @param array|null $imagen Datos de la nueva imagen del continente.
    * @return bool Retorna true si la operación fue exitosa, false en caso contrario.
    */
    function modificar_continente($id, $informacion, $resumenInfo, $imagen) {
        $stmt = null; // Inicializar $stmt a null

        try {
            $this->conexion->autocommit(false);

            // Actualizamos los datos del continente
            $sql = "UPDATE continente SET informacion = ?, resumenInfo = ? WHERE idContinente = ?;";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param('ssi', $informacion, $resumenInfo, $id);
            $stmt->execute();

            if ($imagen !== null && file_exists($imagen["tmp_name"])) {
                // Borramos imagen del fichero
                $sql = "SELECT imagen FROM continente WHERE idContinente = ?;";
                $stmt = $this->conexion->prepare($sql);
                $stmt->bind_param('i', $id);
                $stmt->execute();
                $stmt->bind_result($imagenBorrar);
                $stmt->fetch();
                $stmt->free_result();

                if (!is_null($imagenBorrar) && file_exists(__DIR__."/../../img/".$imagenBorrar)) {
                    unlink(__DIR__."/../../img/".$imagenBorrar);
                }

                // Subimos la nueva imagen
                $ext = pathinfo($imagen["name"], PATHINFO_EXTENSION);
                $nombreImagen = uniqid() . "." . $ext;
                $ruta_destino = __DIR__ . "/../../img/" . $nombreImagen;
                move_uploaded_file($imagen["tmp_name"], $ruta_destino);

                // Actualizamos la ruta de la imagen en la base de datos
                $sql = "UPDATE continente SET imagen = ? WHERE idContinente = ?;";
                $stmt = $this->conexion->prepare($sql);
                $stmt->bind_param('si', $nombreImagen, $id);
                $stmt->execute();
            }

            $this->conexion->commit();
            $stmt->close();

            return true;
        } catch (Exception $e) {
            $this->conexion->rollback();
            $this->error = "Error en la transacción: " . $e->getMessage();
            $stmt->close();
            return false;
        } finally {
            $this->conexion->autocommit(true);
        }
    }
}

?>
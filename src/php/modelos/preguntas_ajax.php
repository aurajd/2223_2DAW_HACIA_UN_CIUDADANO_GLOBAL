<?php
require_once __DIR__.'/conexion.php';
/**
 * Clase preguntas_ajaxModel: Proporciona métodos para interactuar con la base de datos en relación con situaciones y problemas.
 */
class preguntas_ajaxModel extends Conexion{
    
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

    function devolver_problemas($id){
        try {
            $sql = "SELECT idProblema, titulo, informacion, imagen, reflexion 
            FROM problema
            INNER JOIN situacion 
            ON problema.idProblema = situacion.idSituacion
            where idContinente = ?
            ORDER BY RAND()
            LIMIT 2";

            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param('i',$id);
            $stmt->execute();

            $resultado = $stmt->get_result();
            $problemas = $resultado->fetch_all(MYSQLI_ASSOC);
            
            $resultado->close();
            return $problemas;

        }catch(mysqli_sql_exception $e){
            $this->error = "Error ".$e->getCode().": Contacte con el administrador.";
            return false;
        }finally {
            $stmt->close();
        }
    }

    function devolver_info_continentes(){
        $sql = "SELECT idContinente, nombre, informacion, resumenInfo, imagen 
        FROM continente;";
        $resultado = $this->conexion->query($sql);
        $continente = $resultado->fetch_all(MYSQLI_ASSOC);
        return $continente;
    }

    function devolver_soluciones($id){
        try {
            // Consulta SQL para insertar en la tabla 'situacion'
            $sql = "SELECT numSolucion, textoSolucion, correcta
            FROM solucion
            WHERE idSituacion = ? and correcta = 1
            ORDER BY RAND()
            LIMIT 1";

            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param('i',$id);
            $stmt->execute();

            $resultado = $stmt->get_result();
            $SolucionCorrecta = $resultado->fetch_array(MYSQLI_ASSOC);
            $resultado->close();

            $sql = "SELECT numSolucion, textoSolucion, correcta
            FROM solucion
            WHERE idSituacion = ? and NOT numSolucion = ?
            ORDER BY RAND()
            LIMIT 2";

            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param('ii',$id, $SolucionCorrecta["numSolucion"]);
            $stmt->execute();

            $resultado = $stmt->get_result();
            $soluciones = $resultado->fetch_all(MYSQLI_ASSOC);
            array_push($soluciones,$SolucionCorrecta);

            return $soluciones;
        }catch(mysqli_sql_exception $e){
            $this->error = "Error ".$e->getCode().": Contacte con el administrador.";
            return false;
        }finally {
            $stmt->close();
        }
    }

    function devolver_conflicto($id){
        try {
            $sql = "SELECT idConflicto, titulo, informacion, imagen, numMotivo, fechaInicio
            FROM conflicto
            INNER JOIN situacion 
            ON conflicto.idConflicto = situacion.idSituacion
            where idContinente = ?
            ORDER BY RAND()
            LIMIT 1";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param('i',$id);
            $stmt->execute();

            $resultado = $stmt->get_result();
            $conflicto = $resultado->fetch_array(MYSQLI_ASSOC);
            
            $resultado->close();
            return $conflicto;

        }catch(mysqli_sql_exception $e){
            $this->error = "Error ".$e->getCode().": Contacte con el administrador.";
            return false;
        }finally {
            $stmt->close();
        }
    }

    function devolver_motivos($id, $numMotivoCorrecto){
        try {
            // Consulta SQL para insertar en la tabla 'situacion'
            $sql = "SELECT textoMotivo, numMotivo
            FROM motivo
            WHERE idConflicto = ? AND numMotivo = ?";

            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param('ii',$id, $numMotivoCorrecto);
            $stmt->execute();
            

            $resultado = $stmt->get_result();
            $motivoCorrecto = $resultado->fetch_array(MYSQLI_ASSOC);
            $resultado->close();

            $sql = "SELECT textoMotivo, numMotivo
            FROM motivo
            WHERE idConflicto = ? AND NOT numMotivo = ?
            ORDER BY RAND()
            LIMIT 2";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param('ii',$id, $numMotivoCorrecto);
            $stmt->execute();

            $resultado = $stmt->get_result();
            $motivos = $resultado->fetch_all(MYSQLI_ASSOC);
            array_push($motivos,$motivoCorrecto);

            return $motivos;
        }catch(mysqli_sql_exception $e){
            $this->error = "Error ".$e->getCode().": Contacte con el administrador.";
            return false;
        }finally {
            $stmt->close();
        }
    }
}
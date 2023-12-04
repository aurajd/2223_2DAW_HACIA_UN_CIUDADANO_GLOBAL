<?php
// Incluye el archivo del modelo que se utiliza en este controlador
require_once __DIR__.'/../modelos/preguntas_ajax.php';

/**
 * Controlador para gestionar operaciones relacionadas con ranking.
 */
class preguntas_ajaxController{

    /**
     * @var preguntas_ajaxModel Instancia del modelo de ranking.
     */
    public $modelo;
    /**
     * Constructor de la clase
     * 
     * @return void
     */
    public function __construct() {
        $this->modelo = new preguntas_ajaxModel();
    }

    function devolver_problema_random(){
        $id = $_GET["id"];
        $problemas = $this->modelo->devolver_problemas($id);
        foreach ($problemas as $key => $problema) {
            $soluciones = $this->modelo->devolver_soluciones($problema["idProblema"]);
            shuffle($soluciones);
            $problemas[$key]["respuestas"] = $soluciones;
            $problemas[$key]["tipo"] = "problema";
        }        
        
        $objeto = new stdClass();
        $objeto = [];
        foreach ($problemas as $fila) {
            array_push($objeto,$fila);
        }

        $conflicto = $this->modelo->devolver_conflicto($id);
        $conflicto["tipo"] = "conflicto";
        $motivos = $this->modelo->devolver_motivos($conflicto["idConflicto"], $conflicto["numMotivo"]);
        shuffle($motivos);
        $conflicto["respuestas"] = $motivos;
        array_push($objeto,$conflicto);
        shuffle($objeto);

        echo json_encode($objeto);
        die();
    }

    function devolver_info_continentes(){
        $continentes = $this->modelo->devolver_info_continentes();
        $objeto = new stdClass();
        $objeto = [];
        foreach ($continentes as $fila) {
            array_push($objeto,$fila);
        }
        echo json_encode($objeto);
        die();
    }
        
}
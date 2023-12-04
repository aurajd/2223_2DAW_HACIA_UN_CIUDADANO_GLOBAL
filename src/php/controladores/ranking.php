<?php
// Incluye el archivo del modelo que se utiliza en este controlador
require_once __DIR__.'/../modelos/ranking.php';

/**
 * Controlador para gestionar operaciones relacionadas con ranking.
 */
class rankingController{


    /**
     * @var rankingModel Instancia del modelo de ranking.
     */
    public $modelo;
    /**
     * Constructor de la clase
     * 
     * @return void
     */
    public function __construct() {
        $this->modelo = new rankingModel();
    }

    function anadir_puntuacion(){
        $nombre = $_POST['nombre'] ?? '';
        $puntuacion = $_POST['puntuacion'] ?? '';
        if($this->validar($nombre,$puntuacion)){
            $estado = $this->modelo->insertar_puntuacion($nombre,$puntuacion);
            if($estado){
                echo "Añadido con éxito";
                die();
            }else{
                echo $this->modelo->error;
                die();
            }
        }
        echo "Valores no validos";
        die();
    }

    function devolver_puntuaciones_ajax(){
        $top5 = $this->modelo->devolver_top_5();
        $objeto = new stdClass();
        $objeto->filas = [];
        foreach ($top5 as $top) {
            array_push($objeto->filas,$top);
        }
        echo json_encode($objeto);
        die();
    }

    /**
     * Valida los datos de un problema.
     *
     * @param string $titulo Título del problema.
     * @param string $informacion Información del problema.
     * @param string $reflexion Texto de reflexión sobre el problema.
     * @param array $imagen Datos de la imagen.
     *
     * @return bool True si los datos son válidos, false si no.
     */
    function validar($nombre,$puntuacion){
        if(empty($nombre)){
            return false;
        }

        if(is_numeric(substr($nombre, 0, 1))){
            return false;
        }

        if(!is_numeric($puntuacion)){
            return false;
        }

        if(strlen($nombre)>30){
            return false;
        }

        // Comprueba que el campo título solo contenga letras, números, espacios y una serie de carácteres concretos
        if (!preg_match('/^[a-zA-ZÑñÁáÉéÍíÓóÚúÜü][a-zA-Z0-9ÑñÁáÉéÍíÓóÚúÜü ]{0,29}$/', $nombre))
        {
            return false;
        }
        return true;
    }
    
}
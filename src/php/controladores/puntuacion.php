<?php
// Incluye el archivo del modelo que se utiliza en este controlador
require_once __DIR__.'/../modelos/puntuacion.php';

/**
 * Controlador para gestionar operaciones relacionadas con la puntuacion.
 */
class puntuacionController{
    

    // Propiedades de la clase
    /**
     * @var string Título de la página.
     */
    public $titulo;
    /**
     * @var problemaModel Instancia del modelo de conflicto.
     */
    public $modelo;
    /**
     * @var string Vista por defecto.
     */
    public $view;

    /**
     * Constructor de la clase
     * 
     * @return void
     */
    public function __construct() {
        $this->modelo = new puntuacionModel();
        $this->titulo = 'Menú puntuación';
        $this->view="listar_puntuaciones";
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

    function mostrar_puntuaciones(){
        $this->view = "listar_puntuaciones";
        $this->titulo = "Listar puntuaciones";
        $puntuaciones = $this->modelo->listar_puntuaciones();
        if($puntuaciones)  
        {
            return $puntuaciones;

        }
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
    

    function confirmar_borrado(){
        $this->view = "borrar_puntuacion";
        $this->titulo = "Borrar puntuaciones";
    }

    function borrar_puntuaciones(){
        $this->modelo->borrar_puntuaciones();
        $this->mostrar_puntuaciones();
    }

}
<?php
// Incluye el archivo del modelo que se utiliza en este controlador
require_once __DIR__.'/../modelos/problema.php';

/**
 * Clase Controlador para manejar la lógica de negocio relacionada con situaciones o problemas.
 */
class problemaController{

    // Propiedades de la clase
    public $titulo;
    public $controladorVolver;
    public $accionVolver;
    public $modelo;
    public $view;

    // Constructor de la clase que inicializa el modelo
    public function __construct() {
        $this->modelo = new problemaModel();
        $this->titulo = '';
        $this->controladorVolver = "";
        $this->accionVolver = "";
    }

    function menu(){
        $this->view = "menu_problema";
        $this->titulo = "Menú problemas";
        $this->controladorVolver = "situacion";
        $this->accionVolver = "menu";
    }

    function mostrar_anadir(){
        $this->view = "anadir_problema";
        $this->titulo = "Añadir problemas";
        $this->controladorVolver = "problema";
        $this->accionVolver = "menu";
    }

    function listar(){
        $this->view = "listar_problema";
        $this->titulo = "Listar problemas";
        $this->controladorVolver = "problema";
        $this->accionVolver = "menu";
        return $this->modelo->listar();
    }

    function mostrar_modificar(){
        $this->view = "modificar_problema";
        $this->titulo = "Modificar problema";
        return $this->modelo->listar_fila($_GET["id"]);
    }

    function confirmar_borrado(){
        $this->view = "borrar_problema";
        $this->titulo = "Borrar problema";
        return $this->modelo->listar_fila($_GET["id"]);
    }

    /**
     * Método para insertar una nueva situación o problema.
     * @param string $titulo Título de la situación.
     * @param string $informacion Información asociada a la situación.
     * @param string $reflexion Reflexión sobre la situación.
     * @param array $imagen Información de la imagen asociada a la situación.
     */
    function insertar(){
        $titulo = $_POST['titulo'];
        $informacion = $_POST['informacion']; 
        $reflexion = $_POST['reflexion'];
        $imagen = $_FILES['imagen'];
        // Verifica que los datos necesarios no estén vacíos antes de insertar
        if ($this->validar($titulo,$informacion,$reflexion,$imagen)) {            
            // Llama al método del modelo para insertar la situación
            $resultado = $this->modelo->insertar_problema($titulo, $informacion, $reflexion, $imagen);
            if($resultado){
                $_GET["respuesta"] = true;
            }
            else{
                $_GET["respuesta"] = false;
                $_GET["error"] = $this->modelo->error;
            }
        } else{
            $_GET["respuesta"] = false;
        }
        $this->mostrar_anadir();
    }

    


    /**
     * Método para modificar una situación o problema existente.
     * @param int $id ID de la situación a modificar.
     * @param string $titulo Nuevo título de la situación.
     * @param string $informacion Nueva información asociada a la situación.
     * @param string $reflexion Nueva reflexión sobre la situación.
     * @param array $imagen Nueva información de la imagen asociada a la situación.
     */
    function modificar(){
        // Verifica que los datos necesarios no estén vacíos antes de modificar
        $id = $_GET['id'];
        $titulo = $_POST['titulo'];
        $informacion = $_POST['informacion']; 
        $reflexion = $_POST['reflexion'];
        $imagen = $_FILES['imagen'];
        // Verifica que los datos necesarios no estén vacíos antes de insertar
        if ($this->validar($titulo,$informacion,$reflexion,$imagen)) {            
            // Llama al método del modelo para insertar la situación
            $resultado = $this->modelo->modificar_fila($id,$titulo, $informacion, $reflexion, $imagen);
            if($resultado){
                $_GET["respuesta_modificacion"] = true;
                return $this->listar();
            }
            $_GET["error"] = $this->modelo->error;
        }
        $_GET["respuesta_modificacion"] = false;
        return $this->mostrar_modificar();
    }

    /**
     * Método para borrar una fila (situación) por su ID y su imagen asociada.
     * @param int $id ID de la situación a borrar.
     * @param array $img Nombre de la imagen asociada.
     */
    function borrar_fila(){
        $id = $_GET["id"];
        // Verifica que el ID no esté vacío antes de borrar
        if (!empty($id)) {
            // Llama al método del modelo para borrar la situación
            $this->modelo->borrar_situacion($id);
        }
        $_GET["respuesta_borrado"] = true;
        return $this->listar();
    }

    function validar($titulo,$informacion,$reflexion, $imagen){
        if(empty($titulo) || empty($informacion) || empty($reflexion)){
            $_GET["error"] = "Debes rellenar todos los campos.";
            return false;
        }
        
        //Si el archivo no existe (no se ha subido ninguno), no se realizan las validaciones de la imagen
        if(file_exists($imagen['tmp_name']))
            // Utilizamos la funcion getimagesize que si se usa en una imagen
            // devuelve un array con la información del tamaño de la imagen, si no devuelve un array no es una imagen
            if (!is_array(getimagesize($imagen['tmp_name']))){
                $_GET["error"] = "La imagen no es válida";
                return false;
            }    
        return true;
    }
    
}

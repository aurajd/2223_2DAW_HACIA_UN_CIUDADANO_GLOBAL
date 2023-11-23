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
        $this->titulo = 'Menú problemas';
        $this->view="menu_problema";
        $this->controladorVolver = "situacion";
        $this->accionVolver = "";
    }

    function mostrar_anadir(){
        $this->view = "anadir_problema";
        $this->titulo = "Añadir problemas";
        $this->controladorVolver = "problema";
    }

    function listar(){
        $this->view = "listar_problema";
        $this->titulo = "Listar problemas";
        $this->controladorVolver = "problema";
        return $this->modelo->listar();
    }

    function mostrar_modificar(){
        $id = $_GET['id'] ?? '';
        if(!$this->modelo->comprobarExisteProblema($id)){
            $_GET["tipomsg"] = "error";
            $_GET["msg"] = "No existe el problema seleccionado.";
            return $this->listar();
        }
        $this->view = "modificar_problema";
        $this->titulo = "Modificar problema";
        $this->controladorVolver = "problema";
        $this->accionVolver = "listar";
        return $this->modelo->listar_fila($id);
    }

    function confirmar_borrado(){
        $id = $_GET['id'] ?? '';
        if(!$this->modelo->comprobarExisteProblema($id)){
            $_GET["tipomsg"] = "error";
            $_GET["msg"] = "No existe el problema seleccionado.";
            return $this->listar();
        }
        $this->view = "borrar_problema";
        $this->titulo = "Borrar problema";
        
        $this->controladorVolver = "problema";
        $this->accionVolver = "listar";
        return $this->modelo->listar_fila($id);
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
                $_GET["tipomsg"] = "exito";
                $_GET["msg"] = "Problema añadido con éxito.";
            }
            else{
                $_GET["tipomsg"] = "error";
                $_GET["msg"] = $this->modelo->error;
            }
        } else{
            $_GET["tipomsg"] = "error";
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
        $id = $_GET['id'] ?? '';
        if(!$this->modelo->comprobarExisteProblema($id)){
            $_GET["tipomsg"] = "error";
            $_GET["msg"] = "No existe el problema seleccionado.";
            return $this->listar();
        }
        $titulo = $_POST['titulo'];
        $informacion = $_POST['informacion']; 
        $reflexion = $_POST['reflexion'];
        $imagen = $_FILES['imagen'];
        // Verifica que los datos necesarios no estén vacíos antes de insertar
        if ($this->validar($titulo,$informacion,$reflexion,$imagen)) {            
            // Llama al método del modelo para insertar la situación
            $resultado = $this->modelo->modificar_fila($id,$titulo, $informacion, $reflexion, $imagen);
            if($resultado){
                $_GET["tipomsg"] = "exito";
                $_GET["msg"] = "Problema modificado con éxito.";
                return $this->listar();
            }
            $_GET["tipomsg"] = "error";
            $_GET["msg"] = $this->modelo->error;
        }
        $_GET["tipomsg"] = "error";
        return $this->mostrar_modificar();
    }

    /**
     * Método para borrar una fila (situación) por su ID y su imagen asociada.
     * @param int $id ID de la situación a borrar.
     * @param array $img Nombre de la imagen asociada.
     */
    function borrar_fila(){
        $id = $_GET['id'] ?? '';
        if(!$this->modelo->comprobarExisteProblema($id)){
            $_GET["tipomsg"] = "error";
            $_GET["msg"] = "No existe el problema seleccionado.";
            return $this->listar();
        }
        $this->modelo->borrar_situacion($id);
        $_GET["tipomsg"] = "exito";
        $_GET["msg"] = "Problema eliminado con éxito.";
        return $this->listar();
    }

    function validar($titulo,$informacion,$reflexion, $imagen){
        if(empty($titulo) || empty($informacion) || empty($reflexion)){
            $_GET["msg"] = "Debes rellenar todos los campos.";
            return false;
        }

        if (preg_match('/[\^£$%&*()}{@#~><>|=_+¬-]/', $titulo))
        {
            $_GET["msg"] = "El título no puede contener carácteres especiales.";
            return false;
        }

        if(is_numeric(substr($titulo, 0, 1))){
            $_GET["msg"] = "El título no puede comenzar por un número.";
            return false;
        }

        if(strlen($titulo)>50 || strlen($informacion)>2000 || strlen($informacion)>2000){
            $_GET["msg"] = "Uno de los campos excede el límite de carácteres.";
            return false;
        }
        
        //Si el archivo no existe (no se ha subido ninguno), no se realizan las validaciones de la imagen
        if(file_exists($imagen['tmp_name'])){
            //Si pesa más de 10 megabytes da error
            if ($imagen['size']> 3000000){
                $_GET["msg"] = "La imagen pesa demasiado.";
                return false;
            }  
            // Utilizamos la funcion getimagesize que si se usa en una imagen
            // devuelve un array con la información del tamaño de la imagen, si no devuelve un array no es una imagen
            if (!is_array(getimagesize($imagen['tmp_name']))){
                $_GET["msg"] = "La imagen no es válida";
                return false;
            }    
        }
        return true;
    }
    
}

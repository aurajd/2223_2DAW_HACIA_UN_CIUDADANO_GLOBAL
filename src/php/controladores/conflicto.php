<?php
// Incluye el archivo del modelo que se utiliza en este controlador
require_once __DIR__.'/../modelos/conflicto.php';

/**
 * Clase Controlador para manejar la lógica de negocio relacionada con situaciones o problemas.
 */
class conflictoController{

    // Propiedades de la clase
    public $titulo;
    public $controladorVolver;
    public $accionVolver;
    public $modelo;
    public $view;

    // Constructor de la clase que inicializa el modelo
    public function __construct() {
        $this->modelo = new conflictoModel();
        $this->titulo = '';
        $this->controladorVolver = "";
        $this->accionVolver = "";
    }

    function menu(){
        $this->view = "menu_conflicto";
        $this->titulo = "Menú conflictos";
        $this->controladorVolver = "situacion";
        $this->accionVolver = "menu";
    }

    function listar(){
        $this->view = "listar_conflicto";
        $this->titulo = "Listar conflictos";
        $this->controladorVolver = "conflicto";
        $this->accionVolver = "menu";
        return $this->modelo->listar();
    }

    function mostrar_anadir(){
        $this->view = "anadir_conflicto";
        $this->titulo = "Añadir conflictos";
        $this->controladorVolver = "conflicto";
        $this->accionVolver = "menu";
    }
    
    function mostrar_modificar(){
        $this->view = "modificar_conflicto";
        $this->titulo = "Modificar conflicto";
        return $this->modelo->listar_conflicto_motivo($_GET["id"]);
    }

    function confirmar_borrado(){
        $this->view = "borrar_conflicto";
        $this->titulo = "Borrar conflicto";
        return $this->modelo->listar_fila($_GET["id"]);
    }

    function insertar(){
        $titulo = $_POST['titulo'];
        $informacion = $_POST['informacion']; 
        $fecha = $_POST['fecha'];
        $imagen = $_FILES['imagen'];
        $motivoCorrecto = isset($_POST['motivoCorrecto']) ? $_POST['motivoCorrecto'] : null;
        $motivos = $_POST['motivos'];
        if ($this->validar($titulo,$informacion,$fecha,$imagen,$motivoCorrecto,$motivos)) {            
            // Llama al método del modelo para insertar el conflicto y sus motivos
            $resultado = $this->modelo->insertar_conflicto($titulo, $informacion, $fecha, $imagen, $motivoCorrecto, $motivos);
            if ($resultado) {
                $_GET["respuesta"] = true;
            }
            else{
                $_GET["respuesta"] = false;
                $_GET["error"] = $this->modelo->error;
            }
        } else{
            $_GET["respuesta"] = false;
        }
        return $this->mostrar_anadir();
    }

    function modificar(){
        $id = $_GET['id'];
        $titulo = $_POST['titulo'];
        $informacion = $_POST['informacion']; 
        $fecha = $_POST['fecha'];
        $imagen = $_FILES['imagen'];
        $motivoCorrecto = isset($_POST['motivoCorrecto']) ? $_POST['motivoCorrecto'] : null;
        $motivos = $_POST['motivos'];
        if ($this->validar($titulo,$informacion,$fecha,$imagen,$motivoCorrecto,$motivos)) {            
            // Llama al método del modelo para insertar el conflicto y sus motivos
            $resultado = $this->modelo->modificar_conflicto($id,$titulo, $informacion, $fecha, $imagen, $motivoCorrecto, $motivos);
            if ($resultado) {
                $_GET["respuesta_modificacion"] = true;
                return $this->listar();
            }
            $_GET["error"] = $this->modelo->error;
        }
        $_GET["respuesta_modificacion"] = false;
        return $this->mostrar_modificar();
    }
    
    function validar($titulo,$informacion,$fecha,$imagen,$motivoCorrecto,$motivos){
        if (!$this->validarConflicto($titulo, $informacion, $fecha, $imagen))
            return false;
        if (!$this->validarMotivos($motivoCorrecto,$motivos))
            return false;
        return true;
    }

    function validarConflicto($titulo, $informacion, $fecha, $imagen){
        if(empty($titulo) || empty($informacion) || empty($fecha)){
            $_GET["error"] = "Debes rellenar todos los campos.";
            return false;
        }

        if(!$this->validarFecha($fecha)){
            $_GET["error"] = "La fecha introducida no es válida.";
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

    function validarMotivos($motivoCorrecto,$motivos){
        if(is_null($motivoCorrecto)){
            $_GET["error"] = "Debes seleccionar un motivo como válido.";
            return false;
        }
        foreach ($motivos as $motivo) {
            if(empty($motivo)){
                $_GET["error"] = "Debes rellenar todos los motivos.";
                return false;
            }
        }
        return true;
    }
    
    function validarFecha($fecha, $formato = 'Y-m-d') {
        // Utilizamos la clase DateTime de PHP para intentar crear un objeto de fecha a partir de la cadena de 
        // fecha proporcionada ($date) y el formato especificado ($format). 
        // Este método devuelve un objeto DateTime si la cadena de fecha es válida y sigue el formato especificado, 
        // o false si no es válida.
        $dateTime = DateTime::createFromFormat($formato, $fecha);
        // Devuelve true si $dateTime no es falsa (es decir, se pudo crear un objeto DateTime) 
        // y si la fecha formateada del objeto $dateTime coincide exactamente con la cadena de fecha original ($date). 
        // En otras palabras, esto verifica si la cadena de fecha proporcionada es válida según el formato especificado.
        return $dateTime && $dateTime->format($formato) === $fecha;
    }
    
    function borrar_fila(){
        $id = $_GET["id"];
        // Verifica que el ID no esté vacío antes de borrar
        if (!empty($id)) {
            // Llama al método del modelo para borrar el conflicto
            $this->modelo->borrar_conflicto($id);
        }
        $_GET["respuesta_borrado"] = true;
        return $this->listar();
    }
}

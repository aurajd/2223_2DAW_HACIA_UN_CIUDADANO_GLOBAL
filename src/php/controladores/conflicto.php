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
        $this->view = "menu_conflicto";
        $this->titulo = "Menú conflictos";
        $this->controladorVolver = "situacion";
        $this->accionVolver = "";
    }

    function listar(){
        $this->view = "listar_conflicto";
        $this->titulo = "Listar conflictos";
        $this->controladorVolver = "conflicto";
        return $this->modelo->listar();
    }

    function listar_motivos(){
        $id = $_GET['id'] ?? '';
        // Si la id que recibe no coincide con ningún conflicto (por ejemplo url modificada) 
        // devuelve a la lista de conflictos y muestra un mensaje de error.
        if(!$this->modelo->comprobarExisteConflicto($id)){
            $_GET["tipomsg"] = "error";
            $_GET["msg"] = "No existe el conflicto seleccionado.";
            return $this->listar();
        }
        $this->view = "listar_motivos";
        $this->titulo = "Listar motivos";
        $this->controladorVolver = "conflicto";
        $this->accionVolver = "listar";
        return $this->modelo->listar_conflicto_motivo($id);
    }

    function mostrar_anadir(){
        $this->view = "anadir_conflicto";
        $this->titulo = "Añadir conflictos";
        $this->controladorVolver = "conflicto";
    }
    
    function mostrar_modificar(){
        $id = $_GET['id'] ?? '';
        // Si la id que recibe no coincide con ningún conflicto (por ejemplo url modificada) 
        // devuelve a la lista de conflictos y muestra un mensaje de error.
        if(!$this->modelo->comprobarExisteConflicto($id)){
            $_GET["tipomsg"] = "error";
            $_GET["msg"] = "No existe el conflicto seleccionado.";
            return $this->listar();
        }
        $this->view = "modificar_conflicto";
        $this->titulo = "Modificar conflicto";
        $this->controladorVolver = "conflicto";
        $this->accionVolver = "listar";
        return $this->modelo->listar_conflicto_motivo($id);
    }

    function confirmar_borrado(){
        $id = $_GET['id'] ?? '';
        // Si la id que recibe no coincide con ningún conflicto (por ejemplo url modificada) 
        // devuelve a la lista de conflictos y muestra un mensaje de error.
        if(!$this->modelo->comprobarExisteConflicto($id)){
            $_GET["tipomsg"] = "error";
            $_GET["msg"] = "No existe el conflicto seleccionado.";
            return $this->listar();
        }
        $this->view = "borrar_conflicto";
        $this->titulo = "Borrar conflicto";
        $this->controladorVolver = "conflicto";
        $this->accionVolver ="listar";
        return $this->modelo->listar_conflicto($id);
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
                $_GET["tipomsg"] = "exito";
                $_GET["msg"] = "Conflicto añadido con éxito.";
            }
            else{
                $_GET["tipomsg"] = "error";
                $_GET["msg"] = $this->modelo->error;
            }
        } else{
            $_GET["tipomsg"] = "error";
        }
        return $this->mostrar_anadir();
    }

    function modificar(){
        $id = $_GET['id'] ?? '';
        // Si la id que recibe no coincide con ningún conflicto (por ejemplo url modificada) 
        // devuelve a la lista de conflictos y muestra un mensaje de error.
        if(!$this->modelo->comprobarExisteConflicto($id)){
            $_GET["tipomsg"] = "error";
            $_GET["msg"] = "No existe el conflicto que deseas modificar.";
            return $this->listar();
        }
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
                $_GET["tipomsg"] = "exito";
                $_GET["msg"] = "Conflicto modificado con éxito.";
                return $this->listar();
            }
            $_GET["tipomsg"] = "error";
        }
        $_GET["tipomsg"] = "error";
        return $this->mostrar_modificar();
    }
    
    function borrar_fila(){
        $id = $_GET['id'] ?? '';
        if(!$this->modelo->comprobarExisteConflicto($id)){
            $_GET["tipomsg"] = "error";
            $_GET["msg"] = "No existe el conflicto que deseas eliminar.";
            return $this->listar();
        }
        // Llama al método del modelo para borrar el conflicto
        $this->modelo->borrar_conflicto($id);
        $_GET["tipomsg"] = "exito";
        $_GET["msg"] = "Conflicto eliminado con éxito.";
        return $this->listar();
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

        if(strlen($titulo)>50 || strlen($informacion)>2000){
            $_GET["msg"] = "Uno de los campos excede el límite de carácteres.";
            return false;
        }

        if(!$this->validarFecha($fecha)){
            $_GET["msg"] = "La fecha introducida no es válida.";
            return false;
        }

        if(!$this->validarFechaMenorActual($fecha)){
            $_GET["msg"] = "La fecha introducida debe ser anterior o igual a la fecha actual.";
            return false;
        }
        
        //Si el archivo no existe (no se ha subido ninguno), no se realizan las validaciones de la imagen
        if(file_exists($imagen['tmp_name'])){
            if ($imagen['size']> 10485760){
                $_GET["msg"] = "La imagen no es válida";
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

    function validarMotivos($motivoCorrecto,$motivos){
        if(is_null($motivoCorrecto)){
            $_GET["msg"] = "Debes seleccionar un motivo como válido.";
            return false;
        }
        if(count($motivos)<$motivoCorrecto || $motivoCorrecto<1){
            $_GET["msg"] = "El valor del motivo seleccionado como correcto no coincide con ningún motivo.";
            return false;
        }
        if(count($motivos)<3){
            $_GET["msg"] = "Debes introducir al menos tres motivos.";
            return false;
        }
        if(strlen($motivos)>2000){
            $_GET["msg"] = "Uno de los motivos excede el límite de carácteres..";
            return false;
        }
        // Comprobamos que no se haya modificado el valor del indice del motivo
        $indiceMotivo = 1;
        foreach ($motivos as $indice => $motivo) {
            if($indice!=$indiceMotivo++){
                $_GET["msg"] = "Se ha modificado el valor del índice de un motivo.";
                return false;
            }
            if(empty($motivo)){
                $_GET["msg"] = "Debes rellenar todos los motivos.";
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
    
    function validarFechaMenorActual($fecha){
        // Tomamos la fecha actual en un string formato año-mes-dia (igual que el input de fecha), 
        // si no se introduce un segundo parámetro en la funcion date toma la fecha actual.
        $fechaActual = date("Y-m-d"); 

        // Los strings con fechas en formato año-mes-dia son comparables, si la actual es mayor o igual que la introducida es válida,
        // si es menor no. 
        if ($fechaActual >= $fecha) 
            return true;
        return false;
        
    }

}

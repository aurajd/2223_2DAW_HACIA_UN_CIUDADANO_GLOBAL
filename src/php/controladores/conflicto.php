<?php
// Incluye el archivo del modelo que se utiliza en este controlador
require_once __DIR__.'/../modelos/conflicto.php';

/**
 * Controlador para gestionar operaciones relacionadas con conflictos.
 */
class conflictoController{

    // Propiedades de la clase
    /**
     * @var string Título de la página.
     */
    public $titulo;
    /**
     * @var string Nombre del controlador al que se redirige para volver atrás.
     */
    public $controladorVolver;
    /**
     * @var string Método a ejecutar al volver atrás.
     */
    public $accionVolver;
    /**
     * @var conflictoModel Instancia del modelo de conflicto.
     */
    public $modelo;
    /**
     * @var string Vista por defecto.
     */
    public $view;

    /**
     * Constructor de la clase que inicializa propiedades por defecto.
     */
    public function __construct() {
        $this->modelo = new conflictoModel();
        $this->view = "menu_conflicto";
        $this->titulo = "Menú conflictos";
        $this->controladorVolver = "situacion";
        $this->accionVolver = "";
    }

    /**
     * Lista los conflictos.
     *
     * @return array Resultado de la operación.
     */
    function listar(){
        $this->view = "listar_conflicto";
        $this->titulo = "Listar conflictos";
        $this->controladorVolver = "conflicto";
        return $this->modelo->listar();
    }

    /**
     * Lista los motivos de un conflicto.
     *
     * @return array Resultado de la operación.
     */
    function listar_motivos(){
        //Si $_GET['id'] no es NULL $id toma su valor, si es NULL se le asigna '' en su lugar
        $id = $_GET['id'] ?? '';
        // Si la id que recibe no coincide con ningún conflicto (por ejemplo url modificada) 
        // devuelve a la lista de conflictos y muestra un mensaje de error.
        if(!$this->modelo->comprobarExisteConflicto($id)){
            //Si se recibe en la lista por $_GET la variable msg se muestra un mensaje, 
            // si tipomsg vale error se le da un estilo al p distinto que si vale exito
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

    /**
     * Muestra el formulario para añadir un conflicto.
     */
    function mostrar_anadir(){
        $this->view = "anadir_conflicto";
        $this->titulo = "Añadir conflictos";
        $this->controladorVolver = "conflicto";
    }
    
    /**
     * Muestra el formulario para modificar un conflicto. Si la id que recibe no existe muestra la lista de conflictos.
     *
     * @return void|array Puede o no devolver nada o devolver información del conflicto a modificar.
     */
    function mostrar_modificar(){
        //Si $_GET['id'] no es NULL $id toma su valor, si es NULL se le asigna '' en su lugar
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

    /**
     * Muestra el formulario para eliminar un conflicto. Si la id que recibe no existe muestra la lista de conflictos.
     *
     * @return void|array Puede o no devolver nada o devolver información del conflicto a eliminar.
     */
    function confirmar_borrado(){
        //Si $_GET['id'] no es NULL $id toma su valor, si es NULL se le asigna '' en su lugar
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

    /**
     * Inserta un nuevo conflicto. Si lo consigue envia por $_GET un mensaje de exito, 
     * si no, uno de error
     *
     * @return void
     */
    function insertar(){
        // Hacemos trim a los datos recibidos para eliminar espacios en blanco antes y después del texto
        $titulo = trim($_POST['titulo']);
        $informacion = trim($_POST['informacion']); 
        $fecha = $_POST['fecha'];
        $imagen = $_FILES['imagen'];
        $motivoCorrecto = isset($_POST['motivoCorrecto']) ? $_POST['motivoCorrecto'] : null;
        $motivos = array_map("trim",$_POST['motivos']);
        //Validamos que todos los datos recibidos sean correctos
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

    /**
     * Modifica un conflicto. Si lo consigue envia por $_GET un mensaje de exito, 
     * si no, uno de error. Si la id que recibe no existe muestra la lista de conflictos.
     *
     * @return void
     */
    function modificar(){
        //Si $_GET['id'] no es NULL $id toma su valor, si es NULL se le asigna '' en su lugar
        $id = $_GET['id'] ?? '';
        // Si la id que recibe no coincide con ningún conflicto (por ejemplo url modificada) 
        // devuelve a la lista de conflictos y muestra un mensaje de error.
        if(!$this->modelo->comprobarExisteConflicto($id)){
            $_GET["tipomsg"] = "error";
            $_GET["msg"] = "No existe el conflicto que deseas modificar.";
            return $this->listar();
        }
        // Hacemos trim a los datos recibidos para eliminar espacios en blanco antes y después del texto
        $titulo = trim($_POST['titulo']);
        $informacion = trim($_POST['informacion']); 
        $fecha = $_POST['fecha'];
        $imagen = $_FILES['imagen'];
        //Si no se ha seleccionado el motivoCorrecto se guarda null
        $motivoCorrecto = isset($_POST['motivoCorrecto']) ? $_POST['motivoCorrecto'] : null;
        // Usamos array_map que devuelve un array que contiene todos los elementos del arrya que le pasamos
        // después de haber aplicado la función callback, trim en este caso, a cada uno de ellos.
        $motivos = array_map("trim",$_POST['motivos']);
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
    
    /**
     * Borra un conflicto. Si lo consigue envia por $_GET un mensaje de exito, 
     * si no, uno de error. Si la id que recibe no existe muestra la lista de conflictos.
     *
     * @return void
     */
    function borrar_fila(){
        $id = $_GET['id'] ?? '';
         // Si la id que recibe no coincide con ningún conflicto (por ejemplo url modificada) 
        // devuelve a la lista de conflictos y muestra un mensaje de error.
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

    /**
     * Valida los datos de un conflicto.
     *
     * @param string $titulo Título del conflicto.
     * @param string $informacion Información del conflicto.
     * @param string $fecha Fecha de inicio del conflicto.
     * @param array $imagen Datos de la imagen.
     * @param string $motivoCorrecto Motivo correcto del conflicto.
     * @param array $motivos Lista de motivos del conflicto.
     *
     * @return bool True si los datos son válidos, false si no.
     */
    function validar($titulo,$informacion,$fecha,$imagen,$motivoCorrecto,$motivos){
        //Realiza validaciones sobre el conflicto
        if (!$this->validarConflicto($titulo, $informacion, $fecha, $imagen))
            return false;
        //realiza validaciones sobre los motivos
        if (!$this->validarMotivos($motivoCorrecto,$motivos))
            return false;
        return true;
    }

    /**
     * Valida los datos específicos de un conflicto.
     *
     * @param string $titulo Título del conflicto.
     * @param string $informacion Información del conflicto.
     * @param string $fecha Fecha de inicio del conflicto.
     * @param array $imagen Datos de la imagen.
     *
     * @return bool True si los datos son válidos, false si no.
     */
    function validarConflicto($titulo, $informacion, $fecha, $imagen){
        // Comprueba que los campos no estén vacíos, si lo están devuelven false y un mensaje de error
        if(empty($titulo) || empty($informacion) || empty($fecha)){
            $_GET["msg"] = "Debes rellenar todos los campos.";
            return false;
        }

        // Comprueba que el campo título no contenga ninguno de estos carácteres haciendo uso de expresiones regulares
        if (preg_match('/[\^£$%&*()}{@#~><>|=_+¬-]/', $titulo))
        {
            $_GET["msg"] = "El título no puede contener carácteres especiales.";
            return false;
        }

        // Comprueba que el campo título no comienze por un número, 
        // toma el primer carácter creando una substring que empieza por el índice 0 y es de tamaño 1, 
        // y comprueba si es un número con is_numeric
        if(is_numeric(substr($titulo, 0, 1))){
            $_GET["msg"] = "El título no puede comenzar por un número.";
            return false;
        }

        //Comprueba que los campos no superen el máximo de carácteres permitidos.
        if(strlen($titulo)>50 || strlen($informacion)>2000){
            $_GET["msg"] = "Uno de los campos excede el límite de carácteres.";
            return false;
        }

        //Valida que la fecha introducida es una fecha
        if(!$this->validarFecha($fecha)){
            $_GET["msg"] = "La fecha introducida no es válida.";
            return false;
        }

        //Valida que la fecha es menor que la fecha actual
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
            // devuelve un array con la información del tamaño de la imagen, 
            // si no devuelve un array no es una imagen
            if (!is_array(getimagesize($imagen['tmp_name']))){
                $_GET["msg"] = "La imagen no es válida";
                return false;
            }    
        }
        return true;
    }

    /**
     * Valida los motivos de un conflicto.
     *
     * @param string $motivoCorrecto Motivo correcto del conflicto.
     * @param array $motivos Lista de motivos del conflicto.
     *
     * @return bool True si los motivos son válidos, false si no.
     */
    function validarMotivos($motivoCorrecto,$motivos){
        // Si es null (no se ha seleccionado motivo correcto) se devuelve un mensaje de error
        if(is_null($motivoCorrecto)){
            $_GET["msg"] = "Debes seleccionar un motivo como válido.";
            return false;
        }
        // Si el motivo correcto es menor a 1 o superior a la cantidad de motivos introducidos se devuelve un mensaje de error
        if(count($motivos)<$motivoCorrecto || $motivoCorrecto<1){
            $_GET["msg"] = "El valor del motivo seleccionado como correcto no coincide con ningún motivo.";
            return false;
        }
        // Comprueba que hay mínimo tres motivos
        if(count($motivos)<3){
            $_GET["msg"] = "Debes introducir al menos tres motivos.";
            return false;
        }
        
        $indiceMotivo = 1;
        //Comprobamos los motivos uno a uno
        foreach ($motivos as $indice => $motivo) {
            // Comprobamos que no se haya modificado el valor del indice del motivo
            if($indice!=$indiceMotivo++){
                $_GET["msg"] = "Se ha modificado el valor del índice de un motivo.";
                return false;
            }
            //Comprobamos que el motivo no esté vacio
            if(empty($motivo)){
                $_GET["msg"] = "Debes rellenar todos los motivos.";
                return false;
            }
            //Comprobamos que no mida mas de 2000 carácteres
            if(strlen($motivo)>2000){
                $_GET["msg"] = "Uno de los motivos excede el límite de carácteres..";
                return false;
            }
        }
        return true;
    }
    
    /**
     * Valida si la fecha tiene un formato válido.
     *
     * @param string $fecha Fecha a validar.
     * @param string $formato Formato de la fecha.
     *
     * @return bool True si la fecha es válida, false si no.
     */
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
    
     /**
     * Valida si la fecha es menor o igual a la fecha actual.
     *
     * @param string $fecha Fecha a comparar.
     *
     * @return bool True si la fecha es válida, false si no.
     */
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

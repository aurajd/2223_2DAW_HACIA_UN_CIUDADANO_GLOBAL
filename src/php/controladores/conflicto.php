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
     * @var conflictoModel Instancia del modelo de conflicto.
     */
    public $modelo;
    /**
     * @var string Vista por defecto.
     */
    public $view;

    /**
     * Constructor de la clase que inicializa propiedades por defecto además del modelo.
     * 
     * @return void
     */
    public function __construct() {
        $this->modelo = new conflictoModel();
        $this->view = "menu_conflicto";
        $this->titulo = "Menú conflictos";
    }

    /**
     * Muestra una lista resumida de los conflictos.
     *
     * @return array Array con todos los datos de los conflictos.
     */
    function listar(){
        $this->view = "listar_conflicto";
        $this->titulo = "Listar conflictos";
    
        // Verifica si se ha enviado el formulario o si se proporcionó el ID del continente en la URL
        if (isset($_POST['continente']) || isset($_GET['continente'])) {
            // Obtén el ID del continente, dando prioridad al valor en el formulario ($_POST)
            $idContinente = $_POST['continente'] ?? $_GET['continente'];
    
            // Validar que el ID del continente sea un número
            if (!is_numeric($idContinente)) {
                $_GET["tipomsg"] = "error";
                $_GET["msg"] = "El ID del continente debe ser un número.";
                return $this->listar();  // Redirecciona a la lista general en caso de error
            }
    
            // Llama al método listar con el ID del continente como argumento
            return $this->modelo->listar($idContinente);
        } else {
            $_GET["tipomsg"] = "error";
            $_GET["msg"] = "Se requiere especificar el ID del continente.";
            return $this->listar();  // Redirecciona a la lista general en caso de no especificar el ID del continente
        }
    }

    /**
     * Muestra una lista de conflictos con varias opciones para gestionarlos.
     *
     * @return array Array con todos los datos de los conflictos.
     */
    function gestionar(){
        $this->view = "gestionar_conflicto";
        $this->titulo = "Gestionar conflictos";
        
        // Verifica si se ha enviado el formulario o si se proporcionó el ID del continente en la URL
        if (isset($_POST['continente']) || isset($_GET['continente']) ) {
            $idContinente = $_POST['continente'] ?? $_GET['continente'];
    
            // Validar que el ID del continente sea un número
            if (!is_numeric($idContinente)) {
                $_GET["tipomsg"] = "error";
                $_GET["msg"] = "El ID del continente debe ser un número.";
                return $this->listar();  // Redirecciona a la lista general en caso de error
            }
    
            // Llama al método listar con el ID del continente como argumento
            return $this->modelo->listar($idContinente);
        } else {
            $_GET["tipomsg"] = "error";
            $_GET["msg"] = "Se requiere especificar el ID del continente.";
            return $this->listar();  // Redirecciona a la lista general en caso de no especificar el ID del continente
        }
    }

    /**
     * Muestra el formulario para añadir un conflicto.
     * 
     * @return void
     */
    function mostrar_anadir(){
        $this->view = "anadir_conflicto";
        $this->titulo = "Añadir conflictos";
    }
    
    /**
     * Muestra información detallada de un conflicto concreto.
     *
     * @return array Array con todos los datos del conflicto.
     */
    function ver_conflicto(){
        $id = $_GET['id'] ?? '';
        if(!$this->modelo->comprobarExisteConflicto($id)){
            $_GET["tipomsg"] = "error";
            $_GET["msg"] = "No existe el conflicto seleccionado.";
            return $this->listar();
        }
        $this->view = "ver_conflicto";
        $this->titulo = "Ver conflicto";
        return $this->modelo->listar_conflicto_motivo($id);
    }

    /**
     * Lista los motivos de un conflicto.
     *
     * @return void|array Resultado de la operación, si la id que recibe no está asociada a ningún conflicto no devuelve nada.
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
            return $this->gestionar();
        }
        $this->view = "listar_motivos";
        $this->titulo = "Listar motivos";
        return $this->modelo->listar_conflicto_motivo($id);
    }
    
    /**
     * Muestra el formulario para modificar un conflicto. Si la id que recibe no existe muestra la vista de gestión de conflictos.
     *
     * @return void|array Información del conflicto a modificar, si la id que recibe no está asociada a ningún conflicto no devuelve nada.
     */
    function mostrar_modificar(){
        //Si $_GET['id'] no es NULL $id toma su valor, si es NULL se le asigna '' en su lugar
        $id = $_GET['id'] ?? '';
        // Si la id que recibe no coincide con ningún conflicto (por ejemplo url modificada) 
        // devuelve a la lista de conflictos y muestra un mensaje de error.
        if(!$this->modelo->comprobarExisteConflicto($id)){
            $_GET["tipomsg"] = "error";
            $_GET["msg"] = "No existe el conflicto seleccionado.";
            return $this->gestionar();
        }
        $this->view = "modificar_conflicto";
        $this->titulo = "Modificar conflicto";
        return $this->modelo->listar_conflicto_motivo($id);
    }

    /**
     * Muestra el formulario para eliminar un conflicto. Si la id que recibe no existe muestra la vista de gestión de conflictos.
     *
     * @return void|array Información del conflicto a eliminar, si la id que recibe no está asociada a ningún conflicto no devuelve nada.
     */
    function confirmar_borrado(){
        //Si $_GET['id'] no es NULL $id toma su valor, si es NULL se le asigna '' en su lugar
        $id = $_GET['id'] ?? '';
        // Si la id que recibe no coincide con ningún conflicto (por ejemplo url modificada) 
        // devuelve a la lista de conflictos y muestra un mensaje de error.
        if(!$this->modelo->comprobarExisteConflicto($id)){
            $_GET["tipomsg"] = "error";
            $_GET["msg"] = "No existe el conflicto seleccionado.";
            return $this->gestionar();
        }
        $this->view = "borrar_conflicto";
        $this->titulo = "Borrar conflicto";
        return $this->modelo->listar_conflicto($id);
    }

    /**
     * Inserta un nuevo conflicto. Si lo consigue envia por $_GET un mensaje de exito, 
     * si no, uno de error
     *
     * @return void
     */
    function insertar(){
        $idContinente = isset($_GET['idContinente']) ? $_GET['idContinente'] : null;

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
            $resultado = $this->modelo->insertar_conflicto($titulo, $informacion, $fecha, $imagen, $motivoCorrecto, $motivos, $idContinente);
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
     * si no, uno de error. Si la id que recibe no existe muestra la gestión de conflictos.
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
            return $this->gestionar();
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
                return $this->gestionar();
            }
            $_GET["tipomsg"] = "error";
        }
        $_GET["tipomsg"] = "error";
        return $this->mostrar_modificar();
    }
    
    /**
     * Borra un conflicto. Si lo consigue envia por $_GET un mensaje de exito, 
     * si no, uno de error. Si la id que recibe no existe muestra la gestión de conflictos.
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
            return $this->gestionar();
        }
        // Llama al método del modelo para borrar el conflicto
        $this->modelo->borrar_conflicto($id);
        $_GET["tipomsg"] = "exito";
        $_GET["msg"] = "Conflicto eliminado con éxito.";
        return $this->gestionar();
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

        // Comprueba que el campo título no comienze por un número, 
        // toma el primer carácter creando una substring que empieza por el índice 0 y es de tamaño 1, 
        // y comprueba si es un número con is_numeric
        if(is_numeric(substr($titulo, 0, 1))||is_numeric(substr($informacion, 0, 1))){
            $_GET["msg"] = "Los campos no puede comenzar por un número.";
            return false;
        }

        //Comprueba que los campos no superen el máximo de carácteres permitidos.
        if(strlen($titulo)>50 || strlen($informacion)>2000){
            $_GET["msg"] = "Uno de los campos excede el límite de carácteres.";
            return false;
        }

        // Comprueba que el campo título solo contenga letras, números, espacios y una serie de carácteres concretos
        if (!preg_match('/^[a-zA-Z0-9ÑñÁáÉéÍíÓóÚúÜü ]{0,49}$/', $titulo))
        {
            $_GET["msg"] = "El título no puede contener carácteres especiales.";
            return false;
        }

        // Comprueba que el campo título solo contenga letras, números, espacios y una serie de carácteres especiales concretos
        if (!preg_match('/^[a-zA-ZÑñÁáÉéÍíÓóÚúÜü][a-zA-ZÑñÁáÉéÍíÓóÚúÜü0-9!¡:;,.¿?"\' ]{0,1999}$/', $informacion))
        {
            $_GET["msg"] = "La información no puede contener carácteres especiales.";
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
            // Comprueba que el campo título solo contenga letras, números, espacios y una serie de carácteres especiales concretos
            if (!preg_match('/^[a-zA-ZÑñÁáÉéÍíÓóÚúÜü][a-zA-ZÑñÁáÉéÍíÓóÚúÜü0-9!¡:;,.¿?"\' ]{0,1999}$/', $motivo))
            {
                $_GET["msg"] = "Los motivos no puede contener carácteres especiales.";
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

<?php
// Incluye el archivo del modelo que se utiliza en este controlador
require_once __DIR__.'/../modelos/problema.php';

/**
 * Controlador para gestionar operaciones relacionadas con problemas.
 */
class problemaController{

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
     * Constructor de la clase que inicializa propiedades por defecto además del modelo.
     * 
     * @return void
     */
    public function __construct() {
        $this->modelo = new problemaModel();
        $this->titulo = 'Menú problemas';
        $this->view="menu_problema";
    }

    /**
     * Muestra una lista resumida de los problemas.
     *
     * @return array Array con todos los datos de los problemas.
     */
    function listar() {
        $this->view = "listar_problema";
        $this->titulo = "Listar problemas";
        
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
     * Muestra una lista de problemas con varias opciones para gestionarlos.
     *
     * @return array Array con todos los datos de los problemas.
     */
    function gestionar(){
        $this->view = "gestionar_problema";
        $this->titulo = "Gestionar problema";
    
        // Verifica si se ha enviado el formulario y si se proporcionó el ID del continente
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
     * Muestra el formulario para añadir un problema.
     * 
     * @return void
     */
    function mostrar_anadir(){
        $this->view = "anadir_problema";
        $this->titulo = "Añadir problemas";
    }

    /**
     * Muestra información detallada de un problema concreto.
     *
     * @return array Array con todos los datos del problema.
     */
    function ver_problema(){
        $id = $_GET['id'] ?? '';
        if(!$this->modelo->comprobarExisteProblema($id)){
            $_GET["tipomsg"] = "error";
            $_GET["msg"] = "No existe el problema seleccionado.";
            return $this->listar();
        }
        $this->view = "ver_problema";
        $this->titulo = "Ver problema";
        return $this->modelo->listar_fila($id);
    }
    
    /**
     * Muestra el formulario para modificar un problema. Si la id que recibe no existe muestra la vista de gestión de problemas.
     *
     * @return void|array Información del conflicto a modificar, si la id que recibe no está asociada a ningún conflicto no devuelve nada.
     */
    function mostrar_modificar(){
        $id = $_GET['id'] ?? '';
        if(!$this->modelo->comprobarExisteProblema($id)){
            $_GET["tipomsg"] = "error";
            $_GET["msg"] = "No existe el problema seleccionado.";
            return $this->gestionar();
        }
        $this->view = "modificar_problema";
        $this->titulo = "Modificar problema";
        return $this->modelo->listar_fila($id);
    }

    /**
     * Muestra el formulario para eliminar un problema. Si la id que recibe no existe muestra la vista de gestión de problemas.
     *
     * @return void|array Información del problema a eliminar, si la id que recibe no está asociada a ningún problema no devuelve nada.
     */
    function confirmar_borrado(){
        $id = $_GET['id'] ?? '';
        if(!$this->modelo->comprobarExisteProblema($id)){
            $_GET["tipomsg"] = "error";
            $_GET["msg"] = "No existe el problema seleccionado.";
            return $this->gestionar();
        }
        $this->view = "borrar_problema";
        $this->titulo = "Borrar problema";
        
        return $this->modelo->listar_fila($id);
    }

    /**
     * Inserta un nuevo problema. Si lo consigue envia por $_GET un mensaje de exito, 
     * si no, uno de error
     *
     * @return void
     */
    function insertar(){
        $idContinente = $_GET['continente'];
        if(!is_numeric($idContinente)){
            $_GET["tipomsg"] = "error";
            $_GET["msg"] = "La id del continente no es válida.";
            $this->mostrar_anadir();  // Redirecciona en caso de error 
        }
        $titulo = trim($_POST['titulo']);
        $informacion = trim($_POST['informacion']);
        $reflexion = trim($_POST['reflexion']);
        $imagen = $_FILES['imagen'];
        $soluciones = $_POST['soluciones'] ?? array(); // Se obtienen las soluciones
        $correctas = $_POST['correctas'] ?? "";   // Se obtienen las respuestas correctas
    
        // Verificar que al menos una opción sea marcada como correcta
        if (empty($correctas)) {
            $_GET["tipomsg"] = "error";
            $_GET["msg"] = "Debes marcar al menos una opción como correcta.";
            $this->mostrar_anadir();  // Redirecciona en caso de error
        } else {
            // Realizar la inserción en la base de datos
            if ($this->validar($titulo, $informacion, $reflexion, $imagen, $soluciones, $correctas)) {
                $resultado = $this->modelo->insertar_problema($titulo, $informacion, $reflexion, $imagen, $soluciones, $correctas,$idContinente);
    
                if ($resultado) {
                    $_GET["tipomsg"] = "exito";
                    $_GET["msg"] = "Problema añadido con éxito.";
                    
                    // Redireccionar a la vista "anadir_problema"
                    $this->mostrar_anadir();
                    return;
                } else {
                    $_GET["tipomsg"] = "error";
                    $_GET["msg"] = $this->modelo->error;
                }
            } else {
                $_GET["tipomsg"] = "error";
            }
    
            // Si la inserción no fue exitosa o hubo un error de validación, redirigir a "mostrar_anadir"
            $this->mostrar_anadir();
        }
    }
    
    
   /**
     * Modifica un problema. Si lo consigue, envía por $_GET un mensaje de éxito,
     * si no, uno de error. Si la id que recibe no existe, muestra la gestión de problemas.
     *
     * @return void
     */
    function modificar() {
        $id = $_GET['id'] ?? '';
        if (!$this->modelo->comprobarExisteProblema($id)) {
            $_GET["tipomsg"] = "error";
            $_GET["msg"] = "No existe el problema seleccionado.";
            return $this->gestionar();
        }

        $titulo = trim($_POST['titulo']);
        $informacion = trim($_POST['informacion']);
        $reflexion = trim($_POST['reflexion']);
        $imagen = $_FILES['imagen'];
        $soluciones = $_POST['soluciones'] ?? [];  // Hay que asgurarse de tener $soluciones disponible
        $correctas = $_POST['correctas'] ?? [];


        // Verificar que al menos una opción sea marcada como correcta
        if (empty($correctas)) {
            $_GET["tipomsg"] = "error";
            $_GET["msg"] = "Debes marcar al menos una opción como correcta.";
            $this->mostrar_anadir();  // Redirecciona en caso de error
        } else {
            // Validar antes de modificar
            if ($this->validar($titulo, $informacion, $reflexion, $imagen, $soluciones, $correctas)) {
                // Continuar con la lógica de modificación
                $resultado = $this->modelo->modificar_fila($id, $titulo, $informacion, $reflexion, $imagen, $correctas);
                if ($resultado) {
                    $_GET["tipomsg"] = "exito";
                    $_GET["msg"] = "Problema modificado con éxito.";
                    return $this->gestionar();
                }
                $_GET["tipomsg"] = "error";
                $_GET["msg"] = $this->modelo->error;
            } else {
                $_GET["tipomsg"] = "error";
            }
        }
        return $this->mostrar_modificar();
}


    /**
     * Borra un problema. Si lo consigue envia por $_GET un mensaje de exito, 
     * si no, uno de error. Si la id que recibe no existe muestra la gestión de problemas.
     *
     * @return void
     */
    function borrar_fila(){
        $id = $_GET['id'] ?? '';
        if(!$this->modelo->comprobarExisteProblema($id)){
            $_GET["tipomsg"] = "error";
            $_GET["msg"] = "No existe el problema seleccionado.";
            return $this->gestionar();
        }
        $this->modelo->borrar_situacion($id);
        $_GET["tipomsg"] = "exito";
        $_GET["msg"] = "Problema eliminado con éxito.";
        return $this->gestionar();
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
    function validar($titulo, $informacion, $reflexion, $imagen, $soluciones, $correctas){
        if(empty($titulo) || empty($informacion) || empty($reflexion)){
            $_GET["msg"] = "Debes rellenar todos los campos.";
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

        // Comprueba que el campo título solo contenga letras, números, espacios y una serie de carácteres concretos
        if (!preg_match('/^[a-zA-ZÑñÁáÉéÍíÓóÚúÜü][a-zA-Z0-9ÑñÁáÉéÍíÓóÚúÜü ]{0,49}$/', $titulo))
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

            // Validar soluciones
        if (empty($soluciones) || !is_array($soluciones)) {
            $_GET["msg"] = "Debes proporcionar al menos una solución.";
            return false;
        }

        foreach ($soluciones as $solucion) {
            // Comprobar si la solución está vacía o contiene caracteres especiales
            if (empty($solucion) || !preg_match('/^[a-zA-ZÑñÁáÉéÍíÓóÚúÜü0-9!¡:;,.¿?"\' ]{0,199}$/', $solucion)) {
                $_GET["msg"] = "Las soluciones no pueden estar vacías y deben contener solo caracteres válidos.";
                return false;
            }
        }

        foreach ($correctas as $respuestaCorrecta) {
            if (!preg_match('/^[a-zA-Z0-9,]+$/', $respuestaCorrecta)) {
                $_GET["msg"] = "Las respuestas correctas deben contener solo letras, números y comas.";
                return false;
            }
        }
        
            return true;
        }
}
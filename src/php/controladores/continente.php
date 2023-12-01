<?php
// Incluye el archivo del modelo que se utiliza en este controlador
require_once __DIR__.'/../modelos/continente.php';

/**
 * Controlador para gestionar operaciones relacionadas con continentes.
 */
class ContinenteController {

    // Propiedades de la clase
    /**
     * @var string Título de la página.
     */
    public $titulo;
    /**
     * @var ContinenteModel Instancia del modelo de continente.
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
        $this->modelo = new ContinenteModel();
        $this->titulo = 'Menú continentes';
        $this->view = "menu_continente";
    }

    function gestionar() {
        // Agrega aquí la lógica para gestionar continentes
        // Puedes redirigir a la vista correspondiente o realizar otras operaciones según sea necesario
        $this->view = "gestionar_continente";
        $this->titulo = "Gestionar continente";
        return $this->modelo->listar_continentes();
    }

    function ver_continente() {
        $id = $_GET['id'] ?? '';
    
        // Cambiado para obtener la información del continente
        $infoContinente = $this->modelo->obtener_informacion_continente($id);
    
        if ($infoContinente) {
            // Cambiado para pasar la información del continente a la vista
            include_once __DIR__.'/../vistas/listar_continente.php';
        }
    }
    
    /**
     * Muestra el formulario para modificar un continente. Si la id que recibe no existe, muestra la vista de gestión de continentes.
     *
     * @return void|array Información del continente a modificar, si la id que recibe no está asociada a ningún continente no devuelve nada.
     */
    function mostrar_modificar() {
        $id = $_GET['id'] ?? '';
        if (!$this->modelo->comprobar_existe_continente($id)) {
            $_GET["tipomsg"] = "error";
            $_GET["msg"] = "No existe el continente seleccionado.";
            return $this->gestionar();
        }

        $this->view = "modificar_continente";
        $this->titulo = "Modificar continente";

        // Agrega aquí tu lógica para obtener la información del continente a modificar
        $infoContinente = $this->modelo->obtener_informacion_continente($id);

        return $infoContinente;
    }

   /**
     * Modifica un continente. Si lo consigue, envía por $_GET un mensaje de éxito,
     * si no, uno de error. Si la id que recibe no existe, muestra la gestión de continentes.
     *
     * @return void
     **/

/**
 * Modifica un continente. Si lo consigue, envía por $_GET un mensaje de éxito,
 * si no, uno de error. Si la id que recibe no existe, muestra la gestión de continentes.
 *
 * @return void
 **/
function modificar() {
    $id = $_GET['id'] ?? '';
    if (!$this->modelo->comprobar_existe_continente($id)) {
        $_GET["tipomsg"] = "error";
        $_GET["msg"] = "No existe el continente seleccionado.";
        return $this->gestionar();
    }

    // Obtener información del continente
    $infoContinente = $this->modelo->obtener_informacion_continente($id);

    // Verificar si se obtuvo la información del continente
    if (!$infoContinente) {
        $_GET["tipomsg"] = "error";
        $_GET["msg"] = "Error al obtener la información del continente.";
        return $this->gestionar();
    }

    // Resto del código para modificar el continente

    $nombre = $_POST['nombre'] ?? '';
    $informacion = $_POST['informacion'] ?? '';
    $resumenInfo = $_POST['resumenInfo'] ?? '';
    $imagen = $_FILES['imagen'] ?? null;

    // Verificar si se proporcionó una nueva imagen
    if ($imagen && $imagen['size'] > 0) {
        // Lógica para procesar la nueva imagen
        // Puedes usar el nombre original o generar uno único
        $imagenNombre = $imagen['name'];
        move_uploaded_file($imagen['tmp_name'], __DIR__.'/../img/'.$imagenNombre);
    } else {
        // Si no se proporciona una nueva imagen, conservar la existente
        $imagenNombre = $infoContinente['imagen'] ?? null;
    }

    // Resto del código para modificar el continente
    $exito = $this->modelo->modificar_continente($id, $nombre, $informacion, $resumenInfo, $imagenNombre);

    if (!$exito) {
        $_GET["tipomsg"] = "error";
        $_GET["msg"] = "Error al modificar el continente.";
    }

    return $this->gestionar();
}




}
?>

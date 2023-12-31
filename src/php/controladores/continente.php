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
        $this->view = "listar_continente";
        $this->titulo = "Gestionar continente";
        return $this->modelo->listar_continentes();
    }

    function ver_continente() {
        $id = $_GET['id'] ?? '';
    
        // Obtener la información del continente
        $infoContinente = $this->modelo->obtener_informacion_continente($id);
    
        if ($infoContinente) {
            // Pasar la información del continente a la vista
            $this->titulo = 'Lista continente';
            $this->view = "listar_continente";
            return $infoContinente;
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

        $infoContinente = $this->modelo->obtener_informacion_continente($id);

        return $infoContinente;
    }

    /**
     * Modifica un continente. Si lo consigue, envía por $_GET un mensaje de éxito,
     * si no, uno de error. Si la id que recibe no existe, muestra la gestión de continentes.
     *
     * @return void
     */
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

        $informacion = isset($_POST['informacion']) ? $_POST['informacion'] : '';
        $resumenInfo = isset($_POST['resumenInfo']) ? $_POST['resumenInfo'] : '';
        $imagen = $_FILES['imagen'];

        // Validar los datos del continente
        if (!$this->validar_continente($informacion, $resumenInfo, $imagen)) {
            // Redirigir a la vista de "modificar_continente" con los datos actuales
            return $this->mostrar_modificar();
        }

        // Verificar si se proporcionó una nueva imagen
        if ($imagen && $imagen['size'] > 0) {
            // Actualizar la información del continente con la nueva imagen
            $exito = $this->modelo->modificar_continente($id, $informacion, $resumenInfo, $imagen);
        } else {
            // Si no se proporciona una nueva imagen, conservar la existente
            $exito = $this->modelo->modificar_continente($id, $informacion, $resumenInfo, null);
        }

        // Verificar si la modificación fue exitosa
        if ($exito) {
            // Obtener la información actualizada del continente
            $infoContinente = $this->modelo->obtener_informacion_continente($id);

            if ($infoContinente) {
                // Pasar la información del continente a la vista
                $this->titulo = 'Lista continente';
                $this->view = "listar_continente";
                return $infoContinente;
            } else {
                // Si no se puede obtener la información, mostrar un mensaje de error
                $_GET["tipomsg"] = "error";
                $_GET["msg"] = "Error al obtener la información actualizada del continente.";
            }
        }

        return $this->gestionar();
    }

    /**
     * Valida los datos de un continente.
     *
     * @param string $nombre Nombre del continente.
     * @param string $informacion Información del continente.
     * @param string $resumenInfo Resumen de la información del continente.
     * @param array|null $imagen Datos de la imagen (puede ser null si no se proporciona una nueva imagen).
     *
     * @return bool True si los datos son válidos, false si no.
     */
    function validar_continente($informacion, $resumenInfo, $imagen) {
        if (empty($informacion) || empty($resumenInfo)) {
            $_GET["tipomsg"] = "error";
            $_GET["msg"] = "Debes rellenar todos los campos.";
            return false;
        }

        if (strlen($informacion) > 2000 || strlen($resumenInfo) > 500) {
            $_GET["tipomsg"] = "error";
            $_GET["msg"] = "Uno de los campos excede el límite de caracteres.";
            return false;
        }

        // Comprueba que los campos información y resumenInfo solo contengan letras, números, espacios y una serie de caracteres especiales concretos
        $patron = '/^[a-zA-ZÑñÁáÉéÍíÓóÚúÜü][a-zA-ZÑñÁáÉéÍíÓóÚúÜü0-9!¡:;,.¿?"\'\r?\n ]{0,1999}$/';
        if (!preg_match($patron, $informacion) || !preg_match($patron, $resumenInfo)) {
            $_GET["tipomsg"] = "error";
            $_GET["msg"] = "La información y el resumen no pueden contener ciertos caracteres especiales.";
            return false;
        }

        // Validar la imagen si se proporciona una nueva
        if ($imagen && $imagen['size'] > 0) {
            // Lógica de validación de imagen (puedes agregar más validaciones según sea necesario)
            if ($imagen['size'] > 3000000) {
                $_GET["tipomsg"] = "error";
                $_GET["msg"] = "La imagen pesa demasiado.";
                return false;
            }

            if (!is_array(getimagesize($imagen['tmp_name']))) {
                $_GET["tipomsg"] = "error";
                $_GET["msg"] = "La imagen no es válida.";
                return false;
            }
        }

        return true;
    }
}

?>
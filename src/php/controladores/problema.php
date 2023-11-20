<?php
// Incluye el archivo del modelo que se utiliza en este controlador
require_once __DIR__.'/../modelos/problema.php';

/**
 * Clase Controlador para manejar la lógica de negocio relacionada con situaciones o problemas.
 */
class problemaController{

    // Propiedades de la clase
    public $modelo;
    public $view;

    // Constructor de la clase que inicializa el modelo
    public function __construct() {
        $this->modelo = new problemaModel();
    }

    function menu(){
        $this->view = "menu_problema";
    }

    function listar(){
        $this->view = "listar_problema";
        return $this->modelo->listar();
    }

    

    /**
     * Método para insertar una nueva situación o problema.
     * @param string $titulo Título de la situación.
     * @param string $informacion Información asociada a la situación.
     * @param string $reflexion Reflexión sobre la situación.
     * @param array $imagen Información de la imagen asociada a la situación.
     */
    function insertar($titulo, $informacion, $reflexion, $imagen){
        // Verifica que los datos necesarios no estén vacíos antes de insertar
        if ($this->validar($titulo,$informacion,$reflexion)) {            
            // Llama al método del modelo para insertar la situación
            $this->modelo->insertar_situacion($titulo, $informacion, $reflexion, $imagen);
        }
    }

    /**
     * Método para modificar una situación o problema existente.
     * @param int $id ID de la situación a modificar.
     * @param string $titulo Nuevo título de la situación.
     * @param string $informacion Nueva información asociada a la situación.
     * @param string $reflexion Nueva reflexión sobre la situación.
     * @param array $imagen Nueva información de la imagen asociada a la situación.
     */
    function modificar($id, $titulo, $informacion, $reflexion, $imagen){
        // Verifica que los datos necesarios no estén vacíos antes de modificar
        if($this->validar($titulo,$informacion,$reflexion) && !empty($id)){

            // Llama al método del modelo para modificar la situación
            $this->modelo->modificar_fila($id, $titulo, $informacion, $reflexion, $imagen);
        }
    }

    /**
     * Método para borrar una fila (situación) por su ID y su imagen asociada.
     * @param int $id ID de la situación a borrar.
     * @param array $img Nombre de la imagen asociada.
     */
    function borrar_fila($id, $img){
        // Verifica que el ID no esté vacío antes de borrar
        if (!empty($id)) {
            // Llama al método del modelo para borrar la situación
            $this->modelo->borrar_situacion($id, $img);
        }
    }

    function validar($titulo,$informacion,$reflexion){
        if(!empty($titulo) && !empty($informacion) && !empty($reflexion))
            return true;
        return false;
    }

    function validarImagen($img){
        
    }
}

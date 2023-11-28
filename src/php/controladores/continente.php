<?php

/**
 * Controlador que gestiona los contientes.
 */
class continenteController{

    // Propiedades de la clase
    
    

    /**
     * Constructor de la clase continenteController.
     *
     *
     * @return void
     */
    public function __construct() {
        
    /**
     * Muestra una lista de conflictos con varias opciones para gestionarlos.
     *
     * @return array Array con todos los datos de los conflictos.
     */
    function gestionar() {
        $continente = $_GET['continente'] ?? ''; // Obtén el continente de la URL

        // Validación adicional si es necesario
        if (!in_array($continente, ['Europa', 'Asia', 'Oceanía', 'América del norte', 'América del sur', 'África'])) {
            // Manejar error, por ejemplo, redirigir a una página de error o mostrar un mensaje
            die("Error: Continente no válido");
        }

        $this->view = "gestionar_conflicto";
        $this->titulo = "Gestionar conflictos en $continente";

        // Utiliza el método del modelo para obtener conflictos por continente
        $conflictos = $this->modelo->listarPorContinente($continente);

        // Realiza las acciones necesarias con los conflictos obtenidos
        // ...

        return $conflictos;
    }
    
}

<?php
// Incluye el archivo del controlador
require_once __DIR__.'/../controladores/c_situacion_problema.php';

try {
    // Crea una instancia del controlador
    $controlador = new Controlador();

    // Obtiene y valida los valores de 'id' e 'img' desde la URL usando $_GET
    /** @var int|null $id ID de la fila a borrar */
    $id = isset($_GET['id']) ? intval($_GET['id']) : null;

    /** @var string|null $img Nombre de la imagen asociada a la fila */
    $img = isset($_GET['img']) ? $_GET['img'] : null;

    if ($id !== null && $img !== null) {
        // Llama al método 'borrar_fila' del controlador para borrar la fila
        $controlador->borrar_fila($id, $img);

        // Redirige a la página 'listar_problema.php' después de borrar
        header("Location: listar_problema.php");
        exit();
    } else {
        // Manejo de error si 'id' o 'img' están ausentes o no válidos
        throw new Exception("Parámetros no válidos. Contacte con el administrador");
    }
} catch (Exception $e) {
    // Manejo de errores generales
    echo "Error: " . $e->getMessage();
}
?>

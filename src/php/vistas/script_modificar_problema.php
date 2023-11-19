<?php
require_once __DIR__.'/../controladores/c_situacion_problema.php';

try {
    // Crear una instancia del controlador
    $controlador = new Controlador();

    // Obtener y validar los parámetros desde $_GET y $_POST
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_STRING);
    $informacion = filter_input(INPUT_POST, 'informacion', FILTER_SANITIZE_STRING);
    $reflexion = filter_input(INPUT_POST, 'reflexion', FILTER_SANITIZE_STRING);
    $imagen = $_FILES['imagen'] ?? null;

    // Verificar si el ID es válido
    if ($id === false || $id === null || $id <= 0) {
        throw new Exception("Valores no válido. Contacte con el administrador");
    }

    // Llamar al método 'modificar' del controlador para actualizar la fila
    $controlador->modificar($id, $titulo, $informacion, $reflexion, $imagen);

    // Redirigir a la página 'listar_problema.php' después de modificar
    header('Location: listar_problema.php');
    exit();
} catch (Exception $e) {
    // Manejar errores generales
    echo "Error: " . $e->getMessage();
}
?>

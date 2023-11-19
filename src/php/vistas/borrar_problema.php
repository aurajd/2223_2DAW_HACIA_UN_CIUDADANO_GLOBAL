<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar Borrado</title>
    <link rel="stylesheet" href="../../css/style_admin.css">
</head>
<body>
    <main>
        <div>
            <h1>¿Estas seguro de eliminar este problema?</h1>
            <?php
                require_once __DIR__."/../modelos/m_situacion_problema.php";
                $modelo = new Modelo();
                $fila = $modelo->listar_fila($_GET['id']);

                echo "
                    <p class='titulo'>Título:</p>
                    <p class='campos'>{$fila[0]['titulo']}</p>
                    <p class='titulo'>Informacion:</p>
                    <textarea readonly>{$fila[0]['informacion']}</textarea>
                    <p class='titulo'>Reflexión:</p>
                    <textarea readonly>{$fila[0]['reflexion']}</textarea>
                    <p class='titulo'>Imagen:</p>
                    <img src='../../img/{$fila[0]['imagen']}' id='imagenMostrar'>
                    <div class='opciones'>
                        <a href='script_borrar_problema.php?id={$_GET['id']}&img={$fila[0]['imagen']}'>Aceptar</a>
                        <a href='listar_problemas.php'>Cancelar</a>
                    </div>";
            ?>
        </div>
    </main>
</body>
</html>
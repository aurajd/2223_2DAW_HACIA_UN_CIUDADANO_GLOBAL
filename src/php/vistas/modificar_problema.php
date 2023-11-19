<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar problema</title>
    <link rel="stylesheet" href="../../css/style_admin.css">
</head>
<body>
    <main>
        <div>
            <h1>Modificar problema</h1>
            <?php
                require_once __DIR__."/../modelos/m_situacion_problema.php";
                $modelo = new Modelo();
                
                $fila = $modelo->listar_fila($_GET['id']);

                echo "
                    <form method='post' enctype='multipart/form-data' action='script_modificar_problema.php?id={$_GET['id']}'>
                        <label for='titulo'>Título:</label>
                        <input type='text' name='titulo' value='{$fila[0]['titulo']}'>
                        
                        <label for='informacion'>Información:</label>
                        <textarea name='informacion'>{$fila[0]['informacion']}</textarea>
                        
                        <label for='reflexion'>Reflexión:</label>
                        <textarea name='reflexion'>{$fila[0]['reflexion']}</textarea>
                        
                        <p class='titulo'>Imagen actual:</p>
                        <img src='../../img/{$fila[0]['imagen']}' id='imagenMostrar'>
                        
                        <label for='imagen'>Modificar imagen (opcional):</label>
                        <input type='file' name='imagen'>
                        
                        <div class='opciones'>
                            <input type='submit' value='Aceptar' name='aceptar'>
                            <a href='listar_problemas.php'>Cancelar</a>
                        </div>
                    </form>";

                ?>
            </form>
        </div>
    </main>
</body>
</html>
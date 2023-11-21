<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir problema</title>
    <link rel="stylesheet" href="css/style_admin.css">
</head>
<body>
    <nav class="navbar">
        <h1>Añadir problema</h1>
        <a class="back-link" href="index.php?controller=problema&action=menu">Volver</a>
    </nav>
    <main>
        <div>
            <?php
                $titulo = $informacion = $reflexion = $imagen = '';
                if(isset($_POST["titulo"]) &  isset($_GET["respuesta"])) 
                    if ($_GET["respuesta"] == false) $titulo = $_POST["titulo"];
                if(isset($_POST["informacion"]) & isset($_GET["respuesta"])) 
                    if ($_GET["respuesta"] == false) $informacion = $_POST["informacion"];
                if(isset($_POST["reflexion"]) & isset($_GET["respuesta"]))
                    if ($_GET["respuesta"] == false) $reflexion = $_POST["reflexion"];


                if(isset($_GET["respuesta"])){
                    if($_GET["respuesta"]==true){
                        ?>
                        <p id="exito">Problema añadido con éxito.</p>
                        <?php
                    }else{
                        ?>
                        <p id="error">
                            
                            <?php echo $_GET["error"] ?>
                        </p>
                        <?php
                    }
                }
            ?>
            <form action="index.php?controller=problema&action=insertar" method="post" enctype="multipart/form-data">
                    <label for="titulo">Título:</label>
                    <input type="text" name="titulo" value='<?php echo $titulo; ?>'>
                    <label for="informacion">Informacion:</label>
                    <textarea name="informacion"><?php echo $informacion; ?></textarea>
                    <label for="reflexion">Reflexión:</label>
                    <textarea name="reflexion"><?php echo $reflexion; ?></textarea>
                    <label for="imagen">Imagen (opcional):</label>
                    <input type="file" name="imagen">
                    <input type="submit" value="Enviar" id="anadirBoton">
            </form>
        </div>
    </main>
</body>
</html>
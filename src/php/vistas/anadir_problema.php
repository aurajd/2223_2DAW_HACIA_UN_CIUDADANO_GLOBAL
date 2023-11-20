<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir problema</title>
    <link rel="stylesheet" href="css/style_admin.css">
</head>
<body>
    <nav><a href="index.php?controller=problema&action=menu">Volver</a></nav>
    <main>
        <div>
            <h1>Añadir problema</h1>
            <?php
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
                    <input type="text" name="titulo">
                    <label for="informacion">Informacion:</label>
                    <textarea name="informacion"></textarea>
                    <label for="reflexion">Reflexión:</label>
                    <textarea name="reflexion"></textarea>
                    <label for="imagen">Imagen (opcional):</label>
                    <input type="file" name="imagen">
                    <input type="submit" value="Enviar" id="anadirBoton">
            </form>
        </div>
    </main>
</body>
</html>
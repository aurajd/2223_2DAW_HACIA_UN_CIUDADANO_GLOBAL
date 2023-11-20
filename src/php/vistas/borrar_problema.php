<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar Borrado</title>
    <link rel="stylesheet" href="css/style_admin.css">
</head>
<body>
    <nav><a href="index.php?controller=problema&action=listar">Volver</a></nav>
    <main>
        <div>
            <h1>¿Estas seguro de eliminar este problema?</h1>
                <p class='titulo'>Título:</p>
                <p class='campos'><?php echo $dataToView["data"]["titulo"] ?></p>
                <p class='titulo'>Informacion:</p>
                <textarea readonly><?php echo $dataToView["data"]["informacion"] ?></textarea>
                <p class='titulo'>Reflexión:</p>
                <textarea readonly><?php echo $dataToView["data"]["reflexion"] ?></textarea>
                <?php
                    if(!is_null($dataToView["data"]["imagen"])){
                    ?>
                        <p class='titulo'>Imagen:</p>
                        <img src='img/<?php echo $dataToView["data"]["imagen"] ?>' id='imagenMostrar'>
                    <?php
                    }
                ?>
                <div class='opciones'>
                    <a href='index.php?controller=problema&action=borrar_fila&id=<?php echo $dataToView["data"]['idSituacion']?>'>Aceptar</a>
                    <a href='index.php?controller=problema&action=listar'>Cancelar</a>
                </div>
            ?>
        </div>
    </main>
</body>
</html>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista problemas</title>
    <link rel="stylesheet" href="css/style_admin.css">
</head>
<body>
    <nav class="navbar">
        <h1><?php echo $controlador->titulo ?></h1>
        <?php if(!empty($controlador->controladorVolver)){ ?>
            <a class="back-link" href="index.php?controller=<?php echo $controlador->controladorVolver ?><?php if (!empty($controlador->accionVolver)){echo "&action=".$controlador->accionVolver;} ?>">Ir atrás</a>
        <?php }?>
    </nav>
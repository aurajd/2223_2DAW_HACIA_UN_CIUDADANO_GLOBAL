<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $controlador->titulo ?></title>
    <link rel="stylesheet" href="css/style_admin.css">
</head>
<body>
    <nav>
        <h1>MENÚ ADMINISTRADOR</h1>
        <a href="index.php?controller=continente">Continentes</a>        
        <a href="index.php?controller=problema">Problemas</a>        
        <a href="index.php?controller=conflicto">Conflictos</a>
        <a href="index.php?controller=puntuacion">Puntuaciones</a>
    </nav>
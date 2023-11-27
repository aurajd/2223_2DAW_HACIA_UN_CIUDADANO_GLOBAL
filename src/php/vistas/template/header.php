<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $controlador->titulo ?></title>
    <link rel="stylesheet" href="css/style_admin.css">
</head>
<body>
    <nav class="navbar">
        <h1>Menú administrador</h1>
        <a href="index.php?controller=continente" class="back-link">Continentes</a>        
        <a href="index.php?controller=problema" class="back-link">Problemas</a>        
        <a href="index.php?controller=conflicto" class="back-link">Conflictos</a>
        <a href="index.php?controller=puntuacion" class="back-link">Puntuaciones</a>
    </nav>
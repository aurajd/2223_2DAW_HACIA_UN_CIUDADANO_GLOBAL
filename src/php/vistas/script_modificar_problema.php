<?php
    require_once __DIR__.'/../controladores/c_situacion_problema.php';
    $controlador = new Controlador();
    $controlador->modificar($_GET['id'], $_POST['titulo'], $_POST['informacion'], $_POST['reflexion'], $_FILES['imagen']);
    header('Location: listar_problema.php');
<?php
    require_once __DIR__.'/../controladores/c_situacion_problema.php';
    $controlador = new Controlador();
    $controlador->borrar_fila($_GET['id'], $_GET['img']);
    header("Location: listar_problema.php");
    exit();
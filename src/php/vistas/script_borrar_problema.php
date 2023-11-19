<?php
    require_once __DIR__.'/../modelos/m_situacion_problema.php';
    $modelo = new Modelo();
    $modelo->borrar_situacion($_GET['id'], $_GET['img']);
    header("Location: listar_problema.php");
    exit();
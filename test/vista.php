<?php
    require 'controlador.php';
    $controlador = new Controlador();
    $controlador->insertar($_POST['titulo'], $_POST['informacion'], $_POST['reflexion'], $_POST['imagen']);
    header("Location:anadir_problema.php");
    
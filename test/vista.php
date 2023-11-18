<?php
    require $_GET["c"].'.php';
    $controlador = new Controlador();
    $controlador->insertar($_POST['titulo'], $_POST['informacion'], $_POST['reflexion'], $_FILES['imagen']);
    header("Location:anadir_problema.php");
    
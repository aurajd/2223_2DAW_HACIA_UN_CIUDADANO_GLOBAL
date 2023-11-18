<?php
    require 'controlador.php';
    $controlador = new Controlador();
    $controlador->borrar($_POST['id']);
    header("Location:borrar_problema.php");
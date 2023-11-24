<?php

// Crear un objeto stdClass
$objeto = new stdClass();
$objeto->atrib1 = 'Hola Pepe';
$objeto->atrib2 = 42;

// Convertir el objeto a formato JSON y mostrarlo
echo json_encode($objeto);
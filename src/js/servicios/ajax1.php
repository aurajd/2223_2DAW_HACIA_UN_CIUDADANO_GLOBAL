<?php

$objeto = new stdClass();
$objeto->atrib1 = 'Hola Pepe';
$objeto->atrib2 = 42;

echo json_encode($objeto);
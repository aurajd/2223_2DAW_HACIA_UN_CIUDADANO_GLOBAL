<?php

    // Recuperar los valores desde la URL
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $controlador = isset($_POST['c']) ? $_POST['c'] : 'default_controlador';
        $modelo = isset($_POST['m']) ? $_POST['m'] : 'default_modelo';
    
        // Utilizar un switch para determinar la acción
        switch ($controlador) {
            case 'crud_situacion':
                switch ($modelo){
                    case 'insertar':
                        header("Location: vista.php?c=$controlador&m=$modelo");
                        break;

                    case 'borrar':
                        header("Location: vista.php?c=$controlador&m=$modelo");
                        break;

                    case 'modificar':
                        header("Location: vista.php?c=$controlador&m=$modelo");
                        break;
                }
            case '2':
                
                break;

            // Caso por defecto
            default:
                
                break;
        }
    }


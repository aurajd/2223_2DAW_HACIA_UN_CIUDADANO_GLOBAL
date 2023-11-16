<?php

class Modelo{

    public $conexion = null;

    public function __construct() {
        include 'conexion.php';
        $this->conexion = new mysqli($servidorbd, $usuario, $contraseña, $basedatos);
    }

    function insertar_situacion($titulo, $info, $reflexion){
        
        $sql = "INSERT INTO situacion(titulo, informacion)
        VALUES ('$titulo', '$info');";

        $this->conexion->query($sql);

        $id = $this->conexion->insert_id;

        $sql = "INSERT INTO problema(idProblema, reflexion)
        VALUES ('$id','$reflexion');";

        $this->conexion->query($sql);

        if (isset($imagen)) {
            $targetDirectory = ""; // Carpeta donde se almacenarán las imágenes
            $targetFile = $targetDirectory . basename($_FILES['file']['name']); // Ruta completa del archivo de destino

            // Verificar si el archivo es una imagen real o un archivo de imagen falso
            $check = getimagesize($_FILES['file']['tmp_name']);
            if ($check !== false) {
                // Mover el archivo cargado al directorio de destino
                if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
                    echo "La imagen " . basename($_FILES['file']['name']) . " ha sido subida con éxito.";
                } else {
                    echo "Hubo un error al subir la imagen.";
                }
            } else {
                echo "El archivo no es una imagen válida.";
            }
        }

        $this->conexion->close();
    }

}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista problemas</title>
    <link rel="stylesheet" href="css/style_admin.css">
</head>
<body>
    <nav class="navbar">
        <h1>Listar problema</h1>
        <a class="back-link" href="index.php?controller=problema&action=menu">Volver</a>
    </nav>
    <main>
        <?php
            if(count($dataToView["data"])>0){
            ?>
        <div>
            <?php
            if(isset($_GET["respuesta_modificacion"])&&$_GET["respuesta_modificacion"]==true){
                ?>
                <p id="exito">Problema modificado con éxito.</p>
                <?php
            }
            if(isset($_GET["respuesta_borrado"])&&$_GET["respuesta_borrado"]==true){
                ?>
                <p id="exito">Problema eliminado con éxito.</p>
                <?php
            }
            ?>
            <table>
                <tr>
                    <th>Título</th>
                    <th>Información</th>
                    <th>Reflexión</th>
                    <th>Imagen</th>
                    <th>Opciones</th>
                </tr>
                <?php
                    foreach ($dataToView["data"] as $fila){
                        ?>
                        <tr>
                            <td>
                                <div class='scroll'>
                                    <?php echo $fila['titulo']; ?>
                                </div>
                            </td>
                            <td>
                                <div class='scroll'>
                                    <?php echo $fila['informacion']; ?>
                                </div>
                            </td>
                            <td>
                                <div class='scroll'>
                                    <?php echo $fila['reflexion']; ?>
                                </div>
                            </td>
                            <td>
                                <?php 
                                    if(!is_null($fila['imagen'])){
                                    ?>
                                        <img src='img/<?php echo $fila['imagen']; ?>'>
                                        <?php
                                    }
                                    ?>
                                </td>
                            <td>
                                <ul>
                                    <li><a href='index.php?controller=problema&action=confirmar_borrado&id=<?php echo $fila['idSituacion'] ?>'>Borrar</a></li>
                                    <li><a href='index.php?controller=problema&action=mostrar_modificar&id=<?php echo $fila['idSituacion'] ?>'>Modificar</a></li>
                                </ul>
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
            </table>
        </div>
        <?php
        }
        else{
            ?>
            <div class="no_lista">
                <h1 >No hay ningún problema en la base de datos.</h1>
            </div>
        <?php
        }
        ?>
    </main>
</body>
</html>
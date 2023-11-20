<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista problemas</title>
    <link rel="stylesheet" href="css/style_admin.css">
</head>
<body>
    <nav><a href="index.php?controller=problema&action=menu">Volver</a></nav>
    <main>
        <?php
            if(count($dataToView["data"])>0){
            ?>
        <div>
        
            <h1>Listar problema</h1>
            <table>
                <tr>
                    <th>Título</th>
                    <th>Información</th>
                    <th>Reflexión</th>
                    <th>Imagen</th>
                    <th>Opciones</th>
                </tr>
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
                            <?php 
                                if(!is_null($fila['imagen'])){
                                    ?>
                                    <td>
                                        <img src='img/<?php echo $fila['imagen']; ?>'>
                                    </td>
                                <?php
                                }
                                ?>
                            <td>
                                <ul>
                                    <li><a href='borrar_problema.php?id={$fila['idSituacion']}'>Borrar</a></li>
                                    <li><a href='modificar_problema.php?id={$fila['idSituacion']}'>Modificar</a></li>
                                </ul>
                            </td>
                        </tr>
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
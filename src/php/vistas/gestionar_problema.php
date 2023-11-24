<main>
    <?php if(count($dataToView["data"])>0){ ?>
        <div>
            <?php if(isset($_GET["msg"])){ ?>
                <p id="<?php echo $_GET["tipomsg"] ?>">
                    <?php echo $_GET["msg"] ?>
                </p>
            <?php } ?>
            <div class='opciones'>
                <a href='index.php?controller=problema'>Volver atrás</a>
                <a href='index.php?controller=problema&action=mostrar_anadir'>Añadir problema</a>
            </div>
            <h1>Gestión de problemas</h1>
            <table>
                <tr>
                    <th>Título</th>
                    <th>Información</th>
                    <th>Reflexión</th>
                    <th>Imagen</th>
                    <th>Opciones</th>
                </tr>
                <?php foreach ($dataToView["data"] as $fila){ ?>
                    <tr>
                        <td>
                            <div class='scroll'>
                                <?php echo htmlspecialchars($fila['titulo'],ENT_QUOTES); ?>
                            </div>
                        </td>
                        <td>
                            <div class='scroll'>
                                <?php echo htmlspecialchars($fila['informacion'],ENT_QUOTES); ?>
                            </div>
                        </td>
                        <td>
                            <div class='scroll'>
                                <?php echo htmlspecialchars($fila['reflexion'],ENT_QUOTES); ?>
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
                <?php } ?>
            </table>
        </div>
    <?php } else{ ?>
        <div class="no_lista">
            <h1 >No hay ningún problema en la base de datos.</h1>
        </div>
    <?php } ?>
<main>

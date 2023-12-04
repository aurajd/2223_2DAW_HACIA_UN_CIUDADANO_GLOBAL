<main>
    <aside>
    
    <?php if(count($dataToView["data"])>0){ ?>
            <div class='opciones'>
                <a href='index.php?controller=conflicto'>Volver</a>
                <a href='index.php?controller=conflicto&action=mostrar_anadir&continente=<?php echo isset($_POST["continente"]) ? $_POST["continente"] : $_GET["continente"]; ?>'>Añadir</a>
            </div>
            <?php if(isset($_GET["msg"])){ ?>
                <p id="<?php echo $_GET["tipomsg"] ?>"><?php echo $_GET["msg"] ?></p>
            <?php } ?>
            
            <h1>Gestión de conflictos</h1>
            <table>
                <tr>
                    <th>Título</th>
                    <th>Información</th>
                    <th>Fecha de inicio</th>
                    <th>Imagen</th>
                    <th class="botones">Opciones</th>
                </tr>
                <?php
                    foreach ($dataToView["data"] as $fila){
                        ?>
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
                                    <?php echo $fila['fechaInicio']; ?>
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
                                <ul class="contenedorBotones">
                                    <li><a href='index.php?controller=conflicto&action=confirmar_borrado&id=<?php echo $fila['idSituacion'] ?>&continente=<?php echo isset($_POST["continente"]) ? $_POST["continente"] : $_GET["continente"]; ?>'><i class="fa-solid fa-trash"></i></a></li>
                                    <li><a href='index.php?controller=conflicto&action=mostrar_modificar&id=<?php echo $fila['idSituacion'] ?>&continente=<?php echo isset($_POST["continente"]) ? $_POST["continente"] : $_GET["continente"]; ?>'><i class="fa-solid fa-pen"></i></a></li>
                                    <li><a href='index.php?controller=conflicto&action=listar_motivos&id=<?php echo $fila['idSituacion'] ?>&continente=<?php echo isset($_POST["continente"]) ? $_POST["continente"] : $_GET["continente"]; ?>'><i class="fa-solid fa-list"></i></a></li>
                                </ul>
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
            </table>
        
    <?php } else { ?>
        <div class="no_lista">
            <h1 >No hay ningún conflicto en la base de datos.</h1>
            <div class='opciones'>
                <a href='index.php?controller=conflicto'>Volver atrás</a>
                <a href='index.php?controller=conflicto&action=mostrar_anadir'>Añadir conflicto</a>
            </div>
        </div>
    <?php } ?>
    </aside>
</main>
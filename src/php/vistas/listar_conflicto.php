<main>
    <aside>
    <?php if(count($dataToView["data"])>0){ ?>
        <div>
            <?php if(isset($_GET["msg"])){ ?>
                <p id="<?php echo $_GET["tipomsg"] ?>"><?php echo $_GET["msg"] ?></p>
            <?php } ?>
            <div class='opciones'>
                <a href='index.php?controller=conflicto'>Volver atrás</a>
            </div>
            <h1>Lista conflictos</h1>
            <table>
                <tr>
                    <th>Título</th>
                    <th>Información</th>
                    <th>Fecha de inicio</th>
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
                                <ul class="contenedorBotones">
                                    <li><a href='index.php?controller=conflicto&action=ver_conflicto&id=<?php echo $fila['idSituacion'] ?>'><i class="fa-regular fa-eye"></i></a></li>
                                </ul>
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
            </table>
        </div>
    <?php } else { ?>
        <div class="no_lista">
            <h1 >No hay ningún conflicto en la base de datos.</h1>
            <div class='opciones'>
                <a href='index.php?controller=conflicto'>Volver atrás</a>
            </div>
        </div>
    <?php } ?>
    </aside>
</main>
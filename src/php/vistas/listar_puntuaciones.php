<main>
    <?php if(!is_null($dataToView["data"])){ ?>
        <aside>
            <?php if(isset($_GET["msg"])){ ?>
                <p id="<?php echo $_GET["tipomsg"] ?>">
                    <?php echo $_GET["msg"] ?>
                </p>
            <?php } ?>
            <div class='opciones'>
            <a href='index.php?controller=puntuacion&action=confirmar_borrado'>Eliminar</a>
            </div>
            <h1>Lista puntuaciones</h1>
            <table>
                <tr>
                    <th>Nombre</th>
                    <th>Puntuación</th>
                </tr>
                <?php foreach ($dataToView["data"] as $fila) { ?>
                    <tr>
                        <td>
                            <?php echo htmlspecialchars($fila['nombreJugador'], ENT_QUOTES); ?>
                        </td>
                        <td>
                            <?php echo $fila['puntuacion']; ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </aside>
    <?php } else {  ?>
        <div class="no_lista">
            <h1>No hay ninguna puntuación en la base de datos.</h1>
            <div class='opciones'>
                <a href='index.php'>Volver atrás</a>
            </div>
        </div>
    <?php } ?>
<main>
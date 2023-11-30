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
            </div>
            <h1>Lista problemas</h1>
            <table>
                <tr>
                    <th>Título</th>
                    <th>Información</th>
                    <th>Reflexión</th>
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
                    </tr>
                <?php } ?>
            </table>
        </div>
    <?php } else{ ?>
        <div class="no_lista">
            <h1 >No hay ningún problema en la base de datos.</h1>
            <div class='opciones'>
                <a href='index.php?controller=problema'>Volver atrás</a>
            </div>
        </div>
    <?php } ?>
<main>
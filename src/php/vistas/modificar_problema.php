<main>
    <div>
        <?php if(isset($_GET["msg"])){ ?>
            <p id="<?php echo $_GET["tipomsg"] ?>">
                <?php echo $_GET["msg"] ?>
            </p>
        <?php } ?>
        <form method='post' enctype='multipart/form-data' action='index.php?controller=problema&action=modificar&id=<?php echo $dataToView["data"]["idSituacion"] ?>&continente=<?php echo $_GET["continente"]?>'>
            <label for='titulo'>Título:</label>
            <input type='text' name='titulo' value='<?php echo htmlspecialchars($dataToView["data"]["titulo"],ENT_QUOTES) ?>'>
            
            <label for='informacion'>Información:</label>
            <textarea name='informacion'><?php echo htmlspecialchars($dataToView["data"]["informacion"],ENT_QUOTES) ?></textarea>
            
            <label for='reflexion'>Reflexión:</label>
            <textarea name='reflexion'><?php echo htmlspecialchars($dataToView["data"]["reflexion"],ENT_QUOTES) ?></textarea>
            
            <?php
                if(!is_null($dataToView["data"]["imagen"])){
                ?>
                    <p class='titulo'>Imagen actual:</p>
                    <img src='img/<?php echo $dataToView["data"]["imagen"] ?>' id='imagenMostrar'>
                <?php
                }
            ?>
            <label for='imagen'>Modificar imagen (opcional):</label>
            <input type='file' name='imagen'>
            <div class="motivos">
                <h2>Solución 1</h2>
                <label for="motivo1">Información:</label>
                <textarea name="soluciones[1]" id="motivo1" placeholder="Escribe aquí"></textarea>      
                <label>
                    <input type="checkbox" name="correctas[1]" value="1">
                    Es correcto
                </label>
            </div>
            <div class="motivos">
                <h2>Solución 2</h2>
                <label for="motivo2">Información:</label>
                <textarea name="soluciones[2]" id="motivo2" placeholder="Escribe aquí"></textarea>      
                <label>
                    <input type="checkbox" name="correctas[2]" value="2">
                    Es correcto
                </label>
            </div>
            <div class="motivos" id="duplicadoOriginal">
                    <h2>Solución 3</h2>
                    <label for="motivo3">Información:</label>
                    <textarea name="soluciones[3]" id="motivo3" placeholder="Escribe aquí"></textarea>      
                    <label>
                        <input type="checkbox" name="correctas[3]" value="3">
                        Es correcto
                    </label>
                </div>
                <div id="contenedorDuplicados">

                </div>
                <div class="botones-cuadrado">
                    <button class="boton-cuadrado" id="boton1" type="button">Añadir</button>
                    <button class="boton-cuadrado" id="boton2" type="button">Eliminar</button>
                </div>
            <div class='opciones'>
                <input type='submit' value='Aceptar' name='aceptar'>
                <a href='index.php?controller=problema&action=gestionar&continente=<?php echo $_GET["continente"]?>'>Cancelar</a>
            </div>
        </form>
    </div>
</main>
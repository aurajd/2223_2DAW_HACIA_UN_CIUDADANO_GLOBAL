<main>
    <aside>
        <?php if(isset($_GET["msg"])){ ?>
            <p id="<?php echo $_GET["tipomsg"] ?>"><?php echo $_GET["msg"] ?></p>
        <?php } ?>
        <h1>Modificar problema</h1>
        <form method='post' enctype='multipart/form-data' action='index.php?controller=problema&action=modificar&id=<?php echo $dataToView["data"]["idSituacion"]?>&continente=<?php echo $_GET["continente"]?>' id="form">
            <p>
                <p><label for='titulo'>Título:</label></p>
                <input type='text' id="titulo" name='titulo' value='<?php echo htmlspecialchars($dataToView["data"]["titulo"],ENT_QUOTES) ?>'>
            </p>
            <div>
                <label for='informacion'>Información:</label>
                <textarea id="informacion" name='informacion'><?php echo htmlspecialchars($dataToView["data"]["informacion"],ENT_QUOTES) ?></textarea>
            </div>
            <div>
                <label for='reflexion'>Reflexión:</label>
                <textarea id="reflexion" name='reflexion'><?php echo htmlspecialchars($dataToView["data"]["reflexion"],ENT_QUOTES) ?></textarea>
            </div>
            
            <?php
                if(!is_null($dataToView["data"]["imagen"])){
                ?>
                    <p class='titulo'>Imagen actual:</p>
                    <img src='img/<?php echo $dataToView["data"]["imagen"] ?>' id='imagenMostrar'>
                <?php
                }
            ?>
            <label for='imagen'>Modificar imagen (opcional):</label>
            <input type='file' id="imagen" name='imagen'>

            <p class='titulo'>Modificar soluciones:</p>

            <?php foreach ($dataToView["soluciones"] ?? [] as $key => $solucion) { 
                $solucionId = $solucion['idSolucion'];
            ?>
                <div class="soluciones">
                    <h2>Solución <?php echo $key + 1 ?></h2>
                    <label for="solucion<?php echo $solucionId ?>">Información:</label>
                    <textarea name="soluciones[<?php echo $solucionId ?>]" id="solucion<?php echo $solucionId ?>" placeholder="Escribe aquí"><?php echo htmlspecialchars($solucion['informacion'], ENT_QUOTES) ?></textarea>
                    <label>
                        <input type="checkbox" name="correctas[<?php echo $solucionId ?>]" value="<?php echo $solucionId ?>" <?php echo ($solucion['correcta'] == 1) ? 'checked' : ''; ?>>
                        Es correcto
                    </label>
                </div>
            <?php } ?>

            <div id="contenedorDuplicados"></div>
            
            <div class="botones-cuadrado">
                <button class="boton-cuadrado" id="boton1" type="button">Añadir</button>
                <button class="boton-cuadrado" id="boton2" type="button">Eliminar</button>
            </div>
            
            <div class='opciones'>
                <button type="button" name='enviar' id='enviar'>Enviar</button>
                <a href='index.php?controller=problema&action=gestionar&continente=<?php echo $_GET["continente"]?>'>Cancelar</a>
            </div>
        </form>
    </aside>
</main>
<script type=module src="js/vistas/vista_admin_problema.js"></script>

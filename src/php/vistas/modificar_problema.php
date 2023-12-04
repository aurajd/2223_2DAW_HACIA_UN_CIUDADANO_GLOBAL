<main>
    <div>
        <?php if(isset($_GET["msg"])){ ?>
            <p id="<?php echo $_GET["tipomsg"] ?>"><?php echo $_GET["msg"] ?></p>
        <?php } ?>
        <h1>Modificar problema</h1>
        <form method='post' enctype='multipart/form-data' action='index.php?controller=problema&action=modificar&id=<?php echo $dataToView["data"]["idSituacion"]?>&continente=<?php echo $_GET["continente"]?>' id="form">
            <label for='titulo'>Título:</label>
            <input type='text' id="titulo" name='titulo' value='<?php echo htmlspecialchars($dataToView["data"]["problema"]["titulo"],ENT_QUOTES) ?>'>
            
            <label for='informacion'>Información:</label>
            <textarea id="informacion" name='informacion'><?php echo htmlspecialchars($dataToView["data"]["problema"]["informacion"],ENT_QUOTES) ?></textarea>
            
            <label for='reflexion'>Reflexión:</label>
            <textarea id="reflexion" name='reflexion'><?php echo htmlspecialchars($dataToView["data"]["problema"]["reflexion"],ENT_QUOTES) ?></textarea>
            
            <?php
                if(!is_null($dataToView["data"]["problema"]["imagen"])){
                ?>
                    <p class='titulo'>Imagen actual:</p>
                    <img src='img/<?php echo $dataToView["data"]["problema"]["imagen"] ?>' id='imagenMostrar'>
                <?php
                }
            ?>
            <label for='imagen'>Modificar imagen (opcional):</label>
            <input type='file' id="imagen" name='imagen'>

            <p class='titulo'>Modificar soluciones:</p>

            <?php for ($i=0;$i<3;$i++) { 
                $numSolucion = $dataToView["data"]["soluciones"][$i]["numSolucion"];
                $solucion = $dataToView["data"]["soluciones"][$i]["textoSolucion"]
                ?>
                <div class="motivos" <?php if ($numSolucion == 3) {echo 'id="duplicadoOriginal"';}?>>
                    <h2>Solución <?php echo $numSolucion?></h2>
                    <label for="motivo<?php echo $numSolucion?>">Información:</label>
                    <textarea name="motivos[<?php echo $numSolucion?>]" id="motivo<?php echo $numSolucion?>" placeholder="Escribe aquí"><?php echo htmlspecialchars($solucion,ENT_QUOTES)?></textarea>      
                    <label>
                        <input type="checkbox" name="motivoCorrecto" value="<?php echo $numSolucion;?>" <?php if ($dataToView["data"]["soluciones"][$i]["correcta"]) {echo ' checked ';}?>>
                        Es correcto
                    </label>
                </div>
            <?php } ?>
            <div id="contenedorDuplicados">
            <?php
            // Empieza un for desde la posicion tres
            for($offset=3; $offset < count($dataToView["data"]["soluciones"]); $offset++) {
                $numSolucion = $dataToView["data"]["soluciones"][$offset]["numSolucion"];
                $solucion = $dataToView["data"]["soluciones"][$offset]["textoSolucion"]
                ?>
                <div class="motivos">
                    <h2>Solución <?php echo $numSolucion?></h2>
                    <label for="motivo<?php echo $numSolucion?>">Información:</label>
                    <textarea name="motivos[<?php echo $numSolucion?>]" id="motivo<?php echo $numSolucion?>" placeholder="Escribe aquí"><?php echo htmlspecialchars($solucion,ENT_QUOTES)?></textarea>      
                    <label>
                        <input type="checkbox" name="motivoCorrecto" value="<?php echo $numSolucion;?>" <?php if ($dataToView["data"]["soluciones"][$i]["correcta"]) {echo ' checked ';}?>>
                        Es correcto
                    </label>
                </div>
            <?php } ?>
            </div>
            <div class="botones-cuadrado">
                <button class="boton-cuadrado" id="boton1" type="button">Añadir</button>
                <button class="boton-cuadrado" id="boton2" type="button">Eliminar</button>
            </div>
            
            <div class='opciones'>
                <button type="button" name='enviar' id='enviar'>Enviar</button>
                <a href='index.php?controller=problema&action=gestionar&continente=<?php echo $_GET["continente"]?>'>Cancelar</a>
            </div>
        </form>
    </div>
</main>
<script type=module src="js/vistas/vista_admin_problema.js"></script>

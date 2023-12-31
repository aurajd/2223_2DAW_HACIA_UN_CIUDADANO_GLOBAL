<main>
    <aside>
        <?php if(isset($_GET["msg"])){ ?>
            <p id="<?php echo $_GET["tipomsg"] ?>"><?php echo $_GET["msg"] ?></p>
        <?php } ?>
        <h1>Modificar conflicto</h1>
        <form method='post' enctype='multipart/form-data' action='index.php?controller=conflicto&action=modificar&id=<?php echo $dataToView["data"]["conflicto"]["idSituacion"]?>&continente=<?php echo isset($_POST["continente"]) ? $_POST["continente"] : $_GET["continente"]; ?>'id="form">
            <p>
                <p><label for='titulo'>Título:</label></p>
                <input type='text' id="titulo" name='titulo' value='<?php echo htmlspecialchars($dataToView["data"]["conflicto"]["titulo"],ENT_QUOTES) ?>'>
            </p>
            <div>
                <label for='informacion'>Información:</label>
                <textarea id="informacion" name='informacion'><?php echo htmlspecialchars($dataToView["data"]["conflicto"]["informacion"],ENT_QUOTES) ?></textarea>
            </div>
            <p>
                <label for='reflexion'>Fecha de inicio:</label>
                <input type="date" id="fecha" name="fecha" value='<?php echo $dataToView["data"]["conflicto"]["fechaInicio"] ?>'>
            </p>
            
            <?php
                if(!is_null($dataToView["data"]["conflicto"]["imagen"])){
                ?>
                    <p class='titulo'>Imagen actual:</p>
                    <img src='img_subidas/<?php echo $dataToView["data"]["conflicto"]["imagen"] ?>' id='imagenMostrar'>
                <?php
                }
            ?>
            <label for='imagen'>Modificar imagen (opcional):</label>
            <input type='file' id="imagen" name='imagen'>

            <p class='titulo'>Modificar motivos:</p>
            
            <?php for ($i=0;$i<3;$i++) { 
                $numMotivo = $dataToView["data"]["motivos"][$i]["numMotivo"];
                $motivo = $dataToView["data"]["motivos"][$i]["textoMotivo"]
                ?>
                <div class="motivos" <?php if ($numMotivo == 3) {echo 'id="duplicadoOriginal"';}?>>
                    <h2>Motivo <?php echo $numMotivo?></h2>
                    <label for="motivo<?php echo $numMotivo?>">Información:</label>
                    <textarea name="motivos[<?php echo $numMotivo?>]" id="motivo<?php echo $numMotivo?>" placeholder="Escribe aquí"><?php echo htmlspecialchars($motivo,ENT_QUOTES)?></textarea>      
                    <label>
                        <input type="radio" name="motivoCorrecto" value="<?php echo $numMotivo;?>" <?php if ($numMotivo == $dataToView["data"]["conflicto"]["numMotivo"]) {echo ' checked ';}?>>
                        Es correcto
                    </label>
                </div>
            <?php } ?>
            <div id="contenedorDuplicados">
            <?php
            // Empieza un for desde la posicion tres
            for($offset=3; $offset < count($dataToView["data"]["motivos"]); $offset++) {
                $numMotivo = $dataToView["data"]["motivos"][$offset]["numMotivo"];
                $motivo = $dataToView["data"]["motivos"][$offset]["textoMotivo"]
                ?>
                <div class="motivos">
                    <h2>Motivo <?php echo $numMotivo?></h2>
                    <label for="motivo<?php echo $numMotivo?>">Información:</label>
                    <textarea name="motivos[<?php echo $numMotivo?>]" id="motivo<?php echo $numMotivo?>" placeholder="Escribe aquí"><?php echo htmlspecialchars($motivo,ENT_QUOTES)?></textarea>      
                    <label>
                        <input type="radio" name="motivoCorrecto" value="<?php echo $numMotivo;?>" <?php if ($numMotivo == $dataToView["data"]["conflicto"]["numMotivo"]) {echo ' checked ';}?>>
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
                <a href='index.php?controller=conflicto&action=gestionar&continente=<?php echo isset($_POST["continente"]) ? $_POST["continente"] : $_GET["continente"]; ?>'>Cancelar</a>
            </div>
        </form>
    </aside>
</main>
<script type=module src="js/vistas/vista_admin_conflicto.js"></script>
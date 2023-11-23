<main>
    <div>
        <?php if(isset($_GET["msg"])){ ?>
            <p id="<?php echo $_GET["tipomsg"] ?>"><?php echo $_GET["msg"] ?></p>
        <?php } ?>
        <form method='post' enctype='multipart/form-data' action='index.php?controller=conflicto&action=modificar&id=<?php echo $dataToView["data"]["conflicto"]["idSituacion"] ?>'>
            <label for='titulo'>Título:</label>
            <input type='text' id="titulo" name='titulo' value='<?php echo htmlspecialchars($dataToView["data"]["conflicto"]["titulo"],ENT_QUOTES) ?>'>
            
            <label for='informacion'>Información:</label>
            <textarea id="informacion" name='informacion'><?php echo htmlspecialchars($dataToView["data"]["conflicto"]["informacion"],ENT_QUOTES) ?></textarea>
            
            <label for='reflexion'>Fecha de inicio:</label>
            <input type="date" id="fecha" name="fecha" value='<?php echo $dataToView["data"]["conflicto"]["fechaInicio"] ?>'>
            
            <?php
                if(!is_null($dataToView["data"]["conflicto"]["imagen"])){
                ?>
                    <p class='titulo'>Imagen actual:</p>
                    <img src='img/<?php echo $dataToView["data"]["conflicto"]["imagen"] ?>' id='imagenMostrar'>
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
            
            <?php
            // Empieza un for desde la posicion tres
            for($offset=3; $offset < count($dataToView["data"]["motivos"]); $offset++) {
                $numMotivo = $dataToView["data"]["motivos"][$i]["numMotivo"];
                $motivo = $dataToView["data"]["motivos"][$i]["textoMotivo"]
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


            <div class='opciones'>
                <input type='submit' value='Aceptar' name='aceptar'>
                <a href='index.php?controller=conflicto&action=listar'>Cancelar</a>
            </div>
        </form>
    </div>
</main>
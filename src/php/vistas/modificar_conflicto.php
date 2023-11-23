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
            <?php foreach ($dataToView["data"]["motivos"] as $motivo) { ?>
                <div class="motivos">
                    <h2>Motivo <?php echo $motivo["numMotivo"]?></h2>
                    <label for="motivo1">Información:</label>
                    <textarea name="motivos[<?php echo $motivo["numMotivo"]?>]" id="motivo<?php echo $motivo["numMotivo"]?>" placeholder="Escribe aquí"><?php echo htmlspecialchars($motivo["textoMotivo"],ENT_QUOTES)?></textarea>      
                    <label>
                        <input type="radio" name="motivoCorrecto" value="<?php echo $motivo["numMotivo"];?>" <?php if ($motivo["numMotivo"] == $dataToView["data"]["conflicto"]["numMotivo"]) {echo ' checked ';}?>>
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
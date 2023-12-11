<main>
    <aside>
        <div>
            <p>
                <p><label for="titulo">Título:</label></p>
                <input type="text" id="titulo" name="titulo" value='<?php echo htmlspecialchars($dataToView["data"]["conflicto"]["titulo"],ENT_QUOTES) ?>' readonly>
            </p>
            <div>
                <label for="informacion">Informacion:</label>
                <textarea id="informacion" readonly><?php echo htmlspecialchars($dataToView["data"]["conflicto"]["informacion"],ENT_QUOTES) ?></textarea>
            </div>
            <div>
                <label for="fecha">Fecha de inicio:</label>
                <input type="date" id="fecha" value="<?php echo $dataToView["data"]["conflicto"]["fechaInicio"] ?>"readonly>
            </div>
            <?php if(!is_null($dataToView["data"]["conflicto"]["imagen"])){ ?>
                <p class='titulo'>Imagen:</p>
                <img src='img_subidas/<?php echo $dataToView["data"]["conflicto"]["imagen"] ?>' id='imagenMostrar'>
            <?php } ?>
        </div>

        <?php foreach ($dataToView["data"]["motivos"] as $indice => $motivo) { ?>
                <div class="motivos">
                    <h2>Motivo <?php echo $motivo["numMotivo"]?></h2>
                    <label for="motivo<?php echo $motivo["numMotivo"]?>">Información:</label>
                    <textarea readonly name="motivos[<?php echo $motivo["numMotivo"]?>]" id="motivo<?php echo $motivo["numMotivo"]?>" placeholder="Escribe aquí"><?php echo htmlspecialchars($motivo["textoMotivo"],ENT_QUOTES)?></textarea>      
                    <?php if ($indice+1 == $dataToView["data"]["conflicto"]["numMotivo"]) {echo ' <h2>Es correcto</h2> ';}?>
                </div>
            <?php } ?>

        <div class='opciones'>
        <a href='index.php?controller=conflicto&action=listar&continente=<?php echo $dataToView["data"]["conflicto"]["idContinente"] ?>'>Volver</a>
        </div>
    </aside>
</main>
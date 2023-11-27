<main>
    <div>
        <div>
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" value='<?php echo htmlspecialchars($dataToView["data"]["conflicto"]["titulo"],ENT_QUOTES) ?>' readonly>

            <label for="informacion">Informacion:</label>
            <textarea id="informacion" readonly><?php echo htmlspecialchars($dataToView["data"]["conflicto"]["informacion"],ENT_QUOTES) ?></textarea>

            <label for="fecha">Fecha de inicio:</label>
            <input type="date" id="fecha" value="<?php echo $dataToView["data"]["conflicto"]["fechaInicio"] ?>"readonly>
            
            <?php if(!is_null($dataToView["data"]["conflicto"]["imagen"])){ ?>
                <p class='titulo'>Imagen:</p>
                <img src='img/<?php echo $dataToView["data"]["conflicto"]["imagen"] ?>' id='imagenMostrar'>
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
            <a href='index.php?controller=conflicto&action=listar'>Volver atrás</a>
        </div>
    </div>
</main>
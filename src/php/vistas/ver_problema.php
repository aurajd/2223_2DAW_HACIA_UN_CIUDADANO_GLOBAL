<main>
    <aside>
        <h1>Ver soluciones</h1>
        <div>
            <?php for ($i=0;$i<3;$i++) { 
                $numSolucion = $dataToView["data"]["soluciones"][$i]["numSolucion"];
                $solucion = $dataToView["data"]["soluciones"][$i]["textoSolucion"]
                ?>
                <div class="motivos" <?php if ($numSolucion == 3) {echo 'id="duplicadoOriginal"';}?>>
                    <h2>Solución <?php echo $numSolucion?></h2>
                    <label for="motivo<?php echo $numSolucion?>">Información:</label>
                    <textarea name="soluciones[<?php echo $numSolucion?>]" id="motivo<?php echo $numSolucion?>" placeholder="Escribe aquí"><?php echo htmlspecialchars($solucion,ENT_QUOTES)?></textarea>      
                    <label>
                        <input type="checkbox" name="correctas[<?php echo $numSolucion;?>]" value="<?php echo $numSolucion;?>" <?php if ($dataToView["data"]["soluciones"][$i]["correcta"]) {echo ' checked ';}?>>
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
                    <textarea name="soluciones[<?php echo $numSolucion?>]" id="motivo<?php echo $numSolucion?>" placeholder="Escribe aquí"><?php echo htmlspecialchars($solucion,ENT_QUOTES)?></textarea>      
                    <label>
                        <input type="checkbox" name="correctas[<?php echo $numSolucion;?>]" value="<?php echo $numSolucion;?>" <?php if ($dataToView["data"]["soluciones"][$i]["correcta"]) {echo ' checked ';}?>>
                        Es correcto
                    </label>
                </div>
            <?php } ?>
        <div class='opciones'>
            <a href='index.php?controller=problema&action=listar'>Volver atrás</a>
        </div>
    </aside>
</main>
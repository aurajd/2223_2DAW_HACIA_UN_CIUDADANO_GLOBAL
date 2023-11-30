<main>
    <div>
        <?php if(isset($_GET["msg"])){ ?>
            <p id="<?php echo $_GET["tipomsg"] ?>">
                <?php echo $_GET["msg"] ?>
            </p>
        <?php } ?>
        <h1>Modificar problema</h1>
        <form method='post' enctype='multipart/form-data' action='index.php?controller=problema&action=modificar&id=<?php echo $dataToView["data"]["idSituacion"] ?>&continente=<?php echo $_GET["continente"]?>'>
            <label for='titulo'>Título:</label>
            <input type='text' name='titulo' id='titulo' value='<?php echo htmlspecialchars($dataToView["data"]["titulo"],ENT_QUOTES) ?>'>
            
            <label for='informacion'>Información:</label>
            <textarea name='informacion' id='informacion'><?php echo htmlspecialchars($dataToView["data"]["informacion"],ENT_QUOTES) ?></textarea>
            
            <label for='reflexion'>Reflexión:</label>
            <textarea name='reflexion' id='reflexion'><?php echo htmlspecialchars($dataToView["data"]["reflexion"],ENT_QUOTES) ?></textarea>
            
            <?php
                if(!is_null($dataToView["data"]["imagen"])){
                ?>
                    <p class='titulo'>Imagen actual:</p>
                    <img src='img/<?php echo $dataToView["data"]["imagen"] ?>' id='imagenMostrar'>
                <?php
                }
            ?>
            <label for='imagen'>Modificar imagen (opcional):</label>
            <input type='file' name='imagen'  id="imagen">

            <p class='titulo'>Modificar soluciones:</p>
            
            <?php for ($i = 1; $i <= 3; $i++) { 
                $numSolucion = $i;
                $solucionTexto = isset($dataToView["data"]["soluciones"][$i]["textoSolucion"]) ? htmlspecialchars($dataToView["data"]["soluciones"][$i]["textoSolucion"], ENT_QUOTES) : '';
                $solucionCorrecta = isset($dataToView["data"]["soluciones"][$i]["correcta"]) && $dataToView["data"]["soluciones"][$i]["correcta"] == 1;
                ?>
                <div class="motivos" <?php if ($numSolucion == 3) {echo 'id="duplicadoOriginal"';}?>>
                    <h2>Solución <?php echo $numSolucion?></h2>
                    <label for="solucion<?php echo $numSolucion?>">Información:</label>
                    <textarea name="soluciones[<?php echo $numSolucion?>]" id="solucion<?php echo $numSolucion?>" placeholder="Escribe aquí"><?php echo $solucionTexto; ?></textarea>      
                    <label>
                        <input type="checkbox" name="correctas[<?php echo $numSolucion?>]" value="<?php echo $numSolucion ?>" <?php echo $solucionCorrecta ? 'checked' : ''; ?>>
                        Es correcto
                    </label>
                </div>
            <?php } ?>

            <div id="contenedorDuplicados">
                <?php
                // Verificar si "soluciones" está definido y es un array
                if (isset($dataToView["data"]["soluciones"]) && is_array($dataToView["data"]["soluciones"])) {
                    // Empieza un for desde la posición cuatro, ya que las primeras tres soluciones ya se han mostrado
                    for ($offset = 4; $offset <= count($dataToView["data"]["soluciones"]); $offset++) {
                        $numSolucion = $offset;
                        $solucionTexto = isset($dataToView["data"]["soluciones"][$offset]["textoSolucion"]) ? htmlspecialchars($dataToView["data"]["soluciones"][$offset]["textoSolucion"], ENT_QUOTES) : '';
                        $solucionCorrecta = isset($dataToView["data"]["soluciones"][$offset]["correcta"]) && $dataToView["data"]["soluciones"][$offset]["correcta"] == 1;
                        ?>
                        <div class="motivos">
                            <h2>Solución <?php echo $numSolucion ?></h2>
                            <label for="solucion<?php echo $numSolucion ?>">Información:</label>
                            <textarea name="soluciones[<?php echo $numSolucion ?>]" id="solucion<?php echo $numSolucion ?>" placeholder="Escribe aquí"><?php echo $solucionTexto; ?></textarea>
                            <label>
                                <input type="checkbox" name="correctas[<?php echo $numSolucion ?>]" value="<?php echo $numSolucion ?>" <?php echo $solucionCorrecta ? 'checked' : ''; ?>>
                                Es correcto
                            </label>
                        </div>
                    <?php }
                }
                ?>
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
<script type=module src="js/vistas/vista_admin_problema.js"></script>
<main>
    <div>
        <?php if(isset($_GET["msg"])){ ?>
            <p id="<?php echo $_GET["tipomsg"] ?>">
                <?php echo $_GET["msg"] ?>
            </p>
        <?php } ?>
        <form method='post' enctype='multipart/form-data' action='index.php?controller=problema&action=modificar&id=<?php echo $dataToView["data"]["idSituacion"] ?>'>
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
            <div class='opciones'>
                <input type='submit' value='Aceptar' name='aceptar'>
                <a href='index.php?controller=problema&action=gestionar'>Cancelar</a>
            </div>
            
            <label for="soluciones">Soluciones (separadas por comas):</label>
            <input type="text" name="soluciones" id="soluciones" value="<?php echo htmlspecialchars(implode(', ', $dataToView["data"]["soluciones"]), ENT_QUOTES); ?>" placeholder="Ejemplo: Solución 1, Solución 2">
        </form>
    </div>
</main>
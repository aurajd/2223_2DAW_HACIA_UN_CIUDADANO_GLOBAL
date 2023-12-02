<main>
    <div>
        <?php if(isset($_GET["msg"])){ ?>
            <p id="<?php echo $_GET["tipomsg"] ?>">
                <?php echo $_GET["msg"] ?>
            </p>
        <?php } ?>
        <form method='post' enctype='multipart/form-data' action='index.php?controller=continente&action=modificar&id=<?php echo $dataToView["data"]["idContinente"] ?>'>
            <label for='nombre'>Nombre:</label>
            <input type='text' name='nombre' value='<?php echo htmlspecialchars($dataToView["data"]["nombre"],ENT_QUOTES) ?>'>

            <label for='informacion'>Información:</label>
            <textarea name='informacion'><?php echo htmlspecialchars($dataToView["data"]["informacion"], ENT_QUOTES) ?></textarea>

            <label for='resumenInfo'>Resumen información:</label>
            <textarea name='resumenInfo'><?php echo htmlspecialchars($dataToView["data"]["resumenInfo"], ENT_QUOTES) ?></textarea>

            <?php if(isset($dataToView["data"]["imagen"]) && !empty($dataToView["data"]["imagen"])) { ?>
                <p class='titulo'>Imagen actual:</p>
                <img src='img/<?php echo $dataToView["data"]["imagen"] ?>' id='imagenMostrar'>
            <?php } ?>
            <label for='imagen'>Modificar imagen (opcional):</label>
            <input type='file' name='imagen'>

            <div class='opciones'>
                <button type='submit' name='Aceptar' id='aceptar'>Enviar</button>
                <a href='index.php?controller=continente&action=ver_continente'>Cancelar</a>
            </div>
        </form>
    </div>
</main>

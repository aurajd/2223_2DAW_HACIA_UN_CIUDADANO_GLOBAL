<main>
    <aside>
        <?php if(isset($_GET["msg"])){ ?>
            <p id="<?php echo $_GET["tipomsg"] ?>">
                <?php echo $_GET["msg"] ?>
            </p>
        <?php } ?>
        <form method='post' enctype='multipart/form-data' action='index.php?controller=continente&action=modificar&id=<?php echo $dataToView["data"]["idContinente"] ?>'>
            <p>
                <label for='informacion'>Información:</label>
                <textarea name='informacion'><?php echo htmlspecialchars($dataToView["data"]["informacion"], ENT_QUOTES) ?></textarea>
            </p>
            <div>
                <label for='resumenInfo'>Resumen información:</label>
                <textarea name='resumenInfo'><?php echo htmlspecialchars($dataToView["data"]["resumenInfo"], ENT_QUOTES) ?></textarea>
            </div>
            <p>
            <?php if(isset($dataToView["data"]["imagen"]) && !empty($dataToView["data"]["imagen"])) { ?>
                <p class='titulo'>Imagen actual:</p>
                <img src='img/<?php echo $dataToView["data"]["imagen"] ?>' id='imagenMostrar'>
            <?php } ?>
            </p>
            <label for='imagen'>Modificar imagen (opcional):</label>
            <input type='file' name='imagen'>

            <div class='opciones'>
                <button type='submit' name='Aceptar' id='aceptar'>Enviar</button>
                <a href='index.php?controller=continente&action=ver_continente&id=<?php echo $dataToView["data"]["idContinente"]; ?>'>Cancelar</a>
            </div>
        </form>
    </aside>
</main>
<script type=module src="js/vistas/vista_admin_continente.js"></script>
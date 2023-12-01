<main>
    <div>
        <?php if(isset($_GET["msg"])){ ?>
            <p id="<?php echo $_GET["tipomsg"] ?>"><?php echo $_GET["msg"] ?></p>
        <?php } ?>
        <h1>Modificar continente</h1>
        <form method='post' enctype='multipart/form-data' action='index.php?controller=continente&action=modificar&id=<?php echo $dataToView["data"]["idContinente"] ?>' id="form">
            <label for='nombre'>Nombre:</label>
            <input type='text' id="nombre" name='nombre' value='<?php echo isset($dataToView["data"]["nombre"]) ? htmlspecialchars($dataToView["data"]["nombre"], ENT_QUOTES) : '' ?>'>
            
            <label for='informacion'>Información:</label>
            <textarea id="informacion" name='informacion'><?php echo isset($dataToView["data"]["informacion"]) ? htmlspecialchars($dataToView["data"]["informacion"], ENT_QUOTES) : '' ?></textarea>
            
            <label for='resumenInfo'>Resumen información:</label>
            <textarea id="resumenInfo" name='resumenInfo'><?php echo isset($dataToView["data"]["resumenInfo"]) ? htmlspecialchars($dataToView["data"]["resumenInfo"], ENT_QUOTES) : '' ?></textarea>

            <?php if(isset($dataToView["data"]["imagen"]) && !empty($dataToView["data"]["imagen"])) { ?>
                <p class='titulo'>Imagen actual:</p>
                <img src='img/<?php echo $dataToView["data"]["imagen"] ?>' id='imagenMostrar'>
            <?php } ?>
            <label for='imagen'>Modificar imagen (opcional):</label>
            <input type='file' id="imagen" name='imagen'>

            <div class='opciones'>
                <button type="submit" name='enviar' id='enviar'>Enviar</button>
                <a href='index.php?controller=continente&action=ver_continente'>Listar</a>                
            </div>
        </form>
    </div>
</main>

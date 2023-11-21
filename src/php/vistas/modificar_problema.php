<main>
    <div>
        <?php
        if(isset($_GET["respuesta_modificacion"])&&$_GET["respuesta_modificacion"]==false){
            ?>
            <p id="error">
                <?php echo $_GET["error"] ?>
            </p>
            <?php
            }
        ?>
        <form method='post' enctype='multipart/form-data' action='index.php?controller=problema&action=modificar&id=<?php echo $dataToView["data"]["idSituacion"] ?>'>
            <label for='titulo'>Título:</label>
            <input type='text' name='titulo' value='<?php echo $dataToView["data"]["titulo"] ?>'>
            
            <label for='informacion'>Información:</label>
            <textarea name='informacion'><?php echo $dataToView["data"]["informacion"] ?></textarea>
            
            <label for='reflexion'>Reflexión:</label>
            <textarea name='reflexion'><?php echo $dataToView["data"]["reflexion"] ?></textarea>
            
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
                <a href='index.php?controller=problema&action=listar'>Cancelar</a>
            </div>
        </form>
    </div>
</main>
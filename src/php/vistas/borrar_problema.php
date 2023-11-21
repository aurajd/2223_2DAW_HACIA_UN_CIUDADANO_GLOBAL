<main>
    <div>
        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" value='<?php echo $dataToView["data"]["titulo"] ?>' readonly>

        <label for="informacion">Informacion:</label>
        <textarea id="informacion" readonly><?php echo $dataToView["data"]["informacion"] ?></textarea>

        <label for="reflexion">Reflexión:</label>
        <textarea id="reflexion" readonly><?php echo $dataToView["data"]["reflexion"] ?></textarea>
        
        <?php if(!is_null($dataToView["data"]["imagen"])){ ?>
            <p class='titulo'>Imagen:</p>
            <img src='img/<?php echo $dataToView["data"]["imagen"] ?>' id='imagenMostrar'>
        <?php } ?>
        <div class='opciones'>
            <a href='index.php?controller=problema&action=borrar_fila&id=<?php echo $dataToView["data"]['idSituacion']?>'>Aceptar</a>
            <a href='index.php?controller=problema&action=listar'>Cancelar</a>
        </div>
    </div>
</main>
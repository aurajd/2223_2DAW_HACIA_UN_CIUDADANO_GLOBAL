<main>
    <div>
        <div>
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" value='<?php echo $dataToView["data"]["titulo"] ?>' readonly>

            <label for="informacion">Informacion:</label>
            <textarea id="informacion" readonly><?php echo $dataToView["data"]["informacion"] ?></textarea>

            <label for="fecha">Fecha de inicio:</label>
            <input type="date" id="fecha" value="<?php echo $dataToView["data"]["fechaInicio"] ?>"readonly>
            
            <?php if(!is_null($dataToView["data"]["imagen"])){ ?>
                <p class='titulo'>Imagen:</p>
                <img src='img/<?php echo $dataToView["data"]["imagen"] ?>' id='imagenMostrar'>
            <?php } ?>
        </div>

        <div class='opciones'>
            <a href='index.php?controller=conflicto&action=borrar_fila&id=<?php echo $dataToView["data"]['idSituacion']?>'>Aceptar</a>
            <a href='index.php?controller=conflicto&action=listar'>Cancelar</a>
        </div>
    </div>
</main>
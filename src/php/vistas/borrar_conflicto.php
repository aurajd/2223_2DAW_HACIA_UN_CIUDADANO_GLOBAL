<main>
    <aside>
        <div>
            <h1>Eliminar conflicto</h1>
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" value='<?php echo htmlspecialchars($dataToView["data"]["titulo"],ENT_QUOTES) ?>' readonly>

            <label for="informacion">Informacion:</label>
            <textarea id="informacion" readonly><?php echo htmlspecialchars($dataToView["data"]["informacion"],ENT_QUOTES) ?></textarea>

            <label for="fecha">Fecha de inicio:</label>
            <input type="date" id="fecha" value="<?php echo $dataToView["data"]["fechaInicio"] ?>"readonly>
            
            <?php if(!is_null($dataToView["data"]["imagen"])){ ?>
                <p class='titulo'>Imagen:</p>
                <img src='img/<?php echo $dataToView["data"]["imagen"] ?>' id='imagenMostrar'>
            <?php } ?>
        </div>

        <div class='opciones'>
            <a href='index.php?controller=conflicto&action=borrar_fila&id=<?php echo $dataToView["data"]['idSituacion']?>'>Aceptar</a>
            <a href='index.php?controller=conflicto&action=gestionar'>Cancelar</a>
        </div>
    </aside>
</main>
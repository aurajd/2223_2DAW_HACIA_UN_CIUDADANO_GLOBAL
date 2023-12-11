<main>
    <aside>
        <div>
            <h1>Eliminar conflicto</h1>
            <p>
                <p><label for="titulo">Título:</label></p>
                <input type="text" id="titulo" name="titulo" value='<?php echo htmlspecialchars($dataToView["data"]["titulo"],ENT_QUOTES) ?>' readonly>
            </p>
            <div>
                <label for="informacion">Informacion:</label>
                <textarea id="informacion" readonly><?php echo htmlspecialchars($dataToView["data"]["informacion"],ENT_QUOTES) ?></textarea>
            <div>
            <div>
                <label for="fecha">Fecha de inicio: </label>
                <input type="date" id="fecha" value="<?php echo $dataToView["data"]["fechaInicio"] ?>"readonly>
            <div>
            <?php if(!is_null($dataToView["data"]["imagen"])){ ?>
                <p class='titulo'>Imagen:</p>
                <img src='img_subidas/<?php echo $dataToView["data"]["imagen"] ?>' id='imagenMostrar'>
            <?php } ?>
        </div>

        <div class='opciones'>
            <a href='index.php?controller=conflicto&action=borrar_fila&id=<?php echo $dataToView["data"]['idSituacion']?>&continente=<?php echo isset($_POST["continente"]) ? $_POST["continente"] : $_GET["continente"]; ?>'>Aceptar</a>
            <a href='index.php?controller=conflicto&action=gestionar&continente=<?php echo isset($_POST["continente"]) ? $_POST["continente"] : $_GET["continente"]; ?>'>Cancelar</a>
        </div>
    </aside>
</main>
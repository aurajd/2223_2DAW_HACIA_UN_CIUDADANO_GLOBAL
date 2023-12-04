<main>
    <aside>
        <h1>Eliminar problema</h1>

        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" value='<?php echo htmlspecialchars($dataToView["data"]["titulo"],ENT_QUOTES) ?>' readonly>

        <label for="informacion">Informacion:</label>
        <textarea id="informacion" readonly><?php echo htmlspecialchars($dataToView["data"]["informacion"],ENT_QUOTES) ?></textarea>

        <label for="reflexion">Reflexión:</label>
        <textarea id="reflexion" readonly><?php echo htmlspecialchars($dataToView["data"]["reflexion"],ENT_QUOTES) ?></textarea>
        
        <?php if(!is_null($dataToView["data"]["imagen"])){ ?>
            <p class='titulo'>Imagen:</p>
            <img src='img/<?php echo $dataToView["data"]["imagen"] ?>' id='imagenMostrar'>
        <?php } ?>
        <div class='opciones'>
            <a href='index.php?controller=problema&action=borrar_fila&id=<?php echo $dataToView["data"]['idSituacion']?>&continente=<?php echo $_GET["continente"]?>'>Aceptar</a>
            <a href='index.php?controller=problema&action=gestionar&continente=<?php echo $_GET["continente"] ?>'>Cancelar</a>
        </div>
    </aside>
</main>
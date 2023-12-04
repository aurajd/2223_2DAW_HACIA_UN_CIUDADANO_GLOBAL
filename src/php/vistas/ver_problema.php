<main>
    <div>
        <h1>Ver problema</h1>
        <div>
            <label for='titulo'>Título:</label>
            <input readonly type='text' name='titulo' value='<?php echo htmlspecialchars($dataToView["data"]["titulo"],ENT_QUOTES) ?>'>
            
            <label for='informacion'>Información:</label>
            <textarea readonly name='informacion'><?php echo htmlspecialchars($dataToView["data"]["informacion"],ENT_QUOTES) ?></textarea>
            
            <label for='reflexion'>Reflexión:</label>
            <textarea readonly name='reflexion'><?php echo htmlspecialchars($dataToView["data"]["reflexion"],ENT_QUOTES) ?></textarea>
            
            <?php
                if(!is_null($dataToView["data"]["imagen"])){
                ?>
                    <p class='titulo'>Imagen actual:</p>
                    <img src='img/<?php echo $dataToView["data"]["imagen"] ?>' id='imagenMostrar'>
                <?php
                }
            ?>

        <div class='opciones'>
            <a href='index.php?controller=problema&action=listar'>Volver atrás</a>
        </div>
    </div>
</main>
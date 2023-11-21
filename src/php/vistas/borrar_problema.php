<main>
    <div>
            <p class='titulo'>Título:</p>
            <p class='campos'><?php echo $dataToView["data"]["titulo"] ?></p>
            <p class='titulo'>Informacion:</p>
            <textarea readonly><?php echo $dataToView["data"]["informacion"] ?></textarea>
            <p class='titulo'>Reflexión:</p>
            <textarea readonly><?php echo $dataToView["data"]["reflexion"] ?></textarea>
            <?php
                if(!is_null($dataToView["data"]["imagen"])){
                ?>
                    <p class='titulo'>Imagen:</p>
                    <img src='img/<?php echo $dataToView["data"]["imagen"] ?>' id='imagenMostrar'>
                <?php
                }
            ?>
            <div class='opciones'>
                <a href='index.php?controller=problema&action=borrar_fila&id=<?php echo $dataToView["data"]['idSituacion']?>'>Aceptar</a>
                <a href='index.php?controller=problema&action=listar'>Cancelar</a>
            </div>
        ?>
    </div>
</main>
<?php if(isset($dataToView["data"]) && is_array($dataToView["data"]) && count($dataToView["data"]) > 0) { ?>
    <div>
        <?php if(isset($dataToView["data"]["nombre"])) { ?>
            <div>Nombre continente</div>
            <div><?php echo htmlspecialchars($dataToView["data"]['nombre'], ENT_QUOTES); ?></div>
        <?php } ?>

        <?php if(isset($dataToView["data"]["imagen"])) { ?>
            <div>
                <div>Imagen continente</div>
                <div>
                <img src='img/<?php echo $dataToView["data"]['imagen']; ?>'>
                </div>
            </div>
        <?php } ?>

        <?php if(isset($dataToView["data"]["informacion"])) { ?>
            <div>
                <div>Información</div>
                <div>
                    <?php echo htmlspecialchars($dataToView["data"]['informacion'], ENT_QUOTES); ?>
                </div>
            </div>
        <?php } ?>

        <?php if(isset($dataToView["data"]["resumenInfo"])) { ?>
            <div>
                <div>Resumen información</div>
                <div>
                    <?php echo htmlspecialchars($dataToView["data"]['resumenInfo'], ENT_QUOTES); ?>
                </div>
            </div>
        <?php } ?>
    </div>

    <div class='opciones'>
        <a href='index.php?controller=continente&action=mostrar_modificar&id=<?php echo $dataToView["data"]["idContinente"]; ?>'>Modificar</a>
        <a href='index.php?controller=continente&id=<?php echo $dataToView["data"]["idContinente"]; ?>'>Volver atrás</a>
    </div>


    <?php } else { ?>
        <div class="no_lista">
            <h1>Error: No se pudo obtener la información del continente.</h1>
            <div class='opciones'>
                <a href='index.php?controller=continente'>Volver atrás</a>
            </div>
        </div>
    <?php } ?>
    
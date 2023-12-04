<main>
<?php if(isset($dataToView["data"]) && is_array($dataToView["data"]) && count($dataToView["data"]) > 0) { ?>
    <aside>
    <div>
        <?php if(isset($dataToView["data"]["nombre"])) { ?>
            <div><h1><?php echo htmlspecialchars($dataToView["data"]['nombre'], ENT_QUOTES); ?></h1></div>
        <?php } ?>
        <div id="listarContContenedor">
            <div id="listarContTexto">
                <?php if(isset($dataToView["data"]["informacion"])) { ?>
                    <div>
                        <h2>Información</h2>
                        <div>
                            <?php echo htmlspecialchars($dataToView["data"]['informacion'], ENT_QUOTES); ?>
                        </div>
                    </div>
                <?php } ?>

                <?php if(isset($dataToView["data"]["resumenInfo"])) { ?>
                    <div>
                        <h2>Resumen información</h2>
                        <div>
                            <?php echo htmlspecialchars($dataToView["data"]['resumenInfo'], ENT_QUOTES); ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div id="listarContImg">
                <?php if(isset($dataToView["data"]["imagen"])) { ?>
                    <div>
                        <h2>Imagen continente</h2>
                        <div>
                        <img src='img/<?php echo $dataToView["data"]['imagen']; ?>'>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
        
    <div class='opciones'>
        <a href='index.php?controller=continente&action=mostrar_modificar&id=<?php echo $dataToView["data"]["idContinente"]; ?>'>Modificar</a>
        <a href='index.php?controller=continente&id=<?php echo $dataToView["data"]["idContinente"]; ?>'>Volver</a>
    </div>


    <?php } else { ?>
        <div class="no_lista">
            <h1>Error: No se pudo obtener la información del continente.</h1>
            <div class='opciones'>
                <a href='index.php?controller=continente'>Volver</a>
            </div>
        </div>
    <?php } ?>
    </aside>
</main>

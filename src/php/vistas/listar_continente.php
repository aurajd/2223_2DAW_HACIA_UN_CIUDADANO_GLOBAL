<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Continente</title>
    <link rel="stylesheet" href="../css/style_admin.css">
    <style>
        img {
            max-height: 200px;
        }
        div {
            color: white;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>Menú administrador</h1>
        <a class="back-link">Continentes</a>
        <a class="back-link">Problemas</a>
        <a class="back-link">Conflictos</a>
        <a class="back-link">Puntuaciones</a>
    </div>

    <?php if(isset($infoContinente) && is_array($infoContinente) && count($infoContinente) > 0) { ?>
        <div>
            <?php if(isset($infoContinente["nombre"])) { ?>
                <div>Nombre continente</div>
                <div><?php echo htmlspecialchars($infoContinente['nombre'], ENT_QUOTES); ?></div>
            <?php } ?>

            <?php if(isset($infoContinente["imagen"])) { ?>
                <div>
                    <div>Imagen continente</div>
                    <div>
                        <img src="../img/<?php echo htmlspecialchars($infoContinente['imagen'], ENT_QUOTES); ?>">
                    </div>
                </div>
            <?php } ?>

            <?php if(isset($infoContinente["informacion"])) { ?>
                <div>
                    <div>Información</div>
                    <div>
                        <?php echo htmlspecialchars($infoContinente['informacion'], ENT_QUOTES); ?>
                    </div>
                </div>
            <?php } ?>

            <?php if(isset($infoContinente["resumenInfo"])) { ?>
                <div>
                    <div>Resumen información</div>
                    <div>
                        <?php echo htmlspecialchars($infoContinente['resumenInfo'], ENT_QUOTES); ?>
                    </div>
                </div>
            <?php } ?>
        </div>

        <div class='opciones'>
            <a href='index.php?controller=continente&action=modificar&id=<?php echo $infoContinente["idContinente"]; ?>'>Modificar</a>
            <a href='index.php?controller=continente&action=borrar&id=<?php echo $infoContinente["idContinente"]; ?>'>Borrar</a>
        </div>

    <?php } else { ?>
        <div class="no_lista">
            <h1>Error: No se pudo obtener la información del continente.</h1>
            <div class='opciones'>
                <a href='index.php?controller=continente'>Volver atrás</a>
            </div>
        </div>
    <?php } ?>
</body>
</html>

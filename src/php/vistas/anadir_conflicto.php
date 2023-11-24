<main>   
    <div>
        <?php if(isset($_GET["msg"])){ ?>
            <p id="<?php echo $_GET["tipomsg"] ?>">
                <?php echo $_GET["msg"] ?>
            </p>
        <?php } ?>
        <form action="index.php?controller=conflicto&action=insertar" method="post" enctype="multipart/form-data" id="form">
                <label for="titulo">Título:</label>
                <input type="text" id="titulo" name="titulo" placeholder="Introducir título">

                <label for="informacion">Información:</label>
                <textarea name="informacion" id="informacion" placeholder="Escribe aquí"></textarea>

                <label for="fecha">Fecha de inicio del conflicto:</label>
                <input type="date" id="fecha" name="fecha"></input>

                <label for="imagen">Imagen (opcional):</label>
                <input type="file" id="imagen" name="imagen">

                <p class='titulo'>Añadir motivos:</p>
                <div class="motivos">
                    <h2>Motivo 1</h2>
                    <label for="motivo1">Información:</label>
                    <textarea name="motivos[1]" id="motivo1" placeholder="Escribe aquí" class="textarea"></textarea>      
                    <label>
                        <input type="radio" name="motivoCorrecto" value="1">
                        Es correcto
                    </label>
                </div>
                <div class="motivos">
                    <h2>Motivo 2</h2>
                    <label for="motivo2">Información:</label>
                    <textarea name="motivos[2]" id="motivo2" placeholder="Escribe aquí" class="textarea"></textarea>      
                    <label>
                        <input type="radio" name="motivoCorrecto" value="2">
                        Es correcto
                    </label>
                </div>
                <div class="motivos" id="duplicadoOriginal">
                    <h2>Motivo 3</h2>
                    <label for="motivo3">Información:</label>
                    <textarea name="motivos[3]" id="motivo3" placeholder="Escribe aquí" class="textarea"></textarea>      
                    <label>
                        <input type="radio" name="motivoCorrecto" value="3">
                        Es correcto
                    </label>
                </div>
                <div id="contenedorDuplicados">

                </div>
                <div class="botones-cuadrado">
                    <button class="boton-cuadrado" id="boton1" type="button">Añadir</button>
                    <button class="boton-cuadrado" id="boton2" type="button">Eliminar</button>
                </div>
                <div class='opciones'>
                    <button type="button" name='enviar' id='enviar'>Enviar</button>
                </div>
        </form>
    </div>
</main>
<script type=module src="js/vistas/vista_admin_conflicto.js"></script>
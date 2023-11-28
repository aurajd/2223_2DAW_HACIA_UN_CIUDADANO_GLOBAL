<main>    
    <div>
        <div class="opciones">
            <a href='index.php?controller=problema&action=gestionar'>Volver atrás</a>
        </div>
        <?php if(isset($_GET["msg"])){ ?>
            <p id="<?php echo $_GET["tipomsg"] ?>">
                <?php echo $_GET["msg"] ?>
            </p>
        <?php } ?>
        <h1>Añadir problema</h1>
        <form action="index.php?controller=problema&action=insertar" method="post" enctype="multipart/form-data">
            <label for="titulo">Título:</label>
            <input type="text" name="titulo" id="titulo" placeholder="Introducir título">

            <label for="informacion">Informacion:</label>
            <textarea name="informacion" id="informacion" placeholder="Escribe aquí"></textarea>

            <label for="reflexion">Reflexión:</label>
            <textarea name="reflexion" id="reflexion" placeholder="Escribe aquí"></textarea>

            <label for="imagen">Imagen (opcional):</label>
            <input type="file" id="imagen" name="imagen">

            <div class="motivos">
                <h2>Solución 1</h2>
                <label for="motivo1">Información:</label>
                <textarea name="motivos[1]" id="motivo1" placeholder="Escribe aquí"></textarea>      
                <label>
                    <input type="checkbox" name="motivoCorrecto" value="1">
                    Es correcto
                </label>
            </div>
            <div class="motivos">
                <h2>Solución 2</h2>
                <label for="motivo1">Información:</label>
                <textarea name="motivos[1]" id="motivo1" placeholder="Escribe aquí"></textarea>      
                <label>
                    <input type="checkbox" name="motivoCorrecto" value="1">
                    Es correcto
                </label>
            </div>
            <div class="motivos">
                <h2>Solución 3</h2>
                <label for="motivo1">Información:</label>
                <textarea name="motivos[1]" id="motivo1" placeholder="Escribe aquí"></textarea>      
                <label>
                    <input type="checkbox" name="motivoCorrecto" value="1">
                    Es correcto
                </label>
            </div>
            <div class='opciones'>
                    <button type="button" name='enviar' id='enviar'>Enviar</button>
            </div>
        </form>
    </div>
</main>   
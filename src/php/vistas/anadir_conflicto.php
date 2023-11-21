<main>   
    <div>
        <?php
            if(isset($_GET["respuesta"])){
                if($_GET["respuesta"]==true){
                    ?>
                    <p id="exito">Conflicto añadido con éxito.</p>
                    <?php
                }else{
                    ?>
                    <p id="error">
                        
                        <?php echo $_GET["error"] ?>
                    </p>
                    <?php
                }
            }
        ?>
        <form action="index.php?controller=conflicto&action=insertar" method="post" enctype="multipart/form-data">
                <label for="titulo">Título:</label>
                <input type="text" name="titulo" placeholder="Introducir título">
                <label for="informacion">Información:</label>
                <textarea name="informacion" placeholder="Escribe aquí"></textarea>
                <label for="fecha">Fecha de inicio del conflicto:</label>
                <input type="date" name="fecha"></input>
                <label for="imagen">Imagen (opcional):</label>
                <input type="file" name="imagen">
                <p class='titulo'>Añadir motivos:</p>
                <div class="motivos">
                    <h2>Motivo 1</h2>
                    <label for="motivos">Información:</label>
                    <textarea name="motivos[1]" placeholder="Escribe aquí"></textarea>      
                    <label>
                        <input type="radio" name="motivoCorrecto" value="1">
                        Es correcto
                    </label>
                </div>
                <div class="motivos">
                    <h2>Motivo 2</h2>
                    <label for="motivos">Información:</label>
                    <textarea name="motivos[2]" placeholder="Escribe aquí"></textarea>      
                    <label>
                        <input type="radio" name="motivoCorrecto" value="2">
                        Es correcto
                    </label>
                </div>
                <div class="motivos">
                    <h2>Motivo 3</h2>
                    <label for="motivos">Información:</label>
                    <textarea name="motivos[3]" placeholder="Escribe aquí"></textarea>      
                    <label>
                        <input type="radio" name="motivoCorrecto" value="3">
                        Es correcto
                    </label>
                </div>
                <div class="botones-cuadrado">
                    <button class="boton-cuadrado" id="boton1">Añadir</button>
                    <button class="boton-cuadrado" id="boton2">Eliminar</button>
                </div>
                <input type="submit" value="Enviar" id="anadirBoton"> 
        </form>
    </div>
</main>   
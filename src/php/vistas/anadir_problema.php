<main>    
    <div>
        <?php
            if(isset($_GET["respuesta"])){
                if($_GET["respuesta"]==true){
                    ?>
                    <p id="exito">Problema añadido con éxito.</p>
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
        <form action="index.php?controller=problema&action=insertar" method="post" enctype="multipart/form-data">
                <label for="titulo">Título:</label>
                <input type="text" name="titulo" id="titulo" placeholder="Introducir título">

                <label for="informacion">Informacion:</label>
                <textarea name="informacion" id="informacion" placeholder="Escribe aquí"></textarea>

                <label for="reflexion">Reflexión:</label>
                <textarea name="reflexion" id="reflexion" placeholder="Escribe aquí"></textarea>

                <label for="imagen">Imagen (opcional):</label>
                <input type="file" id="imagen" name="imagen">

                <div class='opciones'>
                    <input type='submit' value='Enviar' name='enviar'>
                </div>
        </form>
    </div>
</main>   
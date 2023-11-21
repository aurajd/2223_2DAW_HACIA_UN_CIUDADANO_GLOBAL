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
                <input type="text" name="titulo" placeholder="Introducir título">
                <label for="informacion">Informacion:</label>
                <textarea name="informacion" placeholder="Escribe aquí"></textarea>
                <label for="reflexion">Reflexión:</label>
                <textarea name="reflexion" placeholder="Escribe aquí"></textarea>
                <label for="imagen">Imagen (opcional):</label>
                <input type="file" name="imagen">
                <input type="submit" value="Enviar" id="anadirBoton">
        </form>
    </div>
</main>   
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir conflictos</title>
    <link rel="stylesheet" href="css/style_admin.css">
</head>
<body>
    <main>
        <div>
            <h1>Añadir conflictos</h1>
            <form action="anadir_conflicto_exito.html" method="post">
                    <label for="titulo">Título:</label>
                    <input type="text" name="titulo" placeholder="Introducir título">
                    <label for="informacion">Información:</label>
                    <textarea name="informacion" placeholder="Escribe aquí"></textarea>
                    <label for="reflexion">Datos del incio del conflicto:</label>
                    <textarea name="reflexion" placeholder="Escribe aquí"></textarea>
                    <label for="imagen">Imagen (opcional):</label>
                    <input type="file" name="imagen">
                    <div class="motivos">
                        <h2>Añadir motivos</h2>
                        <label for="motivos">Información:</label>
                        <textarea name="motivos" placeholder="Escribe aquí"></textarea>      
                        <label>
                            <input type="radio" id="motivo1" name="motivo" value="motivo1">
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
</body>
</html>
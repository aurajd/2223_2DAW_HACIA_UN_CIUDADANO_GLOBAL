<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir conflictos</title>
    <link rel="stylesheet" href="css/style_admin.css">
</head>
<body>
    <nav class="navbar">
        <h1>Añadir conflicto</h1>
        <a class="back-link" href="index.php?controller=conflicto&action=menu">Volver</a>
    </nav>
    <main>
        <div>
            <h1>Añadir conflictos</h1>
            <form action="index.php?controller=conflicto&action=insertar" method="post" enctype="multipart/form-data">
                    <label for="titulo">Título:</label>
                    <input type="text" name="titulo" placeholder="Introducir título">
                    <label for="informacion">Información:</label>
                    <textarea name="informacion" placeholder="Escribe aquí"></textarea>
                    <label for="fecha">Fecha de inicio del conflicto:</label>
                    <input type="date" name="fecha"></input>
                    <label for="imagen">Imagen (opcional):</label>
                    <input type="file" name="imagen">
                    <div class="motivos">
                        <h2>Añadir motivos</h2>
                        <label for="motivos">Información:</label>
                        <textarea name="motivos[1]" placeholder="Escribe aquí"></textarea>      
                        <label>
                            <input type="radio" name="motivoCorrecto" value="motivo1">
                            Es correcto
                        </label>
                    </div>
                    <div class="motivos">
                        <h2>Añadir motivos</h2>
                        <label for="motivos">Información:</label>
                        <textarea name="motivos[2]" placeholder="Escribe aquí"></textarea>      
                        <label>
                            <input type="radio" name="motivoCorrecto" value="motivo2">
                            Es correcto
                        </label>
                    </div>
                    <div class="motivos">
                        <h2>Añadir motivos</h2>
                        <label for="motivos">Información:</label>
                        <textarea name="motivos[3]" placeholder="Escribe aquí"></textarea>      
                        <label>
                            <input type="radio" name="motivoCorrecto" value="motivo3">
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
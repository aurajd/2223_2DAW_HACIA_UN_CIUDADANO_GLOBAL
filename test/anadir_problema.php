<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <main>
        <h1>Añadir problema</h1>
        <form action="vista.php" method="POST" enctype="multipart/form-data">
            <fieldset>
                <label for="titulo">Título:</label>
                <input type="text" name="titulo">
                <label for="informacion">Informacion:</label>
                <textarea name="informacion" cols="30" rows="10"></textarea>
                <label for="reflexion">Reflexión:</label>
                <textarea name="reflexion" cols="30" rows="10"></textarea>
                <label for="imagen">Imagen (opcional):</label>
                <input type="file" name="imagen">
                <input type="submit" value="Enviar">
            </fieldset>
        </form>
    </main>
</body>
</html>
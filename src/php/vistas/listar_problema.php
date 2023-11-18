<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista problemas</title>
    <link rel="stylesheet" href="../../css/style_admin.css">
</head>
<body>
    <main>
        <div>
            <h1>Listar problema</h1>
            <table>
                <tr>
                    <th>Título</th>
                    <th>Información</th>
                    <th>Reflexión</th>
                    <th>Imagen</th>
                    <th>Opciones</th>
                </tr>
                <?php
                    require_once __DIR__.'/../modelos/m_situacion_problema.php';
                    $modelo = new Modelo();
                    $arr = $modelo->listar();
                    foreach ($arr as $fila){
                        echo "<tr>
                                <td>
                                    <div class='scroll'>
                                        {$fila['titulo']}
                                    </div>
                                </td>
                                <td>
                                    <div class='scroll'>
                                        {$fila['informacion']}
                                    </div>
                                </td>
                                <td>
                                    <div class='scroll'>
                                        {$fila['reflexion']}
                                    </div>
                                </td>
                                <td><img src='../../img/" . $fila['imagen'] . "'></td>
                                <td>
                                    <ul>
                                        <li><a href='#'>Borrar</a></li>
                                        <li><a href='#'>Modificar</a></li>
                                    </ul>
                                </td>
                            </tr>";
                    }
                    
                ?>
            </table>
        </div>
    </main>
</body>
</html>
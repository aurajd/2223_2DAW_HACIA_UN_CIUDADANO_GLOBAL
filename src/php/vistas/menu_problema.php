<div class="menu">
    <div class="botones">
        <h1>OPCIONES PROBLEMA</h1>
        <form id="formulario" method="post">
        <label for="continente">Seleccionar continente:</label>
        <select name="continentes" id="continente">
            <option value="1">Europa</option>
            <option value="2">Asia</option>
            <option value="3">Oceanía</option>
            <option value="4">América del norte</option>
            <option value="5">América del sur</option>
            <option value="6">África</option>
        </select>
        <button type="button" onclick="setAction('gestionar')">Gestionar</button>
            <button type="button" onclick="setAction('listar')">Listar</button>
        </form>

        <script>
            function setAction(action) {
                document.getElementById('formulario').action = 'index.php?controller=problema&action=' + action;
                document.getElementById('formulario').submit();
            }
        </script>
    </div>
</div>

<!--<div class="menu">
    <div class="botones">
        <h1>OPCIONES PROBLEMA</h1>
        <form action="index.php?controller=problema&action=gestiona" method="post">
            <label for="continente">Seleccionar continente:</label>
            <select name="continentes" id="continente">
                <option value="1">Europa</option>
                <option value="2">Asia</option>
                <option value="3">Oceanía</option>
                <option value="4">América del norte</option>
                <option value="5">América del sur</option>
                <option value="6">África</option>
            </select>
            <button type="submit" name="action" value="gestionar">Gestionar</button>
            <button type="submit" name="action" value="listar">Listar</button>
        </form>
    </div>
</div>-->
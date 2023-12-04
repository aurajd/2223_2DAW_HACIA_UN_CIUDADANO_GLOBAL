<main>
    <aside>
        <h1>OPCIONES CONFLICTO</h1>
        <form id="formulario" method="post" class="formMenu">
            <label for="continente">Seleccionar continente:</label>
            <select name="continente" id="continente">
                <option value="1">Europa</option>
                <option value="2">Asia</option>
                <option value="3">Oceanía</option>
                <option value="4">América del norte</option>
                <option value="5">América del sur</option>
                <option value="6">África</option>
            </select>
            <button class="boton" type="button" onclick="setAction('gestionar')">Gestionar</button>
            <button class="boton" type="button" onclick="setAction('listar')">Listar</button>
        </form>
        <script>
            function setAction(action) {
                document.getElementById('formulario').action = 'index.php?controller=conflicto&action=' + action;
                document.getElementById('formulario').submit();
            }
        </script>
    </aside>
</main>

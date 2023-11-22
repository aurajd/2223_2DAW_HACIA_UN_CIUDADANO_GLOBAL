<main>
    <div>
        <h1><?php echo htmlspecialchars($dataToView["data"]["conflicto"]["titulo"]) ?></h1>
        <table>
            <tr>
                <th class="columna-correcto">CORRECTO</th>
                <th>TEXTO MOTIVO</th>
            </tr>
            <?php foreach ($dataToView["data"]["motivos"] as $motivo) { ?>
                <tr>
                    <td class="columna-correcto">
                        <?php 
                        if($motivo["numMotivo"]==$dataToView["data"]["conflicto"]["numMotivo"])
                            echo "Sí";
                        else
                            echo "No";
                        ?>
                    </td>
                    <td>
                        <div class='scroll'>
                            <?php echo htmlspecialchars($motivo["textoMotivo"]) ?>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</main>
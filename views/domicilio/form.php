<div class="formulario-direccion">
    <h3>Dirección de envío</h3>
    <form method="POST" action="domicilio.php?action=<?php echo $action; ?>">
        <div class="una-columna">
            <input class="form-control form-control-lg" type="text" placeholder="Alias de la dirección"
                aria-label="default input example" name="data[ALIAS]"
                value="<?php echo isset($data[0]['ALIAS']) ? $data[0]['ALIAS'] : ''; ?>">
        </div>
        <div class="dos-columna">
            <input class="form-control form-control-lg izq" id="cod_postal" oninput="cambioCod('x');" type="text"
                placeholder="Código postal" aria-label="default input example" name="data[COD_POSTAL]"
                value="<?php echo isset($data[0]['COD_POSTAL']) ? $data[0]['COD_POSTAL'] : ''; ?>">
            <select id="colonia" class="form-select form-select-lg der" aria-label=".form-select-lg example" name="data[COLONIA]">
            </select>
        </div>
        <div class="una-columna">
            <input class="form-control form-control-lg" id="ciudad" type="text" placeholder="Ciudad"
                aria-label="default input example" name="data[CIUDAD]"
                value="<?php echo isset($data[0]['CIUDAD']) ? $data[0]['CIUDAD'] : ''; ?>" disabled>
        </div>
        <div class="una-columna">
            <input class="form-control form-control-lg" type="text" placeholder="Calle"
                aria-label="default input example" name="data[CALLE]"
                value="<?php echo isset($data[0]['CALLE']) ? $data[0]['CALLE'] : ''; ?>">
        </div>
        <div class="dos-columna">
            <input class="form-control form-control-lg izq" type="text" placeholder="Num. Int"
                aria-label="default input example" name="data[NUM_INT]"
                value="<?php echo isset($data[0]['NUM_INT']) ? $data[0]['NUM_INT'] : ''; ?>">
            <input class="form-control form-control-lg der" type="text" placeholder="Num. Ext."
                aria-label="default input example" name="data[NUM_EXT]"
                value="<?php echo isset($data[0]['NUM_EXT']) ? $data[0]['NUM_EXT'] : ''; ?>">
        </div>
        <div class="dos-columna">
            <input class="form-control form-control-lg izq" type="text" placeholder="Entre calles"
                aria-label="default input example" name="data[ENTRE_CALLES]"
                value="<?php echo isset($data[0]['ENTRE_CALLES']) ? $data[0]['ENTRE_CALLES'] : ''; ?>">
            <input class="form-control form-control-lg der" type="text" placeholder="Referencias"
                aria-label="default input example" name="data[REFERENCIAS]"
                value="<?php echo isset($data[0]['REFERENCIAS']) ? $data[0]['REFERENCIAS'] : ''; ?>">
        </div>
        <div class="una-columna">
            <input class="form-control form-control-lg" type="text" placeholder="Teléfono"
                aria-label="default input example" name="data[TELEFONO]"
                value="<?php echo isset($data[0]['TELEFONO']) ? $data[0]['TELEFONO'] : ''; ?>">
        </div>
        <input type="hidden" class="btn btn-warning der" name="data[DIRECCION_WEB_ID]"
            value="<?php echo isset($data[0]['DIRECCION_WEB_ID']) ? $data[0]['DIRECCION_WEB_ID'] : ''; ?>">
        <div class="botones-formulario">
            <input type="submit" class="btn btn-light izq" value="Cancelar" name="cancelar">
            <input type="submit" class="btn btn-warning der" value="Aceptar" name="aceptar">
        </div>
        <span id="lbl"></span>
    </form>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E="
    crossorigin="anonymous"></script>
<script src="js/domicilio-select.js"></script>
<script>
    $(function () {
        var mensajes = '<?php echo isset($data[0]['COLONIA']) ? $data[0]['COLONIA'] : ''; ?>';
        cambioCod(mensajes);
    });
</script>
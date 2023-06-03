<div class="formulario-direccion">
    <h3>Datos personales</h3>
    <form method="POST" action="mi-cuenta.php?action=edit">
        <div class="una-columna">
            <input class="form-control form-control-lg" type="text" placeholder="Nombre(s)"
                aria-label="default input example" name="data[NOMBRE]"
                value="<?php echo isset($data[0]['NOMBRE']) ? $data[0]['NOMBRE'] : ''; ?>">
        </div>
        <div class="una-columna">
            <input class="form-control form-control-lg" type="text" placeholder="Apellido(s)"
                aria-label="default input example" name="data[APELLIDO]"
                value="<?php echo isset($data[0]['APELLIDO']) ? $data[0]['APELLIDO'] : ''; ?>">
        </div>
        <div class="una-columna">
            <input class="form-control form-control-lg" type="text" placeholder="Correo electrónico"
                aria-label="default input example" name="data[CORREO]"
                value="<?php echo isset($data[0]['CORREO']) ? $data[0]['CORREO'] : ''; ?>">
        </div>

        <input type="hidden" class="btn btn-warning der" name="data[DIRECCION_WEB_ID]"
            value="<?php echo isset($data[0]['USUARIO_WEB_ID']) ? $data[0]['USUARIO_WEB_ID'] : ''; ?>">
        <div class="botones-formulario">
            <input type="submit" class="btn btn-light izq" value="Cancelar" name="cancelar">
            <input type="submit" class="btn btn-warning der" value="Guardar" name="aceptar">
        </div>
        <span id="lbl"></span>
    </form>
</div>
</div>
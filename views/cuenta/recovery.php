<div class="contenedor-crearlogear-cuenta">
    <div class="cuadro-cuenta">
        <h5 style="text-align: center;">Contraseña olvidada</h5>
        <form method="POST" action="cuenta.php?action=reset">
            <!-- Email input -->
            <h6>Ingresa tu nueva contraseña</h6>
            <div class="form-outline mb-4">
                <input type="password" id="form1Example23" name="contrasena" class="form-control form-control-lg"
                    placeholder="Contraseña" required />
            </div>
            <input type="hidden" name="correo" value="<?php echo $data['correo']; ?>" />
            <input type="hidden" name="token" value="<?php echo $data['token']; ?>" />
            <div class="botones-crear-cuenta">
                <input type="submit" class="btn btn-primary btn-crear-cuenta" class="btn btn-primary btn-lg btn-block"
                    name="enviar" value="Restablecer contraseña">
            </div>
        </form>
    </div>
</div>
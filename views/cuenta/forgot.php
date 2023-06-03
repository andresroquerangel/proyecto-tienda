<div class="contenedor-crearlogear-cuenta">
    <div class="cuadro-cuenta">
        <h5 style="text-align: center;">Contraseña olvidada</h5>
        <form method="POST" action="cuenta.php?action=send">
            <!-- Email input -->
            <h6>Ingresa el correo electrónico de tu cuenta</h6>
            <div class="form-outline mb-4">
                <input type="email" id="form1Example13" name="correo" class="form-control form-control-lg"
                    placeholder="Correo electrónico" required />
            </div>

            <div class="botones-crear-cuenta">
                <input type="submit" class="btn btn-primary btn-crear-cuenta" class="btn btn-primary btn-lg btn-block" name="enviar" value="Enviar correo">
            </div>
        </form>
    </div>
</div>
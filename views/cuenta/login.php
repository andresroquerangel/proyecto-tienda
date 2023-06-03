<div class="contenedor-crearlogear-cuenta">
    <div class="cuadro-cuenta">
        <h5 style="text-align: center;">Iniciar sesión</h5>
        <form method="POST" action="cuenta.php?action=login">
            <!-- Email input -->
            <div class="form-outline mb-4">
                <input type="email" id="form1Example13" name="correo" class="form-control form-control-lg"
                    placeholder="Correo electrónico" required />
            </div>
            <!-- Password input -->
            <div class="form-outline mb-4">
                <input type="password" id="form1Example23" name="contrasena" class="form-control form-control-lg"
                    placeholder="Contraseña" required />
            </div>

            <div class="botones-crear-cuenta">
                <input type="submit" class="btn btn-primary btn-crear-cuenta" class="btn btn-primary btn-lg btn-block" name="enviar" value="Iniciar sesión">
                <a href="cuenta.php?action=forgot" style="margin-top:0px;">Olvidé mi contraseña</a>
                <p>¿No tienes una cuenta?</p>

                <a type="submit" class="btn btn-light btn-iniciar-sesion" href="cuenta.php?action=crear">Registrarse</a>
            </div>
        </form>
    </div>
</div>
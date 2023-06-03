<div class="contenedor-crearlogear-cuenta">
    <div class="cuadro-cuenta">
        <h5 style="text-align: center;">Crear cuenta</h5>
        <form method="POST" action="cuenta.php?action=crear">
            <!-- Nombre input-->
            <input class="form-control form-control-lg" type="text" name="nombre" placeholder="Nombre(s)"
                aria-label=".form-control-lg example" required />
            <!-- Apellidos input-->
            <input class="form-control form-control-lg" type="text" name="apellidos" placeholder="Apellido(s)"
                aria-label=".form-control-lg example" required />
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
                <input type="submit" class="btn btn-primary btn-crear-cuenta" class="btn btn-primary btn-lg btn-block" name="enviar" value="Crear cuenta">

                <p>¿Ya tienes una cuenta?</p>

                <a class="btn btn-light btn-iniciar-sesion" href="cuenta.php?action=login">Iniciar sesión</a>
            </div>
        </form>
    </div>
</div>
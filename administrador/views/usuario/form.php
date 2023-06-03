<div class="col py-3" id="cuadro-azul">
    <div class="contenedor-index">
        <div class="contenedor-caja shadow-sm rounded">
            <h1>
                <?php echo ($action == 'edit') ? 'Modificar ' : 'Nuevo ' ?>Usuario
            </h1>
            <form method="POST" action="usuario.php?action=<?php echo $action; ?>">
            <div class="mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="data[NOMBRE]" class="form-control" placeholder="Nombre"
                        value="<?php echo isset($data[0]['NOMBRE']) ? $data[0]['NOMBRE'] : ''; ?>" required
                        minlength="3" maxlength="50" />
                </div>
                <div class="mb-3">
                    <label class="form-label">Apellido</label>
                    <input type="text" name="data[APELLIDO]" class="form-control" placeholder="Apellido"
                        value="<?php echo isset($data[0]['APELLIDO']) ? $data[0]['APELLIDO'] : ''; ?>" required
                        minlength="3" maxlength="50" />
                </div>    
            <div class="mb-3">
                    <label class="form-label">Correo del usuario</label>
                    <input type="text" name="data[CORREO]" class="form-control" placeholder="Correo electrónico"
                        value="<?php echo isset($data[0]['CORREO']) ? $data[0]['CORREO'] : ''; ?>" required
                        minlength="3" maxlength="50" />
                </div>
                <div class="mb-3">
                    <label class="form-label">Contraseña</label>
                    <input type="password" name="data[CONTRASENA]" class="form-control" placeholder="Contraseña"
                        required minlength="3" maxlength="50" value="<?php echo isset($data[0]['CONTRASENA']) ? $data[0]['CONTRASENA'] : ''; ?>" />
                </div>
                <?php
                $n = 1;
                foreach ($data_roles as $key => $rol):
                    $check = 0; ?>
                    <?php
                    if (isset($data_ru)) {
                        foreach ($data_ru as $key2 => $rol2) {
                            if ($rol['ROL_WEB_ID'] == $rol2['ROL_WEB_ID']) {
                                $check = 1;
                            }
                        }
                    } ?>
                    <div class="form-check" style="margin-bottom:10px">
                        <input class="form-check-input" type="checkbox" value="<?php echo $rol['ROL_WEB_ID']; ?>"
                            id="flexCheckDefault" name='data[roles][<?php echo $rol['ROL_WEB_ID']; ?>]' <?php echo ($check == 1) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="flexCheckDefault">
                            <?php echo $rol['ROL']; ?>
                        </label>
                    </div>
                    <?php $n++;
                endforeach; ?>
                <div class="mb-3">
                    <?php if ($action == 'edit'): ?>
                        <input type="hidden" name="data[USUARIO_WEB_ID]"
                            value="<?php echo isset($data[0]['USUARIO_WEB_ID']) ? $data[0]['USUARIO_WEB_ID'] : ''; ?>">
                    <?php endif; ?>
                    <input type="submit" name="enviar" value="Guardar" class="btn btn-primary" />
                </div>
            </form>
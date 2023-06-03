<div class="col py-3" id="cuadro-azul">
    <div class="contenedor-index">
        <div class="contenedor-caja shadow-sm rounded">
            <h1>
                <?php echo ($action == 'edit') ? 'Modificar ' : 'Nuevo ' ?>Privilegio
            </h1>
            <form method="POST" action="privilegios.php?action=<?php echo $action; ?>">
                <div class="mb-3">
                    <label class="form-label">Nombre del Privilegio</label>
                    <input type="text" name="data[PRIVILEGIO]" class="form-control" placeholder="Privilegio"
                        value="<?php echo isset($data[0]['PRIVILEGIO']) ? $data[0]['PRIVILEGIO'] : ''; ?>" required
                        minlength="3" maxlength="50" />
                </div>
                <div class="mb-3">
                    <?php if ($action == 'edit'): ?>
                        <input type="hidden" name="data[PRIVILEGIO_WEB_ID]"
                            value="<?php echo isset($data[0]['PRIVILEGIO_WEB_ID']) ? $data[0]['PRIVILEGIO_WEB_ID'] : ''; ?>">
                    <?php endif; ?>
                    <input type="submit" name="enviar" value="Guardar" class="btn btn-primary" />
                </div>
            </form>
        </div>
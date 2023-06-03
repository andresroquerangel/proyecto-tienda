<div class="col py-3">
    <div class="contenedor-index">
        <div class="contenedor-caja shadow-sm rounded">
            <h1>Roles</h1>
            <a href="roles.php?action=new" class="btn btn-success">Nuevo</a>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col" class="col-md-1">id</th>
                        <th scope="col" class="col-md-6">Rol</th>
                        <th scope="col" class="col-md-3">Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $n = 1; ?>
                    <?php foreach ($data as $key => $rol): ?>
                        <tr>
                            <th scope="row">
                                <?php echo $rol['ROL_WEB_ID']; ?>
                            </th>
                            <td>
                                <?php echo $rol['ROL']; ?>
                            </td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Menu Renglon">
                                    <a class="btn btn-dark" data-bs-toggle="collapse"
                                        href="#multiCollapseExample<?php echo $n; ?>" role="button" aria-expanded="false"
                                        aria-controls="multiCollapseExample<?php echo $n; ?>" id="ver-privilegios">Ver privilegios</a>
                                    <a class="btn btn-primary"
                                        href="roles.php?action=edit&id=<?php echo $rol['ROL_WEB_ID'] ?>">Modificar</a>
                                    <a class="btn btn-danger"
                                        href="roles.php?action=delete&id=<?php echo $rol['ROL_WEB_ID'] ?>">Eliminar</a>
                                </div>
                                <div class="collapse multi-collapse" id="multiCollapseExample<?php echo $n; ?>">
                                    <div class="card card-body">
                                        <ul class="list-group list-group-flush">
                                            <?php
                                            $coincidencias = 0;
                                            foreach ($data_privilegios as $key2 => $privilegio):
                                                if ($rol['ROL_WEB_ID'] == $privilegio['ROL_WEB_ID']): ?>
                                                    <li class="list-group-item">
                                                        <?php echo $privilegio['PRIVILEGIO']; ?>
                                                    </li>
                                                    <?php $coincidencias++; ?>
                                                <?php endif;
                                            endforeach;
                                            if ($coincidencias == 0): ?>
                                                <li class="list-group-item">No tiene privilegios</li>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php $n++;
                    endforeach; ?>
                </tbody>
                <tr>
                    <th scope="col"></th>
                    <th scope="col"></th>
                    <th scope="col">Se encontraron
                        <?php echo sizeof($data); ?> registros.
                    </th>
                </tr>
            </table>
        </div>
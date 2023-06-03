<div class="col py-3">
    <div class="contenedor-index">
        <div class="contenedor-caja shadow-sm rounded">
            <h1>Privilegios</h1>
            <a href="privilegios.php?action=new" class="btn btn-success">Nuevo</a>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col" class="col-md-1">id</th>
                        <th scope="col" class="col-md-8">Privilegio</th>
                        <th scope="col" class="col-md-3">Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $key => $privilegio): ?>
                        <tr>
                            <th scope="row">
                                <?php echo $privilegio['PRIVILEGIO_WEB_ID']; ?>
                            </th>
                            <td>
                                <?php echo $privilegio['PRIVILEGIO']; ?>
                            </td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Menu Renglon">
                                    <a class="btn btn-primary"
                                        href="privilegios.php?action=edit&id=<?php echo $privilegio['PRIVILEGIO_WEB_ID'] ?>">Modificar</a>
                                    <a class="btn btn-danger"
                                        href="privilegios.php?action=delete&id=<?php echo $privilegio['PRIVILEGIO_WEB_ID'] ?>">Eliminar</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
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
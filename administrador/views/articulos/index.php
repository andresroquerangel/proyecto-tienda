<div class="col py-3">
    <div class="contenedor-index">
        <div class="contenedor-caja shadow-sm rounded">
            <h1>Lista de articulos</h1>
            <div>
                <a href="articulos.php?action=crear" class="btn btn-warning">Agregar artículo</a>
                <a href="generar_excel.php?action=excel" class="btn btn-success">Descargar excel</a>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col" class="col-md-1">id</th>
                        <th scope="col" class="col-md-1">Imagen</th>
                        <th scope="col" class="col-md-1">Nombre</th>
                        <th scope="col" class="col-md-1">Categoria</th>
                        <th scope="col" class="col-md-1">Precio</th>
                        <th scope="col" class="col-md-1">Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $key => $articulo): ?>
                        <tr>
                            <th scope="row">
                                <?php echo $articulo['ARTICULO_ID']; ?>
                            </th>
                            <td>
                                <img src="<?php echo !empty($articulo['IMAGEN']) ? 'data:image/png;base64,' . base64_encode($articulo['IMAGEN']): '../images/no_image.svg'; ?>"
                                    style="width: 150px;height: 150px;">
                            </td>
                            <td>
                                <?php echo $articulo['NOMBRE']; ?>
                            </td>
                            <td>
                                <?php echo $articulo['CATEGORIA']; ?>
                            </td>
                            <td>
                                <?php echo '$' . substr($articulo['PRECIO'], 0, strlen($articulo['PRECIO']) - 4); ?>
                            </td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Menu Renglon">
                                    <a class="btn btn-primary"
                                        href="articulos.php?action=edit&id=<?php echo $articulo['ARTICULO_ID'] ?>">Editar</a>
                                    <a class="btn btn-danger"
                                        href="articulos.php?action=delete&id=<?php echo $articulo['ARTICULO_ID'] ?>">Eliminar</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tr>
                    <th scope="col"></th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                    <th scope="col">Se encontraron
                        <?php echo sizeof($data); ?> registros.
                    </th>
                </tr>
            </table>
            <nav aria-label="...">
                <ul class="pagination">
                    <li class="page-item <?php echo ($page - 1 == 0) ? 'disabled' : ''; ?>">
                        <a class="page-link" href="articulos.php?page=<?php echo $page - 1; ?>">Antes</a>
                    </li>
                    <li class="page-item <?php echo ($page == $aux + 1) ? 'active' : ''; ?>"><a class="page-link"
                            href="articulos.php?page=1">
                            <?php echo $aux + 1 ?>
                        </a></li>
                    <li class="page-item <?php echo ($page == $aux + 2) ? 'active' : ''; ?>" aria-current="page">
                        <a class="page-link" href="articulos.php?page=2">
                            <?php echo $aux + 2 ?>
                        </a>
                    </li>
                    <li class="page-item <?php echo ($page == $aux + 3) ? 'active' : ''; ?>"><a class="page-link"
                            href="articulos.php?page=3">
                            <?php echo $aux + 3 ?>
                        </a></li>
                    <li class="page-item">
                        <a class="page-link" href="articulos.php?page=<?php echo $page + 1; ?>">Siguiente</a>
                    </li>
                </ul>
            </nav>
        </div>
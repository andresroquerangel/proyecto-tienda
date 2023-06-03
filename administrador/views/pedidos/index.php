<div class="col py-3">
    <div class="contenedor-index">
        <div class="contenedor-caja shadow-sm rounded">
            <h1>Lista de pedidos</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col" class="col-md-1">id</th>
                        <th scope="col" class="col-md-2">Correo</th>
                        <th scope="col" class="col-md-2">Fecha</th>
                        <th scope="col" class="col-md-2">Costo</th>
                        <th scope="col" class="col-md-3">Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $key => $pedido): ?>
                        <tr>
                            <th scope="row">
                                <?php echo $pedido['PEDIDO_WEB_ID']; ?>
                            </th>
                            <td>
                                <?php echo $pedido['CORREO']; ?>
                            </td>
                            <td>
                                <?php echo $pedido['FECHA']; ?>
                            </td>
                            <td>
                                <?php echo '$' . substr($pedido['PRECIO'], 0, strlen($pedido['PRECIO']) - 4); ?>
                            </td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Menu Renglon">
                                <a class="btn btn-primary"
                                        href="pedidos.php?action=view&id=<?php echo $pedido['PEDIDO_WEB_ID'] ?>">Ver pedido</a>
                                <a class="btn btn-dark"
                                        href="reporte.php?action=pedido&id=<?php echo $pedido['PEDIDO_WEB_ID'] ?>" target="_blank">Descargar</a>    
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
        </div>
<div class="col py-3">
    <div class="contenedor-index">
        <div class="row columna-indice-datos">
            <div class="card shadow-sm tarjeta-index">
                <div class="card-body">
                    <h3>Ventas</h3>
                    <div class="cuadro-tarjeta">
                        <div class="cuadro-imagen" style="background-color: #f6f6fe;">
                            <img src="images/logo_ventas.svg" alt="Imagen de un carrito de compras">
                        </div>
                        <div class="cuadro-texto">
                            <h2>
                                <?php echo $data_p['VENTAS']; ?>
                            </h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm tarjeta-index">
                <div class="card-body">
                    <h3>Productos</h3>
                    <div class="cuadro-tarjeta">
                        <div class="cuadro-imagen">
                            <img src="images/logo_productos.svg" alt="Imagen de un carrito de compras">
                        </div>
                        <div class="cuadro-texto">
                            <h2>
                                <?php echo $data_p['PRODUCTOS']; ?>
                            </h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm tarjeta-index">
                <div class="card-body">
                    <h3>Usuarios</h3>
                    <div class="cuadro-tarjeta">
                        <div class="cuadro-imagen" style="background-color: #ffecdf;">
                            <img src="images/logo_usuarios.svg" alt="Imagen de un carrito de compras">
                        </div>
                        <div class="cuadro-texto">
                            <h2>
                                <?php echo $data_p['USUARIOS']; ?>
                            </h2>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="contenedor-caja shadow-sm rounded">
            <h3>Ventas del año
                <?php echo date('Y'); ?>
            </h3>
            <!--Div that will hold the pie chart-->
            <div id="chart_div" style="margin-top:20px; height: 500px"></div>
        </div>

        <div class="contenedor-caja shadow-sm rounded">
            <h3>
                Top ventas
            </h3>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col" class="col-md-2">Imagen</th>
                        <th scope="col" class="col-md-2">Producto</th>
                        <th scope="col" class="col-md-1">Precio</th>
                        <th scope="col" class="col-md-1">Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($data_a as $key => $articulo): ?>
                    <tr>
                        <td><img src="<?php echo !empty($articulo['IMAGEN']) ? 'data:image/png;base64,' . base64_encode($articulo['IMAGEN']): '../images/no_image.svg'; ?>"
                                    style="width: 150px;height: 150px;"></td>
                        <td><?php echo $articulo['NOMBRE']; ?></td>
                        <td><?php  echo '$' . substr($articulo['PRECIO'], 0, strlen($articulo['PRECIO']) - 4); ?></td>
                        <td><?php echo $articulo['CANTIDAD']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart', 'line'] });
    google.charts.setOnLoadCallback(drawBasic);

    function drawBasic() {

        var data = google.visualization.arrayToDataTable([
            ['Mes', 'Ventas'],
            <?php
            for ($n = 0; $n < 12; $n++):
                $valor = 0;
                foreach ($data as $key => $mes) {
                    if ($mes['MES'] == $n + 1) {
                        $valor = $mes['CANTIDAD'];
                    }
                } ?>
                [<?php echo "\"" . $meses[$n] . "\""; ?>, <?php echo $valor ?>],
            <?php endfor; ?>

        ]);


        var options = {
            hAxis: {
                title: 'Mes'
            },
            vAxis: {
                title: 'Productos vendidos'
            }
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

        chart.draw(data, options);
    }
</script>
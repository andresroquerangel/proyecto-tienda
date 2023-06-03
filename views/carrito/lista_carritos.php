<h2>Mi carrito</h2>
<?php if (empty($data)): ?>
    <h5>Tu carrito de compras está vacio.</h5>
<?php endif; ?>
<div class="row center">
    <div class="col-9 lista-carrito">
        <?php foreach ($data as $key => $articulo): ?>
            <div class="articulo_carrito">
                <div class="imagen_articulo">
                    <img src="<?php echo isset($articulo['IMAGEN'])?'data:image/png;base64,'.base64_encode($articulo['IMAGEN']):'images/no_image.svg'; ?>" class="card-img-top">
                </div>
                <div class="info_articulo_carrito">
                    <h5>
                        <?php echo $articulo['NOMBRE']; ?>
                    </h5>
                    <div class="botones_articulo_carrito">
                        <p>Cantidad:
                            <?php echo $articulo['CANTIDAD']; ?>
                        </p>
                        <a href="carrito.php?action=borrar&id=<?php echo $articulo['CARRITO_WEB_ID']; ?>&articulo=<?php echo $articulo['ARTICULO_ID']; ?>"
                            class="card-link">Eliminar</a>
                    </div>
                </div>
                <div class="articulo_precio_carrito">
                    <h4>
                        <?php echo '$' . substr($articulo['PRECIO'], 0, strlen($articulo['PRECIO']) - 4); ?>
                    </h4>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php if (!empty($data)): ?>
        <div class="col-2 cuadro-info-carrito">
            <h4>Subtotal: $
                <?php echo substr($subtotal, 0, strlen($subtotal) - 4);
                ; ?>
            </h4>
            <div class="botones">
                <a href="pago.php" class="btn btn-warning">Proceder al pago</a>
            </div>
        </div>
    <?php endif; ?>
</div>
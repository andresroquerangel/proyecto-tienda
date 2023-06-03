<div class="listado_articulos">
    <?php
    for ($m = 0; $m < sizeof($data); ): ?>
        <div class="row">
            <?php for ($n = 0; $n < 4, $m < sizeof($data); $n++, $m++): ?>
                <div class="col-3">
                    <div class="card tarjeta_producto" style="width: 18rem;">
                        <a class="card-image" href="articulo.php?&id=<?php echo $data[$m]['ARTICULO_ID']; ?>">
                        <img src="<?php echo isset($data[$m]['IMAGEN'])?'data:image/png;base64,'.base64_encode($data[$m]['IMAGEN']):'images/no_image.svg'; ?>" class="card-img-top" alt="..."
                                href="articulo.php?action=ver&id=<?php echo $data[$m]['ARTICULO_ID']; ?>">
                        </a>
                        <div class="card-body" style="width: 100%;">
                            <div class="div_titulo">
                                <a class="card-title" href="articulo.php?&id=<?php echo $data[$m]['ARTICULO_ID']; ?>">
                                    <?php echo $data[$m]['NOMBRE']; ?>
                                </a>
                            </div>
                            <p>
                                <b>
                                    <?php echo '$' . substr($data[$m]['PRECIO'], 0, strlen($data[$m]['PRECIO']) - 4); ?>
                                </b>
                            </p>
                            <div class="div_boton">
                                <a href="carrito.php?action=agregar&id=<?php echo $data[$m]['ARTICULO_ID']; ?>" class="btn btn-warning">Añadir al carrito</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
    <?php endfor; ?>
</div>
<div class="container-fluid row">
    <div class="col-6 cuadro-imagen-articulo">
        <img src="<?php echo isset($data[0]['IMAGEN'])?'data:image/png;base64,'.base64_encode($data[0]['IMAGEN']):'images/no_image.svg'; ?>" class="card-img-top">
    </div>
    <div class="col-6 cuadro-informacion-articulo">
        <h2>
            <?php echo $data[0]['NOMBRE']; ?>
        </h2>
        <div class="cuadro-informacion-articulo2">
            <h5>
                <b>
                    Precio:
                    <?php echo '$' . substr($data[0]['PRECIO'], 0, strlen($data[0]['PRECIO']) - 4); ?>
                </b>
            </h5>
            <form method="POST" action="carrito.php?action=agregar">
                <div class="caja-contador">
                    <p>Cantidad: </p>
                    <div class="botones-cantidad">
                        <button type="button" onclick="decrementar()" style="margin-right:10px" class="btn btn-light">-</button>
                        <p id="cantidad_texto">1</p>
                        <input type="hidden" id="cantidad_input" value="1" name="data[CANTIDAD]">
                        <button type="button" onclick="aumentar()" style="margin-left:10px" class="btn btn-light">+</button>
                    </div>
                </div>
                <div class="boton_anadir">
                    <input type="hidden" name="data[ARTICULO_ID]" value="<?php echo $data[0]['ARTICULO_ID']; ?>">
                    <input type="submit" class="btn btn-warning" value="Añadir al carrito" name="agregar">                </div>
            </form>
        </div>
    </div>
</div>

<script src="js/articulo.js"></script>

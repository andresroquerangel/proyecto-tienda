<div class="row center">
    <div class="col-7 informacion_envio">
        <h4>1 Selecciona dirección de envío.</h4>
        <form id="form_direccion_pago" method="POST" action="pago.php?action=pago_realizado">
            <?php for ($n = 0; $n < sizeof($data_domicilio); $n++): ?>
                <div class="radio_direccion">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="id_direccion"
                            name="radio" value="<?php echo $data_domicilio[$n]['DIRECCION_WEB_ID']; ?>" <?php echo ($n == 0) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="flexRadioDefault1">
                            <p><b>
                                    <?php echo $data_domicilio[$n]['ALIAS']; ?>
                                </b>
                                <?php echo $data_domicilio[$n]['CALLE'] . ', ' . $data_domicilio[$n]['COLONIA'] . ', ' . $data_domicilio[$n]['CIUDAD'] . ', ' . $data_domicilio[$n]['COD_POSTAL']; ?><br>
                                <?php echo $data_domicilio[$n]['REFERENCIAS'] . ', ' . $data_domicilio[$n]['ENTRE_CALLES'] . ', ' . $data_domicilio[$n]['TELEFONO']; ?>
                            </p>
                        </label>
                    </div>
                </div>
            <?php endfor; ?>
        </form>
        <h4>2 Método de pago.</h4>
        <div id="paypal-button-container"></div>
    </div>
    <div class="col-2 informacion_pago">
        <h5>Confirmación de pedido</h5>
        Subtotal: $
        <?php echo substr($subtotal, 0, strlen($subtotal) - 4); ?><br>
        Envio: <?php echo ENVIO; ?><br><br>
        <?php $total = substr($subtotal, 0, strlen($subtotal) - 4) + ENVIO; ?>
        <b>Total $
            <?php echo $total; ?>
        </b>
    </div>
</div>

<script
    src="https://www.paypal.com/sdk/js?client-id=AY31gH-TVzlpsJxYJhW7_kcP7Ol5TBoQ4en5RgaYL3cTLGqQmN3xo8adBBjk66h3pxCTqGG-GTIt539c&currency=MXN"></script>
<script>
    var temp1 = <?= json_encode($total) ?>;
    paypal.Buttons({
        style: {
            shape: 'pill',
            label: 'pay'
        },
        createOrder: function (data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        currency: "MXN",
                        value: temp1
                    }
                }]
            });
        },
        onApprove: function (data, actions) {
            actions.order.capture().then(function (detalles) {
                //window.location.href = "views/pago/pago_exitoso.php?id="+id_domicilio;
                document.getElementById("form_direccion_pago").submit();
            });
        },
        onCancel: function (data) {
            alert("Pago cancelado.");
            console.log(data);
        }
    }).render('#paypal-button-container');
</script>
<script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E="
    crossorigin="anonymous"></script>
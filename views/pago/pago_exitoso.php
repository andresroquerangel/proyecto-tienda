<div class="center_done">
    <img src="<?php echo ($estatus == 'done') ? 'images/pay_done.svg' : 'images/pay_fail.svg'; ?>"
        alt="Logo de Maxix Supermercado" width="500px">
    <h3>
        <?php echo ($estatus == 'done') ? '¡El pago se ha realizado con éxito!' : '¡Hubo un problema!'; ?>
    </h3>
    <?php if ($estatus = 'done'): ?>
        <a href="pedidos.php" class="btn btn-warning">Ver pedidos</a>
    <?php endif; ?>
</div>
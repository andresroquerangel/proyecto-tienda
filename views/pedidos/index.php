<h2>Mis pedidos</h2>
<nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button"
      role="tab" aria-controls="nav-home" aria-selected="true">En proceso</button>
    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button"
      role="tab" aria-controls="nav-profile" aria-selected="false">Entregados</button>
  </div>
</nav>
<div class="tab-content" id="nav-tabContent">
  <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
    <div class="row center">
      <?php foreach ($data as $key => $pedido_proceso):
        if ($pedido_proceso['PEDIDO_WEB_ESTATUS_ID'] == 1): ?>
          <div class="card card_pedido">
            <div class="card-header">
              <table>
                <thead>
                  <tr>
                    <th scope="col" class="col-md-2">FECHA</th>
                    <th scope="col" class="col-md-2">TOTAL</th>
                    <th scope="col" class="col-md-2">CÓDIGO</th>
                    <th scope="col" class="col-md-2">PEDIDO NO.</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>
                      <?php echo $pedido_proceso['FECHA']; ?>
                    </td>
                    <td>
                      <?php echo '$' . substr($pedido_proceso['PRECIO'], 0, strlen($pedido_proceso['PRECIO']) - 4); ?>
                    </td>
                    <td>
                      <?php echo $pedido_proceso['COD_ENTREGA']; ?>
                    </td>
                    <td>
                      <?php echo '#' . $pedido_proceso['PEDIDO_WEB_ID']; ?>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="card-body">
              <?php foreach ($data_detalle as $key => $articulo):
                if ($articulo['PEDIDO_WEB_ID'] == $pedido_proceso['PEDIDO_WEB_ID']): ?>
                  <div class="articulo_carrito">
                    <div class="imagen_articulo">
                    <img src="<?php echo isset($articulo['IMAGEN'])?'data:image/png;base64,'.base64_encode($articulo['IMAGEN']):'images/no_image.svg'; ?>" class="card-img-top">
                    </div>
                    <div class="info_articulo_carrito">
                      <h5>
                        <?php echo $articulo['NOMBRE']; ?>
                      </h5>
                    </div>
                  </div>
                <?php endif;
              endforeach; ?>
            </div>
          </div>
          <?php
        endif;
      endforeach; ?>
    </div>
  </div>
  <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
  <div class="row center">
  <?php foreach ($data as $key => $pedido_proceso):
    if ($pedido_proceso['PEDIDO_WEB_ESTATUS_ID'] == 2): ?>
      <div class="card card_pedido">
        <div class="card-header">
          <table>
            <thead>
              <tr>
                <th scope="col" class="col-md-2">FECHA</th>
                <th scope="col" class="col-md-2">TOTAL</th>
                <th scope="col" class="col-md-2">CÓDIGO</th>
                <th scope="col" class="col-md-2">PEDIDO NO.</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  <?php echo $pedido_proceso['FECHA']; ?>
                </td>
                <td>
                  <?php echo '$' . substr($pedido_proceso['PRECIO'], 0, strlen($pedido_proceso['PRECIO']) - 4); ?>
                </td>
                <td>
                  <?php echo $pedido_proceso['COD_ENTREGA']; ?>
                </td>
                <td>
                  <?php echo '#' . $pedido_proceso['PEDIDO_WEB_ID']; ?>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="card-body">
          <?php foreach ($data_detalle as $key => $articulo):
            if ($articulo['PEDIDO_WEB_ID'] == $pedido_proceso['PEDIDO_WEB_ID']): ?>
              <div class="articulo_carrito">
                <div class="imagen_articulo">
                <img src="<?php echo isset($articulo['IMAGEN'])?'data:image/png;base64,'.base64_encode($articulo['IMAGEN']):'images/no_image.svg'; ?>" class="card-img-top">
                </div>
                <div class="info_articulo_carrito">
                  <h5>
                    <?php echo $articulo['NOMBRE']; ?>
                  </h5>
                </div>
              </div>
            <?php endif;
          endforeach; ?>
        </div>
      </div>
      <?php
    endif;
  endforeach; ?>
</div>
  </div>
</div>
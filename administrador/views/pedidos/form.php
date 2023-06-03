<div class="col py-3">
    <div class="contenedor-index">
        <div class="contenedor-caja shadow-sm rounded">
            <div class="info-pedido">
                <div class="dos-columna">
                    <input class="form-control form-control-lg izq" id="cod_postal" type="text"
                        placeholder="Nombre" aria-label="default input example"
                        value="<?php echo isset($data[0]['NOMBRE']) ? $data[0]['NOMBRE'] : ''; ?>" disabled>
                    <input class="form-control form-control-lg der" id="cod_postal" type="text"
                        placeholder="Apellido" aria-label="default input example"
                        value="<?php echo isset($data[0]['APELLIDO']) ? $data[0]['APELLIDO'] : ''; ?>" disabled>
                </div>
                <div class="una-columna">
                <input class="form-control form-control-lg izq" id="cod_postal"
                            type="text" placeholder="Correo" aria-label="default input example"
                            value="<?php echo isset($data[0]['CORREO']) ? $data[0]['CORREO'] : ''; ?>" disabled>
                </div>
                <h3>Dirección de envío</h3>
                <div class="una-columna">
                    <input class="form-control form-control-lg" type="text" placeholder="Alias de la dirección"
                        aria-label="default input example" name="data[ALIAS]"
                        value="<?php echo isset($data[0]['ALIAS']) ? $data[0]['ALIAS'] : ''; ?>" disabled>
                </div>
                <div class="dos-columna">
                    <input class="form-control form-control-lg izq" id="cod_postal" type="text"
                        placeholder="Código postal" aria-label="default input example" name="data[COD_POSTAL]"
                        value="<?php echo isset($data[0]['COD_POSTAL']) ? $data[0]['COD_POSTAL'] : ''; ?>" disabled>
                    <input class="form-control form-control-lg der" id="cod_postal" type="text" placeholder="Colonia"
                        aria-label="default input example" name="data[COD_POSTAL]"
                        value="<?php echo isset($data[0]['COLONIA']) ? $data[0]['COLONIA'] : ''; ?>" disabled>
                </div>
                <div class="una-columna">
                    <input class="form-control form-control-lg" id="ciudad" type="text" placeholder="Ciudad"
                        aria-label="default input example" name="data[CIUDAD]"
                        value="<?php echo isset($data[0]['CIUDAD']) ? $data[0]['CIUDAD'] : ''; ?>" disabled>
                </div>
                <div class="una-columna">
                    <input class="form-control form-control-lg" type="text" placeholder="Calle"
                        aria-label="default input example" name="data[CALLE]"
                        value="<?php echo isset($data[0]['CALLE']) ? $data[0]['CALLE'] : ''; ?>" disabled>
                </div>
                <div class="dos-columna">
                    <input class="form-control form-control-lg izq" type="text" placeholder="Num. Int"
                        aria-label="default input example" name="data[NUM_INT]"
                        value="<?php echo isset($data[0]['NUM_INT']) ? $data[0]['NUM_INT'] : ''; ?>" disabled>
                    <input class="form-control form-control-lg der" type="text" placeholder="Num. Ext."
                        aria-label="default input example" name="data[NUM_EXT]"
                        value="<?php echo isset($data[0]['NUM_EXT']) ? $data[0]['NUM_EXT'] : ''; ?>" disabled>
                </div>
                <div class="dos-columna">
                    <input class="form-control form-control-lg izq" type="text" placeholder="Entre calles"
                        aria-label="default input example" name="data[ENTRE_CALLES]"
                        value="<?php echo isset($data[0]['ENTRE_CALLES']) ? $data[0]['ENTRE_CALLES'] : ''; ?>" disabled>
                    <input class="form-control form-control-lg der" type="text" placeholder="Referencias"
                        aria-label="default input example" name="data[REFERENCIAS]"
                        value="<?php echo isset($data[0]['REFERENCIAS']) ? $data[0]['REFERENCIAS'] : ''; ?>" disabled>
                </div>
                <div class="una-columna">
                    <input class="form-control form-control-lg" type="text" placeholder="Teléfono"
                        aria-label="default input example" name="data[TELEFONO]"
                        value="<?php echo isset($data[0]['TELEFONO']) ? $data[0]['TELEFONO'] : ''; ?>" disabled>
                </div>
                <h3>Productos adquiridos</h3>
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
                        <td>
                            <div class="cuadro-imagen-producto">
                                <img src="<?php echo isset($articulo['IMAGEN'])?'data:image/png;base64,'.base64_encode($articulo['IMAGEN']):'../images/no_image.svg'; ?>" style="width: 150px;height: 150px;">                            </div>
                        <td><?php echo $articulo['NOMBRE']; ?></td>
                        <td><?php  echo '$' . substr($articulo['PRECIO'], 0, strlen($articulo['PRECIO']) - 4); ?></td>
                        <td><?php echo $articulo['CANTIDAD']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            </div>
        </div>
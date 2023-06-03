<div class="col py-3">
    <div class="contenedor-index">
        <div class="contenedor-caja shadow-sm rounded">
            <div class="container-fluid row">
                <div class="col-6 cuadro-imagen-articulo">
                    <img src="<?php echo !empty($data[0]['IMAGEN']) ? 'data:image/png;base64,'.base64_encode($data[0]['IMAGEN']) : '../images/no_image.svg'; ?>"
                        class="card-img-top">
                </div>
                <div class="col-6 cuadro-informacion-articulo">
                    <div class="info-pedido">
                        <h5>Nombre del artículo</h5>
                        <form method="POST" action="articulos.php?action=<?php echo $action; ?>"
                            enctype="multipart/form-data">
                            <div class="una-columna">
                                <input class="form-control form-control-lg izq" type="text" name="data[NOMBRE]"
                                    aria-label="default input example"
                                    value="<?php echo isset($data[0]['NOMBRE']) ? $data[0]['NOMBRE'] : ''; ?>">
                            </div>
                            <h5>Precio</h5>
                            <div class="una-columna">
                                <input class="form-control form-control-lg izq" type="text" name="data[PRECIO]"
                                    aria-label="default input example"
                                    value="<?php echo isset($data[0]['PRECIO']) ? substr($data[0]['PRECIO'], 0, strlen($data[0]['PRECIO']) - 4) : ''; ?>">
                            </div>
                            <h5>Categoria</h5>
                            <div class="una-columna">
                                <select name="data[LINEA]" class="form-control" required>
                                    <?php
                                    foreach ($data_cat as $key => $linea):
                                        $selected = "";
                                        if ($linea['LINEA_ARTICULO_ID'] == $data[0]['LINEA_ARTICULO_ID']):
                                            $selected = "selected";
                                        endif;
                                        ?>
                                        <option value="<?php echo $linea['LINEA_ARTICULO_ID']; ?>" <?php echo $selected ?>>
                                            <?php echo $linea['NOMBRE'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <h5>Archivo imagen</h5>
                            <div class="una-columna">
                                <input type="file" name="imagen" />
                            </div>
                            <input type="hidden" class="btn btn-warning der" name="data[ARTICULO_ID]"
                                value="<?php echo isset($data[0]['ARTICULO_ID']) ? $data[0]['ARTICULO_ID'] : ''; ?>">
                            <div class="botones-formulario">
                                <input type="submit" class="btn btn-light izq" value="Cancelar" name="cancelar">
                                <input type="submit" class="btn btn-warning der" value="Aceptar" name="aceptar">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
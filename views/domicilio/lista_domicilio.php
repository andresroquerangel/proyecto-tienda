<div class="col-10">
    <div class="cuadro-boton-agregar">
        <a href="domicilio.php?action=crear" class="btn btn-warning">Agregar dirección</a>
    </div>
    <div class="lista-domicilio">
        <?php
        for ($m = 0; $m < sizeof($data); ): ?>
            <div class="row">
                <?php for ($n = 0; $n < 3, $m < sizeof($data); $n++, $m++): ?>
                    <div class="col-4">
                        <div class="card" style="width: 18rem;">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <?php echo $data[$m]['ALIAS']; ?>
                                </h5>
                                <p class="card-text">
                                    <?php echo $data[$m]['CALLE'] . ', ' . $data[$m]['NUM_EXT']; ?> <br>
                                    <?php echo $data[$m]['CIUDAD'] . ', ' . $data[$m]['COLONIA'] . ', ' . $data[$m]['COD_POSTAL']; ?>
                                </p>
                                <p class="card-text"><b>
                                        <?php echo 'Referencias'; ?>
                                    </b> <br>
                                    <?php echo $data[$m]['REFERENCIAS'] ?>
                                </p>
                                <p class="card-text"><b>
                                        <?php echo 'Teléfono'; ?>
                                    </b> <br>
                                    <?php echo $data[$m]['TELEFONO'] ?>
                                </p>
                                <div class="botones">
                                    <a href="domicilio.php?action=editar&id=<?php echo $data[$m]['DIRECCION_WEB_ID']; ?>"
                                        class="card-link">Editar</a>
                                    <a href="domicilio.php?action=borrar&id=<?php echo $data[$m]['DIRECCION_WEB_ID']; ?>"
                                        class="card-link">Borrar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>
        <?php endfor; ?>
    </div>
</div>
</div>
<div class="col py-3" id="cuadro-azul">
    <div class="contenedor-index">
        <div class="contenedor-caja shadow-sm rounded">
<h1>
  <?php echo ($action == 'edit') ? 'Modificar ' : 'Nuevo ' ?>Rol
</h1>
<form method="POST" action="roles.php?action=<?php echo $action; ?>">
  <div class="mb-3">
    <label class="form-label">Nombre del Rol</label>
    <input type="text" name="data[ROL]" class="form-control" placeholder="rol"
      value="<?php echo isset($data[0]['ROL']) ? $data[0]['ROL'] : ''; ?>" required minlength="3" maxlength="50" />
  </div>
  <?php
  $n = 1;
  foreach ($data_privilegios as $key => $privilegio):
    $check = 0;?>
    <?php
    if(isset($data_pr)){
      foreach ($data_pr as $key2 => $privilegio2){
        if ($privilegio['PRIVILEGIO_WEB_ID'] == $privilegio2['PRIVILEGIO_WEB_ID']) {
          $check = 1;
        }
      }
    }?>
    <div class="form-check" style="margin-bottom:10px">
      <input class="form-check-input" type="checkbox" value="<?php echo $privilegio['PRIVILEGIO_WEB_ID']; ?>" id="flexCheckDefault"
        name='data[privilegios][<?php echo $privilegio['PRIVILEGIO_WEB_ID']; ?>]' <?php echo ($check==1)?'checked':'' ?>>
      <label class="form-check-label" for="flexCheckDefault">
        <?php echo $privilegio['PRIVILEGIO']; ?>
      </label>
    </div>
    <?php $n++;
  endforeach; ?>
  <div class="mb-3">
    <?php if ($action == 'edit'): ?>
      <input type="hidden" name="data[ROL_WEB_ID]" value="<?php echo isset($data[0]['ROL_WEB_ID']) ? $data[0]['ROL_WEB_ID'] : ''; ?>">
    <?php endif; ?>
    <input type="submit" name="enviar" value="Guardar" class="btn btn-primary" />
  </div>
</form>
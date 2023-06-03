<div class="col py-3">
    <div class="contenedor-index">
        <div class="contenedor-caja shadow-sm rounded">
<h1>Usuarios</h1>
<a href="usuario.php?action=new" class="btn btn-success">Nuevo</a>
<table class="table">
  <thead>
    <tr>
      <th scope="col" class="col-md-1">id</th>
      <th scope="col" class="col-md-6">Correo</th>
      <th scope="col" class="col-md-3">Opciones</th>
    </tr>
  </thead>
  <tbody>
    <?php $n = 1; ?>
    <?php foreach ($data as $key => $usuario): ?>
      <tr>
        <th scope="row">
          <?php echo $usuario['USUARIO_WEB_ID']; ?>
        </th>
        <td>
          <?php echo $usuario['CORREO']; ?>
        </td>
        <td>
          <div class="btn-group" role="group" aria-label="Menu Renglon">
            <a class="btn btn-dark" data-bs-toggle="collapse" href="#multiCollapseExample<?php echo $n; ?>" role="button"
              aria-expanded="false" aria-controls="multiCollapseExample<?php echo $n; ?>">Ver roles</a>
            <a class="btn btn-primary" href="usuario.php?action=edit&id=<?php echo $usuario['USUARIO_WEB_ID'] ?>">Modificar</a>
            <a class="btn btn-danger" href="usuario.php?action=delete&id=<?php echo $usuario['USUARIO_WEB_ID'] ?>">Eliminar</a>
          </div>
          <div class="collapse multi-collapse" id="multiCollapseExample<?php echo $n; ?>">
            <div class="card card-body">
              <ul class="list-group list-group-flush">
                <?php
                $coincidencias = 0;
                foreach ($data_roles as $key2 => $rol):
                  if ($usuario['USUARIO_WEB_ID'] == $rol['USUARIO_WEB_ID']): ?>
                    <li class="list-group-item">
                      <?php echo $rol['ROL']; ?>
                    </li>
                    <?php $coincidencias++; ?>
                  <?php endif;
                endforeach;
                if ($coincidencias == 0): ?>
                  <li class="list-group-item">No tiene privilegios</li>
                <?php endif; ?>
              </ul>
            </div>
          </div>
        </td>
      </tr>
      <?php $n++;
    endforeach; ?>
  </tbody>
  <tr>
    <th scope="col"></th>
    <th scope="col"></th>
    <th scope="col">Se encontraron
      <?php echo sizeof($data); ?> registros.
    </th>
  </tr>
</table>
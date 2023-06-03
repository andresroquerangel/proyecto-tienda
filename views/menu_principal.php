<?php
require_once("controllers/sistema.php");
require_once("controllers/carrito.php");
?>
<nav class="navbar navbar-expand-lg navbar_principal">
  <div class="seccion_navbar">
    <a class="navbar-brand" href="index.php">
      <img src="images/logo_navbar.svg" alt="Logo de Maxix Supermercado" width="174px">
    </a>
    <form class="d-flex seccion_busqueda" role="search">
      <input class="form-control barra_busqueda" type="search" placeholder="Buscar" aria-label="Search">
      <a class="btn btn-warning boton_busqueda" href="#">
        <img src="images/logo_busqueda.svg" alt="Logo de buscar" width="25px">
      </a>
    </form>
    <?php
    if (empty($_SESSION)): ?>
      <div class="dropdown">
        <a class="btn dropdown-toggle navbar_opcion" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          Cuenta
        </a>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="cuenta.php?action=login">Iniciar sesión</a></li>
          <li><a class="dropdown-item" href="cuenta.php?action=crear">Registrarse</a></li>
        </ul>
      </div>
    <?php else: ?>
      <div class="dropdown">
        <a class="btn dropdown-toggle navbar_opcion" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          Hola,
          <?php echo explode(" ", $_SESSION['NOMBRE'])[0]; ?>
        </a>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="mi-cuenta.php">Perfil</a></li>
          <li><a class="dropdown-item" href="domicilio.php">Domicilios</a></li>
          <li><a class="dropdown-item" href="pedidos.php">Pedidos</a></li>
          <li><a class="dropdown-item" href="cuenta.php?action=cerrar">Cerrar sesión</a></li>
        </ul>
      </div>
    <?php endif; ?>
    <a class="icono_carrito position-relative" <?php echo (!empty($_SESSION))?'href="carrito.php"':''; ?>>
      <img src="images/logo_carrito.svg" alt="Logo de carrito de compra" width='40px'>
      <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning">
        <?php if (empty($_SESSION)): ?>
          0
          <?php else:
            $cantidad = $carritos -> cantidad($_SESSION['USUARIO_WEB_ID']);
            echo isset($cantidad[0]['SUM'])?$cantidad[0]['SUM']:0;
            ?>
        <?php endif; ?>
        <span class="visually-hidden">unread messages</span>
      </span>
    </a>
  </div>
</nav>

<?php
?>
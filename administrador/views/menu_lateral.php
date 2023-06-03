<div class="container-fluid">
    <div class="row flex-nowrap">
        <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark" data-bs-theme="dark">
            <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                <div style="position: fixed;bottom: 0px;top: 10px;">
                    <a href="/"
                        class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                        <span class="fs-5 d-none d-sm-inline">Panel de administración</span>
                    </a>
                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start"
                        id="menu">
                        <li class="nav-item">
                            <a href="index.php" class="nav-link align-middle px-0">
                                <i class="fs-4 bi-house"></i> <span
                                    class="ms-1 d-none d-sm-inline <?php echo ($opcion=='inicio')?'':'text-white'; ?>">Inicio</span>
                            </a>
                        </li>
                        <hr>
                        <li class="nav-item">
                            <a href="privilegios.php" class="nav-link align-middle px-0">
                                <i class="fs-4 bi-house"></i> <span
                                    class="ms-1 d-none d-sm-inline <?php echo ($opcion=='privilegios')?'':'text-white'; ?>">Privilegios</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="roles.php" class="nav-link align-middle px-0">
                                <i class="fs-4 bi-house"></i> <span
                                    class="ms-1 d-none d-sm-inline <?php echo ($opcion=='roles')?'':'text-white'; ?>">Roles</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="usuario.php" class="nav-link align-middle px-0">
                                <i class="fs-4 bi-house"></i> <span
                                    class="ms-1 d-none d-sm-inline <?php echo ($opcion=='usuarios')?'':'text-white'; ?>">Usuarios</span>
                            </a>
                        </li>
                    </ul>
                    <hr>
                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start"
                        id="menu">
                        <li class="nav-item">
                            <a href="articulos.php" class="nav-link align-middle px-0">
                                <i class="fs-4 bi-house"></i> <span
                                    class="ms-1 d-none d-sm-inline <?php echo ($opcion=='articulos')?'':'text-white'; ?>">Articulos</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="pedidos.php" class="nav-link align-middle px-0">
                                <i class="fs-4 bi-house"></i> <span
                                    class="ms-1 d-none d-sm-inline <?php echo ($opcion=='pedidos')?'':'text-white'; ?>">Pedidos</span>
                            </a>
                        </li>
                    </ul>
                    <hr>
                    <div class="dropdown pb-4" style="position: absolute;bottom:0px;">
                        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                            id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://github.com/mdo.png" alt="hugenerd" width="30" height="30"
                                class="rounded-circle">
                            <span class="d-none d-sm-inline mx-1">Administrador</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                            <li><a class="dropdown-item" href="../cuenta.php?action=cerrar">Cerrar sesión</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
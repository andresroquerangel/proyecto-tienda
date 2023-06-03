<?php
require_once("controllers/departamento.php");
$datos = $departamentos->getDepartamentos();
?>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-auto-close="outside" href="#" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Catálogos
                    </a>
                    <ul class="dropdown-menu">
                        <?php foreach ($datos as $key => $departamento): ?>
                            <li class="dropend">
                                <a class="dropdown-item dropdown-toggle" data-bs-toggle="dropdown">
                                    <?php echo $key; ?>
                                </a>
                                <ul class="dropdown-menu">
                                    <?php foreach ($departamento as $key2 => $nombre): ?>
                                        <li><a href="departamento.php?id=<?php echo $nombre['NOMBRE']; ?>"
                                                class="dropdown-item">
                                                <?php echo $nombre['NOMBRE']; ?>
                                            </a></li>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
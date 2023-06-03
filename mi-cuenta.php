<?php
require_once('controllers/sistema.php');
$sistema -> validateRol('CLIENTE');
include_once('views/header.php');
include_once('views/menu_principal.php');
include_once('views/menu_categorias.php');
$opcion = 'personal';
include_once('views/menu_lateral.php');
$action = (isset($_GET['action'])) ? $_GET['action'] : '';
switch ($action) {
    case 'get':
    default:
        $data = $sistema->getDatosCuenta($_SESSION['USUARIO_WEB_ID']);
        include('views/cuenta/mi-cuenta.php');
        break;

    case 'edit':
        $sistema -> validatePrivilegio('CUENTA EDITAR');
        if (isset($_POST['aceptar'])) {
            $data = $_POST['data'];
            $hubo_error = $sistema->editDatosCuenta($_SESSION['USUARIO_WEB_ID'], $data);
            if ($hubo_error == "Correcto") {
                $sistema->flash('success', 'Los cambios se han realizado correctamente');
            } else {
                $sistema->flash('danger', $hubo_error);
            }
            $data = $sistema->getDatosCuenta($_SESSION['USUARIO_WEB_ID']);
            include('views/cuenta/mi-cuenta.php');
        }
        break;
}
include_once('views/footer.php');
?>
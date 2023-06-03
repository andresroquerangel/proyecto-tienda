<?php
require_once(__DIR__."/controllers/rol.php");
$rol->validateRol('ADMINISTRADOR');
include_once('views/header.php');
$opcion = 'roles';
include_once('views/menu_lateral.php');
$action = (isset($_GET['action'])) ? ($_GET['action']) : 'get';
$id = (isset($_GET['id'])) ? ($_GET['id']) : null;
switch ($action) {
    case 'new':
        if (isset($_POST['enviar'])) {
            $data = $_POST['data'];
            $cantidad = $rol->new($data);
            if ($cantidad) {
                $rol->flash('success', 'Registro registrado con éxito');
                $data = $rol->get();
                $data_privilegios = $rol->getPrivilegiosRol();
                include('views/rol/index.php');
            } else {
                $rol->flash('danger', 'Algo salió mal');
                $data_privilegios = $rol->getAllPrivilegios();
                include('views/rol/form.php');
            }
        } else {
            $data_privilegios = $rol->getAllPrivilegios();
            include('views/rol/form.php');
        }
        break;
    case 'edit':
        if (isset($_POST['enviar'])) {
            $data = $_POST['data'];
            $id = $_POST['data']['ROL_WEB_ID'];
            $cantidad = $rol->edit($id, $data);
            if ($cantidad) {
                $rol->flash('success', 'Registro actualizado con éxito');
                $data = $rol->get();
                $data_privilegios = $rol->getPrivilegiosRol();
                include('views/rol/index.php');
            } else {
                $rol->flash('danger', 'Algo salió mal');
                $data = $rol->get($id);
                $data_privilegios = $rol->getAllPrivilegios();
                $data_pr = $rol->getPrivilegiosRol($id);
                include('views/rol/form.php');
            }
        } else {
            $data = $rol->get($id);
            $data_privilegios = $rol->getAllPrivilegios();
            $data_pr = $rol->getPrivilegiosRol($id);
            include('views/rol/form.php');
        }
        break;
    case 'delete':
        $cantidad = $rol->delete($id);
        if ($cantidad) {
            $rol->flash('success', 'Registro eliminado con éxito');
        } else {
            $rol->flash('danger', 'Algo salió mal');
        }
        $data = $rol->get();
        $data_privilegios = $rol->getPrivilegiosRol();
        include('views/rol/index.php');
        break;
    case 'get':
    default:
        $data = $rol->get();
        $data_privilegios = $rol->getPrivilegiosRol();

        include("views/rol/index.php");
        break;
}
include_once("views/footer.php");
?>
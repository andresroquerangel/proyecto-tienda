<?php
require_once(__DIR__ . "/controllers/usuario.php");
$usuario->validateRol('ADMINISTRADOR');
include_once('views/header.php');
$opcion = 'usuarios';
include_once('views/menu_lateral.php');
$action = (isset($_GET['action'])) ? ($_GET['action']) : 'get';
$id = (isset($_GET['id'])) ? ($_GET['id']) : null;
switch ($action) {
    case 'new':
        if (isset($_POST['enviar'])) {
            $data = $_POST['data'];
            $cantidad = $usuario->new($data);
            if ($cantidad) {
                $usuario->flash('success', 'Registro registrado con éxito');
                $data = $usuario->get();
                $data_roles = $usuario->getRolesUsuarios();
                include('views/usuario/index.php');
            } else {
                $usuario->flash('danger', 'Algo salió mal');
                $data_roles = $usuario->getAllRoles();
                include('views/usuario/form.php');
            }
        } else {
            $data_roles = $usuario->getAllRoles();
            include('views/usuario/form.php');
        }
        break;
    case 'edit':
        if (isset($_POST['enviar'])) {
            $data = $_POST['data'];
            $id = $_POST['data']['USUARIO_WEB_ID'];
            $cantidad = $usuario->edit($id, $data);
            if ($cantidad) {
                $usuario->flash('success', 'Registro actualizado con éxito');
                $data = $usuario->get();
                $data_roles = $usuario->getRolesUsuarios();
                include('views/usuario/index.php');
            } else {
                $usuario->flash('danger', 'Algo salió mal');
                $data = $usuario->get($id);
                $data_roles = $usuario->getAllRoles();
                $data_ru = $usuario->getRolesUsuarios($id);
                include('views/usuario/form.php');
            }
        } else {
            $data = $usuario->get($id);
            $data_roles = $usuario->getAllRoles();
            $data_ru = $usuario->getRolesUsuarios($id);
            //echo '<pre>';
            //print_r($data_roles);
            //print_r($data_ru);
            //die();
            include('views/usuario/form.php');
        }
        break;
    case 'delete':
        $cantidad = $usuario->delete($id);
        if ($cantidad) {
            $usuario->flash('success', 'Registro eliminado con éxito');
        } else {
            $usuario->flash('danger', 'Algo salió mal');
        }
        $data = $usuario->get();
        $data_roles = $usuario->getRolesUsuarios();
        include('views/usuario/index.php');
        break;
    case 'get':
    default:
        $data = $usuario->get();
        $data_roles = $usuario->getRolesUsuarios();
        include("views/usuario/index.php");
        break;
}
include_once("views/footer.php");
?>
<?php
require_once('controllers/articulos.php');
$articulo->validateRol('ADMINISTRADOR');
include_once('views/header.php');
$opcion = 'articulos';
include_once('views/menu_lateral.php');
$action = (isset($_GET['action'])) ? ($_GET['action']) : 'get';
$id = (isset($_GET['id'])) ? ($_GET['id']) : null;
$aux = 0;
$page = (isset($_GET['page'])) ? ($_GET['page']) : '1';
$count = $articulo->contar();
$count = $count[0]['COUNT'] / 20;
switch ($action) {
    case 'crear':
        if (isset($_POST['aceptar'])) {
            $data = $_POST['data'];
            $cantidad = $articulo->agregar($data);
            if ($cantidad) {
                $articulo->flash('', 'El articulo se añadió con éxito');
            } else {
                $articulo->flash('', 'Hubo un error');
            }
            $data = $articulo -> get(null,($page-1)*20);
            include('views/articulos/index.php');
        } else if (isset($_POST['cancelar'])) {
            $data = $articulo -> get(null,($page-1)*20);
            include('views/articulos/index.php');
        } else {
            $data_cat = $articulo->getCategoria();
            include('views/articulos/form.php');
        }
        break;
    case 'edit':
        if (isset($_POST['aceptar'])) {
            $data = $_POST['data'];
            $id = $_POST['data']['ARTICULO_ID'];
            $cantidad = $articulo->editar($data,$id);
            if ($cantidad) {
                $articulo->flash('', 'Se actualizó con éxito');
            } else {
                $articulo->flash('', 'Hubo un error');
            }
            $data = $articulo -> get(null,($page-1)*20);
            include('views/articulos/index.php');
        } else if (isset($_POST['cancelar'])) {
            $data = $articulo -> get(null,($page-1)*20);
            include('views/articulos/index.php');
        } else {
            $data = $articulo->get($id);
            $data_cat = $articulo->getCategoria();
            include("views/articulos/form.php");
        }
        break;
    case 'delete':
        $cantidad = $articulo -> eliminar($id);
        if ($cantidad) {
            $articulo->flash('', 'Se eliminó con éxito');
        } else {
            $articulo->flash('', 'Hubo un error');
        }
        $data = $articulo -> get(null,($page-1)*20);
        include('views/articulos/index.php');
        break;
    case 'get':
    default:
        if (is_null($id)) {
            $data = $articulo -> get(null,($page-1)*20);
        }
        include("views/articulos/index.php");
        break;
}
include_once("views/footer.php");
?>
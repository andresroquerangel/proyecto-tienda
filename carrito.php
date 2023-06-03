<?php
require_once('controllers/carrito.php');
$carritos -> validateRol('CLIENTE');
include_once('views/header.php');
include_once('views/menu_principal.php');
include_once('views/menu_categorias.php');
$action = isset($_GET['action']) ? $_GET['action'] : '';
$id = (isset($_GET['id'])) ? $_GET['id'] : '';
$articulo = (isset($_GET['articulo'])) ? $_GET['articulo'] : '';
switch ($action) {
    case 'ver':
    default:
        $data = $carritos->get($_SESSION['USUARIO_WEB_ID']);
        $subtotal = $carritos->getPrecio($_SESSION['USUARIO_WEB_ID']);
        $subtotal = $subtotal[0]['SUBTOTAL'];
        include('views/carrito/lista_carritos.php');
        break;
    case 'agregar':
        $carritos -> validatePrivilegio('CARRITO AGREGAR');
        if (empty($_POST)) {
            $carritos->agregar($_SESSION['USUARIO_WEB_ID'], $id, 1);
            if ($cantidad) {
                $carritos->flash('success', 'Se añadió el producto a su carrito');
                $subtotal = $carritos->getPrecio($_SESSION['USUARIO_WEB_ID']);
                $subtotal = $subtotal[0]['SUBTOTAL'];
                $data = $carritos->get($_SESSION['USUARIO_WEB_ID']);
                include('views/carrito/lista_carritos.php');
            } else {
                $carritos->flash('danger', 'Hubo un problema al añadir su producto');
            }
        } else {
            $data = $_POST['data'];
            if (isset($_POST['agregar'])) {
                $carritos->agregar($_SESSION['USUARIO_WEB_ID'], $data['ARTICULO_ID'], $data['CANTIDAD']);
                if ($cantidad) {
                    $carritos->flash('success', 'Se añadió el producto a su carrito');
                    $subtotal = $carritos->getPrecio($_SESSION['USUARIO_WEB_ID']);
                    $subtotal = $subtotal[0]['SUBTOTAL'];
                    $data = $carritos->get($_SESSION['USUARIO_WEB_ID']);
                    include('views/carrito/lista_carritos.php');
                } else {
                    $carritos->flash('danger', 'Hubo un problema al añadir su producto');
                }
            }
        }
        break;
    case 'borrar':
        $carritos -> validatePrivilegio('CARRITO BORRAR');
        $cantidad = $carritos->borrar($articulo, $_SESSION['USUARIO_WEB_ID'], $id);
        if ($cantidad) {
            $carritos->flash('success', 'Se eliminó el producto de su carrito');
        } else {
            $carritos->flash('danger', 'Hubo un problema al borrar el producto de su carrito');
        }
        $subtotal = $carritos->getPrecio($_SESSION['USUARIO_WEB_ID']);
        $subtotal = $subtotal[0]['SUBTOTAL'];
        $data = $carritos->get($_SESSION['USUARIO_WEB_ID']);
        include('views/carrito/lista_carritos.php');
        break;
}
include_once('views/footer.php');
?>
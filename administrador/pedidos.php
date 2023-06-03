<?php
require_once('controllers/pedidos.php');
$pedido->validateRol('ADMINISTRADOR');
include_once('views/header.php');
$opcion = 'pedidos';
include_once('views/menu_lateral.php');
$action = (isset($_GET['action'])) ? ($_GET['action']) : 'get';
$id = (isset($_GET['id'])) ? ($_GET['id']) : null;
switch ($action) {
    case 'view':
        $data = $pedido->get($id);
        $data_a = $pedido -> getArticulos($id);
        include("views/pedidos/form.php");
        break;
    case 'get':
    default:
        $data = $pedido->get();
        include("views/pedidos/index.php");
        break;
}
include_once("views/footer.php");
?>
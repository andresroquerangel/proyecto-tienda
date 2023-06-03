<?php
require_once("controllers/pedidos.php");
$pedidos -> validateRol('CLIENTE');
include("views/header.php");
include("views/menu_principal.php");
include("views/menu_categorias.php");
$action = (isset($_GET['accion']))? $_GET['accion'] : 'get';
switch($action){
    case 'get':
        default:
        $data = $pedidos -> get($_SESSION['USUARIO_WEB_ID']);
        $data_detalle = $pedidos -> get_detalle($_SESSION['USUARIO_WEB_ID']);
        include_once("views/pedidos/index.php");
        break;
}
include("views/footer.php");
?>
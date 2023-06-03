<?php
require_once("controllers/departamento.php");
include_once('views/header.php');
include_once('views/menu_principal.php');
include_once('views/menu_categorias.php');
$action = (isset($_GET['action'])) ? ($_GET['action']) : 'get';
$id = (isset($_GET['id'])) ? ($_GET['id']) : null;
switch ($action) {
    case 'get':
    default:
        $data = $departamentos->getArticulos($id);
        include("views/departamento/index.php");
        break;
}
include_once('views/footer.php');
?>
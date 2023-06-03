<?php
require_once('controllers/domicilio.php');
require_once('controllers/pago.php');
$pagos -> validateRol('CLIENTE');
include_once('views/header.php');
include_once('views/header_cuenta.php');
$action = (isset($_GET['action'])) ? $_GET['action'] : '';
switch ($action) {
    case 'pago_realizado':
        if (!empty($_POST)) {
            $estatus = 'fail';
            $id_direccion = $_POST['id_direccion'];
            $rc = $pagos->pago($_SESSION['USUARIO_WEB_ID'], $id_direccion);
            if ($rc[0] == 1) {
                $cantidad = $pagos->pago_detalle($_SESSION['USUARIO_WEB_ID'], $rc['COD']);
                if ($cantidad) {
                    $estatus = 'done';
                    $pagos -> enviar_correo($_SESSION['CORREO']);
                    $pagos->limpiarCarrito($_SESSION['USUARIO_WEB_ID']);
                }
            }
        } else{
            $estatus = 'fail';
        }
        include('views/pago/pago_exitoso.php');
        break;
    case 'get':
    default:
        $data_domicilio = $domicilios->get($_SESSION['USUARIO_WEB_ID']);
        $subtotal = $pagos->getPrecio($_SESSION['USUARIO_WEB_ID']);
        $subtotal = $subtotal[0]['SUBTOTAL'];
        include('views/pago/form.php');
        break;
}
include_once('views/footer.php');
?>
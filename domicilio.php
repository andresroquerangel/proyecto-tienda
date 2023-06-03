<?php
require_once('controllers/domicilio.php');
$domicilios -> validateRol('CLIENTE');
include_once('views/header.php');
include_once('views/menu_principal.php');
include_once('views/menu_categorias.php');
$opcion = 'direccion';
include_once('views/menu_lateral.php');
$action = (isset($_GET['action'])) ? ($_GET['action']) : 'get';
$id = (isset($_GET['id'])) ? ($_GET['id']) : null;
switch ($action) {
    case 'crear':
        $domicilios -> validatePrivilegio('DOMICILIO CREAR');
        if(isset($_POST['aceptar'])){
            $data = $_POST['data'];
            $cantidad = $domicilios -> crear($data,$_SESSION['USUARIO_WEB_ID']);
            if($cantidad){
                $domicilios -> flash('','Se actualizó con éxito');
            } else{
                $domicilios -> flash('','Hubo un error');
            }
            $data = $domicilios->get($_SESSION['USUARIO_WEB_ID']);
            include('views/domicilio/lista_domicilio.php');
        } else if(isset($_POST['cancelar'])){
            $data = $domicilios->get($_SESSION['USUARIO_WEB_ID']);
            include('views/domicilio/lista_domicilio.php');
        }
        else{
            include('views/domicilio/form.php');
        }
        break;
    case 'editar':
        $domicilios -> validatePrivilegio('DOMICILIO EDITAR');
        if(isset($_POST['aceptar'])){
            $data = $_POST['data'];
            $cantidad = $domicilios -> editar($data);
            if($cantidad){
                $domicilios -> flash('','Se actualizó con éxito');
            } else{
                $domicilios -> flash('','Hubo un error');
            }
            $data = $domicilios->get($_SESSION['USUARIO_WEB_ID']);
            include('views/domicilio/lista_domicilio.php');
        } else if(isset($_POST['cancelar'])){
            $data = $domicilios->get($_SESSION['USUARIO_WEB_ID']);
            include('views/domicilio/lista_domicilio.php');
        }
        else{
            $data = $domicilios -> getDom($_SESSION['USUARIO_WEB_ID'],$id);
            include('views/domicilio/form.php');
        }
        break;
    case 'borrar':
        $domicilios -> validatePrivilegio('DOMICILIO ELIMINAR');
        $cantidad = $domicilios->borrar($id, $_SESSION['USUARIO_WEB_ID']);
        if($cantidad==0){
            $domicilios -> flash('sucess','Hubo un problema al querer eliminar la dirección.');
        }
        $data = $domicilios->get($_SESSION['USUARIO_WEB_ID']);
        include('views/domicilio/lista_domicilio.php');
        break;
    case 'get':
    default:
        $domicilios -> validatePrivilegio('DOMICILIO LEER');
        $data = $domicilios->get($_SESSION['USUARIO_WEB_ID']);
        include('views/domicilio/lista_domicilio.php');
        break;
}
include_once('views/footer.php');
?>
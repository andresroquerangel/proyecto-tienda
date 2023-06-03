<?php 
    require_once(__DIR__."/controllers/privilegio.php");
    $privilegio -> validateRol('ADMINISTRADOR');
    include_once('views/header.php');
    $opcion = 'privilegios';
    include_once('views/menu_lateral.php');
    $action = (isset($_GET['action']))?($_GET['action']):'get';
    $id = (isset($_GET['id']))?($_GET['id']):null;
    switch($action){
        case 'new':  
            if(isset($_POST['enviar'])){
                $data = $_POST['data'];
                $cantidad = $privilegio-> new($data);
                if($cantidad){
                    $privilegio->flash('success','Registro registrado con éxito');
                    $data = $privilegio->get();
                    include('views/privilegio/index.php');
                }
                else{
                    $privilegio->flash('danger','Algo salió mal');
                    include('views/privilegio/form.php');
                }
            }
            else{
                include('views/privilegio/form.php');
            }
            break;
        case 'edit':
            if(isset($_POST['enviar'])){
                $data = $_POST['data'];
                $id = $_POST['data']['PRIVILEGIO_WEB_ID'];
                $cantidad =$privilegio-> edit($id,$data);
                if($cantidad){
                    $privilegio->flash('success','Registro actualizado con éxito');
                    $data = $privilegio->get();
                    include('views/privilegio/index.php');
                }
                else{
                    $privilegio->flash('danger','Algo salió mal');
                    $data = $privilegio->get();
                    include('views/privilegio/form.php');
                }
            }
            else{
                $data = $privilegio->get($id);
                include('views/privilegio/form.php');
            }
            break;
        case 'delete':
            $cantidad = $privilegio->delete($id);
            if($cantidad){
                $privilegio->flash('success','Registro eliminado con éxito');
                $data = $privilegio->get();
                include('views/privilegio/index.php');
            }
            else{
                $privilegio->flash('danger','Algo salió mal');
                $data = $privilegio->get();
                include('views/privilegio/index.php');
            }
            break;
        case 'get':
        default:
            $data = $privilegio->get($id);
            include("views/privilegio/index.php");
            break;
    }
    include_once("views/footer.php");
?>
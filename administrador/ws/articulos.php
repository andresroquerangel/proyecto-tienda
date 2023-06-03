<?php

use function PHPSTORM_META\type;

header('Content-type: application/json; charset=utf-8');
include_once(__DIR__ . "/../controllers/sistema.php");
include_once(__DIR__ . "/../controllers/articulos.php");
$action = $_SERVER['REQUEST_METHOD'];
$id = (isset($_GET['id'])) ? $_GET['id'] : null;
$page = (isset($_GET['page'])) ? ($_GET['page']) : '1';
switch ($action) {
    case 'DELETE':
        $data['mensaje'] = 'No existe el articulo';
        if (!is_null($id)) {
            $contador = $articulo->eliminar($id);
            if ($contador == 1) {
                $data['mensaje'] = 'Se eliminó el articulo';
            }
            $data = json_encode($data);
            echo $data;
        }
        break;
    case 'POST':
        if (!empty($_POST)) {
            if (!empty($_POST['data']['NOMBRE']) && !empty($_POST['data']['PRECIO']) && !empty($_POST['data']['LINEA'])) {
                if (isset($_FILES['imagen'])) {
                    if (!$articulo->comprobarFormato()) {
                        $data['mensaje2'] = 'El formato de imagen es incorrecto';
                    }
                }
                if (is_numeric($_POST['data']['PRECIO']) == 1 && is_numeric($_POST['data']['LINEA']) == 1) {
                    $data = $_POST['data'];
                    echo $id;
                    if (is_null($id)) {
                        $cantidad = $articulo->agregar($data);
                        if ($cantidad != 0) {
                            $data['mensaje'] = 'Se insertó el articulo';
                        } else {
                            $data['mensaje'] = 'Ocurrió un error al agregar';
                        }
                    } else {
                        $cantidad = $articulo->editar($data, $id);
                        if ($cantidad != 0) {
                            $data['mensaje'] = 'Se actualizó el articulo';
                        } else {
                            $data['mensaje'] = 'Ocurrió un error';
                        }
                    }
                } else {
                    $data['mensaje'] = 'Has introducido datos no validos';
                }
            } else {
                $data['mensaje'] = 'Introduce todos los campos, te faltan';
            }
        } else {
            $data['mensaje'] = 'Introduce campos';
        }
        $data = json_encode($data);
        echo $data;
        break;
    case 'GET':
    default:
        if (is_null($id)) {
            $data = $articulo->get(null, ($page - 1) * 20);
        } else {
            $data = $articulo->get($id);
        }
        $data = $articulo->arreglarJson($data);
        $data = json_encode($data);
        echo $data;
        break;
}
?>
<h1></h1>
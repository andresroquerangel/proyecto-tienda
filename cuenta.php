<?php
include('controllers/sistema.php');
require_once('views/header.php');
require_once('views/header_cuenta.php');
$action = (isset($_GET['action'])) ? ($_GET['action']) : 'get';
switch ($action) {
    case 'crear':
        if (isset($_POST['enviar'])) {
            $data = $_POST;
            $hubo_error = $sistema->crearCuenta($data['nombre'], $data['apellidos'], $data['correo'], $data['contrasena']);
            if ($hubo_error == "Correcto") {
                $sistema->login($data['correo'], $data['contrasena']);
                header("Location: index.php");
            } else {
                $sistema->flash('danger', $hubo_error);
            }
        }
        include('views/cuenta/crearcuenta.php');
        break;
    case 'cerrar':
        $sistema->logout();
        header("Location: index.php");
        break;
    case 'forgot':
        include('views/cuenta/forgot.php');
        break;
    case 'send':
        if (isset($_POST['enviar'])) {
            $correo = $_POST['correo'];
            $cantidad = $sistema->loginsend($correo);
            if ($cantidad == 1) {
                $sistema->flash('success', 'Se ha enviado un email al correo');
            } else {
                $sistema->flash('danger', 'Tal vez se envío');
            }
            include('views/cuenta/login.php');
        }
        break;
    case 'recovery':
        $data = $_GET;
        if (isset($data['correo']) and isset($data['token'])) {
            if ($sistema->validateToken($data['correo'], $data['token'])) {
                include_once('views/cuenta/recovery.php');
            } else {
                $sistema->flash('danger', 'El token expiró');
                include('views/cuenta/login.php');
            }
        } else {
            $sistema->flash('danger', 'url no puede ser completada como la requirió');
            include('views/cuenta/login.php');
        }
        break;
    case 'reset':
        $data = $_POST;
        if (isset($data['correo']) and isset($data['token']) and isset($data['contrasena'])) {
            if ($sistema->validateToken($data['correo'], $data['token'])) {
                if ($sistema->resetPassword($data['correo'], $data['token'], $data['contrasena'])) {
                    $sistema->flash('success', 'Contraseña actualizada con éxito');
                    include('views/cuenta/login.php');
                } else {
                    $sistema->flash('warning', 'Contacta a soporte técnico o vuelve a iniciar el proceso especificando su correo electrónico');
                    include_once('views/cuenta/forgot.php');
                }
            } else {
                $sistema->flash('danger', 'El token expiró');
            }
        } else {
            $sistema->flash('danger', 'url no puede ser completada como la requirió');
            include('views/cuenta/login.php');
        }
        break;
    case 'login':
        if (isset($_POST['enviar'])) {
            $data = $_POST;
            if ($sistema->login($data['correo'], $data['contrasena'])) {
                if (in_array('ADMINISTRADOR', $_SESSION['roles'])) {
                    header("Location: administrador/index.php");
                } else {
                    if (in_array('CLIENTE', $_SESSION['roles'])) {
                        header("Location: index.php");
                    }
                }
            }
        }
        include('views/cuenta/login.php');
        break;
}
require_once('views/footer.php');
?>
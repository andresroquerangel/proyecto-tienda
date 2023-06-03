<?php
session_start();
require_once(__DIR__ . '/../config.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

$c = substr($_SERVER['REQUEST_URI'], 1, 14);
require __DIR__ . '/../vendor/autoload.php';
class Sistema
{
    var $db = null;
    public function db()
    {
        $dsn = DBDRIVER . ':dbname=' . DBHOST . '/' . DBPORT . ':' . DBNAME;
        $this->db = new PDO($dsn, DBUSER, DBPASS);
    }

    public function flash($color, $msg)
    {
        include('views/flash.php');
    }

    public function crearCuenta($nombre, $apellido, $correo, $contrasena)
    {
        if (!is_null($nombre) and !is_null($apellido) and !is_null($correo) and !is_null($contrasena)) {
            if (strlen($nombre) > 0 and strlen($apellido) > 0 and strlen($correo) > 0 and strlen($contrasena) > 0) {
                if ($this->validateEmail($correo)) {
                    $a = $this->existeEmail($correo);
                    if ($a[0]['COUNT'] == 0) {
                        $this->db();
                        $sql = "insert into usuario_web(nombre, apellido, correo, contrasena) values (:nombre,:apellido,:correo,:contrasena)";
                        $st = $this->db->prepare($sql);
                        $st->bindParam(':nombre', $nombre, PDO::PARAM_STR);
                        $st->bindParam(':apellido', $apellido, PDO::PARAM_STR);
                        $st->bindParam(':correo', $correo, PDO::PARAM_STR);
                        $contrasena = md5($contrasena);
                        $st->bindParam(':contrasena', $contrasena, PDO::PARAM_STR);
                        $st->execute();

                        $sql = "select USUARIO_WEB_ID from USUARIO_WEB where CORREO = :correo";
                        $st = $this->db->prepare($sql);
                        $st->bindParam(':correo', $correo, PDO::PARAM_STR);
                        $st->execute();
                        $data = $st->fetchAll(PDO::FETCH_ASSOC);
                        $usuario_id = $data[0]['USUARIO_WEB_ID'];

                        $sql = "insert into USUARIO_ROL_WEB(USUARIO_WEB_ID,ROL_WEB_ID) values (:id,3)";
                        $st = $this->db->prepare($sql);
                        $st->bindParam(':id', $usuario_id, PDO::PARAM_STR);
                        $st->execute();
                        return "Correcto";
                    }
                    return "Ya existe una cuenta con esas credenciales";
                }
                return "El correo no es válido";
            }
        }
        return false;
    }

    public function login($correo, $contrasena)
    {
        if (!is_null($contrasena)) {
            if (strlen($contrasena) > 0) {
                if ($this->validateEmail($correo)) {
                    $contrasena = md5($contrasena);
                    $this->db();
                    $sql = 'select usuario_web_id,nombre,correo from usuario_web where correo= :correo and contrasena= :contrasena';
                    $st = $this->db->prepare($sql);
                    $st->bindParam(':correo', $correo, PDO::PARAM_STR);
                    $st->bindParam(':contrasena', $contrasena, PDO::PARAM_STR);
                    $st->execute();
                    $data = $st->fetchAll(PDO::FETCH_ASSOC);
                    if (isset($data[0])) {
                        $data = $data[0];
                        $_SESSION = $data;
                        $_SESSION['roles'] = $this->getRoles($correo);
                        $_SESSION['privilegios'] = $this->getPrivilegios($correo);
                        $_SESSION['validado'] = true;
                        return true;
                    }
                }
            }
        }
        return false;
    }

    public function logout()
    {
        unset($_SESSION["logeado"]);
        session_destroy();
    }

    public function loginsend($correo)
    {
        $rc = 0;
        if ($this->validateEmail($correo)) {
            $this->db();
            $sql = 'SELECT CORREO from USUARIO_WEB where CORREO = :correo';
            $st = $this->db->prepare($sql);
            $st->bindParam(':correo', $correo, PDO::PARAM_STR);
            $st->execute();
            $data = $st->fetchAll(PDO::FETCH_ASSOC);
            if (isset($data[0])) {
                $token = $this->generarToken($correo);
                $sql2 = 'UPDATE USUARIO_WEB set TOKEN = :token where CORREO = :correo';
                $st2 = $this->db->prepare($sql2);
                $st2->bindParam(':token', $token, PDO::PARAM_STR);
                $st2->bindParam(':correo', $correo, PDO::PARAM_STR);
                $st2->execute();
                $rc = $st2->rowCount();
                $this->forgot($correo, $token);
            }
        }
        return $rc;
    }

    public function forgot($destinatario, $token)
    {
        if ($this->validateEmail($destinatario)) {
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 465;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->SMTPAuth = true;
            $mail->Username = '20030928@itcelaya.edu.mx';
            $mail->Password = 'xmtvlsouhaoqoqjz';
            $mail->setFrom('20030928@itcelaya.edu.mx', 'Roque Rangel Andres');
            $mail->addAddress($destinatario, 'TIENDA MAXIX');
            $mail->Subject = 'Recuperación de contraseña';
            $msg = "
            Estimado Usuario <br>
            Presione <a href=\"http://localhost/tienda/cuenta.php?action=recovery&token=$token&correo=$destinatario\">aqui</a> para recuperar la contraseña <br>
            Att: Constructora
            ";
            $mail->msgHTML($msg);
            if (!$mail->send()) {
                //echo 'Mailer Error: ' . $mail->ErrorInfo;
            } else {
                //echo 'Message sent!';
            }
            function save_mail($mail)
            {
                $path = '{imap.gmail.com:993/imap/ssl}[Gmail]/Sent Mail';
                $imapStream = imap_open($path, $mail->Username, $mail->Password);
                $result = imap_append($imapStream, $path, $mail->getSentMIMEMessage());
                imap_close($imapStream);
                return $result;
            }
        }
    }

    public function generarToken($correo)
    {
        $token = "papaschicas";
        $n = rand(1, 1000000);
        $x = md5(md5($token));
        $y = md5($x . $n);
        $token = md5($y);
        $token = md5($token . 'calamardo');
        $token = md5('patricio') . md5($token . $correo);
        return $token;
    }

    public function resetPassword($correo, $token, $contrasena)
    {
        $cantidad = 0;
        if (strlen($token) == 64 and strlen($contrasena) > 0) {
            if ($this->validateEmail($correo)) {
                $contrasena = md5($contrasena);
                $this->db();
                $sql = 'UPDATE USUARIO_WEB SET CONTRASENA = :contrasena, TOKEN = null where CORREO = :correo and TOKEN = :token';
                $st = $this->db->prepare($sql);
                $st->bindParam(':contrasena', $contrasena, PDO::PARAM_STR);
                $st->bindParam(':correo', $correo, PDO::PARAM_STR);
                $st->bindParam(':token', $token, PDO::PARAM_STR);
                $st->execute();
                $cantidad = $st->rowCount();
            }
        }
        return $cantidad;
    }

    public function validateToken($correo, $token)
    {
        if (strlen($token) == 64) {
            if ($this->validateEmail($correo)) {
                $this->db();
                $sql = 'SELECT CORREO FROM USUARIO_WEB WHERE CORREO = :correo AND TOKEN = :token';
                $st = $this->db->prepare($sql);
                $st->bindParam(':correo', $correo, PDO::PARAM_STR);
                $st->bindParam(':token', $token, PDO::PARAM_STR);
                $st->execute();
                $data = $st->fetchAll(PDO::FETCH_ASSOC);
                if (isset($data[0])) {
                    return true;
                }
            }
        }
        return false;
    }

    public function validateEmail($correo)
    {
        if (filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }

    public function existeEmail($correo)
    {
        $this->db();
        $sql = "select count(*) from USUARIO_WEB where correo= :correo";
        $st = $this->db->prepare($sql);
        $st->bindParam(':correo', $correo, PDO::PARAM_STR);
        $st->execute();
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRoles($correo)
    {
        $roles = array();
        if ($this->validateEmail($correo)) {
            $this->db();
            $sql = 'select r.rol_web_id, r.rol from usuario_web u join usuario_rol_web ur on u.usuario_web_id=ur.usuario_web_id join rol_web r on r.rol_web_id=ur.rol_web_id where u.correo= :correo';
            $st = $this->db->prepare($sql);
            $st->bindParam(':correo', $correo, PDO::PARAM_STR);
            $st->execute();
            $data = $st->fetchAll(PDO::FETCH_ASSOC);
            foreach ($data as $key => $rol) {
                array_push($roles, $rol['ROL']);
            }
        }
        return $roles;
    }

    public function getPrivilegios($correo)
    {
        $privilegios = array();
        if ($this->validateEmail($correo)) {
            $this->db();
            $sql = 'SELECT p.PRIVILEGIO from PRIVILEGIO_WEB p join ROL_PRIVILEGIO_WEB rp on p.PRIVILEGIO_WEB_ID=rp.PRIVILEGIO_WEB_ID join ROL_WEB r on r.ROL_WEB_ID=rp.ROL_WEB_ID join USUARIO_ROL_WEB ur on r.ROL_WEB_ID=ur.ROL_WEB_ID join USUARIO_WEB u on u.USUARIO_WEB_ID=ur.USUARIO_WEB_ID where u.CORREO= :correo';
            $st = $this->db->prepare($sql);
            $st->bindParam(':correo', $correo, PDO::PARAM_STR);
            $st->execute();
            $data = $st->fetchAll(PDO::FETCH_ASSOC);
            foreach ($data as $key => $privilegio) {
                array_push($privilegios, $privilegio['PRIVILEGIO']);
            }
        }
        return $privilegios;
    }

    public function validateRol($rol)
    {
        if (isset($_SESSION['validado'])) {
            if ($_SESSION['validado']) {
                if (isset($_SESSION['roles'])) {
                    if (!in_array($rol, $_SESSION['roles'])) {
                        $this->killApp('No tienes el rol adecuado');
                    }
                } else {
                    $this->killApp('No tienes roles asignados');
                }
            } else {
                $this->killApp('No estás validado');
            }
        } else {
            $this->killApp('No estás logeado');
        }
    }

    public function validatePrivilegio($privilegio)
    {
        if (isset($_SESSION['validado'])) {
            if ($_SESSION['validado']) {
                if (isset($_SESSION['privilegios'])) {
                    if (!in_array($privilegio, $_SESSION['privilegios'])) {
                        $this->killApp('No tienes el privilegio adecuado');
                    }
                } else {
                    $this->killApp('No tienes privilegios asignados');
                }
            } else {
                $this->killApp('No estás validado');
            }
        } else {
            $this->killApp('No estás logeado');
        }
    }

    public function killApp($mensaje)
    {
        $this -> flash('danger',$mensaje);
        header("Location: index.php");
    }

    public function getDatosCuenta($id_user)
    {
        $this->db();
        $sql = "SELECT USUARIO_WEB_ID,NOMBRE,APELLIDO,CORREO FROM USUARIO_WEB WHERE USUARIO_WEB_ID = :id_user";
        $st = $this->db->prepare($sql);
        $st->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $st->execute();
        $data = $st->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function editDatosCuenta($id_user, $data)
    {
        if (!is_null($data['NOMBRE']) and !is_null($data['APELLIDO']) and !is_null($data['CORREO'])) {
            if (strlen($data['NOMBRE']) > 0 and strlen($data['APELLIDO']) > 0 and strlen($data['CORREO']) > 0) {
                if ($this->validateEmail($data['CORREO'])) {
                    $this->db();
                    $sql = "UPDATE USUARIO_WEB SET NOMBRE=:nombre,APELLIDO=:apellido,CORREO=:correo WHERE USUARIO_WEB_ID = :id_user";
                    $st = $this->db->prepare($sql);
                    $st->bindParam(':nombre', $data['NOMBRE'], PDO::PARAM_STR);
                    $st->bindParam(':apellido', $data['APELLIDO'], PDO::PARAM_STR);
                    $st->bindParam(':correo', $data['CORREO'], PDO::PARAM_STR);
                    $st->bindParam(':id_user', $id_user, PDO::PARAM_INT);
                    $st->execute();
                    $rc = $st->rowCount();
                    return 'Correcto';
                }
                return "El correo no es válido";
            }
        }
        return false;
    }
}
$sistema = new Sistema();
?>
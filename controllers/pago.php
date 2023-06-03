<?php
require_once('sistema.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
require __DIR__ . '/../vendor/autoload.php';
class Pago extends Sistema
{
    public function pago($id_user, $id_direccion)
    {
        try {
            $this->db();
            $this->db->beginTransaction();
            $sql = 'INSERT INTO PEDIDO_WEB(DIRECCION_WEB_ID,PRECIO,FECHA,COD_ENTREGA,USUARIO_WEB_ID,PEDIDO_WEB_ESTATUS_ID) VALUES (:DIRECCION_WEB_ID,:PRECIO,:FECHA,:COD_ENTREGA,:USUARIO_WEB_ID,1)';
            $st = $this->db->prepare($sql);
            $precio = $this->getPrecio($id_user);
            $precio = $precio[0]['SUBTOTAL'] + 50;
            $st->bindParam(':DIRECCION_WEB_ID', $id_direccion, PDO::PARAM_STR);
            $st->bindParam(':PRECIO', $precio, PDO::PARAM_STR);
            $fecha = date('Y-m-d');
            $st->bindParam(':FECHA', $fecha, PDO::PARAM_STR);
            $cod = $this->generarCod();
            $st->bindParam(':COD_ENTREGA', $cod, PDO::PARAM_STR);
            $st->bindParam(':USUARIO_WEB_ID', $id_user, PDO::PARAM_INT);
            $st->execute();
            $rc = $st->rowCount();
            $rc = array($rc);
            $rc['COD'] = $cod;
            $this->db->commit();
        } catch (PDOException $E) {
            $this->db->rollBack();
        }
        return $rc;
    }

    public function enviar_correo($destinatario){
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
            $mail->Subject = 'PEDIDO REALIZADO';
            $msg = "
            Estimado Usuario <br>
            Usted ha realizado una compra en nuestra tienda MAXIX SUPERMERCADO
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
    public function pago_detalle($id_user, $cod)
    {
        try {
            $this->db();
            $this->db->beginTransaction();
            $rc = 0;
            $sql = "SELECT PEDIDO_WEB_ID FROM PEDIDO_WEB WHERE COD_ENTREGA = :COD_ENTREGA";
            $st = $this->db->prepare($sql);
            $st->bindParam(':COD_ENTREGA', $cod, PDO::PARAM_STR);
            $st->execute();
            $id_pago = $st->fetchAll(PDO::FETCH_ASSOC);
            $id_pago = $id_pago[0]['PEDIDO_WEB_ID'];
            $lista_articulos = $this->getArticulos($id_user);
            foreach ($lista_articulos as $key => $articulo) {
                $articulo_id = $articulo['ARTICULO_ID'];
                $cantidad = $articulo['CANTIDAD'];
                $sql = 'INSERT INTO PEDIDO_DETALLE_WEB(PEDIDO_WEB_ID,ARTICULO_ID,CANTIDAD) VALUES (:PEDIDO_WEB_ID,:ARTICULO_ID,:CANTIDAD)';
                $st = $this->db->prepare($sql);
                $st->bindParam(':PEDIDO_WEB_ID', $id_pago, PDO::PARAM_INT);
                $st->bindParam(':ARTICULO_ID', $articulo_id, PDO::PARAM_INT);
                $st->bindParam(':CANTIDAD', $cantidad, PDO::PARAM_INT);
                $st->execute();
                $rc = $st->rowCount();
                if ($rc == 0) {
                    return $rc;
                }
            }
            $this->db->commit();
        } catch (PDOException $E) {
            $this->db->rollBack();
        }
        return $rc;
    }

    public function getArticulos($id_user)
    {
        $this->db();
        $sql = 'SELECT ARTICULO_ID,CANTIDAD from CARRITO_WEB cw where USUARIO_WEB_ID= :ID';
        $st = $this->db->prepare($sql);
        $st->bindParam(':ID', $id_user, PDO::PARAM_STR);
        $st->execute();
        $data = $st->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function limpiarCarrito($id_user)
    {
        $this->db();
        $sql = "DELETE FROM CARRITO_WEB WHERE USUARIO_WEB_ID= :USUARIO_WEB_ID";
        $st = $this->db->prepare($sql);
        $st->bindParam(':USUARIO_WEB_ID', $id_user, PDO::PARAM_INT);
        $st->execute();
        $rc = $st->rowCount();
        return $rc;
    }

    public function generarCod()
    {
        $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $codigo = '';
        for ($i = 0; $i < 5; $i++) {
            $codigo .= $caracteres[rand(0, strlen($caracteres) - 1)];
        }
        $codigo = strtoupper($codigo);
        return $codigo;
    }

    public function getPrecio($id_user)
    {
        $this->db();
        $sql = "SELECT SUM((select max(precio)*C.CANTIDAD from PRECIOS_ARTICULOS p1 join articulos a1 on p1.ARTICULO_ID=a1.ARTICULO_ID JOIN CARRITO_WEB c1 ON a1.ARTICULO_ID = c1.ARTICULO_ID where a1.ARTICULO_ID=a.ARTICULO_ID)) AS SUBTOTAL FROM CARRITO_WEB c JOIN ARTICULOS a ON  c.ARTICULO_ID=a.ARTICULO_ID WHERE c.USUARIO_WEB_ID = :id_user";
        $st = $this->db->prepare($sql);
        $st->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $st->execute();
        $data = $st->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

}
$pagos = new Pago;
?>
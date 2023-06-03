<?php
require_once(__DIR__ . "/sistema.php");
class Pedido extends Sistema
{
    public function get($id = null)
    {
        $this->db();
        if (is_null($id)) {
            $sql = "SELECT p.PEDIDO_WEB_ID,uw.CORREO, p.FECHA,p.PRECIO FROM PEDIDO_WEB p JOIN USUARIO_WEB UW on p.USUARIO_WEB_ID = UW.USUARIO_WEB_ID ORDER BY 1";
            $st = $this->db->prepare($sql);
            $st->execute();
            $data = $st->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $sql = "SELECT dw.*,col.nombre as COLONIA ,col.COD_POSTAL,ciu.nombre as CIUDAD,u.nombre,u.apellido,u.correo FROM USUARIO_WEB u JOIN DIRECCION_WEB DW on u.USUARIO_WEB_ID = DW.USUARIO_WEB_ID join COLONIA_WEB col on DW.COLONIA_WEB_ID=col.COLONIA_WEB_ID join CIUDADES ciu on col.CIUDAD_ID=ciu.CIUDAD_ID JOIN PEDIDO_WEB PW on DW.DIRECCION_WEB_ID = PW.DIRECCION_WEB_ID WHERE PW.PEDIDO_WEB_ID=:id";
            $st = $this->db->prepare($sql);
            $st->bindParam(':id', $id, PDO::PARAM_INT);
            $st->execute();
            $data = $st->fetchAll(PDO::FETCH_ASSOC);
        }
        return $data;
    }

    public function getArticulos($id)
    {
        $this->db();
        $sql = "SELECT a.ARTICULO_ID,ia.imagen,a.NOMBRE,(select max(precio) from PRECIOS_ARTICULOS p1 join articulos a1 on p1.ARTICULO_ID=a1.ARTICULO_ID where a1.ARTICULO_ID=a.ARTICULO_ID) AS PRECIO,PDW.CANTIDAD FROM PEDIDO_DETALLE_WEB PDW JOIN PEDIDO_WEB PW on PDW.PEDIDO_WEB_ID = PW.PEDIDO_WEB_ID JOIN ARTICULOS A on PDW.ARTICULO_ID = A.ARTICULO_ID LEFT JOIN IMAGENES_ARTICULOS IA on A.ARTICULO_ID = IA.ARTICULO_ID WHERE PW.PEDIDO_WEB_ID=:id";
        $st = $this->db->prepare($sql);
        $st->bindParam(':id', $id, PDO::PARAM_INT);
        $st->execute();
        $data = $st->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
}
$pedido = new Pedido;
?>
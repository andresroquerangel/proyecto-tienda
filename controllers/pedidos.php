<?php
require_once("sistema.php");
class Pedidos extends Sistema{
    public function get($id_user){
        $this -> db();
        $sql = "SELECT pd.*,pe.estatus FROM PEDIDO_WEB pd JOIN PEDIDO_WEB_ESTATUS pe ON pd.PEDIDO_WEB_ESTATUS_ID=pe.PEDIDO_WEB_ESTATUS_ID WHERE USUARIO_WEB_ID = :id_user";
        $st = $this -> db -> prepare($sql);
        $st -> bindParam(':id_user',$id_user,PDO::PARAM_INT);
        $st -> execute();
        $data = $st -> fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function get_detalle($id_user){
        $this -> db();
        $sql = "SELECT pd.*,a.nombre,ia.imagen FROM PEDIDO_DETALLE_WEB pd JOIN ARTICULOS a on pd.ARTICULO_ID = a.ARTICULO_ID LEFT JOIN imagenes_articulos ia ON a.articulo_id=ia.articulo_id LEFT JOIN PEDIDO_WEB p ON p.PEDIDO_WEB_ID=pd.PEDIDO_WEB_ID WHERE p.USUARIO_WEB_ID=:id_user";
        $st = $this -> db -> prepare($sql);
        $st -> bindParam(':id_user',$id_user,PDO::PARAM_INT);
        $st -> execute();
        $data = $st -> fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
}
$pedidos = new Pedidos();
?>
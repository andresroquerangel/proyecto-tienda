<?php
require_once('sistema.php');
class Index extends Sistema{
    public function obtenerGrafica(){
        $this -> db();
        $sql = "SELECT extract(month from fecha) as MES,count(*) AS CANTIDAD FROM PEDIDO_WEB where extract(year from fecha)=extract(year from current_date) group by 1 order by 1";
        $st = $this -> db -> prepare($sql);
        $st -> execute();
        $data = $st -> fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function obtenerEstadisticas(){
        $this -> db();
        $sql = "SELECT COUNT(*) AS VENTAS FROM PEDIDO_WEB";
        $st = $this -> db -> prepare($sql);
        $st -> execute();
        $data_aux = $st -> fetchAll(PDO::FETCH_ASSOC);
        $data = $data_aux[0];
        $sql = "SELECT COUNT(*) AS USUARIOS FROM USUARIO_WEB";
        $st = $this -> db -> prepare($sql);
        $st -> execute();
        $data_aux = $st -> fetchAll(PDO::FETCH_ASSOC);
        $data = array_merge($data,$data_aux[0]);
        $sql = "SELECT COUNT(*) AS PRODUCTOS FROM ARTICULOS";
        $st = $this -> db -> prepare($sql);
        $st -> execute();
        $data_aux = $st -> fetchAll(PDO::FETCH_ASSOC);
        $data = array_merge($data,$data_aux[0]);
        return $data;
    }

    public function obtenerArticulosVendidos(){
        $this -> db();
        $sql = "SELECT FIRST 10 a.ARTICULO_ID,ia.imagen,a.NOMBRE,(select max(precio) from PRECIOS_ARTICULOS p1 join articulos a1 on p1.ARTICULO_ID=a1.ARTICULO_ID where a1.ARTICULO_ID=a.ARTICULO_ID) AS PRECIO ,SUM(pwd.CANTIDAD) AS CANTIDAD FROM ARTICULOS a JOIN PEDIDO_DETALLE_WEB pwd ON a.ARTICULO_ID = pwd.ARTICULO_ID LEFT JOIN imagenes_articulos ia ON a.articulo_id=ia.articulo_id join precios_articulos p on a.ARTICULO_ID=p.ARTICULO_ID GROUP BY 1,2,3,4 ORDER BY 5 DESC";
        $st = $this -> db -> prepare($sql);
        $st -> execute();
        $data = $st -> fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
}
$index = new Index;
?>
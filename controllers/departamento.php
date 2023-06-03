<?php
require_once("sistema.php");
class Departamento extends Sistema
{
    public function getDepartamentos()
    {
        $this->db();
        $sql = "select gl.nombre as NOMBRE_GRUPO,la.nombre,la.linea_articulo_id from grupos_lineas gl join lineas_articulos la on la.grupo_linea_id=gl.grupo_linea_id order by la.nombre";
        $st = $this->db->prepare($sql);
        $st->execute();
        $data = $st->fetchAll(PDO::FETCH_GROUP);
        return $data;
    }
    public function getArticulos($id = null)
    {
        $this->db();
        $sql = "select a.articulo_id, a.nombre,(select max(precio) from PRECIOS_ARTICULOS p1 join articulos a1 on p1.ARTICULO_ID=a1.ARTICULO_ID where a1.ARTICULO_ID=a.ARTICULO_ID) as PRECIO,ia.imagen from ARTICULOS a left join IMAGENES_ARTICULOS ia on a.ARTICULO_ID=ia.ARTICULO_ID join precios_articulos p on a.ARTICULO_ID=p.ARTICULO_ID join LINEAS_ARTICULOS la on a.LINEA_ARTICULO_ID=la.LINEA_ARTICULO_ID where la.nombre= :id and a.ESTATUS='A' order by a.nombre";
        $st = $this->db->prepare($sql);
        $st->bindParam(':id', $id, PDO::PARAM_STR);
        $st->execute();
        $data = $st->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
}
$departamentos = new Departamento();
?>
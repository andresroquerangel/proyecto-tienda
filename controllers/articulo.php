<?php
require_once("sistema.php");
class Articulo extends Sistema
{
    public function get($id = null)
    {
        $this->db();
        if (!is_null($id)) {
            $sql = "select a.articulo_id,a.nombre,(select max(precio) from PRECIOS_ARTICULOS p1 join articulos a1 on p1.ARTICULO_ID=a1.ARTICULO_ID where a1.ARTICULO_ID=a.ARTICULO_ID) as precio,
            ia.imagen from ARTICULOS a left join imagenes_articulos ia on a.articulo_id=ia.articulo_id join precios_articulos p on a.ARTICULO_ID=p.ARTICULO_ID where a.articulo_id= :id";
            $st = $this->db->prepare($sql);
            $st->bindParam(':id', $id, PDO::PARAM_INT);
            $st->execute();
            $data = $st->fetchAll(PDO::FETCH_ASSOC);
        }
        return $data;
    }

    public function getTen($skip)
    {
        $this->db();
        $sql = "select FIRST 6 SKIP :skip a.articulo_id,a.nombre,(select max(precio) from PRECIOS_ARTICULOS p1 join articulos a1 on p1.ARTICULO_ID=a1.ARTICULO_ID where a1.ARTICULO_ID=a.ARTICULO_ID) as precio,
            ia.imagen from ARTICULOS a left join imagenes_articulos ia on a.articulo_id=ia.articulo_id join precios_articulos p on a.ARTICULO_ID=p.ARTICULO_ID";
        $st = $this->db->prepare($sql);
        $st->bindParam(':skip', $skip, PDO::PARAM_INT);
        $st->execute();
        $data = $st->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
}
$articulos = new Articulo();
?>
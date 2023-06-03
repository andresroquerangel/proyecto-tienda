<?php
require_once('sistema.php');
class Carrito extends Sistema
{
    public function get($id_user)
    {
        $this->db();
        $sql = 'SELECT cw.*,a.articulo_id, a.nombre,(select max(precio) from PRECIOS_ARTICULOS p1 join articulos a1 on p1.ARTICULO_ID=a1.ARTICULO_ID where a1.ARTICULO_ID=a.ARTICULO_ID) as PRECIO,ia.imagen from ARTICULOS a left join imagenes_articulos ia on a.articulo_id=ia.articulo_id join precios_articulos p on a.ARTICULO_ID=p.ARTICULO_ID join CARRITO_WEB cw on cw.ARTICULO_ID=a.ARTICULO_ID where USUARIO_WEB_ID= :ID';
        $st = $this->db->prepare($sql);
        $st->bindParam(':ID', $id_user, PDO::PARAM_STR);
        $st->execute();
        $data = $st->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function cantidad($id_user)
    {
        $this->db();
        $sql = 'SELECT SUM(CANTIDAD) FROM CARRITO_WEB WHERE USUARIO_WEB_ID = :id_user';
        $st = $this->db->prepare($sql);
        $st->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $st->execute();
        $data = $st->fetchAll(PDO::FETCH_ASSOC);
        return $data;
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

    public function agregar($id_user, $id_articulo, $cantidad)
    {
        try {
            $this->db();
            $this->db->beginTransaction();
            $sql = 'INSERT INTO CARRITO_WEB(USUARIO_WEB_ID, ARTICULO_ID, CANTIDAD) VALUES (:id_user,:id_articulo,:cantidad)';
            $st = $this->db->prepare($sql);
            $st->bindParam(':id_user', $id_user, PDO::PARAM_INT);
            $st->bindParam(':id_articulo', $id_articulo, PDO::PARAM_INT);
            $st->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
            $st->execute();
            $rc = $st->rowCount();
            $this->db->commit();
        } catch (PDOException $E) {
            $this->db->rollBack();
        }
        return $rc;
    }

    public function borrar($id_articulo, $id_user, $id_carrito)
    {
        try {
            $this->db();
            $this->db->beginTransaction();
            $sql = 'DELETE FROM CARRITO_WEB WHERE ARTICULO_ID = :id_articulo AND USUARIO_WEB_ID = :id_user AND CARRITO_WEB_ID = :id_carrito';
            $st = $this->db->prepare($sql);
            $st->bindParam(':id_articulo', $id_articulo, PDO::PARAM_INT);
            $st->bindParam(':id_user', $id_user, PDO::PARAM_INT);
            $st->bindParam(':id_carrito', $id_carrito, PDO::PARAM_INT);
            $st->execute();
            $rc = $st->rowCount();
            $this->db->commit();
        } catch (PDOException $E) {
            $this->db->rollBack();
        }
        return $rc;
    }
}

$carritos = new Carrito();
?>
<?php
require_once(__DIR__ . '/sistema.php');
class Domicilio extends Sistema
{
    public function get($id)
    {
        $this->db();
        $sql = 'SELECT d.*,col.nombre as COLONIA ,col.COD_POSTAL,ciu.nombre as CIUDAD from USUARIO_WEB u join DIRECCION_WEB d on u.USUARIO_WEB_ID = d.USUARIO_WEB_ID join COLONIA_WEB col on d.COLONIA_WEB_ID=col.COLONIA_WEB_ID join CIUDADES ciu on col.CIUDAD_ID=ciu.CIUDAD_ID where u.USUARIO_WEB_ID = :id';
        $st = $this->db->prepare($sql);
        $st->bindParam(':id', $id, PDO::PARAM_INT);
        $st->execute();
        $data = $st->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function getDom($id_us, $id_dom)
    {
        $this->db();
        $sql = 'SELECT d.*,col.nombre as COLONIA ,col.COD_POSTAL,ciu.nombre as CIUDAD from USUARIO_WEB u join DIRECCION_WEB d on u.USUARIO_WEB_ID = d.USUARIO_WEB_ID join COLONIA_WEB col on d.COLONIA_WEB_ID=col.COLONIA_WEB_ID join CIUDADES ciu on col.CIUDAD_ID=ciu.CIUDAD_ID where u.USUARIO_WEB_ID = :id_us and d.DIRECCION_WEB_ID= :id_dom';
        $st = $this->db->prepare($sql);
        $st->bindParam(':id_us', $id_us, PDO::PARAM_INT);
        $st->bindParam(':id_dom', $id_dom, PDO::PARAM_INT);
        $st->execute();
        $data = $st->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function getCol($cod)
    {
        $this->db();
        $sql = 'SELECT CW.COLONIA_WEB_ID,CW.NOMBRE,C.NOMBRE as CIUDAD from COLONIA_WEB CW JOIN CIUDADES C ON CW.CIUDAD_ID=C.CIUDAD_ID where COD_POSTAL= :cod';
        $st = $this->db->prepare($sql);
        $st->bindParam(':cod', $cod, PDO::PARAM_STR);
        $st->execute();
        $data = $st->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function editar($data)
    {
        try {
            $this->db();
            $this->db->beginTransaction();
            $sql = 'UPDATE DIRECCION_WEB set ALIAS = :ALIAS, COLONIA_WEB_ID=(SELECT COLONIA_WEB_ID from COLONIA_WEB where NOMBRE = :NOMBRE), CALLE= :CALLE, NUM_INT= :NUM_INT, NUM_EXT= :NUM_EXT, ENTRE_CALLES= :ENTRE_CALLES, REFERENCIAS= :REFERENCIAS, TELEFONO= :TELEFONO WHERE DIRECCION_WEB_ID= :ID';
            $st = $this->db->prepare($sql);
            $st->bindParam(':ALIAS', $data['ALIAS'], PDO::PARAM_STR);
            $st->bindParam(':NOMBRE', $data['COLONIA'], PDO::PARAM_STR);
            $st->bindParam(':CALLE', $data['CALLE'], PDO::PARAM_STR);
            $st->bindParam(':NUM_INT', $data['NUM_INT'], PDO::PARAM_STR);
            $st->bindParam(':NUM_EXT', $data['NUM_EXT'], PDO::PARAM_STR);
            $st->bindParam(':ENTRE_CALLES', $data['ENTRE_CALLES'], PDO::PARAM_STR);
            $st->bindParam(':REFERENCIAS', $data['REFERENCIAS'], PDO::PARAM_STR);
            $st->bindParam(':TELEFONO', $data['TELEFONO'], PDO::PARAM_STR);
            $st->bindParam(':ID', $data['DIRECCION_WEB_ID'], PDO::PARAM_INT);
            $st->execute();
            $rc = $st->rowCount();
            $this->db->commit();
        } catch (PDOException $E) {
            $this->db->rollBack();
        }
        return $rc;
    }

    public function crear($data, $id_user)
    {
        try {
            $this->db();
            $this->db->beginTransaction();
            $sql = 'INSERT INTO DIRECCION_WEB(ALIAS,USUARIO_WEB_ID,COLONIA_WEB_ID,CALLE,NUM_INT,NUM_EXT,ENTRE_CALLES,REFERENCIAS,TELEFONO) VALUES (:ALIAS,:USUARIO_WEB_ID,(SELECT COLONIA_WEB_ID from COLONIA_WEB where NOMBRE = :NOMBRE),:CALLE,:NUM_INT,:NUM_EXT,:ENTRE_CALLES,:REFERENCIAS,:TELEFONO)';
            $st = $this->db->prepare($sql);
            $st->bindParam(':ALIAS', $data['ALIAS'], PDO::PARAM_STR);
            $st->bindParam(':USUARIO_WEB_ID', $id_user, PDO::PARAM_INT);
            $st->bindParam(':NOMBRE', $data['COLONIA'], PDO::PARAM_STR);
            $st->bindParam(':CALLE', $data['CALLE'], PDO::PARAM_STR);
            $st->bindParam(':NUM_INT', $data['NUM_INT'], PDO::PARAM_STR);
            $st->bindParam(':NUM_EXT', $data['NUM_EXT'], PDO::PARAM_STR);
            $st->bindParam(':ENTRE_CALLES', $data['ENTRE_CALLES'], PDO::PARAM_STR);
            $st->bindParam(':REFERENCIAS', $data['REFERENCIAS'], PDO::PARAM_STR);
            $st->bindParam(':TELEFONO', $data['TELEFONO'], PDO::PARAM_STR);
            $st->execute();
            $rc = $st->rowCount();
            $this->db->commit();
        } catch (PDOException $E) {
            $this->db->rollBack();
        }
        return $rc;
    }

    public function borrar($id, $id_usuario)
    {
        try {
            $this->db();
            $this->db->beginTransaction();
            $sql = 'DELETE from direccion_web where direccion_web_id = :id_direccion and usuario_web_id= :id_usuario';
            $st = $this->db->prepare($sql);
            $st->bindParam(':id_direccion', $id, PDO::PARAM_INT);
            $st->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $st->execute();
            $rc = $st->rowCount();
            $this->db->commit();
        } catch (PDOException $E) {
            $this->db->rollBack();
        }
        return $rc;
    }
}
$domicilios = new Domicilio();

if (isset($_POST['cod_postal']) and !empty($_POST['cod_postal'])) {
    $out = array_values($domicilios->getCol($_POST['cod_postal']));
    echo json_encode($out);
}

?>
<?php
require_once(__DIR__ . "/sistema.php");
class Privilegio extends Sistema
{
    public function get($id = null)
    {
        $this->db();
        if (is_null($id)) {
            $sql = "select * from PRIVILEGIO_WEB";
            $st = $this->db->prepare($sql);
            $st->execute();
            $data = $st->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $sql = "select * from PRIVILEGIO_WEB where PRIVILEGIO_WEB_ID = :id";
            $st = $this->db->prepare($sql);
            $st->bindParam(':id', $id, PDO::PARAM_INT);
            $st->execute();
            $data = $st->fetchAll(PDO::FETCH_ASSOC);
        }
        return $data;
    }
    public function new($data)
    {
        try {
            $this->db();
            $this->db->beginTransaction();
            $sql = "insert into PRIVILEGIO_WEB (privilegio) values (:privilegio)";
            $st = $this->db->prepare($sql);
            $st->bindParam(':privilegio', $data['PRIVILEGIO'], PDO::PARAM_STR);
            $st->execute();
            $rc = $st->rowCount();
            $this->db->commit();
        } catch (PDOException $E) {
            $this->db->rollBack();
        }
        return $rc;
    }
    public function edit($id, $data)
    {
        try {
            $this->db();
            $this->db->beginTransaction();
            $sql = "update PRIVILEGIO_WEB set privilegio = :privilegio where PRIVILEGIO_WEB_ID = :id";
            $st = $this->db->prepare($sql);
            $st->bindParam(':id', $id, PDO::PARAM_INT);
            $st->bindParam(':privilegio', $data['PRIVILEGIO'], PDO::PARAM_STR);
            $st->execute();
            $rc = $st->rowCount();
            $this->db->commit();
        } catch (PDOException $E) {
            $this->db->rollBack();
        }
        return $rc;
    }
    public function delete($id)
    {
        try {
            $this->db();
            $this->db->beginTransaction();
            $sql = "DELETE FROM ROL_PRIVILEGIO_WEB WHERE PRIVILEGIO_WEB_ID = :id";
            $st = $this->db->prepare($sql);
            $st->bindParam(':id', $id, PDO::PARAM_INT);
            $st->execute();
            $rc = $st->rowCount();
            $sql = "DELETE FROM PRIVILEGIO_WEB WHERE PRIVILEGIO_WEB_ID = :id";
            $st = $this->db->prepare($sql);
            $st->bindParam(':id', $id, PDO::PARAM_INT);
            $st->execute();
            $rc = $st->rowCount();
            $this->db->commit();
        } catch (PDOException $E) {
            $this->db->rollBack();
        }
        return $rc;
    }
    public function getOne($id)
    {

    }
}
$privilegio = new Privilegio;
?>
<?php
require_once(__DIR__ . "/sistema.php");
class Rol extends Sistema
{
    public function get($id = null)
    {
        $this->db();
        if (is_null($id)) {
            $sql = "select * from ROL_WEB";
            $st = $this->db->prepare($sql);
            $st->execute();
            $data = $st->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $sql = "select * from ROL_WEB where ROL_WEB_ID = :id";
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
            $sql = "insert into ROL_WEB (ROL) values (:rol)";
            $st = $this->db->prepare($sql);
            $st->bindParam(':rol', $data['ROL'], PDO::PARAM_STR);
            $st->execute();
            $rc = $st->rowCount();
            $rc = $this->AgregarPrivilegios($data);
            $this->db->commit();
        } catch (PDOException $E) {
            $this->db->rollBack();
        }
        return $rc;
    }

    public function AgregarPrivilegios($data)
    {
        $this->db();
        $this->db->beginTransaction();
        $rc = 1;
        $sql = "SELECT ROL_WEB_ID FROM ROL_WEB WHERE ROL= :ROL";
        $st = $this->db->prepare($sql);
        $st->bindParam(':ROL', $data['ROL'], PDO::PARAM_STR);
        $st->execute();
        $id = $st->fetchAll(PDO::FETCH_ASSOC);
        $id = $id[0]['ROL_WEB_ID'];
        if (isset($data['privilegios'])) {
            foreach ($data['privilegios'] as $key => $privilegios) {
                $sql = "insert into ROL_PRIVILEGIO_WEB (PRIVILEGIO_WEB_ID,ROL_WEB_ID) values (:id_privilegio,:id_rol)";
                $st = $this->db->prepare($sql);
                $st->bindParam(':id_privilegio', $privilegios, PDO::PARAM_INT);
                $st->bindParam(':id_rol', $id, PDO::PARAM_INT);
                $st->execute();
                $rc = $st->rowCount();
                if ($rc == 0) {
                    return $rc;
                }
            }
        }
        return $rc;
    }

    public function edit($id, $data)
    {
        try {
            $this->db();
            $this->db->beginTransaction();
            $sql = "update ROL_WEB set ROL=:rol where ROL_WEB_ID = :id_rol";
            $st = $this->db->prepare($sql);
            $st->bindParam(':rol', $data['ROL'], PDO::PARAM_STR);
            $st->bindParam(':id_rol', $id, PDO::PARAM_INT);
            $st->execute();
            $rc = $st->rowCount();
            //SE OBTIENEN LOS PRIVILEGIOS ACTUALES QUE TIENE EL ROL CON ID = :id
            $sql = "select PRIVILEGIO_WEB_ID from ROL_PRIVILEGIO_WEB where ROL_WEB_ID = :id";
            $st = $this->db->prepare($sql);
            $st->bindParam(':id', $id, PDO::PARAM_INT);
            $st->execute();
            $rp = $st->fetchAll(PDO::FETCH_GROUP);
            $rp = array_keys($rp);
            $nuevos = array_diff($data['privilegios'], $rp);
            $borrar = array_diff($rp, $data['privilegios']);
            if (!empty($nuevos)) {
                foreach ($nuevos as $key => $id_privilegio) {
                    $sql = "insert into ROL_PRIVILEGIO_WEB(PRIVILEGIO_WEB_ID,ROL_WEB_ID) values (:id_privilegio,:id_rol)";
                    $st = $this->db->prepare($sql);
                    $st->bindParam(':id_privilegio', $id_privilegio, PDO::PARAM_INT);
                    $st->bindParam(':id_rol', $id, PDO::PARAM_INT);
                    $st->execute();
                    $rc = $st->rowCount();
                    if ($rc == 0) {
                        return $rc;
                    }
                }
            }
            if (!empty($borrar)) {
                foreach ($borrar as $key => $id_privilegio) {
                    $sql = "delete from ROL_PRIVILEGIO_WEB where PRIVILEGIO_WEB_ID= :id_privilegio and ROL_WEB_ID= :id_rol";
                    $st = $this->db->prepare($sql);
                    $st->bindParam(':id_privilegio', $id_privilegio, PDO::PARAM_INT);
                    $st->bindParam(':id_rol', $id, PDO::PARAM_INT);
                    $st->execute();
                    $rc = $st->rowCount();
                    if ($rc == 0) {
                        return $rc;
                    }
                }
            }
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
            $sql = "delete from ROL_PRIVILEGIO_WEB where ROL_WEB_ID = :id";
            $st = $this->db->prepare($sql);
            $st->bindParam(':id', $id, PDO::PARAM_INT);
            $st->execute();
            $rc = $st->rowCount();
            if ($rc == 0) {
                return $rc;
            }
            $sql = "delete from ROL_WEB where ROL_WEB_ID = :id";
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
    public function getPrivilegiosRol($id_rol = null)
    {
        if (is_null($id_rol)) {
            $sql = "select rp.ROL_WEB_ID,p.* from PRIVILEGIO_WEB p join ROL_PRIVILEGIO_WEB rp on p.PRIVILEGIO_WEB_ID=rp.PRIVILEGIO_WEB_ID";
            $st = $this->db->prepare($sql);
        } else {
            $sql = "select rp.ROL_WEB_ID,p.* from PRIVILEGIO_WEB p join ROL_PRIVILEGIO_WEB rp on p.PRIVILEGIO_WEB_ID=rp.PRIVILEGIO_WEB_ID where rp.ROL_WEB_ID= :id_rol";
            $st = $this->db->prepare($sql);
            $st->bindParam(':id_rol', $id_rol, PDO::PARAM_INT);
        }
        $st->execute();
        $data = $st->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function getAllPrivilegios()
    {
        $this->db();
        $sql = "select * from PRIVILEGIO_WEB";
        $st = $this->db->prepare($sql);
        $st->execute();
        $data = $st->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
}
$rol = new Rol;
?>
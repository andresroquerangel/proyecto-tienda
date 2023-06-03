<?php
require_once(__DIR__ . "/sistema.php");
class Usuario extends Sistema
{
    public function get($id = null)
    {
        $this->db();
        if (is_null($id)) {
            $sql = "select * from USUARIO_WEB";
            $st = $this->db->prepare($sql);
            $st->execute();
            $data = $st->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $sql = "select * from USUARIO_WEB where USUARIO_WEB_ID = :id";
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
            $sql = "insert into USUARIO_WEB (NOMBRE,APELLIDO,CORREO,CONTRASENA) values (:nombre,:apellido,:correo,:contrasena)";
            $st = $this->db->prepare($sql);
            $st->bindParam(':nombre', $data['NOMBRE'], PDO::PARAM_STR);
            $st->bindParam(':apellido', $data['APELLIDO'], PDO::PARAM_STR);
            $st->bindParam(':correo', $data['CORREO'], PDO::PARAM_STR);
            $contrasena = md5($data['CONTRASENA']);
            $st->bindParam(':contrasena', $contrasena, PDO::PARAM_STR);
            $st->execute();
            $rc = $st->rowCount();
            $rc = $this->agregarRoles($data);
            $this->db->commit();
        } catch (PDOException $E) {
            $this->db->rollBack();
        }
        return $rc;
    }

    public function agregarRoles($data)
    {
        $this->db();
        $rc = 1;
        $sql = "SELECT USUARIO_WEB_ID FROM USUARIO_WEB WHERE CORREO= :CORREO";
        $st = $this->db->prepare($sql);
        $st->bindParam(':CORREO', $data['CORREO'], PDO::PARAM_STR);
        $st->execute();
        $id = $st->fetchAll(PDO::FETCH_ASSOC);
        $id = $id[0]['USUARIO_WEB_ID'];
        if (isset($data['roles'])) {
            foreach ($data['roles'] as $key => $roles) {
                $sql = "insert into USUARIO_ROL_WEB (USUARIO_WEB_ID,ROL_WEB_ID) values (:id_usuario,:id_rol)";
                $st = $this->db->prepare($sql);
                $st->bindParam(':id_usuario', $id, PDO::PARAM_INT);
                $st->bindParam(':id_rol', $roles, PDO::PARAM_INT);
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
            $sql = "update USUARIO_WEB set CORREO=:correo, CONTRASENA=:contrasena where USUARIO_WEB_ID = :id_usuario";
            $st = $this->db->prepare($sql);
            $st->bindParam(':correo', $data['CORREO'], PDO::PARAM_STR);
            $contrasena = md5($data['CONTRASENA']);
            $st->bindParam(':contrasena', $contrasena, PDO::PARAM_STR);
            $st->bindParam(':id_usuario', $id, PDO::PARAM_INT);
            $st->execute();
            $rc = $st->rowCount();
            //SE OBTIENEN LOS ROLES ACTUALES QUE TIENE EL USUARIO CON ID = :id
            $sql = "select ROL_WEB_ID from USUARIO_ROL_WEB where USUARIO_WEB_ID = :id";
            $st = $this->db->prepare($sql);
            $st->bindParam(':id', $id, PDO::PARAM_INT);
            $st->execute();
            $rp = $st->fetchAll(PDO::FETCH_GROUP);
            $rp = array_keys($rp);
            $nuevos = array_diff($data['roles'], $rp);
            $borrar = array_diff($rp, $data['roles']);
            if (!empty($nuevos)) {
                foreach ($nuevos as $key => $id_rol) {
                    $sql = "insert into USUARIO_ROL_WEB(USUARIO_WEB_ID,ROL_WEB_ID) values (:id_usuario,:id_rol)";
                    $st = $this->db->prepare($sql);
                    $st->bindParam(':id_usuario', $id, PDO::PARAM_INT);
                    $st->bindParam(':id_rol', $id_rol, PDO::PARAM_INT);
                    $st->execute();
                    $rc = $st->rowCount();
                    if ($rc == 0) {
                        return $rc;
                    }
                }
            }
            if (!empty($borrar)) {
                foreach ($borrar as $key => $id_rol) {
                    $sql = "delete from USUARIO_ROL_WEB where ROL_WEB_ID= :id_rol and USUARIO_WEB_ID= :id_usuario";
                    $st = $this->db->prepare($sql);
                    $st->bindParam(':id_rol', $id_rol, PDO::PARAM_INT);
                    $st->bindParam(':id_usuario', $id, PDO::PARAM_INT);
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
            $sql = "delete from USUARIO_ROL_WEB where USUARIO_WEB_ID = :id";
            $st = $this->db->prepare($sql);
            $st->bindParam(':id', $id, PDO::PARAM_INT);
            $st->execute();
            $rc = $st->rowCount();
            if ($rc == 0) {
                return $rc;
            }
            $sql = "delete from USUARIO_WEB where USUARIO_WEB_ID = :id";
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
    public function getRolesUsuarios($id_usuario = null)
    {
        if (is_null($id_usuario)) {
            $sql = "select ur.USUARIO_WEB_ID,r.* from ROL_WEB r join USUARIO_ROL_WEB ur on r.ROL_WEB_ID=ur.ROL_WEB_ID";
            $st = $this->db->prepare($sql);
        } else {
            $sql = "select ur.USUARIO_WEB_ID,r.* from ROL_WEB r join USUARIO_ROL_WEB ur on r.ROL_WEB_ID=ur.ROL_WEB_ID where ur.USUARIO_WEB_ID= :id_usuario";
            $st = $this->db->prepare($sql);
            $st->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        }
        $st->execute();
        $data = $st->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function getAllRoles()
    {
        $this->db();
        $sql = "select * from ROL_WEB";
        $st = $this->db->prepare($sql);
        $st->execute();
        $data = $st->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
}
$usuario = new Usuario;
?>
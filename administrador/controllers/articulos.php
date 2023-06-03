<?php
require_once(__DIR__ . "/sistema.php");
class Articulo extends Sistema
{
    public function get($id = null, $rango = null)
    {
        $this->db();
        if (is_null($id)) {
            if (is_null($rango)) {
                $sql = "SELECT a.ARTICULO_ID,ia.imagen,a.NOMBRE,la.NOMBRE as CATEGORIA,(select max(precio) from PRECIOS_ARTICULOS p1 join articulos a1 on p1.ARTICULO_ID=a1.ARTICULO_ID where a1.ARTICULO_ID=a.ARTICULO_ID) AS PRECIO FROM ARTICULOS A LEFT JOIN IMAGENES_ARTICULOS IA on A.ARTICULO_ID = IA.ARTICULO_ID LEFT JOIN LINEAS_ARTICULOS la ON A.LINEA_ARTICULO_ID=la.LINEA_ARTICULO_ID ORDER BY A.FECHA_HORA_ULT_MODIF DESC";
                $st = $this->db->prepare($sql);
            } else {
                $sql = "SELECT FIRST 20 SKIP :rango a.ARTICULO_ID,ia.imagen,a.NOMBRE,la.NOMBRE as CATEGORIA,(select max(precio) from PRECIOS_ARTICULOS p1 join articulos a1 on p1.ARTICULO_ID=a1.ARTICULO_ID where a1.ARTICULO_ID=a.ARTICULO_ID) AS PRECIO FROM ARTICULOS A LEFT JOIN IMAGENES_ARTICULOS IA on A.ARTICULO_ID = IA.ARTICULO_ID LEFT JOIN LINEAS_ARTICULOS la ON A.LINEA_ARTICULO_ID=la.LINEA_ARTICULO_ID ORDER BY A.FECHA_HORA_ULT_MODIF DESC";
                $st = $this->db->prepare($sql);
                $st->bindParam(':rango', $rango, PDO::PARAM_INT);
            }
            $st->execute();
            $data = $st->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $sql = "SELECT a.ARTICULO_ID,ia.imagen,a.NOMBRE,la.LINEA_ARTICULO_ID,la.NOMBRE as CATEGORIA,(select max(precio) from PRECIOS_ARTICULOS p1 join articulos a1 on p1.ARTICULO_ID=a1.ARTICULO_ID where a1.ARTICULO_ID=a.ARTICULO_ID) AS PRECIO FROM ARTICULOS A LEFT JOIN IMAGENES_ARTICULOS IA on A.ARTICULO_ID = IA.ARTICULO_ID JOIN LINEAS_ARTICULOS la ON A.LINEA_ARTICULO_ID=la.LINEA_ARTICULO_ID WHERE A.ARTICULO_ID=:id";
            $st = $this->db->prepare($sql);
            $st->bindParam(':id', $id, PDO::PARAM_INT);
            $st->execute();
            $data = $st->fetchAll(PDO::FETCH_ASSOC);
        }
        return $data;
    }

    public function arreglarJson($data)
    {
        for ($n = 0; $n < sizeof($data); $n++) {
            $data[$n]['ARTICULO_ID'] = utf8_encode($data[$n]['ARTICULO_ID']);
            $data[$n]['IMAGEN'] = base64_encode($data[$n]['IMAGEN']);
            $data[$n]['NOMBRE'] = utf8_encode($data[$n]['NOMBRE']);
            $data[$n]['CATEGORIA'] = utf8_encode($data[$n]['CATEGORIA']);
            $data[$n]['PRECIO'] = utf8_encode($data[$n]['PRECIO']);
        }
        return $data;
    }

    public function contar()
    {
        $this->db();
        $sql = "SELECT COUNT(*) FROM ARTICULOS";
        $st = $this->db->prepare($sql);
        $st->execute();
        $data = $st->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function getCategoria()
    {
        $this->db();
        $sql = "SELECT LINEA_ARTICULO_ID,NOMBRE FROM LINEAS_ARTICULOS ORDER BY 2";
        $st = $this->db->prepare($sql);
        $st->execute();
        $data = $st->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function agregar($data)
    {
        try {
            $this->db();
            $this->db->beginTransaction();
            $id_a = $this->obtenerUltimoArticulo();
            $id_a = $id_a[0]['ARTICULO_ID'];
            $sql = "INSERT INTO ARTICULOS(ARTICULO_ID,NOMBRE,LINEA_ARTICULO_ID) VALUES (:id,:nombre,:linea)";
            $st = $this->db->prepare($sql);
            $st->bindParam(':id', $id_a, PDO::PARAM_INT);
            $st->bindParam(':nombre', $data['NOMBRE'], PDO::PARAM_STR);
            $st->bindParam(':linea', $data['LINEA'], PDO::PARAM_INT);
            $st->execute();
            $rc = $st->rowCount();
            if ($rc == 1) {
                $id_p = $this->obtenerUltimoPrecio();
                $id_p = $id_p[0]['PRECIO_ARTICULO_ID'];
                $sql = "INSERT INTO PRECIOS_ARTICULOS(PRECIO_ARTICULO_ID, ARTICULO_ID, PRECIO_EMPRESA_ID, PRECIO, MONEDA_ID) VALUES(:id_p,:id_a,42,:precio,1)";
                $st = $this->db->prepare($sql);
                $st->bindParam(':id_a', $id_a, PDO::PARAM_INT);
                $st->bindParam(':id_p', $id_p, PDO::PARAM_INT);
                $st->bindParam(':precio', $data['PRECIO'], PDO::PARAM_STR);
                $st->execute();
                $rc = $st->rowCount();
                if ($rc == 1) {
                    if (isset($_FILES['imagen'])) {
                        if ($_FILES['imagen']['error'] == 0) {
                            if ($this->comprobarFormato()) {
                                $id_m = $this->obtenerUltimoImagen();
                                $id_m = $id_m[0]['IMAGEN_ARTICULO_ID'];
                                $sql = "INSERT INTO IMAGENES_ARTICULOS(IMAGEN_ARTICULO_ID, ARTICULO_ID, ROL_IMAGEN_ART_ID, IMAGEN)  VALUES (:id_m,:id_a,64,:imagen)";
                                $st = $this->db->prepare($sql);
                                $st->bindParam(':id_m', $id_m, PDO::PARAM_INT);
                                $st->bindParam(':id_a', $id_a, PDO::PARAM_INT);
                                $imagen = file_get_contents($_FILES['imagen']['tmp_name']);
                                $st->bindParam(':imagen', $imagen, PDO::PARAM_STR);
                                $st->execute();
                                $rc = $st->rowCount();
                            }
                        }
                    }
                }
            }
            $this->db->commit();
        } catch (PDOException $E) {
            $this->db->rollBack();
            $rc = 0;
        }
        return $rc;
    }

    public function editar($data, $id)
    {
        try {
            $this->db();
            $this->db->beginTransaction();
            $sql = "UPDATE ARTICULOS SET NOMBRE= :nombre, LINEA_ARTICULO_ID= :linea WHERE ARTICULO_ID= :id";
            $st = $this->db->prepare($sql);
            $st->bindParam(':nombre', $data['NOMBRE'], PDO::PARAM_INT);
            $st->bindParam(':linea', $data['LINEA'], PDO::PARAM_INT);
            $st->bindParam(':id', $id, PDO::PARAM_INT);
            $st->execute();
            $rc = $st->rowCount();

            if ($rc == 0) {
                return 0;
            }

            $sql = "UPDATE PRECIOS_ARTICULOS SET PRECIO=:precio WHERE ARTICULO_ID = :id";
            $st = $this->db->prepare($sql);
            $st->bindParam(':precio', $data['PRECIO'], PDO::PARAM_INT);
            $st->bindParam(':id', $id, PDO::PARAM_INT);
            $st->execute();
            $rc = $st->rowCount();

            if ($rc == 0) {
                return 0;
            }
            if ($_FILES['imagen']['error'] == 0) {
                if ($this->comprobarFormato()) {
                    if ($this->existeImagen($id) == 1) {
                        $sql = "UPDATE IMAGENES_ARTICULOS SET IMAGEN=:imagen WHERE ARTICULO_ID = :id";
                        $st = $this->db->prepare($sql);
                        $imagen = file_get_contents($_FILES['imagen']['tmp_name']);
                        $st->bindParam(':imagen', $imagen, PDO::PARAM_STR);
                        $st->bindParam(':id', $id, PDO::PARAM_INT);
                        $st->execute();
                        $rc = $st->rowCount();
                    } else {
                        $id_m = $this->obtenerUltimoImagen();
                        $id_m = $id_m[0]['IMAGEN_ARTICULO_ID'];
                        $sql = "INSERT INTO IMAGENES_ARTICULOS(IMAGEN_ARTICULO_ID, ARTICULO_ID, ROL_IMAGEN_ART_ID, IMAGEN)  VALUES (:id_m,:id_a,64,:imagen)";
                        $st = $this->db->prepare($sql);
                        $st->bindParam(':id_m', $id_m, PDO::PARAM_INT);
                        $st->bindParam(':id_a', $id, PDO::PARAM_INT);
                        $imagen = file_get_contents($_FILES['imagen']['tmp_name']);
                        $st->bindParam(':imagen', $imagen, PDO::PARAM_STR);
                        $st->execute();
                        $rc = $st->rowCount();
                    }
                }
            }
            $this->db->commit();
        } catch (PDOException $E) {
            $this->db->rollBack();
        }
        return $rc;
    }

    public function eliminar($id)
    {
        try {
            $this->db();
            $this->db->beginTransaction();
            $sql = "DELETE FROM ARTICULOS WHERE ARTICULO_ID = :id";
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

    public function existeImagen($id)
    {
        $this->db();
        $sql = "SELECT COUNT(*) FROM IMAGENES_ARTICULOS WHERE ARTICULO_ID= :id";
        $st = $this->db->prepare($sql);
        $st->bindParam(':id', $id, PDO::PARAM_INT);
        $st->execute();
        $rc = $st->fetchAll(PDO::FETCH_ASSOC);
        $rc = $rc[0]['COUNT'];
        return $rc;
    }

    public function comprobarFormato()
    {
        $imagenes = array("image/jpeg", "image/gif", "image/png");
        if (in_array($_FILES['imagen']['type'], $imagenes)) {
            return true;
        }
        return false;
    }

    public function obtenerUltimoArticulo()
    {
        $this->db();
        $sql = "SELECT FIRST 1 ARTICULO_ID+1 AS ARTICULO_ID FROM ARTICULOS ORDER BY 1 DESC";
        $st = $this->db->prepare($sql);
        $st->execute();
        $id = $st->fetchAll(PDO::FETCH_ASSOC);
        return $id;
    }

    public function obtenerUltimoPrecio()
    {
        $this->db();
        $sql = "SELECT FIRST 1 PRECIO_ARTICULO_ID+1 AS PRECIO_ARTICULO_ID FROM PRECIOS_ARTICULOS ORDER BY 1 DESC";
        $st = $this->db->prepare($sql);
        $st->execute();
        $id = $st->fetchAll(PDO::FETCH_ASSOC);
        return $id;
    }

    public function obtenerUltimoImagen()
    {
        $this->db();
        $sql = "SELECT FIRST 1 IMAGEN_ARTICULO_ID+1 AS IMAGEN_ARTICULO_ID FROM IMAGENES_ARTICULOS ORDER BY 1 DESC";
        $st = $this->db->prepare($sql);
        $st->execute();
        $id = $st->fetchAll(PDO::FETCH_ASSOC);
        return $id;
    }

    public function getPost($id = null, $rango = null)
    {
        $curl = curl_init();
        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => 'http://localhost/tienda/administrador/ws/articulos.php' . (!is_null($id) ? '?id=' . $id : '') . (!is_null($rango) ? '?page=' . $rango : ''),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'Cookie: PHPSESSID=1cdb48rgshuslnqnhe1ik0o2rj'
                ),
            )
        );

        $response = curl_exec($curl);
        curl_close($curl);
        $data = json_decode($response, true);
        return $data;
    }

    public function newPost($data)
    {
        $curl = curl_init();
        if ($_FILES['imagen']['error'] == 0) {
            // Ruta de la imagen en $_FILES
            $imagenPath = $_FILES['imagen']['tmp_name'];

            // Crear objeto cURL del archivo
            $imagenCURL = curl_file_create($imagenPath, $_FILES['imagen']['type'], $_FILES['imagen']['name']);
            curl_setopt_array(
                $curl,
                array(
                    CURLOPT_URL => 'http://localhost/tienda/administrador/ws/articulos.php',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => array('data[NOMBRE]' => $data['NOMBRE'], 'data[PRECIO]' => $data['PRECIO'], 'data[LINEA]' => $data['LINEA'], 'imagen' => $imagenCURL),
                    CURLOPT_HTTPHEADER => array(
                        'Cookie: PHPSESSID=79p2tn86mkakb5r1j7uqk6hn3g'
                    ),
                )
            );
        } else {
            $_FILES = array();
            curl_setopt_array(
                $curl,
                array(
                    CURLOPT_URL => 'http://localhost/tienda/administrador/ws/articulos.php',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => array('data[NOMBRE]' => $data['NOMBRE'], 'data[PRECIO]' => $data['PRECIO'], 'data[LINEA]' => $data['LINEA'], 'imagen' => null),
                    CURLOPT_HTTPHEADER => array(
                        'Cookie: PHPSESSID=820eoibkq82d03fg19oue08auc'
                    ),
                )
            );
        }

        $response = curl_exec($curl);

        curl_close($curl);
        $cantidad = json_decode($response, true);
        return $cantidad;
    }

    public function deletePost($id)
    {
        $curl = curl_init();
        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => 'http://localhost/tienda/administrador/ws/articulos.php?id=' . $id,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'DELETE',
                CURLOPT_HTTPHEADER => array(
                    'Cookie: PHPSESSID=79p2tn86mkakb5r1j7uqk6hn3g'
                ),
            )
        );

        $response = curl_exec($curl);

        curl_close($curl);
        $cantidad = json_decode($response, true);
        return $cantidad;
    }

}
$articulo = new Articulo;
?>
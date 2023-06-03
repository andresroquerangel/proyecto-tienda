<?php
//DATABASE
/*define("DBDRIVER", "firebird");
define("DBHOST", "127.0.0.1");
define("DBNAME", "C:\Users\andre\OneDrive\Escritorio\ABARROTERA MAXIX.fdb");
define("DBUSER", "sysdba");
define("DBPASS", "masterkey");
define("DBPORT", "3050");
require_once('controllers/sistema.php');
//$dsn = DBDRIVER . ':host=' . DBHOST . ';dbname=' . DBNAME . ';port=' . DBPORT;
$dsn = DBDRIVER . ':dbname=' . DBHOST . '/' . DBPORT . ':' . DBNAME;
try {
    $db = new PDO($dsn, DBUSER, DBPASS);
    $sql = "select imagen from imagenes_articulos where articulo_id=270503";
    $st = $db->prepare($sql);
    $st->execute();
    $data = $st->fetchAll(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    echo 'Hubo un error ' . $e->getMessage() . "\n";
}
$sistema -> flash('danger','Hola');*/
include('views/header.php');
require_once('controllers/sistema.php');
?>

<div class="modal" tabindex="-1" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modal Title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Modal content goes here...</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<?php include('views/footer.php'); ?>
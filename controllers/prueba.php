<?php
include('views/header.php');
require_once('controllers/sistema.php');
$sistema -> flash('success','Hola');
include('views/footer.php');
?>
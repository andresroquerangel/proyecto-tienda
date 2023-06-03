<?php
require_once('controllers/index.php');
$index->validateRol('ADMINISTRADOR');
include_once('views/header.php');
$opcion= 'inicio';
include_once('views/menu_lateral.php');
$data = $index -> obtenerGrafica();
$data_p = $index -> obtenerEstadisticas();
$data_a = $index -> obtenerArticulosVendidos();
$meses = array('Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic');
include_once('views/index.php');
include_once('views/footer.php');
?>
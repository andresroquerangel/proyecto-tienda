<?php
require_once("../vendor/autoload.php");
include_once(__DIR__ . "/controllers/articulos.php");
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

$documento = new Spreadsheet();
$action = (isset($_GET['action'])) ? ($_GET['action']) : 'get';
$sistema -> db();
switch ($action) {
    case 'excel':
        $data = $articulo -> get();
        $documento
            ->getProperties()
            ->setCreator("MAXIX SUPERMERCADO")
            ->setLastModifiedBy('SYSDBA') // última vez modificado por
            ->setTitle('LISTA DE ARTICULOS')
            ->setSubject('ARTICULOS')
            ->setDescription('ESTE DOCUMENTO ES UN EXCEL CON LA LISTA DE ARTICULOS DE LA TIENDA MAXIX SUPERMERCADO')
            ->setKeywords('etiquetas o palabras clave separadas por espacios')
            ->setCategory('La categoría');

        $nombreDelDocumento = "LISTA ARTICULOS.xlsx";
        $hoja = $documento->getActiveSheet();
        $hoja->setTitle("LISTA ARTICULOS");
        $hoja->setCellValue("A1", "ID");
        $hoja->setCellValue("B1", "NOMBRE");
        $hoja->setCellValue("C1", "CATEGORIA");
        $hoja->setCellValue("D1", "PRECIO");
        $n = 2;
        foreach($data as $key => $articulo){
            $hoja -> setCellValue("A".$n,$articulo['ARTICULO_ID']);
            $hoja -> setCellValue("B".$n,utf8_encode($articulo['NOMBRE']));
            $hoja -> setCellValue("C".$n,utf8_encode($articulo['CATEGORIA']));
            $precio = '$' . substr($articulo['PRECIO'], 0, strlen($articulo['PRECIO']) - 4);
            $hoja -> setCellValue("D".$n,$precio);
            $n++;
        }
        /**
         * Los siguientes encabezados son necesarios para que
         * el navegador entienda que no le estamos mandando
         * simple HTML
         * Por cierto: no hagas ningún echo ni cosas de esas; es decir, no imprimas nada
         */

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $nombreDelDocumento . '"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($documento, 'Xlsx');
        $writer->save('php://output');
        break;
}
exit;
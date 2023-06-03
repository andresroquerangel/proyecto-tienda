<?php
include_once(__DIR__ . "/controllers/pedidos.php");
require_once("../vendor/autoload.php");
use Spipu\Html2Pdf\Html2Pdf;

$html2pdf = new Html2Pdf();
$action = (isset($_GET['action'])) ? ($_GET['action']) : 'get';
$id = (isset($_GET['id'])) ? ($_GET['id']) : 'get';
$sistema->db();
switch ($action) {
    case 'pedido':
        $data = $pedido->get($id);
        $data_a = $pedido->getArticulos($id);
        if(empty($data) || empty($data_a)){
            die();
        }
        $html = '<head>
        <meta charset="UTF-8">
        <link href="css/style.css" rel="stylesheet" type="text/css" media="screen"/>
      </head>
      <body>';
        $html .=
            '
        <table>
            <tr>
                <th>
                    <div class="row bar_imagen">
                        <img src="images/logo.jpg" />
                    </div>
                </th>
                <th style="width:185px"></th>
                <th>
                    <table style="text-align:center">
                        <tr>
                            <th><h2>DETALLE DE PEDIDO</h2></th>
                        </tr>
                        <tr>
                            <th>MAXIX TU SUPER EXPRES</th>
                        </tr>
                        <tr>
                            <th>Av.Brillante #311,Col. San Juanico</th>
                        </tr>
                    </table>
                </th>
                <th style="width:185px"></th>
            </tr>
        </table>
        ';
        $html .=
            '<div class="contenedor_formato">
            <div class="titulo">
                <h4>Datos cliente</h4>
            </div>   
            <div class="row">
                <p><b>Nombre: </b>'.$data[0]['NOMBRE'].' '.$data[0]['APELLIDO']. '</p>
            </div>
            <div class="row">
                <p><b>Correo electrónico: </b>'.$data[0]['CORREO']. '</p>
            </div>
            <div class="titulo" style="margin-top:10px">
                <h4>Dirección de envío</h4>
            </div>';
        $html.='
        <table class="tabla_domicilio">
            <tr>
                <th class="dos-columna izq">
                    <table>
                        <tr>
                            <th class="t_campo">Código postal</th>
                            <th class="v_campo">'.$data[0]['COD_POSTAL'].'</th>
                        </tr>
                    </table>
                </th>
                
                <th class="dos-columna der">
                    <table>
                        <tr>
                            <th class="t_campo">Colonia</th>
                            <th class="v_campo">'.$data[0]['COLONIA'].'</th>
                        </tr>
                    </table>
                </th>
            </tr>
        </table>

        <table class="tabla_domicilio">
        <tr>
                <th class="una-columna">
                    <table>
                        <tr>
                            <th class="t_campo">Ciudad</th>
                            <th class="v_campo">'.$data[0]['CIUDAD'].'</th>
                        </tr>
                    </table>
                </th>
            </tr>
        </table>

        <table class="tabla_domicilio">
        <tr>
                <th class="una-columna">
                    <table>
                        <tr>
                            <th class="t_campo">Calle</th>
                            <th class="v_campo">'.$data[0]['CALLE'].'</th>
                        </tr>
                    </table>
                </th>
            </tr>
        </table>
        
        <table class="tabla_domicilio">
            <tr>
                <th class="dos-columna izq">
                    <table>
                        <tr>
                            <th class="t_campo">Num. Int.</th>
                            <th class="v_campo">'.$data[0]['NUM_INT'].'</th>
                        </tr>
                    </table>
                </th>
                
                <th class="dos-columna der">
                    <table>
                        <tr>
                            <th class="t_campo">Num. Ext.</th>
                            <th class="v_campo">'.$data[0]['NUM_EXT'].'</th>
                        </tr>
                    </table>
                </th>
            </tr>
        </table>
        
        <table class="tabla_domicilio">
            <tr>
                <th class="dos-columna izq">
                    <table>
                        <tr>
                            <th class="t_campo">Entre calles</th>
                            <th class="v_campo">'.$data[0]['ENTRE_CALLES'].'</th>
                        </tr>
                    </table>
                </th>
                
                <th class="dos-columna der">
                    <table>
                        <tr>
                            <th class="t_campo">Referencias</th>
                            <th class="v_campo">'.$data[0]['REFERENCIAS'].'</th>
                        </tr>
                    </table>
                </th>
            </tr>
        </table>

        <table class="tabla_domicilio">
        <tr>
                <th class="una-columna">
                    <table>
                        <tr>
                            <th class="t_campo">Teléfono</th>
                            <th class="v_campo">'.$data[0]['TELEFONO'].'</th>
                        </tr>
                    </table>
                </th>
            </tr>
        </table>
        ';
        $html .='<div class="titulo" style="margin-top:10px">
                <h4>Lista de productos</h4>
            </div>
            <div class="tabla_tareas">
                <table>
                <tr>
                    <th style="width:15%">Cantidad</th>
                    <th style="width:55%">Descripción</th>
                    <th style="width:15%">Precio Unitario</th>
                    <th style="width:15%">Importe</th>
                </tr>';
        ?><?php
        $total = 0;
        foreach ($data_a as $key => $articulo):
            $importe = $articulo['CANTIDAD'] * $articulo['PRECIO'];
            $total += $importe;
            $html .= "<tr>
        <td>" . $articulo['CANTIDAD'] . "</td>" .
                "<td>" . $articulo['NOMBRE'] . "</td>" .
                "<td>" . '$' . substr($articulo['PRECIO'], 0, strlen($articulo['PRECIO']) - 4) . "</td>" .
                "<td>" . '$' . $importe . "</td>" .
                "</tr>";
        endforeach;
        $html .='
        <tr>
        <td></td>
        <td>Envío</td>
        <td></td>
        <td>$'.ENVIO.'</td>
        </tr>';
        $total+=ENVIO;
        $html .= '
        <tr>
        <td class="sin-formato"></td>
        <td class="sin-formato"></td>
        <th>Total</th>
        <td> $'. $total . '</td>
        </tr>
        ';
        $html .= '
                </table>
            </div>
        </div>';
        $html .= "</body>";
        break;
    default:
        $html = '<h1>Sin reporte</h1>No hay ningun reporte';
}
$html2pdf->writeHTML($html);
$html2pdf->output();
?>
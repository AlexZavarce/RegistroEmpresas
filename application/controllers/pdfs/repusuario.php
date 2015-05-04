<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Repusuario extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('pdfs/repusuario_model');
        $this->load->library('Pdf');
        $this->load->library(array('session'));
    }

    public function generarListadoUsuariosSinEmpresas() {
        $pdf = new Pdf('l', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetSubject('Tutorial TCPDF');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setFooterData($tc = array(0, 64, 0), $lc = array(0, 64, 128));
        // datos por defecto de cabecera, se pueden modificar en el archivo tcpdf_config.php de libraries/config
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetPageOrientation('l');
        // se pueden modificar en el archivo tcpdf_config.php de libraries/config
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        // se pueden modificar en el archivo tcpdf_config.php de libraries/config
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        // se pueden modificar en el archivo tcpdf_config.php de libraries/config
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //relación utilizada para ajustar la conversión de los píxeles
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        // establecer el modo de fuente por defecto
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', '', 9, '', true);
        $pdf->AddPage();
        $html = null;
        $nombre_archivo = null;
        // Establecemos el contenido para imprimir
        $resultado = $this->repusuario_model->getUsuarioSinEmpresa();
        if ($resultado) {
            $html = " ";
            $html .= "<style type=text/css>";
            $html .= "th{color: #fff; font-weight: bold; background-color: #AAC7E3; align=center}";
            $html .= "td{background-color: #fff; color: #222; align=center}";
            $html .= "</style>";
            $html .= "<h2>Listado de Usuarios Sin Registro de Empresa</h2>";
            $html .= "<table width='100%' border='1' cellpadding='0' cellspacing='0' >";
            $html .= "<tr>
            <th><em>Cedula</em></th>
            <th><em>Rif de la Empresa</em></th>
            <th><em>Razon Social de la Empresa</em></th>
            <th><em>Correo de Contacto</em></th>
             </tr>";
            foreach ($resultado->result_array() as $fila) {
                $html .= "<tr>
                    <td>" . mb_convert_case($fila['cedula'], MB_CASE_TITLE, "UTF-8") . "</td>
                    <td>" . mb_convert_case($fila['rif'], MB_CASE_TITLE, "UTF-8") . "</td>
                    <td>" . mb_convert_case($fila['razonsocial'], MB_CASE_TITLE, "UTF-8") . "</td>
                    <td>" . mb_convert_case($fila['correo'], MB_CASE_TITLE, "UTF-8") . "</td>
                   
                </tr>";
                ;
            }
            $html .= "</table>";
            $nombre_archivo = utf8_decode("Listado Usuario sin Empresa.pdf");
        } else {
            $html = '';
            $html .= "<style type=text/css>";
            $html .= "th{color: #fff; font-weight: bold; background-color: #AAC7E3}";
            $html .= "td{background-color: #fff; color: #222}";
            $html .= "</style>";
            $html .= "<h4>Listado Empresas - Información</h4>";
            $html .= "<table width='100%'>";
            $html .= "<tr><th>No hay Empresas con las caracteristicas indicadas</th></tr>";
            $html .= "</table>";
            $nombre_archivo = utf8_decode("Listado Discapacidad.pdf");
        }
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);
        $pdf->Output($nombre_archivo, 'I');
    }

}

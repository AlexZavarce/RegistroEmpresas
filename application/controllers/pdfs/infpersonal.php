<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Infpersonal extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('pdfs/infpersonal_model');
        $this->load->library('Pdf');
        $this->load->library(array('session'));
    }

    public function listadopersonal() {
        $rif = $this->input->get("rif") . $this->input->get("rif1") . $this->input->get("rif2");

        $rifs = ($rif != 'null') ? '="' . $rif . '"' : 'LIKE "%"';
        $nombrecomer = ($this->input->get("nombrecomer") != '') ? "LIKE '%" . $this->input->get("nombrecomer") . "%'" : 'LIKE "%"';
        $anoact = ($this->input->get("anoact") != 'null') ? '=' . $this->input->get("anoact") : 'LIKE "%"';
        $cmbmunicipio = ($this->input->get("cmbmunicipio") != 'null') ? '=' . $this->input->get("cmbmunicipio") : 'LIKE "%"';
        $cmbparroquia = ($this->input->get("cmbparroquia") != 'null') ? '=' . $this->input->get("cmbparroquia") : 'LIKE "%"';
        $cmbcomunidad = ($this->input->get("cmbcomunidad") != 'null') ? '=' . $this->input->get("cmbcomunidad") : 'LIKE "%"';
        $cmbtipo = ($this->input->get("cmbtipo") != 'null') ? '=' . $this->input->get("cmbtipo") : 'LIKE "%"';
        $cmbseccion = ($this->input->get("cmbseccion") != 'null') ? '=' . $this->input->get("cmbseccion") : 'LIKE "%"';
        $cmbdivision = ($this->input->get("cmbdivision") != 'null') ? '=' . $this->input->get("cmbdivision") : 'LIKE "%"';
        $cmbgrupo = ($this->input->get("cmbgrupo") != 'null') ? '=' . $this->input->get("cmbgrupo") : 'LIKE "%"';
        $cmbclase = ($this->input->get("cmbclase") != 'null') ? '=' . $this->input->get("cmclase") : 'LIKE "%"';
        $cmbrama = ($this->input->get("cmbrama") != 'null') ? '=' . $this->input->get("cmbrama") : 'LIKE "%"';
        $formato = ($this->input->get("cmbformatoReporte"));
        if ($formato != 'PDF' && $formato != 'EXCEL')
            $formato = 'PDF';
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
        $resultado = $this->infpersonal_model->getinfpersonal($rifs, $nombrecomer, $anoact, $cmbmunicipio, $cmbparroquia, $cmbcomunidad, $cmbtipo, $cmbseccion, $cmbdivision, $cmbgrupo, $cmbclase, $cmbrama);
        if ($resultado) {
            $html = " ";
            $html .= "<style type=text/css>";
            $html .= "th{color: #fff; font-weight: bold; background-color: #AAC7E3; align=center}";
            $html .= "td{background-color: #fff; color: #222; align=center}";
            $html .= "</style>";
            $html .= "<h2>Listado  de Empresas Registradas</h2>";
            $html .= "<table width='100%' border='1' cellpadding='0' cellspacing='0' >";
            $html .= "<tr>
            <th><em>Rif</em></th>
            <th><em>Nombre Comercial</em></th>
            <th><em>Cédula</em></th>
            <th><em>Representante</em></th>
            <th><em>tipo</em></th>
            <th><em>Municipio</em></th>
            <th><em>Prroquia</em></th>
            <th><em>Comunidad</em></th>
            <th><em>Sección</em></th>
              <th><em>Division</em></th>
                <th><em>Grupo</em></th>
                  <th><em>Clase</em></th>
            <th><em>Rama</em></th>
            </tr>";
            foreach ($resultado->result_array() as $fila) {
                $html .= "<tr>
                    <td>" . mb_convert_case($fila['rif'], MB_CASE_TITLE, "UTF-8") . "</td>
                    <td>" . mb_convert_case($fila['nombreco'], MB_CASE_TITLE, "UTF-8") . "</td>
                    <td>" . mb_convert_case($fila['cedularep'], MB_CASE_TITLE, "UTF-8") . "</td>
                    <td>" . mb_convert_case($fila['nombrerep'], MB_CASE_TITLE, "UTF-8") . "</td>
                    <td>" . mb_convert_case($fila['tipo'], MB_CASE_TITLE, "UTF-8") . "</td>
                    <td>" . mb_convert_case($fila['municipio'], MB_CASE_TITLE, "UTF-8") . "</td>
                    <td>" . mb_convert_case($fila['parroquia'], MB_CASE_TITLE, "UTF-8") . "</td>
                    <td>" . mb_convert_case($fila['comunidad'], MB_CASE_TITLE, "UTF-8") . "</td>
                    <td>" . mb_convert_case($fila['seccion'], MB_CASE_TITLE, "UTF-8") . "</td>
                    <td>" . mb_convert_case($fila['divisionact'], MB_CASE_TITLE, "UTF-8") . "</td>
                    <td>" . mb_convert_case($fila['grupoact'], MB_CASE_TITLE, "UTF-8") . "</td>
                    <td>" . mb_convert_case($fila['claseact'], MB_CASE_TITLE, "UTF-8") . "</td>
                    <td>" . mb_convert_case($fila['ramaact'], MB_CASE_TITLE, "UTF-8") . "</td>
                </tr>";
                ;
            }
            $html .= "</table>";
            $nombre_archivo = utf8_decode("Listado empresas.pdf");
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
            $nombre_archivo = utf8_decode("Listado empresas.pdf");
        }
        if ($formato == 'PDF') {
            $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);
            $pdf->Output($nombre_archivo, 'I');
        } else {
            header("Content-Type: text/html; charset=utf-8");
            header('Content-type: application/vnd.ms-excel');
            $nombre_archivo = 'Listado empresas';
            header("Content-Disposition: attachment; filename=" . $nombre_archivo . ".xls");
            header("Pragma: no-cache");
            header("Expires: 0");
            echo utf8_decode($html);
        }
    }

}

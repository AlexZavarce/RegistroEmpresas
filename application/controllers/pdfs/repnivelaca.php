<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');
class Repnivelaca extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('pdfs/Repnivelaca_model');
        $this->load->library('Pdf');        
    }
    public function generarListadogennivaca() {
        $nombre=($this->input->get("nombre" )!='') ?  "LIKE '%".$this->input->get("nombre")."%'":'LIKE "%"';
        $apellido=($this->input->get("apellido" )!='') ?  "LIKE '%".$this->input->get("apellido")."%'":'LIKE "%"';
        $edocivil=($this->input->get("edocivil")!='null')?'='.$this->input->get("edocivil"):'LIKE "%"';
        $edad=($this->input->get("edad")!='null')?'='.$this->input->get("edad"):'>=0';
        $municipio=($this->input->get("municipio")!='null')?'='.$this->input->get("municipio"):'LIKE "%"';
        $parroquia=($this->input->get("parroquia")!='null')?'='.$this->input->get("parroquia"):'LIKE "%"';
        $sexo=($this->input->get("sexo")!='null')?'='.$this->input->get("sexo"):'LIKE "%"';
        $institucion=($this->input->get("institucion")!='null')?'='.$this->input->get("institucion"):'LIKE "%"';
        $gradoins=($this->input->get("gradoins")!='null')?'='.$this->input->get("gradoins"):'LIKE "%"';
        $limitaciones=($this->input->get("limitaciones")!='null')?'='.$this->input->get("limitaciones"):'LIKE "%"';
        $condiciones=($this->input->get("condiciones")!='null')?'='.$this->input->get("condiciones"):'LIKE "%"';
        $deseoestudiar=($this->input->get("deseoestudiar")!='null')?'='.$this->input->get("deseoestudiar"):'LIKE "%"';
        $pdf = new Pdf('l', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetSubject('Tutorial TCPDF');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
        // datos por defecto de cabecera, se pueden modificar en el archivo tcpdf_config_alt.php de libraries/tcpdf/config
        $pdf->SetHeaderData(PDF_HEADER_LOGO,PDF_HEADER_LOGO_WIDTH,PDF_HEADER_TITLE ,PDF_HEADER_STRING,PDF_HEADER_LOGO1);
        //$pdf->SetHeaderData(PDF_HEADER_LOGO1, PDF_HEADER_LOGO_WIDTH1,PDF_HEADER_TITLE ,PDF_HEADER_STRING, '', 'PNG', 'N', 'T', false, 800,'L', false, false, 0, false, false, false);
        //$pdf->SetHeaderData(PDF_HEADER_LOGO1,PDF_HEADER_LOGO_WIDTH1,PDF_HEADER_TITLE ,PDF_HEADER_STRING);
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
        $html=null;
        $nombre_archivo=null;
        $pdf->MultiCell(55, 10, '[FIT CELL] ', 0, 'L', 1, 1, 165, 15, true, 0, true, true, 60, 'M', true);
        // Establecemos el contenido para imprimir
        $resultado = $this->Repnivelaca_model->getnivelacademico($nombre,$apellido,$edocivil,$edad,$municipio,$parroquia,$sexo,$institucion,$gradoins,$limitaciones,$condiciones,$deseoestudiar); 
        if($resultado){
            $html = '';
            $html .= "<style type=text/css>";
            $html .= "th{color: #fff; font-weight: bold; background-color: #AAC7E3; align=center}";
            $html .= "td{background-color: #fff; color: #222; align=center}";
            $html .= "</style>";
            $html .= "<h2>Listado Discapacitados - Nivel Academico</h2>";
            $html .= "<table width='100%' border='1' cellpadding='0' cellspacing='0' >";
            $html .= "<tr>
            <th><em>Cédula</em></th>
            <th><em>Nombres</em></th>
            <th><em>Teléfonos</em></th>
            <th><em>Municipio</em></th>
            <th><em>Parroquia</em></th>
            <th><em>Fecha Nacimiento</em></th>
            <th><em>Edad</em></th>
            <th><em>Grado de instrucción</em></th>
            <th><em>Deseo de Estudiar</em></th>
            <th><em>Posee Condiciones Fisicas/Mentales</em></th>
            <th><em>Limitaciones de Estudio</em></th>
            </tr>";
            foreach($resultado as $fila){                    
                $html .= '<tr>
                <td>'.mb_convert_case($fila["cedula"],MB_CASE_TITLE, "UTF-8").'</td>
                <td>'.mb_convert_case($fila["nombres"],MB_CASE_TITLE, "UTF-8").'</td>
                <td>'.mb_convert_case($fila["tlfmovil"],MB_CASE_TITLE, "UTF-8").'/'.mb_convert_case($fila["tlffijo"],MB_CASE_TITLE, "UTF-8").'</td>
                <td>'.mb_convert_case($fila["municipio"],MB_CASE_TITLE, "UTF-8").'</td>
                <td>'.mb_convert_case($fila["parroquia"],MB_CASE_TITLE, "UTF-8").'</td>
                <td>'.mb_convert_case(date("d/m/Y", strtotime($fila["fechanacimiento"])),MB_CASE_TITLE, "UTF-8").'</td>
                <td>'.mb_convert_case($fila["edaddis"],MB_CASE_TITLE, "UTF-8").'</td>
                <td>'.mb_convert_case($fila["gradoins"],MB_CASE_TITLE, "UTF-8").'</td>
                <td>'.mb_convert_case($fila["deseoestudio"],MB_CASE_TITLE, "UTF-8").'</td>
                <td>'.mb_convert_case($fila["condicionfismen"],MB_CASE_TITLE, "UTF-8").'</td>
                <td>'.mb_convert_case($fila["nombrelimitacion"],MB_CASE_TITLE, "UTF-8").'</td>    
                </tr><hr>'; 
            }                
            $html .= "</table>";  
            $cantidad=count($resultado);
            if ($cantidad>1){
              $html .="<h4>Actualmente: ".count($resultado)." Discapacitados</h4>";  
            }else{
                $html .="<h4>Actualmente: ".count($resultado)." Discapacitado</h4>";
            }
            $nombre_archivo = utf8_decode("Listado Nivel Academico.pdf");  
        }else{
            $html = '';
            $html .= "<style type=text/css>";
            $html .= "th{color: #fff; font-weight: bold; background-color: #AAC7E3}";
            $html .= "td{background-color: #fff; color: #222}";
            $html .= "</style>";
            $html .= "<h4>Listado Discapacitados - Nivel Academico</h4>";
            $html .= "<table width='100%'>";
            $html .= "<tr><th>No hay Discapacitados con las caracteristicas indicadas</th></tr>";            
            $html .= "</table>";
            $nombre_archivo = utf8_decode("Listado de Nivel_academico.pdf");
        }
        $pdf->writeHTMLCell($w = 0,$h = 0,$x='',$y = '',$html,$border = 0,$ln = 1,$fill = 0,$reseth=true,$align='C',$autopadding= true);
        $pdf->Output($nombre_archivo, 'I');
    }
}   
         
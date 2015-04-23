<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');
class Repnotifivacacionespersonal extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('pdfs/repnotifivacaciones_model');
        $this->load->library('Pdf'); 
        $this->load->library(array('session'));       
    }
    public function mes($m){
        $a['01'] = "Enero"; 
        $a['02'] = "Febrero"; 
        $a['03'] = "Marzo"; 
        $a['04'] = "Abril"; 
        $a['05'] = "Mayo"; 
        $a['06'] = "Junio"; 
        $a['07'] = "Julio"; 
        $a['08'] = "Agosto";
        $a['09'] = "Septiembre";
        $a['10'] = "Octubre";
        $a['11'] = "Noviembre";
        $a['12'] = "Diciembre";
        $mes=$a[date($m)];
        return $mes; 
    }
    public function generarNotificacionpersonal() {  
         $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetSubject('Tutorial TCPDF');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0,0,1), array(0,0,1));
        //$pdf->setFooterData($tc = array(0, 64, 0), $lc = array(0, 64, 128));
        //$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetPageOrientation('p');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        //$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        //$pdf->SetHeaderMargin(PDF_MARGIN_HEADER1);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true); 
        $pdf->SetFont('times', '', 9, '', true);
        $pdf->AddPage();
        $pdf->Cell(5,5,$pdf->Image('./imagen/logo/logoborde.png',15,16,90),0,0,'C');
        $pdf->Cell(6,5,$pdf->Image('./imagen/logo/laraprogresista1.png',150,17,51),0,0,'C');
        $id= $this->input->get("id");
        $nombres=$this->input->get("nombres");
        $cedula=$this->input->get("cedula");
        $idrep=$this->input->get("idrep");
        $status=$this->input->get("status");
        $fecha=$this->input->get("fecha");
        $fechasalida=$this->input->get("fechasalida");
        $html=null;
        $mesactual=date("m");
        $mesletra1=$this->mes(date("m",strtotime($fecha)));
        $mesletra=$this->mes($mesactual);
        $getsolicitud=$this->repnotifivacaciones_model->getnomina($id);
        if ($getsolicitud){
            foreach($getsolicitud->result_array() as $fila){
              $html = "";
                $html .= '<style type=text/css>';
                $html .= 'th{color: #fff; font-weight: bold; background-color: #AAC7E3; align=center font-family: Arial, Helvetica, sans-serif; 
                    font-size: 39px; }';
                $html .= 'td{background-color: #fff; color: #222; font-family: Arial, Helvetica, sans-serif; 
                    font-size: 39px; }';
                $html .= '</style>';
                $html .= '<p></p><p></p><p></p><p></p><p></p><p></p>';
                $html .= '<p></p><p></p><p></p><p></p>';
                if ($status==0){
                    $html .= '<h4><font size="12" ALIGN="left"><b>SECRETARIA GENERAL DE GOBIERNO</b><br><b> OFICINA DE INFORMATICA </b></font><br><font size="12" ALIGN="right">Barquisimeto ,' . date("j") . ' de ' .$mesletra .' del ' . date("Y").'</font><br><br></h4>';
                }else{
                    $html .= '<h4><font size="12" ALIGN="left"><b>SECRETARIA GENERAL DE GOBIERNO</b><br><b> OFICINA DE INFORMATICA </b></font><br><font size="12" ALIGN="right">Barquisimeto ,' . date("j",strtotime($fecha)) . ' de ' .$mesletra1.' del ' . date("Y",strtotime($fecha)).'</font><br><br></h4>';
                }
                $html .= '<h4><font size="12" ALIGN="left"><b>CIUDADANO: </b><br><b> ABOG. ERICK VALLES </b><br><b>JEFE DE OFICINA DE PERSONAL</b><br><b>SU DESPACHO.-</b><br></h4>';
                 $html .= '<h4><font size="12" ALIGN="center">Atención: Abog. Yulimar Méndez: <br>Jefe División de Relaciones Laborales<br></h4>';
                 $html .= '<font size="12" ALIGN="left"><br><b>Reciba un cordial saludo progresista, me dijo a usted, en la oportunidad de remitirle Notificación de Vacaciones, correspondiente  a la ciudadana:</b></font><br><br><br>';
                $html .= '<table border="1" cellspacing="0" cellpadding="4">';
                $html .= '<tr>';
                    $html .= '<td colspan="2"><b>APELLIDOS Y NOMBRES:</b></td>';
                    $html .= '<td colspan="2"><b>C.I.</b></td>';
                    $html .= '<td colspan="2"><b>LAPSO</b></td>';
                    $html .= '<td colspan="2"><b>NOMINA</b></td>';
                    $html .= '<td colspan="2"><b>FECHA DE INICIO DE DISFRUTE</b></td>';
                $html .= '</tr>';
                $html .= '<tr>';
                    
                    $html .= '<td colspan="2"><b>' .$nombres.'</b></td>';
                    $html .= '<td colspan="2"><b>' .$cedula.'</b></td>';
                    if ($status==0){
                        $buscarperiodosrep=$this->repnotifivacaciones_model->buscarperiodosrep($id);
                        if($buscarperiodosrep->num_rows>0){
                            $html .= '<td colspan="2">';
                            foreach ($buscarperiodosrep->result_array() as $row){
                                $hoy = date("Y-m-d");
                                $idrep='r'.$id;
                                $estatusper= array(
                                    'id'    => $row["id"],
                                    'status'=> 1,
                                    'fecha' => $hoy,
                                    'idrep' => $idrep 
                                );
                                $updatestatus=$this->repnotifivacaciones_model->updatestatus($estatusper);
                                $html .= ' <b>'.mb_convert_case($row["periodoini"],MB_CASE_TITLE, "UTF-8").'</b>-<b>'.mb_convert_case($row["periodofin"],MB_CASE_TITLE, "UTF-8").'</b>';
                            }
                            $html .= '</td>';
                        }
                    }else{
                        $buscarperiodosprocesado=$this->repnotifivacaciones_model->buscarperiodosprocesado($idrep,$id);
                        if($buscarperiodosprocesado->num_rows>0){
                            $html .= '<td colspan="2">';
                            foreach ($buscarperiodosprocesado->result_array() as $row){
                                $html .= ' <b>'.mb_convert_case($row["periodoini"],MB_CASE_TITLE, "UTF-8").'</b>-<b>'.mb_convert_case($row["periodofin"],MB_CASE_TITLE, "UTF-8").'</b>';
                            }
                            $html .= '</td>';
                            $solicitud=substr($idrep, 1); 
                            $buscarfechainicio=$this->repnotifivacaciones_model->buscarfechainicio($solicitud);
                            if($buscarfechainicio->num_rows>0){
                                $row1 = $buscarfechainicio->row_array();
                                $data = $row1['fechainicio'];
                            }
                        }
                    }
                    $html .= '<td colspan="2"><b>'.mb_convert_case($fila["tiponomina"],MB_CASE_TITLE, "UTF-8").'</b></td>';
                    if ($status==1){

                        $html .= '<td colspan="2"><b>'.mb_convert_case(date("d/m/Y",strtotime( $data)),MB_CASE_TITLE, "UTF-8").'</b></td>';
                    }else{
                        $html .= '<td colspan="2"><b>'.$fechasalida.'</b></td>';
                    }
                $html .= '</tr>';
                $html .= "</table>";  
                $html .= '<h4><font size="12" ALIGN="left">Sin otro particular, le saluda.<br><br></font></h4>';
                $html .= '<h4><font size="12" ALIGN="center">ING. PABLO ALVAREZ <br>JEFE OFICINA DE INFORMATICA<br></h4>';
                $html .= '<font size="10" ALIGN="left">Anexa: Notificación de Vacaciones.</font>';
                $html .= '<h4><font size="10" ALIGN="left">Copia de Cédula de Identidad y Talón de Pago.<br><br><br></font></h4>';
                $html .= '<h4><font size="10" ALIGN="left">Ing. PA/Lcda.PS/ Lcda.SOL.<br><br><br><br><br></font></h4>';
                $html .= '<h4><font size="10" ALIGN="left">&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;www.lara.gob.ve|Dirección: Carrera 19, esquina calle 23, Edificio Sede, piso 05.  Barquisimeto, estado Lara.&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  Telfs: 0251-2502492  FAX  0251-2502490<br><br></font></h4>';
                $nombre_archivo = utf8_decode("Notificacion de Vacaciones.pdf"); 

            } ;    
        }else{
            $html = '';
            $html .= "<style type=text/css>";
            $html .= "th{color: #fff; font-weight: bold; background-color: #AAC7E3}";
            $html .= "td{background-color: #fff; color: #222}";
            $html .= "</style>";
            $html .= "<h4>Notificaciòn de Vacaciones</h4>";
            $html .= "<table width='100%'>";
            $html .= "<tr><th>No hay Notificación de Vacaciones</th></tr>";            
            $html .= "</table>";
            $nombre_archivo = utf8_decode("Listado de Nivel_academico.pdf");
        }
        $pdf->writeHTMLCell($w = 0,$h = 0,$x='',$y = '',$html,$border = 0,$ln = 1,$fill = 0,$reseth=true,$align='C',$autopadding= true);
        $pdf->Output($nombre_archivo, 'I');
           

    }
} 
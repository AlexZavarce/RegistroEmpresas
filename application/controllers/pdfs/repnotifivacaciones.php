<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');
class Repnotifivacaciones extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('pdfs/repnotifivacaciones_model');
        $this->load->library('Pdf'); 
        $this->load->library(array('session'));       
    }
    public function generarNotificacion() {  
        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetSubject('Tutorial TCPDF');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH,'',PDF_HEADER_STRING,array(0,64,255), array(0,64,128));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', '', 12, '', true);
        $pdf->AddPage();
        $pdf->Cell(6,5,$pdf->Image('./imagen/logo/laraprogresista1.png',225,17,51),0,0,'C');
        $id= $this->input->get("id");
        $nombres=$this->input->get("nombres");
        $cedula=$this->input->get("cedula");
        $sueldo=$this->input->get("sueldo");
        $primahijo=$this->input->get("primahijo");
        $primaantiguedad=$this->input->get("primaantiguedad");
        $nivelacion=$this->input->get("nivelacion");
        $html=null;
        $getsolicitud=$this->repnotifivacaciones_model->getsolicitud($id);
        if ($getsolicitud){
            foreach($getsolicitud->result_array() as $fila){
                $html = "";
                $html .= '<style type=text/css>';
                $html .= 'th{color: #fff; font-weight: bold; background-color: #AAC7E3; align=center font-family: Arial, Helvetica, sans-serif; 
                    font-size: 39px; }';
                $html .= 'td{background-color: #fff; color: #222; font-family: Arial, Helvetica, sans-serif; 
                    font-size: 39px; }';
                $html .= '</style>';
                $html .= '<h4><font size="10" ALIGN="left"><b>República Bolivariana de Venezuela</b><br><b>Gobernación del Estado Lara</b><br><b>Oficina de Informática</b></font></h4>';
                $html .= '<table border="1" cellspacing="0" cellpadding="4">';
                $html .= '<tr>';
                    $html .= '<td colspan="10" align="center"><font size="13"><b>NOTIFICACION DE VACACIONES</b><br> <b>(Forma DRL-010)</b></font></td>';
                $html .= '</tr>';
                $html .= '<tr>';
                    $html .= '<td colspan="6"><b>Apellidos y Nombre:</b></td>';
                    $html .= '<td colspan="4"><b>Cedula:</b></td></tr>';
                $html .= '<tr>';
                    $html .= '<td colspan="6"><b>' .$nombres.'</b></td>';
                    $html .= '<td colspan="4"><b>' .$cedula.'</b></td>';
                $html .= '</tr>';
                $html .= '<tr>';
                    $html .= '<td colspan="3"><b>Titulo del Cargo</b></td>';
                    $html .= '<td colspan="4"><b>Tipo de Personal</b></td>';
                    $html .= '<td colspan="3"><b>Fecha de Ingreso</b></td>';
                $html .= '</tr>';    
                $html .= '<tr>';
                    $html .= '<td colspan="3"><br><b>'.mb_convert_case($fila["cargo"],MB_CASE_TITLE, "UTF-8").'</b></td>';
                    $html .= '<td colspan="4"><br><b>Tipo de Personal</b></td>';
                    $html .= '<td colspan="1" ><b>Día</b><br><b>'.date("d", strtotime($fila["fechaingreso"])).'</b> </td>';
                    $html .= '<td  colspan="1" ><b>Mes</b><br><b>'.date("m", strtotime($fila["fechaingreso"])).'</b></td>';
                    $html .= '<td colspan="1" ><b>Año</b><br><b>'.date("y", strtotime($fila["fechaingreso"])).'</b></td>';
                $html .= '</tr>';      
                $html .= '<tr>';
                    $html .= '<td colspan="6"><b>Ubicación:</b></td>';
                    $html .= '<td colspan="4"><b>Municipio:</b></td>';
                $html .= '</tr>';
                $html .= '<tr>';
                    $html .= '<td colspan="6"><b>'.mb_convert_case($fila["departamento"],MB_CASE_TITLE, "UTF-8").'</b></td>';
                    $html .= '<td colspan="4"><b>Iribarren</b></td>';
                $html .= '</tr>';
                $html .= '<tr>';
                    $html .= '<td colspan="6"><b>Períodos Pendientes por Disfrutar</b></td>';
                    $html .= '<td colspan="4"><b>Períodos de Vacaciones a Disfrutar</b></td>';
                $html .= '</tr>';
                $html .= '<tr>';
                    $html .= '<td colspan="2"><b>Lapsos</b></td>';
                    $empleado=$fila["empleado"];
                    $periodosindisfrutar=$this->repnotifivacaciones_model->periodosindisfrutar($empleado);
                    if ($periodosindisfrutar){
                         $html .= '<td colspan="3">';
                        foreach($periodosindisfrutar->result_array() as $sindisfrutar){
                            $html .= '<b>'.$sindisfrutar["periodoini"].'</b> - <b>'.$sindisfrutar["periodofin"].'</b>  ';
                        }
                        $html .= '</td>';
                    }    
                    $html .= '<td colspan="2"><b>Lapsos</b></td>';
                    $periododisfrutar=$this->repnotifivacaciones_model->periododisfrutar($id);
                    if ($periododisfrutar){
                        $html .= '<td colspan="3">';
                        foreach($periododisfrutar->result_array() as $disfrutar){
                            $html .= '<b>'.$disfrutar["periodoini"].'</b> - <b>'.$disfrutar["periodofin"].'</b>      ';
                        }
                        $html .= '</td>';
                    }    
                $html .= '</tr>';
                $html .= '<tr>';
                    $html .= '<td colspan="5"><b>Salario Devengado</b></td>';
                    $html .= '<td colspan="5"><b>Fecha de Ultimas Vacaciones</b></td>';
                $html .= '</tr>';
                $html .= '<tr>';
                    $html .= '<td colspan="3"><br><b>Sueldo</b></td>';
                    if ($fila["sueldo"]==0){
                        $html .= '<td colspan="2"><br><b>'.$sueldo.'</b></td>';  
                    }else{
                        $html .= '<td colspan="2"><br><b>'.$fila["sueldo"].'</b></td>';
                    }
                    $ultimasvacaciones=$this->repnotifivacaciones_model->ultimasvacaciones($empleado,$id);
                    if ($ultimasvacaciones=='null'|| $ultimasvacaciones=='0000-00-00'){
                        foreach($ultimasvacaciones->result_array() as $ultimas){
                            $html .= '<td colspan="1" ><b>Día</b><br><b></b> </td>';
                            $html .= '<td  colspan="1" rowspan="1"><b>Mes</b><br><b></b></td>';
                            $html .= '<td colspan="1" ><b>Año</b><br><b></b></td>';
                        }
                    }else{
                        foreach($ultimasvacaciones->result_array() as $ultimas){
                            $fecha=$ultimas["fechaultima"];
                            if ($fecha==NULL){
                                $html .= '<td colspan="1" ><b>Día</b><br><b></b> </td>';
                                $html .= '<td  colspan="1" rowspan="1"><b>Mes</b><br><b></b></td>';
                                $html .= '<td colspan="1" ><b>Año</b><br><b></b></td>';
                            }else{
                                $html .= '<td colspan="1" ><b>Día</b><br><b>'.date("d", strtotime($ultimas["fechaultima"])).'</b> </td>';
                                $html .= '<td  colspan="1" rowspan="1"><b>Mes</b><br><b>'.date("m", strtotime($ultimas["fechaultima"])).'</b></td>';
                                $html .= '<td colspan="1" ><b>Año</b><br><b>'.date("y", strtotime($ultimas["fechaultima"])).'</b></td>'; 
                            }
                        }
                        $idsolicitud=$ultimas["solicitudultima"];
                        if ($idsolicitud){
                            $periodoultimavacaciones=$this->repnotifivacaciones_model->periodoultimavacaciones($idsolicitud);
                            if($periodoultimavacaciones->num_rows>0){
                                $row1 = $periodoultimavacaciones->row_array();
                                $periodoultimoini=$row1['periodoutlimoini'];
                                $periodoultimofin=$row1['periodoutlimofin'];
                                $html .= '<td colspan="2" ><b>Periodo</b><br><b>'.$periodoultimoini.'</b>- <b>'.$periodoultimofin.'</b></td>';
                            }
                        }else{
                             $html .= '<td colspan="2" ><b>Periodo</b><br><b></b></td>';
                        }   
                    }  
                $html .= '</tr>'; 
                $html .= '<tr>';
                    $html .= '<td colspan="3"><br><b>Prima por Hijos(CI.39)</b></td>';
                    if ($fila["sueldo"]==0){
                        $html .= '<td colspan="2"><br><b>'.$primahijo.'</b></td>';
                    }else{
                         $html .= '<td colspan="2"><br><b>'.$fila["primahijo"].'</b></td>';
                    }
                    $html .= '<td colspan="5"><br><b></b></td>'; 
                $html .= '</tr>'; 
                $html .= '<tr>';
                    $html .= '<td colspan="3"><br><b>Prima por Antiguedad(CI.40)</b></td>';
                    if ($fila["sueldo"]==0){
                        $html .= '<td colspan="2"><br><b>'.$primaantiguedad.'</b></td>';
                    }else{
                         $html .= '<td colspan="2"><br><b>'.$fila["primaantiguedad"].'</b></td>';
                    }
                    $html .= '<td colspan="5"><br><b></b></td>'; 
                $html .= '</tr>'; 
                $html .= '<tr>';
                    $html .= '<td colspan="3"><br><b>Nivelación Profesional (Cl. 50)</b></td>';
                    if ($fila["sueldo"]==0){
                        $html .= '<td colspan="2"><br><b>'.$nivelacion.'</b></td>';
                    }else{
                         $html .= '<td colspan="2"><br><b>'.$fila["nivelacion"].'</b></td>';
                    }
                    $html .= '<td colspan="5"><br><b></b></td>'; 
                $html .= '</tr>'; 
                $html .= '<tr>';
                    $html .= '<td colspan="3"><br><b>Diferencia de Vacaciones</b></td>';
                    $html .= '<td colspan="2"><br><b></b></td>';
                    $html .= '<td colspan="5"><br><b></b></td>'; 
                $html .= '</tr>'; 
                $html .= '<tr>';
                    $html .= '<td colspan="10" align="center"><b>Datos de Vacaciones</b></td>';
                $html .= '</tr>';
                $html .= '<tr>';
                    $html .= '<td colspan="3"><br><b>Desde</b></td>';
                    $html .= '<td colspan="3"><br><b>Hasta</b></td>';
                    $html .= '<td colspan="3"><br><b>Fecha de Reintegro</b></td>'; 
                    $html .= '<td colspan="1"><br><b>Dìas Habiles</b></td>'; 
                $html .= '</tr>'; 
                 $html .= '<tr>';
                    $html .= '<td colspan="1" ><b>Día</b><br><b>'.date("d", strtotime($fila["fechasalida"])).'</b> </td>';
                    $html .= '<td colspan="1" ><b>Mes</b><br><b>'.date("m", strtotime($fila["fechasalida"])).'</b></td>';
                    $html .= '<td colspan="1" ><b>Año</b><br><b>'.date("y", strtotime($fila["fechasalida"])).'</b></td>';
                    $html .= '<td colspan="1" ><b>Día</b><br><b>'.date("d", strtotime($fila["fechaculminacion"])).'</b> </td>';
                    $html .= '<td colspan="1" ><b>Mes</b><br><b>'.date("m", strtotime($fila["fechaculminacion"])).'</b></td>';
                    $html .= '<td colspan="1" ><b>Año</b><br><b>'.date("y", strtotime($fila["fechaculminacion"])).'</b></td>';
                    $fechaini =$fila["fechasalida"];
                    $nrodia= $fila["diassolicitados"];
                    $retorno=$this->repnotifivacaciones_model->retorno($fechaini,$nrodia);
                    if($retorno){
                        $fecretorno=$retorno;
                    }
                    $html .= '<td colspan="1" ><b>Día</b><br><b>'.date("d", strtotime($fecretorno)).'</b> </td>';
                    $html .= '<td colspan="1" ><b>Mes</b><br><b>'.date("m", strtotime($fecretorno)).'</b></td>';
                    $html .= '<td colspan="1" ><b>Año</b><br><b>'.date("y", strtotime($fecretorno)).'</b></td>';
                    $html .= '<td colspan="1" ><b>'.$fila["diassolicitados"].'</b></td>';
                $html .= '</tr>'; 
                $html .= '<tr>';
                    $html .= '<td colspan="10"><font size="10"><br><b>Observaciones</b></font>';
                    $html .= '<font size="10"><br><b>1- Toda planilla de solicitud de vacaciones de empleados fijos y contratados se debe consignar con memorándum, indicando fecha de inicio del disfrute, debidamente firmado por el Jefe Superior Inmediato.</b></font>';
                    $html .= '<font size="10"><br><b>2- Quedará sujeto a las sanciones correspondientes el Empleado que, sin plena justificación, no se reintegre al trabajo en la fecha señalada en este formulario.</b></font></td>';
                $html .= '</tr>'; 
                $html .= '<tr>';
                    $html .= '<td colspan="3"><b>Elaborado por:</b></td>';
                    $html .= '<td colspan="2"><br><b>Autorizado por:</b></td>';
                    $html .= '<td colspan="2"><br><b>Aprobado por:</b></td>'; 
                    $html .= '<td colspan="3"><br><b>Firme conforme</b></td>'; 
                $html .= '</tr>';
                $html .= '<tr>';
                    $html .= '<td colspan="3"><br><br><b>_____________</b></td>';
                    $html .= '<td colspan="2"><br><br><b>_____________</b></td>';
                    $html .= '<td colspan="2"><br><br><b>_____________</b></td>'; 
                    
                $html .= '</tr>';
                 $html .= '<tr>';
                    $html .= '<td colspan="3"><b>División de Relaciones Laborales</b><br><b>(Firma y Sello):</b></td>';
                    $html .= '<td colspan="2"><br><b>Jefe Inmediato</b><br><b>(Firma y Sello):</b></td>';
                    $html .= '<td colspan="2"><br><b>Jefe de la Oficina de Personal</b><br><b>(Firma y Sello):</b></td>';

                $html .= '</tr>';        
                $html .= "</table>";  
                $nombre_archivo = utf8_decode("Notificacion de Vacaciones.pdf"); 
            } ;    
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
         $nombre_archivo = utf8_decode("Listado de Nivel_academico.pdf");
        $pdf->Output($nombre_archivo, 'I');
           

    }
} 
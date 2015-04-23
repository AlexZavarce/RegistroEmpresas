<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');
class Repasisemanal extends CI_Controller {
    function __construct() {
        parent::__construct();
        //$this->load->model('pdfs/asisemananal_model');
        $this->load->model('pdfs/inasistencia_model');
        $this->load->model('pdfs/repasisemanal_model');
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
    public function generarlistadosemanal() {
        $dias = array('Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado');
        $username = $this->session->userdata('datasession');
        $usuarioced = $username['cedula'];
        $usuariodiv=$this->inasistencia_model->getdivisionusu($usuarioced);
        if($usuariodiv->num_rows>0){
            $row1 = $usuariodiv->row_array();
            $data = array(
                'tipousuario'  => $row1['tipousuario'],
                'divisionusu'  => $row1['divisionusu'],
                'departamento' => $row1['departamento']
            );
            if ($data['tipousuario']==1 || $data['tipousuario']==6){
              $division=($this->input->get("division")!='null')?'='.$this->input->get("division"):'LIKE "%"';   
            }else{
              $division='='.$data['divisionusu'];
            }
        } 
        $departamento=$data['departamento'];
        $nombres=($this->input->get("nombres" )!='') ?  "LIKE '%".$this->input->get("nombres")."%'":'LIKE "%"';
        $tiponomina=($this->input->get("tiponomina" )!='null') ?'=' .$this->input->get("tiponomina"):'LIKE "%"';
        $retardos=($this->input->get("retardos")!='null')?'='.$this->input->get("retardos"):'LIKE "%"';
        $cedula=($this->input->get("cedula" )!='null') ?  "LIKE '%".$this->input->get("cedula")."%'":'LIKE "%"';
        $fechades1=($this->input->get("fechades"));
        $fechahas1=($this->input->get("fechahas"));
        $fechades=date("Y-m-d",  strtotime($fechades1));
        $fechahas=date("Y-m-d",  strtotime($fechahas1));
        $fechades2=date("d/m/Y",  strtotime($fechades1));
        $fechahas2=date("d/m/Y",  strtotime($fechahas1));
        $mes1=date("m",  strtotime($fechades1));
        $mes2=date("m",  strtotime($fechahas1));
        $diasferiados= array(); 
        $semana=$this->semana($fechades,$fechahas,$diasferiados);
        $pdf = new Pdf('l', 'mm', 'Legal', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetSubject('Tutorial TCPDF');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0,0,1), array(0,0,1));
        $pdf->setFooterData($tc = array(0, 64, 0), $lc = array(0, 64, 128));
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetPageOrientation('l');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER1);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true); 
        $pdf->SetFont('times', '', 9, '', true);
        $pdf->AddPage();
        $html=null;
        $nombre_archivo=null;
        $divisiones=$this->repasisemanal_model->getdivision($division,$departamento,$nombres,$cedula);
        if($divisiones){
            $html .= "<style type=text/css>";
            $html .= "th{color: #fff; font-weight: bold; background-color: #AAC7E3; align=center}";
            $html .= "p.saltodepagina{background-color: #fff; page-break-after: always;}";
            $html .= "</style>";
            //$html .= '<h2 align="center">Asistencia Semanal<br>Del '.$fechades2.' al '.$fechahas2.' ';
            //$html .= '<h2 align="center">Del '.$fechades2.' al '.$fechahas2.' </h2>';
            foreach($divisiones->result_array() as $div){
                $divisionasis=$div['division'];
                $nombredivision1=$div['nombredivision'];
                $empleado=$this->repasisemanal_model->getasistencia($divisionasis,$cedula,$fechades,$fechahas,$nombres);
                $cedemp=null;
                $tot=0;
                $asist=array();
                $fechadia=null;
                $lunes1=0;
                foreach($empleado->result_array() as $emp){
                    $iddep=$emp['iddep'];
                    if ($iddep==1){
                        $iddepartamento='Dep.1';
                    }else{
                        $iddepartamento='Dep.2';
                    }
                    $nombre=$emp['nombre'];
                    $tot=$tot+1;
                    if ($cedemp!=$emp['cedula']){
                        if ($tot!=1){
                            $lunes1=0;
                            switch ($fechadia) {
                            case 'Lunes':
                                $html .='<tr>'; 
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >Martes</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .='</tr>'; 
                                $html .= '<tr>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >Miercoles</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .='</tr>'; 
                                $html .= '<tr>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >Jueves</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .='</tr>'; 
                                $html .= '<tr>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >Viernes</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .='</tr>'; 
                                $html .= '<tr>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >Sabado</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .='</tr>'; 
                                break;
                            case 'Martes':
                                $html .= '<tr>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >Miercoles</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .='</tr>'; 
                                $html .= '<tr>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >Jueves</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .='</tr>'; 
                                $html .= '<tr>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >Viernes</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .='</tr>'; 
                                $html .= '<tr>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >Sabado</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .='</tr>'; 
                                
                                break;
                            case 'Miercoles':
                                $html .= '<tr>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >Jueves</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .='</tr>'; 
                                $html .= '<tr>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >Viernes</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .='</tr>'; 
                                $html .= '<tr>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >Sabado</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .='</tr>'; 
                                
                                break;
                            case 'Jueves':
                                $html .= '<tr>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >Viernes</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .='</tr>'; 
                                $html .= '<tr>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >Sabado</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .='</tr>'; 
                                break;
                            case 'Viernes':
                                $html .= '<tr>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >Sabado</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .='</tr>'; 
                                break;
                            }
                            unset($asist);
                            $asist=array();
                            //$html .= '</table>';
                            $html .= '</table><p></p><p class="saltodepagina" />';      
                            $nombre=$emp['nombre'];
                            $cedulas=$emp['cedula'];
                            $html .= '<h2 align="center">Asistencia Semanal<br>Del '.$fechades2.' al '.$fechahas2.' ';
                            $html .= "<br>$nombredivision1 </h2>";
                            $lunes=0;
                            $html .= '<p></p>';
                            $html .= '<h3 align="left">Empleado:'.$nombre.' &nbsp;&nbsp;&nbsp;&nbsp; Cédula:'.$cedulas.'</h3>';
                            $html .= '<table width="100%"  cellpadding="1" cellspacing="1" BORDER="1" >';
                            $html .='<tr padding:300px>';
                            $html .= '<th><h3><font color="#000000">Dia - Fecha</font></h3></th>';
                            $html .= '<th><h3><font color="#000000">Hora-Llegada</font></h3></th>';
                            $html .= '<th><h3><font color="#000000">Tiempo-Retardo</font></h3></th>';
                            $html .= '<th><h3><font color="#000000">Salida Almuerzo</font></h3></th>';
                            $html .= '<th><h3><font color="#000000">Entrada-Almuerzo</font></h3></th>';
                            $html .= '<th><h3><font color="#000000">Hora-Salida</font></h3></th>';
                            $html .='</tr>';
                            $html .= '</table>';
                            $result=0;
                            $html .= '<table width="100%"  cellpadding="1" cellspacing="1" BORDER="1" >';
                        }else{
                            $html .= '<h2 align="center">Asistencia Semanal<br>Del '.$fechades2.' al '.$fechahas2.' ';
                            $html .= "<br>$nombredivision1 </h2>";
                            $nombre=$emp['nombre'];
                            $cedulas=$emp['cedula'];
                            $html .= '<h3 align="left">Empleado:'.$nombre.' &nbsp;&nbsp;&nbsp;&nbsp; Cédula:'.$cedulas.'</h3>';
                            $html .= '<table width="100%"  cellpadding="1" cellspacing="1" BORDER="1" >';
                            $html .= '<tr padding:300px>';
                            $html .= '<th><h3><font color="#000000">Dia - Fecha</font></h3></th>';
                            $html .= '<th><h3><font color="#000000">Hora-Llegada</font></h3></th>';
                            $html .= '<th><h3><font color="#000000">Tiempo-Retardo</font></h3></th>';
                            $html .= '<th><h3><font color="#000000">Salida Almuerzo</font></h3></th>';
                            $html .= '<th><h3><font color="#000000">Entrada-Almuerzo</font></h3></th>';
                            $html .= '<th><h3><font color="#000000">Hora-Salida</font></h3></th>';
                            $html .='</tr>';
                            $html .= '</table>';
                            $result=0;
                            $html .= '<table width="100%"  cellpadding="1" cellspacing="1" BORDER="1" >';
                        }
                    }
                    $fecha=$emp['fecha'];
                    $fechafor=date("d/m/Y",  strtotime($fecha));
                    if ($fecha==null){
                        $dialetra=null;
                        $fechadia=null;
                        $lunes1=0;
                    }else{
                        $dialetra=$dias[date('N',strtotime($fecha))];
                    }
                    $hora=$emp['horaentrada'];
                    if ($dialetra=='Lunes'){
                        if ($lunes1<>1){
                            $lunes1=1;
                            $retardo=$emp["tiemporetardo"]; 
                            $partes=explode(':',$retardo); 
                            $horas=(int)$partes[0];
                            $minutos=$partes[1];  
                            $fechadia=$dialetra;
                            if (in_array($fecha,$semana)) {
                                $fechadia=$dialetra;
                                $html .='<tr>';
                                $html .='<td bgcolor= "#DFDFDF" align=center><font size="10" >'.mb_convert_case($dialetra,MB_CASE_TITLE, "UTF-8").' - '.mb_convert_case($fechafor,MB_CASE_TITLE, "UTF-8").'</font></td>';
                                $ficherohora='./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoentrada"]).'';
                                if (file_exists($ficherohora)){
                                    if($emp["fotoentrada"]==null){
                                        $html .='<td  align=center><font size="10" >'.mb_convert_case($hora,MB_CASE_TITLE, "UTF-8").'</font></td>';
                                    }else{
                                        $html .='<td  align=center><font size="10" ><img WIDTH="50" HEIGHT="50" src="./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoentrada"]).'"/>'.mb_convert_case($hora,MB_CASE_TITLE, "UTF-8").'</font></td>';
                                    } 
                                }else{
                                   $html .='<td  align=center><font size="10" >'.mb_convert_case($hora,MB_CASE_TITLE, "UTF-8").'</font></td>';  
                                }         
                                $html .='<td>'.((($emp["tiemporetardo"]>'00:16:00')?(($horas>0)?$horas.' hora'.(($horas>1)?'s':''):'').(($minutos>0)?' '.$minutos.'min.':''):'')).'</td>';
                                $ficheroalmsal='./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoalmuerzosal"]).'';
                                if (file_exists($ficheroalmsal)){
                                    if($emp["fotoalmuerzosal"]==null){
                                        $html .='<td>'.mb_convert_case((($emp["almuerzosalida"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzosalida"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                    }else{
                                        $html .='<td  align=center><font size="10" ><img WIDTH="50" HEIGHT="50" src="./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoalmuerzosal"]).'"/>'.mb_convert_case((($emp["almuerzosalida"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzosalida"]))):''),MB_CASE_TITLE, "UTF-8").'</font></td>';
                                    } 
                                }else{
                                   $html .='<td>'.mb_convert_case((($emp["almuerzosalida"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzosalida"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                } 
                                $ficheroalment='./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoalmuerzoent"]).'';
                                if (file_exists($ficheroalment)){
                                    if($emp["fotoalmuerzoent"]==null){
                                        $html .='<td>'.mb_convert_case((($emp["almuerzoentrada"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzoentrada"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                    }else{
                                        $html .='<td  align=center><font size="10" ><img WIDTH="50" HEIGHT="50" src="./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoalmuerzoent"]).'"/>'.mb_convert_case((($emp["almuerzoentrada"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzoentrada"]))):''),MB_CASE_TITLE, "UTF-8").'</font></td>';
                                    } 
                                }else{
                                   $html .='<td>'.mb_convert_case((($emp["almuerzoentrada"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzoentrada"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                } 
                                $ficherosalida='./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotosalida"]).'';
                                if (file_exists($ficherosalida)){
                                    if($emp["fotosalida"]==null){
                                       $html .='<td>'.mb_convert_case((($emp["horasalida"]>'00:00:00')?(date("g:i", strtotime($emp["horasalida"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                    }else{
                                        $html .='<td  align=center><font size="10" ><img WIDTH="50" HEIGHT="50" src="./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotosalida"]).'"/>'.mb_convert_case((($emp["horasalida"]>'00:00:00')?(date("g:i", strtotime($emp["horasalida"]))):''),MB_CASE_TITLE, "UTF-8").'</font></td>';
                                    } 
                                }else{
                                   $html .='<td>'.mb_convert_case((($emp["horasalida"]>'00:00:00')?(date("g:i", strtotime($emp["horasalida"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                }    
                                $html .='</tr>';   
                            }else{
                                $fechadia=$dialetra;
                                $html .='<tr>'; 
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .='</tr>'; 
                            }
                        }else{
                            switch ($fechadia) {
                             case 'Martes':
                                $html .= '<tr>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >Miercoles</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .='</tr>'; 
                                $html .= '<tr>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >Jueves</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .='</tr>'; 
                                $html .= '<tr>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >Viernes</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .='</tr>'; 
                                $html .= '<tr>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >Sabado</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .='</tr>'; 
                                break;
                            case 'Miercoles':
                                $html .= '<tr>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >Jueves</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .='</tr>'; 
                                $html .= '<tr>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >Viernes</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .='</tr>'; 
                                $html .= '<tr>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >Sabado</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .='</tr>'; 
                                break;
                            case 'Jueves':
                                $html .= '<tr>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >Viernes</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .='</tr>'; 
                                $html .= '<tr>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >Sabado</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .='</tr>'; 
                                break;
                            case 'Viernes':
                                $html .= '<tr>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >Sabado</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .='</tr>'; 
                                break;
                            }
                             if (in_array($fecha,$semana)) {
                                $fechadia=$dialetra;
                                $html .= '<tr>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >'.mb_convert_case($dialetra,MB_CASE_TITLE, "UTF-8").' - '.mb_convert_case($fechafor,MB_CASE_TITLE, "UTF-8").'</font></td>';
                                $ficherohora='./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoentrada"]).'';
                                if (file_exists($ficherohora)){
                                    if($emp["fotoentrada"]==null){
                                        $html .='<td  align=center><font size="10" >'.mb_convert_case($hora,MB_CASE_TITLE, "UTF-8").'</font></td>';
                                    }else{
                                        $html .='<td  align=center><font size="10" ><img WIDTH="50" HEIGHT="50" src="./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoentrada"]).'"/>'.mb_convert_case($hora,MB_CASE_TITLE, "UTF-8").'</font></td>';
                                    } 
                                }else{
                                   $html .='<td  align=center><font size="10" >'.mb_convert_case($hora,MB_CASE_TITLE, "UTF-8").'</font></td>';  
                                }       
                                $html .='<td>'.((($emp["tiemporetardo"]>'00:16:00')?(($horas>0)?$horas.' hora'.(($horas>1)?'s':''):'').(($minutos>0)?' '.$minutos.'min.':''):'')).'</td>';
                                $ficheroalmsal='./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoalmuerzosal"]).'';
                                if (file_exists($ficheroalmsal)){
                                    if($emp["fotoalmuerzosal"]==null){
                                        $html .='<td>'.mb_convert_case((($emp["almuerzosalida"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzosalida"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                    }else{
                                        $html .='<td  align=center><font size="10" ><img WIDTH="50" HEIGHT="50" src="./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoalmuerzosal"]).'"/>'.mb_convert_case((($emp["almuerzosalida"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzosalida"]))):''),MB_CASE_TITLE, "UTF-8").'</font></td>';
                                    } 
                                }else{
                                   $html .='<td>'.mb_convert_case((($emp["almuerzosalida"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzosalida"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                } 
                                $ficheroalment='./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoalmuerzoent"]).'';
                                if (file_exists($ficheroalment)){
                                    if($emp["fotoalmuerzoent"]==null){
                                        $html .='<td>'.mb_convert_case((($emp["almuerzoentrada"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzoentrada"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                    }else{
                                        $html .='<td  align=center><font size="10" ><img WIDTH="50" HEIGHT="50" src="./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoalmuerzoent"]).'"/>'.mb_convert_case((($emp["almuerzoentrada"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzoentrada"]))):''),MB_CASE_TITLE, "UTF-8").'</font></td>';
                                    } 
                                }else{
                                   $html .='<td>'.mb_convert_case((($emp["almuerzoentrada"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzoentrada"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                } 
                                $ficherosalida='./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotosalida"]).'';
                                if (file_exists($ficherosalida)){
                                    if($emp["fotosalida"]==null){
                                       $html .='<td>'.mb_convert_case((($emp["horasalida"]>'00:00:00')?(date("g:i", strtotime($emp["horasalida"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                    }else{
                                        $html .='<td  align=center><font size="10" ><img WIDTH="50" HEIGHT="50" src="./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotosalida"]).'"/>'.mb_convert_case((($emp["horasalida"]>'00:00:00')?(date("g:i", strtotime($emp["horasalida"]))):''),MB_CASE_TITLE, "UTF-8").'</font></td>';
                                    } 
                                }else{
                                   $html .='<td>'.mb_convert_case((($emp["horasalida"]>'00:00:00')?(date("g:i", strtotime($emp["horasalida"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                }    
                                $html .='</tr>';   
                            }else{
                                $fechadia=$dialetra;
                                $html .='<tr>'; 
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .='</tr>'; 
                            }
                        }
                    }else{
                        if ($dialetra=='Martes') {
                            $retardo=$emp["tiemporetardo"]; 
                            $partes=explode(':',$retardo); 
                            $horas=(int)$partes[0];
                            $minutos=$partes[1];  
                            if ($fechadia=='Lunes'){
                                if (in_array($fecha,$semana)) {
                                    $fechadia=$dialetra;
                                    $html .= '<tr>';
                                    $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >'.mb_convert_case($dialetra,MB_CASE_TITLE, "UTF-8").' - '.mb_convert_case($fechafor,MB_CASE_TITLE, "UTF-8").'</font></td>';
                                    $ficherohora='./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoentrada"]).'';
                                    if (file_exists($ficherohora)){
                                        if($emp["fotoentrada"]==null){
                                            $html .='<td  align=center><font size="10" >'.mb_convert_case($hora,MB_CASE_TITLE, "UTF-8").'</font></td>';
                                        }else{
                                            $html .='<td  align=center><font size="10" ><img WIDTH="50" HEIGHT="50" src="./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoentrada"]).'"/>'.mb_convert_case($hora,MB_CASE_TITLE, "UTF-8").'</font></td>';
                                        } 
                                    }else{
                                       $html .='<td  align=center><font size="10" >'.mb_convert_case($hora,MB_CASE_TITLE, "UTF-8").'</font></td>';  
                                    }       
                                    $html .='<td>'.((($emp["tiemporetardo"]>'00:16:00')?(($horas>0)?$horas.' hora'.(($horas>1)?'s':''):'').(($minutos>0)?' '.$minutos.'min.':''):'')).'</td>';
                                    $ficheroalmsal='./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoalmuerzosal"]).'';
                                    if (file_exists($ficheroalmsal)){
                                        if($emp["fotoalmuerzosal"]==null){
                                            $html .='<td>'.mb_convert_case((($emp["almuerzosalida"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzosalida"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                        }else{
                                            $html .='<td  align=center><font size="10" ><img WIDTH="50" HEIGHT="50" src="./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoalmuerzosal"]).'"/>'.mb_convert_case((($emp["almuerzosalida"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzosalida"]))):''),MB_CASE_TITLE, "UTF-8").'</font></td>';
                                        } 
                                    }else{
                                       $html .='<td>'.mb_convert_case((($emp["almuerzosalida"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzosalida"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                    } 
                                    $ficheroalment='./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoalmuerzoent"]).'';
                                    if (file_exists($ficheroalment)){
                                        if($emp["fotoalmuerzoent"]==null){
                                            $html .='<td>'.mb_convert_case((($emp["almuerzoentrada"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzoentrada"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                        }else{
                                            $html .='<td  align=center><font size="10" ><img WIDTH="50" HEIGHT="50" src="./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoalmuerzoent"]).'"/>'.mb_convert_case((($emp["almuerzoentrada"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzoentrada"]))):''),MB_CASE_TITLE, "UTF-8").'</font></td>';
                                        } 
                                    }else{
                                       $html .='<td>'.mb_convert_case((($emp["almuerzoentrada"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzoentrada"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                    } 
                                    $ficherosalida='./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotosalida"]).'';
                                    if (file_exists($ficherosalida)){
                                        if($emp["fotosalida"]==null){
                                           $html .='<td>'.mb_convert_case((($emp["horasalida"]>'00:00:00')?(date("g:i", strtotime($emp["horasalida"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                        }else{
                                            $html .='<td  align=center><font size="10" ><img WIDTH="50" HEIGHT="50" src="./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotosalida"]).'"/>'.mb_convert_case((($emp["horasalida"]>'00:00:00')?(date("g:i", strtotime($emp["horasalida"]))):''),MB_CASE_TITLE, "UTF-8").'</font></td>';
                                        } 
                                    }else{
                                       $html .='<td>'.mb_convert_case((($emp["horasalida"]>'00:00:00')?(date("g:i", strtotime($emp["horasalida"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                    }    
                                    $html .='</tr>';   
                                }
                            }else{
                                $fechadia=$dialetra;
                                $html .='<tr>'; 
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >Lunes</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                $html .='</tr>'; 
                                $html .= '<tr>';
                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >'.mb_convert_case($dialetra,MB_CASE_TITLE, "UTF-8").' - '.mb_convert_case($fechafor,MB_CASE_TITLE, "UTF-8").'</font></td>';
                                $ficherohora='./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoentrada"]).'';
                                if (file_exists($ficherohora)){
                                    if($emp["fotoentrada"]==null){
                                        $html .='<td  align=center><font size="10" >'.mb_convert_case($hora,MB_CASE_TITLE, "UTF-8").'</font></td>';
                                    }else{
                                        $html .='<td  align=center><font size="10" ><img WIDTH="50" HEIGHT="50" src="./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoentrada"]).'"/>'.mb_convert_case($hora,MB_CASE_TITLE, "UTF-8").'</font></td>';
                                    } 
                                }else{
                                   $html .='<td  align=center><font size="10" >'.mb_convert_case($hora,MB_CASE_TITLE, "UTF-8").'</font></td>';  
                                }       
                                $html .='<td>'.((($emp["tiemporetardo"]>'00:16:00')?(($horas>0)?$horas.' hora'.(($horas>1)?'s':''):'').(($minutos>0)?' '.$minutos.'min.':''):'')).'</td>';
                                $ficheroalmsal='./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoalmuerzosal"]).'';
                                if (file_exists($ficheroalmsal)){
                                    if($emp["fotoalmuerzosal"]==null){
                                        $html .='<td>'.mb_convert_case((($emp["almuerzosalida"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzosalida"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                    }else{
                                        $html .='<td  align=center><font size="10" ><img WIDTH="50" HEIGHT="50" src="./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoalmuerzosal"]).'"/>'.mb_convert_case((($emp["almuerzosalida"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzosalida"]))):''),MB_CASE_TITLE, "UTF-8").'</font></td>';
                                    } 
                                }else{
                                   $html .='<td>'.mb_convert_case((($emp["almuerzosalida"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzosalida"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                } 
                                $ficheroalment='./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoalmuerzoent"]).'';
                                if (file_exists($ficheroalment)){
                                    if($emp["fotoalmuerzoent"]==null){
                                        $html .='<td>'.mb_convert_case((($emp["almuerzoentrada"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzoentrada"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                    }else{
                                        $html .='<td  align=center><font size="10" ><img WIDTH="50" HEIGHT="50" src="./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoalmuerzoent"]).'"/>'.mb_convert_case((($emp["almuerzoentrada"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzoentrada"]))):''),MB_CASE_TITLE, "UTF-8").'</font></td>';
                                    } 
                                }else{
                                   $html .='<td>'.mb_convert_case((($emp["almuerzoentrada"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzoentrada"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                } 
                                $ficherosalida='./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotosalida"]).'';
                                if (file_exists($ficherosalida)){
                                    if($emp["fotosalida"]==null){
                                       $html .='<td>'.mb_convert_case((($emp["horasalida"]>'00:00:00')?(date("g:i", strtotime($emp["horasalida"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                    }else{
                                        $html .='<td  align=center><font size="10" ><img WIDTH="50" HEIGHT="50" src="./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotosalida"]).'"/>'.mb_convert_case((($emp["horasalida"]>'00:00:00')?(date("g:i", strtotime($emp["horasalida"]))):''),MB_CASE_TITLE, "UTF-8").'</font></td>';
                                    } 
                                }else{
                                   $html .='<td>'.mb_convert_case((($emp["horasalida"]>'00:00:00')?(date("g:i", strtotime($emp["horasalida"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                }    
                                $html .='</tr>';   
                            } 
                        }else{

                            if ($dialetra=='Miercoles') {
                                if ($fechadia=='Martes'){
                                $retardo=$emp["tiemporetardo"]; 
                                $partes=explode(':',$retardo); 
                                $horas=(int)$partes[0];
                                $minutos=$partes[1]; 
                                    if (in_array($fecha,$semana)) {
                                        $fechadia=$dialetra;
                                        $html .= '<tr>';
                                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >'.mb_convert_case($dialetra,MB_CASE_TITLE, "UTF-8").' - '.mb_convert_case($fechafor,MB_CASE_TITLE, "UTF-8").'</font></td>';
                                        $ficherohora='./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoentrada"]).'';
                                        if (file_exists($ficherohora)){
                                            if($emp["fotoentrada"]==null){
                                                $html .='<td  align=center><font size="10" >'.mb_convert_case($hora,MB_CASE_TITLE, "UTF-8").'</font></td>';
                                            }else{
                                                $html .='<td  align=center><font size="10" ><img WIDTH="50" HEIGHT="50" src="./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoentrada"]).'"/>'.mb_convert_case($hora,MB_CASE_TITLE, "UTF-8").'</font></td>';
                                            } 
                                        }else{
                                           $html .='<td  align=center><font size="10" >'.mb_convert_case($hora,MB_CASE_TITLE, "UTF-8").'</font></td>';  
                                        }       
                                        $html .='<td>'.((($emp["tiemporetardo"]>'00:16:00')?(($horas>0)?$horas.' hora'.(($horas>1)?'s':''):'').(($minutos>0)?' '.$minutos.'min.':''):'')).'</td>';
                                        $ficheroalmsal='./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoalmuerzosal"]).'';
                                        if (file_exists($ficheroalmsal)){
                                            if($emp["fotoalmuerzosal"]==null){
                                                $html .='<td>'.mb_convert_case((($emp["almuerzosalida"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzosalida"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                            }else{
                                                $html .='<td  align=center><font size="10" ><img WIDTH="50" HEIGHT="50" src="./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoalmuerzosal"]).'"/>'.mb_convert_case((($emp["almuerzosalida"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzosalida"]))):''),MB_CASE_TITLE, "UTF-8").'</font></td>';
                                            } 
                                        }else{
                                           $html .='<td>'.mb_convert_case((($emp["almuerzosalida"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzosalida"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                        } 
                                        $ficheroalment='./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoalmuerzoent"]).'';
                                        if (file_exists($ficheroalment)){
                                            if($emp["fotoalmuerzoent"]==null){
                                                $html .='<td>'.mb_convert_case((($emp["almuerzoentrada"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzoentrada"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                            }else{
                                                $html .='<td  align=center><font size="10" ><img WIDTH="50" HEIGHT="50" src="./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoalmuerzoent"]).'"/>'.mb_convert_case((($emp["almuerzoentrada"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzoentrada"]))):''),MB_CASE_TITLE, "UTF-8").'</font></td>';
                                            } 
                                        }else{
                                           $html .='<td>'.mb_convert_case((($emp["almuerzoentrada"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzoentrada"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                        } 
                                        $ficherosalida='./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotosalida"]).'';
                                        if (file_exists($ficherosalida)){
                                            if($emp["fotosalida"]==null){
                                               $html .='<td>'.mb_convert_case((($emp["horasalida"]>'00:00:00')?(date("g:i", strtotime($emp["horasalida"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                            }else{
                                                $html .='<td  align=center><font size="10" ><img WIDTH="50" HEIGHT="50" src="./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotosalida"]).'"/>'.mb_convert_case((($emp["horasalida"]>'00:00:00')?(date("g:i", strtotime($emp["horasalida"]))):''),MB_CASE_TITLE, "UTF-8").'</font></td>';
                                            } 
                                        }else{
                                           $html .='<td>'.mb_convert_case((($emp["horasalida"]>'00:00:00')?(date("g:i", strtotime($emp["horasalida"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                        }    
                                        $html .='</tr>';   
                                    }
                                }else{
                                    $fechadia=$dialetra;
                                    $html .='<tr>'; 
                                    $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >Martes</font></td>';
                                    $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                    $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                    $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                    $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                    $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                    $html .='</tr>'; 
                                    $fechadia=$dialetra;
                                    $html .= '<tr>';
                                    $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >'.mb_convert_case($dialetra,MB_CASE_TITLE, "UTF-8").' - '.mb_convert_case($fechafor,MB_CASE_TITLE, "UTF-8").'</font></td>';
                                    $ficherohora='./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoentrada"]).'';
                                    if (file_exists($ficherohora)){
                                        if($emp["fotoentrada"]==null){
                                            $html .='<td  align=center><font size="10" >'.mb_convert_case($hora,MB_CASE_TITLE, "UTF-8").'</font></td>';
                                        }else{
                                            $html .='<td  align=center><font size="10" ><img WIDTH="50" HEIGHT="50" src="./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoentrada"]).'"/>'.mb_convert_case($hora,MB_CASE_TITLE, "UTF-8").'</font></td>';
                                        } 
                                    }else{
                                       $html .='<td  align=center><font size="10" >'.mb_convert_case($hora,MB_CASE_TITLE, "UTF-8").'</font></td>';  
                                    }       
                                    $html .='<td>'.((($emp["tiemporetardo"]>'00:16:00')?(($horas>0)?$horas.' hora'.(($horas>1)?'s':''):'').(($minutos>0)?' '.$minutos.'min.':''):'')).'</td>';
                                    $ficheroalmsal='./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoalmuerzosal"]).'';
                                    if (file_exists($ficheroalmsal)){
                                        if($emp["fotoalmuerzosal"]==null){
                                            $html .='<td>'.mb_convert_case((($emp["almuerzosalida"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzosalida"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                        }else{
                                            $html .='<td  align=center><font size="10" ><img WIDTH="50" HEIGHT="50" src="./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoalmuerzosal"]).'"/>'.mb_convert_case((($emp["almuerzosalida"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzosalida"]))):''),MB_CASE_TITLE, "UTF-8").'</font></td>';
                                        } 
                                    }else{
                                       $html .='<td>'.mb_convert_case((($emp["almuerzosalida"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzosalida"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                    } 
                                    $ficheroalment='./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoalmuerzoent"]).'';
                                    if (file_exists($ficheroalment)){
                                        if($emp["fotoalmuerzoent"]==null){
                                            $html .='<td>'.mb_convert_case((($emp["almuerzoentrada"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzoentrada"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                        }else{
                                            $html .='<td  align=center><font size="10" ><img WIDTH="50" HEIGHT="50" src="./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoalmuerzoent"]).'"/>'.mb_convert_case((($emp["almuerzoentrada"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzoentrada"]))):''),MB_CASE_TITLE, "UTF-8").'</font></td>';
                                        } 
                                    }else{
                                       $html .='<td>'.mb_convert_case((($emp["almuerzoentrada"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzoentrada"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                    } 
                                    $ficherosalida='./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotosalida"]).'';
                                    if (file_exists($ficherosalida)){
                                        if($emp["fotosalida"]==null){
                                           $html .='<td>'.mb_convert_case((($emp["horasalida"]>'00:00:00')?(date("g:i", strtotime($emp["horasalida"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                        }else{
                                            $html .='<td  align=center><font size="10" ><img WIDTH="50" HEIGHT="50" src="./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotosalida"]).'"/>'.mb_convert_case((($emp["horasalida"]>'00:00:00')?(date("g:i", strtotime($emp["horasalida"]))):''),MB_CASE_TITLE, "UTF-8").'</font></td>';
                                        } 
                                    }else{
                                       $html .='<td>'.mb_convert_case((($emp["horasalida"]>'00:00:00')?(date("g:i", strtotime($emp["horasalida"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                    }    
                                    $html .='</tr>';   
                                }
                            }else{
                                if ($dialetra=='Jueves') {
                                    $retardo=$emp["tiemporetardo"]; 
                                    $partes=explode(':',$retardo); 
                                    $horas=(int)$partes[0];
                                    $minutos=$partes[1]; 
                                    if ($fechadia=='Miercoles'){
                                        if (in_array($fecha,$semana)) {
                                            $fechadia=$dialetra;
                                            $html .= '<tr>';
                                            $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >'.mb_convert_case($dialetra,MB_CASE_TITLE, "UTF-8").' - '.mb_convert_case($fechafor,MB_CASE_TITLE, "UTF-8").'</font></td>';
                                            $ficherohora='./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoentrada"]).'';
                                        if (file_exists($ficherohora)){
                                            if($emp["fotoentrada"]==null){
                                                $html .='<td  align=center><font size="10" >'.mb_convert_case($hora,MB_CASE_TITLE, "UTF-8").'</font></td>';
                                            }else{
                                                $html .='<td  align=center><font size="10" ><img WIDTH="50" HEIGHT="50" src="./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoentrada"]).'"/>'.mb_convert_case($hora,MB_CASE_TITLE, "UTF-8").'</font></td>';
                                            } 
                                        }else{
                                           $html .='<td  align=center><font size="10" >'.mb_convert_case($hora,MB_CASE_TITLE, "UTF-8").'</font></td>';  
                                        }       
                                            $html .='<td>'.((($emp["tiemporetardo"]>'00:16:00')?(($horas>0)?$horas.' hora'.(($horas>1)?'s':''):'').(($minutos>0)?' '.$minutos.'min.':''):'')).'</td>';
                                            $ficheroalmsal='./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoalmuerzosal"]).'';
                                            if (file_exists($ficheroalmsal)){
                                                if($emp["fotoalmuerzosal"]==null){
                                                    $html .='<td>'.mb_convert_case((($emp["almuerzosalida"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzosalida"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                                }else{
                                                    $html .='<td  align=center><font size="10" ><img WIDTH="50" HEIGHT="50" src="./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoalmuerzosal"]).'"/>'.mb_convert_case((($emp["almuerzosalida"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzosalida"]))):''),MB_CASE_TITLE, "UTF-8").'</font></td>';
                                                } 
                                            }else{
                                               $html .='<td>'.mb_convert_case((($emp["almuerzosalida"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzosalida"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                            } 
                                            $ficheroalment='./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoalmuerzoent"]).'';
                                            if (file_exists($ficheroalment)){
                                                if($emp["fotoalmuerzoent"]==null){
                                                    $html .='<td>'.mb_convert_case((($emp["almuerzoentrada"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzoentrada"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                                }else{
                                                    $html .='<td  align=center><font size="10" ><img WIDTH="50" HEIGHT="50" src="./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoalmuerzoent"]).'"/>'.mb_convert_case((($emp["almuerzoentrada"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzoentrada"]))):''),MB_CASE_TITLE, "UTF-8").'</font></td>';
                                                } 
                                            }else{
                                               $html .='<td>'.mb_convert_case((($emp["almuerzoentrada"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzoentrada"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                            } 
                                            $ficherosalida='./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotosalida"]).'';
                                            if (file_exists($ficherosalida)){
                                                if($emp["fotosalida"]==null){
                                                   $html .='<td>'.mb_convert_case((($emp["horasalida"]>'00:00:00')?(date("g:i", strtotime($emp["horasalida"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                                }else{
                                                    $html .='<td  align=center><font size="10" ><img WIDTH="50" HEIGHT="50" src="./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotosalida"]).'"/>'.mb_convert_case((($emp["horasalida"]>'00:00:00')?(date("g:i", strtotime($emp["horasalida"]))):''),MB_CASE_TITLE, "UTF-8").'</font></td>';
                                                } 
                                            }else{
                                               $html .='<td>'.mb_convert_case((($emp["horasalida"]>'00:00:00')?(date("g:i", strtotime($emp["horasalida"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                            }    
                                            $html .='</tr>'; 
                                        }
                                    }else{
                                        $fechadia=$dialetra;
                                        $html .='<tr>'; 
                                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >Miercoles</font></td>';
                                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                        $html .='</tr>'; 
                                        $html .= '<tr>';
                                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >'.mb_convert_case($dialetra,MB_CASE_TITLE, "UTF-8").' - '.mb_convert_case($fechafor,MB_CASE_TITLE, "UTF-8").'</font></td>';
                                        $ficherohora='./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoentrada"]).'';
                                        if (file_exists($ficherohora)){
                                            if($emp["fotoentrada"]==null){
                                                $html .='<td  align=center><font size="10" >'.mb_convert_case($hora,MB_CASE_TITLE, "UTF-8").'</font></td>';
                                            }else{
                                                $html .='<td  align=center><font size="10" ><img WIDTH="50" HEIGHT="50" src="./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoentrada"]).'"/>'.mb_convert_case($hora,MB_CASE_TITLE, "UTF-8").'</font></td>';
                                            } 
                                        }else{
                                           $html .='<td  align=center><font size="10" >'.mb_convert_case($hora,MB_CASE_TITLE, "UTF-8").'</font></td>';  
                                        }       
                                        $html .='<td>'.((($emp["tiemporetardo"]>'00:16:00')?(($horas>0)?$horas.' hora'.(($horas>1)?'s':''):'').(($minutos>0)?' '.$minutos.'min.':''):'')).'</td>';
                                        $ficheroalmsal='./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoalmuerzosal"]).'';
                                        if (file_exists($ficheroalmsal)){
                                            if($emp["fotoalmuerzosal"]==null){
                                                $html .='<td>'.mb_convert_case((($emp["almuerzosalida"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzosalida"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                            }else{
                                                $html .='<td  align=center><font size="10" ><img WIDTH="50" HEIGHT="50" src="./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoalmuerzosal"]).'"/>'.mb_convert_case((($emp["almuerzosalida"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzosalida"]))):''),MB_CASE_TITLE, "UTF-8").'</font></td>';
                                            } 
                                        }else{
                                           $html .='<td>'.mb_convert_case((($emp["almuerzosalida"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzosalida"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                        } 
                                        $ficheroalment='./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoalmuerzoent"]).'';
                                        if (file_exists($ficheroalment)){
                                            if($emp["fotoalmuerzoent"]==null){
                                                $html .='<td>'.mb_convert_case((($emp["almuerzoentrada"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzoentrada"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                            }else{
                                                $html .='<td  align=center><font size="10" ><img WIDTH="50" HEIGHT="50" src="./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoalmuerzoent"]).'"/>'.mb_convert_case((($emp["almuerzoentrada"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzoentrada"]))):''),MB_CASE_TITLE, "UTF-8").'</font></td>';
                                            } 
                                        }else{
                                           $html .='<td>'.mb_convert_case((($emp["almuerzoentrada"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzoentrada"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                        } 
                                        $ficherosalida='./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotosalida"]).'';
                                        if (file_exists($ficherosalida)){
                                            if($emp["fotosalida"]==null){
                                               $html .='<td>'.mb_convert_case((($emp["horasalida"]>'00:00:00')?(date("g:i", strtotime($emp["horasalida"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                            }else{
                                                $html .='<td  align=center><font size="10" ><img WIDTH="50" HEIGHT="50" src="./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotosalida"]).'"/>'.mb_convert_case((($emp["horasalida"]>'00:00:00')?(date("g:i", strtotime($emp["horasalida"]))):''),MB_CASE_TITLE, "UTF-8").'</font></td>';
                                            } 
                                        }else{
                                           $html .='<td>'.mb_convert_case((($emp["horasalida"]>'00:00:00')?(date("g:i", strtotime($emp["horasalida"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                        }    
                                        $html .='</tr>'; 
                                    }
                                }else{
                                    if ($dialetra=='Viernes') {
                                        $retardo=$emp["tiemporetardo"]; 
                                        $partes=explode(':',$retardo); 
                                        $horas=(int)$partes[0];
                                        $minutos=$partes[1]; 
                                        if ($fechadia=='Jueves'){
                                            if (in_array($fecha,$semana)) {
                                                $fechadia=$dialetra;
                                                $html .='<tr>';
                                                $html .='<td bgcolor= "#DFDFDF" align=center><font size="10" >'.mb_convert_case($dialetra,MB_CASE_TITLE, "UTF-8").' - '.mb_convert_case($fechafor,MB_CASE_TITLE, "UTF-8").'</font></td>';
                                                $ficherohora='./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoentrada"]).'';
                                                if (file_exists($ficherohora)){
                                                    if($emp["fotoentrada"]==null){
                                                        $html .='<td  align=center><font size="10" >'.mb_convert_case($hora,MB_CASE_TITLE, "UTF-8").'</font></td>';
                                                    }else{
                                                        $html .='<td  align=center><font size="10" ><img WIDTH="50" HEIGHT="50" src="./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoentrada"]).'"/>'.mb_convert_case($hora,MB_CASE_TITLE, "UTF-8").'</font></td>';
                                                    } 
                                                }else{
                                                   $html .='<td  align=center><font size="10" >'.mb_convert_case($hora,MB_CASE_TITLE, "UTF-8").'</font></td>';  
                                                }       
                                                $html .='<td>'.((($emp["tiemporetardo"]>'00:16:00')?(($horas>0)?$horas.' hora'.(($horas>1)?'s':''):'').(($minutos>0)?' '.$minutos.'min.':''):'')).'</td>';
                                                $ficheroalmsal='./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoalmuerzosal"]).'';
                                                if (file_exists($ficheroalmsal)){
                                                    if($emp["fotoalmuerzosal"]==null){
                                                        $html .='<td>'.mb_convert_case((($emp["almuerzosalida"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzosalida"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                                    }else{
                                                        $html .='<td  align=center><font size="10" ><img WIDTH="50" HEIGHT="50" src="./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoalmuerzosal"]).'"/>'.mb_convert_case((($emp["almuerzosalida"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzosalida"]))):''),MB_CASE_TITLE, "UTF-8").'</font></td>';
                                                    } 
                                                }else{
                                                   $html .='<td>'.mb_convert_case((($emp["almuerzosalida"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzosalida"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                                } 
                                                $ficheroalment='./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoalmuerzoent"]).'';
                                                if (file_exists($ficheroalment)){
                                                    if($emp["fotoalmuerzoent"]==null){
                                                        $html .='<td>'.mb_convert_case((($emp["almuerzoentrada"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzoentrada"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                                    }else{
                                                        $html .='<td  align=center><font size="10" ><img WIDTH="50" HEIGHT="50" src="./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoalmuerzoent"]).'"/>'.mb_convert_case((($emp["almuerzoentrada"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzoentrada"]))):''),MB_CASE_TITLE, "UTF-8").'</font></td>';
                                                    } 
                                                }else{
                                                   $html .='<td>'.mb_convert_case((($emp["almuerzoentrada"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzoentrada"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                                } 
                                                $ficherosalida='./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotosalida"]).'';
                                                if (file_exists($ficherosalida)){
                                                    if($emp["fotosalida"]==null){
                                                       $html .='<td>'.mb_convert_case((($emp["horasalida"]>'00:00:00')?(date("g:i", strtotime($emp["horasalida"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                                    }else{
                                                        $html .='<td  align=center><font size="10" ><img WIDTH="50" HEIGHT="50" src="./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotosalida"]).'"/>'.mb_convert_case((($emp["horasalida"]>'00:00:00')?(date("g:i", strtotime($emp["horasalida"]))):''),MB_CASE_TITLE, "UTF-8").'</font></td>';
                                                    } 
                                                }else{
                                                   $html .='<td>'.mb_convert_case((($emp["horasalida"]>'00:00:00')?(date("g:i", strtotime($emp["horasalida"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                                }    
                                                $html .='</tr>'; 
                                            }
                                        }else{
                                            $fechadia=$dialetra;
                                            $html .='<tr>'; 
                                            $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >Jueves</font></td>';
                                            $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                            $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                            $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                            $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                            $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                            $html .='</tr>'; 
                                            $html .= '<tr>';
                                            $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >'.mb_convert_case($dialetra,MB_CASE_TITLE, "UTF-8").' - '.mb_convert_case($fechafor,MB_CASE_TITLE, "UTF-8").'</font></td>';
                                            $ficherohora='./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoentrada"]).'';
                                            if (file_exists($ficherohora)){
                                                if($emp["fotoentrada"]==null){
                                                    $html .='<td  align=center><font size="10" >'.mb_convert_case($hora,MB_CASE_TITLE, "UTF-8").'</font></td>';
                                                }else{
                                                    $html .='<td  align=center><font size="10" ><img WIDTH="50" HEIGHT="50" src="./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoentrada"]).'"/>'.mb_convert_case($hora,MB_CASE_TITLE, "UTF-8").'</font></td>';
                                                } 
                                            }else{
                                               $html .='<td  align=center><font size="10" >'.mb_convert_case($hora,MB_CASE_TITLE, "UTF-8").'</font></td>';  
                                            }       
                                            $html .='<td>'.((($emp["tiemporetardo"]>'00:16:00')?(($horas>0)?$horas.' hora'.(($horas>1)?'s':''):'').(($minutos>0)?' '.$minutos.'min.':''):'')).'</td>';
                                            $ficheroalmsal='./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoalmuerzosal"]).'';
                                            if (file_exists($ficheroalmsal)){
                                                if($emp["fotoalmuerzosal"]==null){
                                                    $html .='<td>'.mb_convert_case((($emp["almuerzosalida"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzosalida"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                                }else{
                                                    $html .='<td  align=center><font size="10" ><img WIDTH="50" HEIGHT="50" src="./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoalmuerzosal"]).'"/>'.mb_convert_case((($emp["almuerzosalida"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzosalida"]))):''),MB_CASE_TITLE, "UTF-8").'</font></td>';
                                                } 
                                            }else{
                                               $html .='<td>'.mb_convert_case((($emp["almuerzosalida"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzosalida"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                            } 
                                            $ficheroalment='./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoalmuerzoent"]).'';
                                            if (file_exists($ficheroalment)){
                                                if($emp["fotoalmuerzoent"]==null){
                                                    $html .='<td>'.mb_convert_case((($emp["almuerzoentrada"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzoentrada"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                                }else{
                                                    $html .='<td  align=center><font size="10" ><img WIDTH="50" HEIGHT="50" src="./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoalmuerzoent"]).'"/>'.mb_convert_case((($emp["almuerzoentrada"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzoentrada"]))):''),MB_CASE_TITLE, "UTF-8").'</font></td>';
                                                } 
                                            }else{
                                               $html .='<td>'.mb_convert_case((($emp["almuerzoentrada"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzoentrada"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                            } 
                                            $ficherosalida='./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotosalida"]).'';
                                            if (file_exists($ficherosalida)){
                                                if($emp["fotosalida"]==null){
                                                   $html .='<td>'.mb_convert_case((($emp["horasalida"]>'00:00:00')?(date("g:i", strtotime($emp["horasalida"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                                }else{
                                                    $html .='<td  align=center><font size="10" ><img WIDTH="50" HEIGHT="50" src="./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotosalida"]).'"/>'.mb_convert_case((($emp["horasalida"]>'00:00:00')?(date("g:i", strtotime($emp["horasalida"]))):''),MB_CASE_TITLE, "UTF-8").'</font></td>';
                                                } 
                                            }else{
                                               $html .='<td>'.mb_convert_case((($emp["horasalida"]>'00:00:00')?(date("g:i", strtotime($emp["horasalida"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                            }    
                                            $html .='</tr>'; 
                                        }
                                    }else{
                                        if ($dialetra=='Sabado') {
                                            $retardo=$emp["tiemporetardo"]; 
                                            $partes=explode(':',$retardo); 
                                            $horas=(int)$partes[0];
                                            $minutos=$partes[1]; 
                                            if ($fechadia=='Viernes'){
                                                if (in_array($fecha,$semana)) {
                                                    $fechadia=$dialetra;
                                                    $html .= '<tr>';
                                                    $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >'.mb_convert_case($dialetra,MB_CASE_TITLE, "UTF-8").' - '.mb_convert_case($fechafor,MB_CASE_TITLE, "UTF-8").'</font></td>';
                                                    $ficherohora='./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoentrada"]).'';
                                                    if (file_exists($ficherohora)){
                                                        if($emp["fotoentrada"]==null){
                                                            $html .='<td  align=center><font size="10" >'.mb_convert_case($hora,MB_CASE_TITLE, "UTF-8").'</font></td>';
                                                        }else{
                                                            $html .='<td  align=center><font size="10" ><img WIDTH="50" HEIGHT="50" src="./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoentrada"]).'"/>'.mb_convert_case($hora,MB_CASE_TITLE, "UTF-8").'</font></td>';
                                                        } 
                                                    }else{
                                                       $html .='<td  align=center><font size="10" >'.mb_convert_case($hora,MB_CASE_TITLE, "UTF-8").'</font></td>';  
                                                    }       
                                                    $html .='<td>'.((($emp["tiemporetardo"]>'00:16:00')?(($horas>0)?$horas.' hora'.(($horas>1)?'s':''):'').(($minutos>0)?' '.$minutos.'min.':''):'')).'</td>';
                                                    $ficheroalmsal='./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoalmuerzosal"]).'';
                                                    if (file_exists($ficheroalmsal)){
                                                        if($emp["fotoalmuerzosal"]==null){
                                                            $html .='<td>'.mb_convert_case((($emp["almuerzosalida"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzosalida"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                                        }else{
                                                            $html .='<td  align=center><font size="10" ><img WIDTH="50" HEIGHT="50" src="./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoalmuerzosal"]).'"/>'.mb_convert_case((($emp["almuerzosalida"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzosalida"]))):''),MB_CASE_TITLE, "UTF-8").'</font></td>';
                                                        } 
                                                    }else{
                                                       $html .='<td>'.mb_convert_case((($emp["almuerzosalida"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzosalida"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                                    } 
                                                    $ficheroalment='./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoalmuerzoent"]).'';
                                                    if (file_exists($ficheroalment)){
                                                        if($emp["fotoalmuerzoent"]==null){
                                                            $html .='<td>'.mb_convert_case((($emp["almuerzoentrada"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzoentrada"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                                        }else{
                                                            $html .='<td  align=center><font size="10" ><img WIDTH="50" HEIGHT="50" src="./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoalmuerzoent"]).'"/>'.mb_convert_case((($emp["almuerzoentrada"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzoentrada"]))):''),MB_CASE_TITLE, "UTF-8").'</font></td>';
                                                        } 
                                                    }else{
                                                       $html .='<td>'.mb_convert_case((($emp["almuerzoentrada"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzoentrada"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                                    } 
                                                    $ficherosalida='./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotosalida"]).'';
                                                    if (file_exists($ficherosalida)){
                                                        if($emp["fotosalida"]==null){
                                                           $html .='<td>'.mb_convert_case((($emp["horasalida"]>'00:00:00')?(date("g:i", strtotime($emp["horasalida"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                                        }else{
                                                            $html .='<td  align=center><font size="10" ><img WIDTH="50" HEIGHT="50" src="./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotosalida"]).'"/>'.mb_convert_case((($emp["horasalida"]>'00:00:00')?(date("g:i", strtotime($emp["horasalida"]))):''),MB_CASE_TITLE, "UTF-8").'</font></td>';
                                                        } 
                                                    }else{
                                                       $html .='<td>'.mb_convert_case((($emp["horasalida"]>'00:00:00')?(date("g:i", strtotime($emp["horasalida"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                                    }    
                                                    $html .='</tr>'; 
                                                }
                                            }else{
                                                $fechadia=$dialetra;
                                                $html .='<tr>'; 
                                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >Viernes</font></td>';
                                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                                $html .='</tr>'; 
                                                $html .= '<tr>';
                                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >'.mb_convert_case($dialetra,MB_CASE_TITLE, "UTF-8").' - '.mb_convert_case($fechafor,MB_CASE_TITLE, "UTF-8").'</font></td>';
                                                $ficherohora='./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoentrada"]).'';
                                                if (file_exists($ficherohora)){
                                                    if($emp["fotoentrada"]==null){
                                                        $html .='<td  align=center><font size="10" >'.mb_convert_case($hora,MB_CASE_TITLE, "UTF-8").'</font></td>';
                                                    }else{
                                                        $html .='<td  align=center><font size="10" ><img WIDTH="50" HEIGHT="50" src="./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoentrada"]).'"/>'.mb_convert_case($hora,MB_CASE_TITLE, "UTF-8").'</font></td>';
                                                    } 
                                                }else{
                                                   $html .='<td  align=center><font size="10" >'.mb_convert_case($hora,MB_CASE_TITLE, "UTF-8").'</font></td>';  
                                                }       
                                                $html .='<td>'.((($emp["tiemporetardo"]>'00:16:00')?(($horas>0)?$horas.' hora'.(($horas>1)?'s':''):'').(($minutos>0)?' '.$minutos.'min.':''):'')).'</td>';
                                                $ficheroalmsal='./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoalmuerzosal"]).'';
                                                if (file_exists($ficheroalmsal)){
                                                    if($emp["fotoalmuerzosal"]==null){
                                                        $html .='<td>'.mb_convert_case((($emp["almuerzosalida"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzosalida"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                                    }else{
                                                        $html .='<td  align=center><font size="10" ><img WIDTH="50" HEIGHT="50" src="./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoalmuerzosal"]).'"/>'.mb_convert_case((($emp["almuerzosalida"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzosalida"]))):''),MB_CASE_TITLE, "UTF-8").'</font></td>';
                                                    } 
                                                }else{
                                                   $html .='<td>'.mb_convert_case((($emp["almuerzosalida"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzosalida"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                                } 
                                                $ficheroalment='./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoalmuerzoent"]).'';
                                                if (file_exists($ficheroalment)){
                                                    if($emp["fotoalmuerzoent"]==null){
                                                        $html .='<td>'.mb_convert_case((($emp["almuerzoentrada"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzoentrada"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                                    }else{
                                                        $html .='<td  align=center><font size="10" ><img WIDTH="50" HEIGHT="50" src="./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoalmuerzoent"]).'"/>'.mb_convert_case((($emp["almuerzoentrada"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzoentrada"]))):''),MB_CASE_TITLE, "UTF-8").'</font></td>';
                                                    } 
                                                }else{
                                                   $html .='<td>'.mb_convert_case((($emp["almuerzoentrada"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzoentrada"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                                } 
                                                $ficherosalida='./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotosalida"]).'';
                                                if (file_exists($ficherosalida)){
                                                    if($emp["fotosalida"]==null){
                                                       $html .='<td>'.mb_convert_case((($emp["horasalida"]>'00:00:00')?(date("g:i", strtotime($emp["horasalida"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                                    }else{
                                                        $html .='<td  align=center><font size="10" ><img WIDTH="50" HEIGHT="50" src="./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotosalida"]).'"/>'.mb_convert_case((($emp["horasalida"]>'00:00:00')?(date("g:i", strtotime($emp["horasalida"]))):''),MB_CASE_TITLE, "UTF-8").'</font></td>';
                                                    } 
                                                }else{
                                                   $html .='<td>'.mb_convert_case((($emp["horasalida"]>'00:00:00')?(date("g:i", strtotime($emp["horasalida"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                                }    
                                                $html .='</tr>';   
                                            }    
                                        }else{
                                           if (in_array($fecha,$semana)) {
                                            $retardo=$emp["tiemporetardo"]; 
                                            $partes=explode(':',$retardo); 
                                            $horas=(int)$partes[0];
                                            $minutos=$partes[1]; 
                                                $html .= '<tr>';
                                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >'.mb_convert_case($dialetra,MB_CASE_TITLE, "UTF-8").' - '.mb_convert_case($fechafor,MB_CASE_TITLE, "UTF-8").'</font></td>';
                                                $ficherohora='./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoentrada"]).'';
                                                if (file_exists($ficherohora)){
                                                    if($emp["fotoentrada"]==null){
                                                        $html .='<td  align=center><font size="10" >'.mb_convert_case($hora,MB_CASE_TITLE, "UTF-8").'</font></td>';
                                                    }else{
                                                        $html .='<td  align=center><font size="10" ><img WIDTH="50" HEIGHT="50" src="./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoentrada"]).'"/>'.mb_convert_case($hora,MB_CASE_TITLE, "UTF-8").'</font></td>';
                                                    } 
                                                }else{
                                                   $html .='<td  align=center><font size="10" >'.mb_convert_case($hora,MB_CASE_TITLE, "UTF-8").'</font></td>';  
                                                }       
                                                $html .='<td>'.((($emp["tiemporetardo"]>'00:16:00')?(($horas>0)?$horas.' hora'.(($horas>1)?'s':''):'').(($minutos>0)?' '.$minutos.'min.':''):'')).'</td>';
                                                $ficheroalmsal='./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoalmuerzosal"]).'';
                                                if (file_exists($ficheroalmsal)){
                                                    if($emp["fotoalmuerzosal"]==null){
                                                        $html .='<td>'.mb_convert_case((($emp["almuerzosalida"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzosalida"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                                    }else{
                                                        $html .='<td  align=center><font size="10" ><img WIDTH="50" HEIGHT="50" src="./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoalmuerzosal"]).'"/>'.mb_convert_case((($emp["almuerzosalida"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzosalida"]))):''),MB_CASE_TITLE, "UTF-8").'</font></td>';
                                                    } 
                                                }else{
                                                   $html .='<td>'.mb_convert_case((($emp["almuerzosalida"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzosalida"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                                } 
                                                $ficheroalment='./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoalmuerzoent"]).'';
                                                if (file_exists($ficheroalment)){
                                                    if($emp["fotoalmuerzoent"]==null){
                                                        $html .='<td>'.mb_convert_case((($emp["almuerzoentrada"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzoentrada"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                                    }else{
                                                        $html .='<td  align=center><font size="10" ><img WIDTH="50" HEIGHT="50" src="./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotoalmuerzoent"]).'"/>'.mb_convert_case((($emp["almuerzoentrada"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzoentrada"]))):''),MB_CASE_TITLE, "UTF-8").'</font></td>';
                                                    } 
                                                }else{
                                                   $html .='<td>'.mb_convert_case((($emp["almuerzoentrada"]>'00:00:00')?(date("g:i", strtotime($emp["almuerzoentrada"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                                } 
                                                $ficherosalida='./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotosalida"]).'';
                                                if (file_exists($ficherosalida)){
                                                    if($emp["fotosalida"]==null){
                                                       $html .='<td>'.mb_convert_case((($emp["horasalida"]>'00:00:00')?(date("g:i", strtotime($emp["horasalida"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                                    }else{
                                                        $html .='<td  align=center><font size="10" ><img WIDTH="50" HEIGHT="50" src="./resources/avatars/'.$iddepartamento.'/'.$fecha.'/'.($emp["fotosalida"]).'"/>'.mb_convert_case((($emp["horasalida"]>'00:00:00')?(date("g:i", strtotime($emp["horasalida"]))):''),MB_CASE_TITLE, "UTF-8").'</font></td>';
                                                    } 
                                                }else{
                                                   $html .='<td>'.mb_convert_case((($emp["horasalida"]>'00:00:00')?(date("g:i", strtotime($emp["horasalida"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
                                                }    
                                                $html .='</tr>';   
                                            }else{
                                                $html .='<tr>'; 
                                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >Lunes</font></td>';
                                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                                $html .='</tr>'; 
                                                $html .='<tr>'; 
                                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >Martes</font></td>';
                                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                                $html .='</tr>';
                                                $html .='<tr>';  
                                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >Miercoles</font></td>';
                                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                                $html .='</tr>'; 
                                                $html .='<tr>'; 
                                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >Jueves</font></td>';
                                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                                $html .='</tr>'; 
                                                $html .='<tr>'; 
                                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >Viernes</font></td>';
                                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                                $html .='</tr>';
                                                $html .='<tr>'; 
                                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >Sabado</font></td>';
                                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                                $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                                                $html .='</tr>';
                                            }  
                                        }
                                    }
                                } 
                            } 
                        }
                    } 
                    array_push($asist, $fecha);
                    $cedemp=$emp['cedula']; 
                    $id=$emp['id'];
                    $fecha1=$emp['fecha'];
                    $tiemporet1=$emp['tiemporetardo'];
                    $almuerzosalida1=$emp['almuerzosalida'];
                    $almuerzoentrada1=$emp['almuerzoentrada'];
                    $horasalida1=$emp['horasalida'];
                    $hora1=$emp['horaentrada'];
                    $dialetra1=$dias[date('N', strtotime( $fecha1))];
                }
                switch ($fechadia) {
                    case 'Lunes':
                        $html .='<tr>'; 
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >Martes</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .='</tr>'; 
                        $html .= '<tr>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >Miercoles</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .='</tr>'; 
                        $html .= '<tr>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >Jueves</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .='</tr>'; 
                        $html .= '<tr>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >Viernes</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .='</tr>'; 
                        $html .= '<tr>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >Sabado</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .='</tr>'; 
                        break;
                    case 'Martes':
                        $html .= '<tr>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >Miercoles</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .='</tr>'; 
                        $html .= '<tr>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >Jueves</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .='</tr>'; 
                        $html .= '<tr>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >Viernes</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .='</tr>'; 
                        $html .= '<tr>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >Sabado</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .='</tr>'; 
                        break;
                    case 'Miercoles':
                        $html .= '<tr>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >Jueves</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .='</tr>'; 
                        $html .= '<tr>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >Viernes</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .='</tr>'; 
                        $html .= '<tr>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >Sabado</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .='</tr>'; 
                        break;
                        case 'Jueves':
                        $html .= '<tr>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >Viernes</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .='</tr>'; 
                        $html .= '<tr>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >Sabado</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .='</tr>'; 
                        break;
                    case 'Viernes':
                        $html .= '<tr>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >Sabado</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .= '<td bgcolor= "#DFDFDF" align=center><font size="10" >X</font></td>';
                        $html .='</tr>'; 
                        break;
                    }
                $html .= '</table><p></p><p class="saltodepagina" />';      
            }
            $html .= '<p></p>';
        }else{
            $html = '';
            $html .= "<style type=text/css>";
            $html .= "th{color: #fff; font-weight: bold; background-color: #AAC7E3}";
            $html .= "td{background-color: #fff; color: #222}";
            $html .= "</style>";
            $html .= "<h4>Listado  De Inasistencia del $fechades al $fechades</h4>";
            $html .= "<table width='100%'>";
            $html .= "<tr><th>No hay Inasistencia con las caracteristicas indicadas</th></tr>";           
            $html .= "</table>";
            $nombre_archivo = utf8_decode("Listado Inasistencia.pdf");
        }
        $pdf->writeHTMLCell($w = 0,$h = 0,$x='',$y = '',$html,$border = 0,$ln = 1,$fill = 0,$reseth=true,$align='C',$autopadding= true);
        $pdf->Output($nombre_archivo, 'I');
    }   
    public function semana($fechades,$fechahas,$diasferiados) {
        $fechainicio = strtotime($fechades);
       $fechafin = strtotime($fechahas);
       $diainc = 24*60*60;
       $diashabiles = array();
       for ($midia = $fechainicio; $midia <= $fechafin; $midia += $diainc) {
           if (!in_array(date('N', $midia), array(7))) {
               if (!in_array(date('Y-m-d', $midia), $diasferiados)) {
               array_push($diashabiles, date('Y-m-d', $midia));
               }
           }
       }
       return $diashabiles;
    }
     
}








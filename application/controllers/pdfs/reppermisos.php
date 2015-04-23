<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');
class Reppermisos extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('pdfs/reppermisos_model');
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
    public function generarlistadopermisos() {
        $username = $this->session->userdata('datasession');
        $usuarioced = $username['cedula'];
        $usuariodiv=$this->reppermisos_model->getdivisionusu($usuarioced);
        if($usuariodiv->num_rows>0){
            $row1 = $usuariodiv->row_array();
            $data = array(
                'tipousuario'  => $row1['tipousuario'],
                'divisionusu'  => $row1['divisionusu'],
                'departamento' => $row1['departamento'],
                'nombre'=> $row1['nombre'],
                'cedulausu'=> $row1['cedulaemp'],
                'cargousu'=> $row1['cargoemp']
            );
            $nombreusu=$data['nombre'];
            $cedulausu=$data['cedulausu'];
            $cargousu=$data['cargousu'];
            if ($data['tipousuario']==1 || $data['tipousuario']==6){
              $division=($this->input->get("division")!='null')?'='.$this->input->get("division"):'LIKE "%"';   
            }else{
              $division='='.$data['divisionusu'];
            }
        } 
        $usuariodivision=$data['divisionusu'];
        $asistente=$this->reppermisos_model->getdivisionasis($data['divisionusu']);

        if ($asistente->num_rows>0){
            $row1 = $asistente->row_array();
            $nombreasistente=$row1['nombreasistente'];
            $cedulaasistente=$row1['cedulaasistente'];
            $cargoasistente=$row1['cargoasistente'];
        }
        $nomjefe=$this->reppermisos_model->verificarJefes($data['divisionusu']);

        if ($nomjefe->num_rows>0){
            $row1 = $nomjefe->row_array();
            $nombrejefe=$row1['nombre'];
            $cedulajefe=$row1['cedula'];
            $cargojefe=$row1['cargo'];
        }
        $departamento=$data['departamento'];
        $nomjefedep=$this->reppermisos_model->verificarJefesdep($data['departamento']);
        if ($nomjefedep->num_rows>0){
            $row1 = $nomjefedep->row_array();
            $nombrejefedep=$row1['nombredep'];
            $cedulajefedep=$row1['ceduladep'];
            $cargojefedep=$row1['cargodep'];
            $departamentonombre=$row1['departamentonombre'];
        }
        $tiponomina=($this->input->get("tiponomina" )!='null') ?'=' .$this->input->get("tiponomina"):'LIKE "%"';
        if ($tiponomina<>'LIKE "%"'){
            $tiponomina1=$this->reppermisos_model->gettiponomina1($tiponomina);
            if ($tiponomina1->num_rows>0){
                $row1 = $tiponomina1->row_array();
                $nombrenomina=$row1['nombrenomina'];
            }
        }
        $retardos=($this->input->get("retardos")!='null')?'='.$this->input->get("retardos"):'LIKE "%"';
        $cedula=($this->input->get("cedula" )!='null') ?  "LIKE '%".$this->input->get("cedula")."%'":'LIKE "%"';
        $fechades1=($this->input->get("fechades"));
        $fechahas1=($this->input->get("fechahas"));
        $formato=($this->input->get("formato"));
        $observacion=($this->input->get("observacion"));
        $fechadestit=date("d/m/Y",  strtotime($fechades1));
        $fechahastit=date("d/m/Y",  strtotime($fechahas1));
        $fechades=date("Y-m-d",  strtotime($fechades1));
        $fechahas=date("Y-m-d",  strtotime($fechahas1));
        $mes1=date("m",  strtotime($fechades1));
        $mes2=date("m",  strtotime($fechahas1));
        $diasferiados= array(); 
        $habiles=$this->habiles($fechades,$fechahas,$diasferiados);
        $nohabiles=$this->nohabiles($fechades,$fechahas);
        $pdf = new Pdf('l', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetSubject('Tutorial TCPDF');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0,0,1), array(0,0,1));
        //$pdf->setFooterData($tc = array(0, 64, 0), $lc = array(0, 64, 128));
        //$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetPageOrientation('l');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        //$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        //$pdf->SetHeaderMargin(PDF_MARGIN_HEADER1);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true); 
        $pdf->SetFont('times', '', 9, '', true);
        $html=null;
        $pdf->AddPage();
        $nombre_archivo=null;
        $divisiones=$this->reppermisos_model->getdivision($division,$departamento);
        if($divisiones){
            foreach($divisiones->result_array() as $div){ 
            $divisionasis=$div['division'];
            $nombredivision1=$div['nombredivision'];
            $tiponomina1=$this->reppermisos_model->gettiponomina($tiponomina,$divisionasis);
                if ($tiponomina1){
                    foreach($tiponomina1->result_array() as $tipodenomina){
                        $nombrenomina1=$tipodenomina['nombrenomina'];
                        $idnomina=$tipodenomina['idnomina'];
                        if ($formato=='pdf'){
                            $html .= "<table width='100%'>";
                                $html .="<tr padding:300px>";
                                $html .='<td><img src="./imagen/logo/logorep.png"/></td>';
                                $html .="<td>REPUBLICA BOLIVARIANA DE VENEZUELA<br>GOBERNACION DEL ESTADO LARA<br>SECRETARIA GENERAL DE GOBIERNO<br> OFICINA DE ".$departamentonombre."<br>".$div["nombredivision"]."<p></p><p></p></td>";
                                $html .='<td><img src="./imagen/logo/lararep.png"/></td>';
                                $html .= "</tr>";
                            $html .= "</table>";
                        }else{
                            $html .= "<table width='100%'>";
                            $html .="<tr padding:300px>";
                            $html .="<td><img src=BASE_PATH'./imagen/logo/logoborde1.png'/></td>";
                            $html .="<td></td>";
                            $html .="<td>REPUBLICA BOLIVARIANA DE VENEZUELA<br>GOBERNACION DEL ESTADO LARA<br>SECRETARIA GENERAL DE GOBIERNO<br> OFICINA DE ".$departamentonombre."<br>".$div["nombredivision"]."<p></p><p></p></td>";
                            $html .="<td></td>";
                            $html .="<td></td>";
                            $html .='<td><img src="..imagen/logo/lararep.png"/></td>';
                            $html .= "</tr>";
                            $html .= "</table>";
                        }
                        $html .= "<STYLE ></STYLE>";
                        $html .= "<style type=text/css>";
                        $html .= "th{color: #fff; font-weight: bold; background-color: #AAC7E3; align=center}";
                        $html .= "p.saltodepagina{background-color: #fff; page-break-after: always;}";
                        $html .= "</style>";
                        $html .= "<table width='100%'>";
                            $html .='<tr style="font-size:9pt; text-align:center;">';
                            $html .="<td></td>";
                            $html .="<td>RESUMEN MENSUAL DE ASISTENCIA E INASISTENCIA </td>";
                            $html .="<td></td>";
                            $html .="<td></td>";
                            $html .="<td></td>";
                            $html .= "</tr>";
                            $html .="<tr padding:300px>";
                            $html .="<td></td>";
                            $html .="<td>PERSONAL:".$nombrenomina1."</td>";
                            $html .="<td></td>";
                            $html .="<td></td>";
                            $html .="<td></td>";
                            $html .= "</tr>";
                            $html .='<tr style="font-size:9pt; text-align:center;">';
                            $html .="<td></td>";
                            $html .="<td>DESDE $fechadestit HASTA $fechahastit</td>";
                            $html .="<td></td>";
                            $html .="<td></td>";
                            $html .="<td></td>";
                            $html .= "</tr>";
                        $html .= "</table>";
                        $coll=0;
                        foreach($habiles as $resulta){  
                            $coll=$coll+1;
                        } 
                        $coll1=$coll;
                        $html .= '<p></p>';
                        $html .= '<table width="100%"   BORDER="1" >';
                        $divisionasis=$div['division'];
                        $nombredivision1=$div['nombredivision'];
                        $html .='<tr style="font-size:9pt; text-align:center;">';
                        $html .='<th>Cedula</th>';
                        $html .='<th>Nombre y Apellidos</th>';
                        $html .='<th>Unidad Administrativa de Adscripción</th>';
                        $html .='<th>Jornada Extraordinaria del mes</th>';
                        $html .='<th>Reposo(Nro.días)</th>';
                        $html .='<th>Vacaciones(Nro.días)</th>';
                        $html .='<th>Permisos Contractual(Nro.días)</th>';
                        $html .='<th>Inasistencia Injustificada(Nro.días)</th>';
                        $html .='</tr>';
                        if ($divisionasis==3){
                            $empleado=$this->reppermisos_model->getempleadodes($divisionasis,$idnomina,$cedula,$fechades,$fechahas,$departamento);
                        }else{
                            $empleado=$this->reppermisos_model->getempleado($divisionasis,$idnomina,$cedula,$fechades,$fechahas);
                        }
                        unset($asistencia); 
                        $cedemp='null';
                        $asist=array();
                        $numfilas = $empleado->num_rows;
                        $tot=0;
                        foreach($empleado->result_array() as $emp){
                            $tot=$tot+1;
                            $entro=0;
                            if ($cedemp!=$emp['cedula']){
                                if ($cedemp!='null'){
                                    $result=0;
                                    $reposo=0;
                                    $vacaciones=0;
                                    $permi=0;
                                    foreach($habiles as $resulta){                  
                                        if (in_array($resulta, $asist)) {
                                            //$html .= '<td ><font size="10">X</font></td>'; 
                                        }else{
                                            $permiso=$this->reppermisos_model->getpermisos($resulta,$id);
                                            if ($permiso->num_rows>0){
                                                $cantidad=$permiso->num_rows;
                                                $row1 = $permiso->row_array();
                                                if ($row1['tiposolicitud']==1){
                                                    $permi=$permi+1;
                                                }else{
                                                    if ($row1['tiposolicitud']==2){
                                                        $reposo=$reposo+1;
                                                    }else{
                                                        if ($row1['tiposolicitud']==3){
                                                            $vacaciones=$vacaciones+1;
                                                        }else{

                                                        }         
                                                    }
                                                }
                                            }else{
                                                $result=$result+1;
                                            }
                                       }
                                    }
                                    $fechajordiatotal='';
                                    $fechames='';
                                    foreach($nohabiles as $resuljor){
                                        $fechaini = explode("-",$resuljor);
                                        $fechamesini=$fechaini[1];
                                        $jornada=$this->reppermisos_model->getjornada($resuljor,$id);
                                        if ($jornada->num_rows>0){
                                            $entro=1;
                                            $fechajor = explode("-",$resuljor);
                                            $fechajorano=$fechajor[0];
                                            $fechajormes=$fechajor[1];
                                            $fechajordia=$fechajor[2];
                                            if ($fechames!=$fechajormes){
                                                if ($fechames==null){
                                                    $fechames=$fechajormes;
                                                    if ($fechajordiatotal==null){
                                                        $fechajordiatotal=$fechajordia;  
                                                    }else{
                                                        $fechajordiatotal=$fechajordiatotal.','.$fechajordia; 
                                                    }      
                                                }else{
                                                    $fechajordiatotal=$fechajordiatotal.'/'.$fechames.'/'.$fechajorano.' ';
                                                    $fechajordiatotal=$fechajordiatotal.''.$fechajordia;
                                                    $fechames=$fechajormes; 
                                                }
                                            }else{
                                                $fechames=$fechajormes;
                                                $fechajordiatotal=$fechajordiatotal.','.$fechajordia; 
                                            }                                        
                                        } 
                                    }
                                    if($entro==1){
                                          $fechajordiatotal=$fechajordiatotal.'/'.$fechames.'/'.$fechajorano.' ';
                                    }
                                    unset($resulta);
                                    $html .= '<td>'.mb_convert_case("<h4>".$fechajordiatotal."</h4>",MB_CASE_TITLE, "UTF-8").'</td>';
                                    $html .= '<td>'.mb_convert_case("<h4>".$reposo."</h4>",MB_CASE_TITLE, "UTF-8").'</td>';
                                    $html .= '<td>'.mb_convert_case("<h4>".$vacaciones."</h4>",MB_CASE_TITLE, "UTF-8").'</td>';
                                    $html .= '<td>'.mb_convert_case("<h4>".$permi."</h4>",MB_CASE_TITLE, "UTF-8").'</td>';
                                    $html .= '<td>'.mb_convert_case("<h4>".$result."</h4>",MB_CASE_TITLE, "UTF-8").'</td>';
                                    unset($asist);
                                    $asist=array();
                                    $html .='</tr>';
                                    $html .= '<tr style="font-size:9pt; text-align:center;">';
                                    $html .='<td >'.mb_convert_case($emp["cedula"],MB_CASE_TITLE, "UTF-8").'</td>';
                                    $html .='<td >'.mb_convert_case($emp["nombre"],MB_CASE_TITLE, "UTF-8").'</td>';
                                    $html .='<td >'.mb_convert_case($div["nombredivision"],MB_CASE_TITLE, "UTF-8").'</td>';
                                    $fecha=$emp['fecha'];
                                    array_push($asist, $fecha);
                                    $id=$emp['id'];
                                    $cedemp=$emp['cedula'];
                                }else{
                                    if ($tot==1){
                                        $html .= '<tr style="font-size:9pt; text-align:center;">';
                                        $html .='<td >'.mb_convert_case($emp["cedula"],MB_CASE_TITLE, "UTF-8").'</td>';
                                        $html .= '<td >'.mb_convert_case($emp["nombre"],MB_CASE_TITLE, "UTF-8").'</td>';
                                         $html .='<td >'.mb_convert_case($div["nombredivision"],MB_CASE_TITLE, "UTF-8").'</td>';
                                        $fecha=$emp['fecha'];
                                        array_push($asist, $fecha);
                                        $cedemp=$emp['cedula']; 
                                        $id=$emp['id'];
                                    }
                                }
                            }else{    
                                $fecha=$emp['fecha'];
                                array_push($asist, $fecha); 
                            }
                        }
                        $result=0;
                            $reposo=0;
                            $vacaciones=0;
                            $permi=0;
                            foreach($habiles as $resulta){                  
                                if (in_array($resulta, $asist)) {
                                    //$html .= '<td ><font size="10">X</font></td>'; 
                                }else{
                                    $permiso=$this->reppermisos_model->getpermisos($resulta,$id);
                                    if ($permiso->num_rows>0){
                                        $row1 = $permiso->row_array();
                                        if ($row1['tiposolicitud']==1){
                                            $permi=$permi+1;
                                         }else{
                                            if ($row1['tiposolicitud']==2){
                                                $reposo=$reposo+1;
                                            }else{
                                               if ($row1['tiposolicitud']==3){
                                                    $vacaciones=$vacaciones+1;
                                                }else{
                                                                
                                                }  
                                            }
                                        }
                                    }else{
                                        $result=$result+1;
                                    }
                                }
                            }
                            $fechajordiatotal='';
                            $fechames='';
                            foreach($nohabiles as $resuljor){
                                $fechaini = explode("-",$resuljor);
                                $fechamesini=$fechaini[1];
                                $jornada=$this->reppermisos_model->getjornada($resuljor,$id);
                                if ($jornada->num_rows>0){
                                    $entro=1;
                                    $fechajor = explode("-",$resuljor);
                                    $fechajormes=$fechajor[1];
                                    $fechajordia=$fechajor[2];
                                    if ($fechames!=$fechajormes){
                                        if ($fechames==null){
                                            $fechames=$fechajormes;
                                            if ($fechajordiatotal==null){
                                                $fechajordiatotal=$fechajordia;  
                                            }else{
                                                $fechajordiatotal=$fechajordiatotal.','.$fechajordia; 
                                            }      
                                        }else{
                                            $fechajordiatotal=$fechajordiatotal.'/'.$fechames.'/'.$fechajorano.' ';
                                            $fechajordiatotal=$fechajordiatotal.''.$fechajordia;
                                            $fechames=$fechajormes; 
                                        }
                                    }else{
                                        $fechames=$fechajormes;
                                        $fechajordiatotal=$fechajordiatotal.','.$fechajordia; 
                                    }                                        
                                } 
                            }
                            if($entro==1){
                                  $fechajordiatotal=$fechajordiatotal.'/'.$fechames.'/'.$fechajorano.' ';
                            }
       
                        unset($resulta);
                        $html .= '<td>'.mb_convert_case("<h4>".$fechajordiatotal."</h4>",MB_CASE_TITLE, "UTF-8").'</td>';
                        $html .= '<td>'.mb_convert_case("<h4>".$reposo."</h4>",MB_CASE_TITLE, "UTF-8").'</td>';
                        $html .= '<td>'.mb_convert_case("<h4>".$vacaciones."</h4>",MB_CASE_TITLE, "UTF-8").'</td>';
                        $html .= '<td>'.mb_convert_case("<h4>".$permi."</h4>",MB_CASE_TITLE, "UTF-8").'</td>';
                        $html .= '<td>'.mb_convert_case("<h4>".$result."</h4>",MB_CASE_TITLE, "UTF-8").'</td>';
                        $html .= '</tr>'; 
                        $html .= '</table>';
                        $html .= '<p></p>';
                        $html .= '<h3 align="left"><u>OBSERVACIÓN:</u></h3>';
                        $buscarobservacion=$this->reppermisos_model->buscarobservacion($idnomina,$divisionasis,$fechades,$fechahas);
                        if ($buscarobservacion->num_rows>0){
                            $row1 =$buscarobservacion->row_array();
                            $observacion1=$row1['observacion'];
                            $html .= '<h4 align="left">'.$observacion1.'</h4>';
                        }
                        if ($formato=='pdf'){ 
                            $html .= '<p></p>';
                            $html .= "<table width='100%'>";
                            $html .='<tr padding:300px>';
                            $html .='<td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ELABORADO POR:</td>';
                            $html .='<td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;REVISADO POR:</td>';
                            $html .='<td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NOMBRE Y APELLIDO</td>';
                            $html .= "</tr>";
                            $html .='<tr >';
                            $html .='<td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.mb_convert_case($nombreasistente,MB_CASE_TITLE, "UTF-8").'</td>';
                            $html .='<td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.mb_convert_case($nombrejefe,MB_CASE_TITLE, "UTF-8").'</td>';
                            $html .='<td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.mb_convert_case($nombrejefedep,MB_CASE_TITLE, "UTF-8").'</td>';
                            $html .= "</tr>";
                            $html .='<tr >';
                            $html .='<td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.mb_convert_case($cedulaasistente,MB_CASE_TITLE, "UTF-8").'</td>';
                            $html .='<td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.mb_convert_case($cedulajefe,MB_CASE_TITLE, "UTF-8").'</td>';
                            $html .='<td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.mb_convert_case($cedulajefedep,MB_CASE_TITLE, "UTF-8").'</td>';
                            $html .= "</tr>";   
                            $html .='<tr >';
                            $html .='<td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.mb_convert_case($cargoasistente,MB_CASE_TITLE, "UTF-8").'</td>';
                            $html .='<td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.mb_convert_case($cargojefe,MB_CASE_TITLE, "UTF-8").'</td>';
                            $html .='<td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.mb_convert_case($cargojefedep,MB_CASE_TITLE, "UTF-8").'</td>';
                            $html .= "</tr>"; 
                            $html .='<tr >';
                            $html .='<td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Firma:____________</td>'; 
                            $html .='<td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Firma:____________</td>'; 
                            $html .='<td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Firma:____________</td>'; 
                            $html .= '</tr>';            
                            $html .= '</table><p></p><p class="saltodepagina" />';  
                        }else{
                            $html .= '<p></p>';
                            $html .= "<table width='100%'>";
                            $html .='<tr padding:300px>';
                            $html .='<td></td>';
                            $html .='<td align="left">ELABORADO POR:</td>';
                            $html .='<td></td>';
                            $html .='<td align="left">REVISADO POR:</td>';
                            $html .='<td></td>';
                            $html .='<td></td>';
                            $html .='<td align="left">NOMBRE Y APELLIDO</td>';
                            $html .='<td></td>';
                            $html .= "</tr>";
                            $html .='<tr >';
                            $html .='<td></td>';
                            $html .='<td align="left">'.mb_convert_case($nombreasistente,MB_CASE_TITLE, "UTF-8").'</td>';
                            $html .='<td></td>';
                            $html .='<td align="left">'.mb_convert_case($nombrejefe,MB_CASE_TITLE, "UTF-8").'</td>';
                            $html .='<td></td>';
                            $html .='<td></td>';
                            $html .='<td align="left">'.mb_convert_case($nombrejefedep,MB_CASE_TITLE, "UTF-8").'</td>';
                            $html .='<td></td>';
                            $html .= "</tr>";
                            $html .='<tr >';
                            $html .='<td></td>';
                            $html .='<td align="left">'.mb_convert_case($cedulaasistente,MB_CASE_TITLE, "UTF-8").'</td>';
                            $html .='<td></td>';
                            $html .='<td align="left">'.mb_convert_case($cedulajefe,MB_CASE_TITLE, "UTF-8").'</td>';
                            $html .='<td></td>';
                            $html .='<td></td>';
                            $html .='<td align="left">'.mb_convert_case($cedulajefedep,MB_CASE_TITLE, "UTF-8").'</td>';
                            $html .='<td></td>';
                            $html .= "</tr>";   
                            $html .='<tr>';
                            $html .='<td></td>';
                            $html .='<td align="left">'.mb_convert_case($cargoasistente,MB_CASE_TITLE, "UTF-8").'</td>';
                            $html .='<td></td>';
                            $html .='<td align="left">'.mb_convert_case($cargojefe,MB_CASE_TITLE, "UTF-8").'</td>';
                            $html .='<td></td>';
                            $html .='<td></td>';
                            $html .='<td align="left">'.mb_convert_case($cargojefedep,MB_CASE_TITLE, "UTF-8").'</td>';
                            $html .='<td></td>';
                            $html .= "</tr>"; 
                            $html .='<tr>';
                            $html .='<td></td>';
                            $html .='<td align="left">Firma:____________</td>';
                            $html .='<td></td>'; 
                            $html .='<td align="left">Firma:____________</td>'; 
                            $html .='<td></td>';
                            $html .='<td></td>';
                            $html .='<td align="left">Firma:____________</td>'; 
                            $html .='<td></td>';
                            $html .= '</tr>';            
                            $html .= '</table><p></p><p class="saltodepagina" />';  
                        }    
                    }   
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
            }    
        
        }
        if ($formato=='pdf'){ 
            $pdf->writeHTMLCell($w = 0,$h = 0,$x='',$y = '',$html,$border = 0,$ln = 1,$fill = 0,$reseth=true,$align='C',$autopadding= true);
            $pdf->Output($nombre_archivo, 'I');
        }else{
            header("Content-Type: text/html; charset=utf-8");
            header('Content-type: application/vnd.ms-excel');
            $nombre_archivo='Listado Asistencia';
            header("Content-Disposition: attachment; filename=".$nombre_archivo.".xls");
            header("Pragma: no-cache");
            header("Expires: 0");
            echo utf8_decode($html);

        }
    }   
    public function habiles($fechades,$fechahas,$diasferiados) {
       $fechainicio = strtotime($fechades);
       $fechafin = strtotime($fechahas);
       $diainc = 24*60*60;
       $diashabiles = array();
       for ($midia = $fechainicio; $midia <= $fechafin; $midia += $diainc) {
           if (!in_array(date('N', $midia), array(6,7))) {
                if (!in_array(date('Y-m-d', $midia), $diasferiados)) {
                    array_push($diashabiles, date('Y-m-d', $midia));
                }
           }
        }
       return $diashabiles;
    }
    public function nohabiles($fechades,$fechahas) {
        $diasferiados1=$this->reppermisos_model->diasferiadodiames();
        if($diasferiados1->num_rows()>0){
            foreach ($diasferiados1->result_array() as $row){
                $feriados[] =$row['fecha'];
            }
        } 
       $fechainicio = strtotime($fechades);
       $fechafin = strtotime($fechahas);
       $diainc = 24*60*60;
       $diashabiles = array();
       for ($midia = $fechainicio; $midia <= $fechafin; $midia += $diainc) {
           if (!in_array(date('N', $midia), array(1,2,3,4,5))||(in_array(date('Y-m-d', $midia), $feriados))) {
                //if (!in_array(date('Y-m-d', $midia), $feriados)) {
                    array_push($diashabiles, date('Y-m-d', $midia));
               //   }
           }
        }
        return ($diashabiles);
    } 
}


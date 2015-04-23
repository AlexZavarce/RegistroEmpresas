<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');
class Inasistencia extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('pdfs/inasistencia_model');
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
	public function generarlistadoinasistencia() {
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
		$tiponomina=($this->input->get("tiponomina" )!='null') ?'=' .$this->input->get("tiponomina"):'LIKE "%"';
		$retardos=($this->input->get("retardos")!='null')?'='.$this->input->get("retardos"):'LIKE "%"';
		$cedula=($this->input->get("cedula" )!='null') ?  "LIKE '%".$this->input->get("cedula")."%'":'LIKE "%"';
		$fechades1=($this->input->get("fechades"));
		$fechahas1=($this->input->get("fechahas"));
		$fechades=date("Y-m-d",  strtotime($fechades1));
		$fechahas=date("Y-m-d",  strtotime($fechahas1));
		$mes1=date("m",  strtotime($fechades1));
		$mes2=date("m",  strtotime($fechahas1));
		$diasferiados= array(); 
		$habiles=$this->habiles($fechades,$fechahas,$diasferiados);
		$nohabile=$this->nohabiles($fechades,$fechahas);
		$solodiaferiado=$this->feriado($fechades,$fechahas);
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
		$divisiones=$this->inasistencia_model->getdivision($division,$departamento);
		if($divisiones){
			$html .= "<style type=text/css>";
			$html .= "th{color: #fff; font-weight: bold; background-color: #AAC7E3; align=center}";
			$html .= "td{background-color: #fff; color: #222; align=center}";
			$html .= "</style>";
			$html .= "<h2>Listado  de Empleados con Inasistencia </h2>";
			//$html .= '<table width="100%" border="1" cellpadding="1" cellspacing="1" { margin: 15px; padding: 15px; }>';
			$coll=0;
			foreach($habiles as $resulta){  
				$coll=$coll+1;
			} 
			$coll1=$coll;
			foreach($divisiones->result_array() as $div){
				$html .= '<p></p>';
				$html .= '<table width="100%"  cellpadding="1" cellspacing="1" BORDER="1" >';
				$divisionasis=$div['division'];
				$nombredivision1=$div['nombredivision'];
				$html .= '<tr padding:150px>
					<th colspan="'.$coll1.'" ><h3><font color="#000000">'.mb_convert_case($div["nombredivision"],MB_CASE_TITLE, "UTF-8").'</font></h3></th>
				</tr>';
				$html .= '<tr padding:300px>
					<th colspan="'.$coll1.'" ><h3><font color="#000000">Días Hábiles</font></h3></th>
				</tr>';
				$html .='<tr padding:300px>';
				$cont=0;
				$cont1=0;
				foreach($habiles as $resulta){  
					if ($mes1==(date("m", strtotime($resulta)))){
						$cont=$cont+1;
					}else{
						$cont1=$cont1+1;
					}
				}
				$ancho=76/$coll;
				$anchmes1=((76*$cont)/$coll)+1;
				$anchomes1="width:".$anchmes1."%;";
				$anchmes2=((76*$cont1)/$coll)+9.2;
				$anchomes2="width:".$anchmes2."%;";
				$toti="width:".$ancho."%;";
				$mesini=$this->mes($mes1);
				$mesfin=$this->mes($mes2);
				$html .= '<th  style="width: 16%;"  ><h3><font color="#000000">Empleados</font></h3></th>';
				$html .= '<th   style="'.$anchomes1.'" ><h3><font color="#000000">'.$mesini.'</font></h3></th>';
				if ($mesini==$mesfin){
					$html .= '<th  style="width: 0%;"></th>';
				}else{
					$html .= '<th  style="'.$anchomes2.'"><h3><font color="#000000">'.$mesfin.'</font></h3></th>';
				}
				$html .='</tr>';
				$html .='<tr padding:300px>';
				$html .='<th  style="width: 8%;">Cedula</th>';
				$html .='<th style="width: 8%;">Nombres</th>';
				foreach($habiles as $resulta){  
					$diahabil=$resulta;
		   			$html .= '<th  style="'.$toti.'"><h3><font color="#000000">'.mb_convert_case(date("d", strtotime($resulta)),MB_CASE_TITLE, "UTF-8").'</font></h3></th>';
				}
				$html .='<th style="width: 7.8%;">Total-Dias</th>';
				$html .='</tr>';
				if ($divisionasis==3){
					$empleado=$this->inasistencia_model->getempleadodes($divisionasis,$tiponomina,$cedula,$fechades,$fechahas,$departamento);
				}else{
					$empleado=$this->inasistencia_model->getempleado($divisionasis,$tiponomina,$cedula,$fechades,$fechahas);
				}
			   	unset($asistencia);	
			   	$cedemp='null';
			   	$asist=array();
			   	$numfilas = $empleado->num_rows;
			   	$tot=0;
				foreach($empleado->result_array() as $emp){
					$tot=$tot+1;
					if ($cedemp!=$emp['cedula']){
						if ($cedemp!='null'){
							$result=0;
							foreach($habiles as $resulta){                  
								if (in_array($resulta, $asist)) {
									$html .= '<td ><font size="10">X</font></td>'; 
								}else{
									if (in_array($resulta,$solodiaferiado)){
										$html .= '<td bgcolor= "#DCDCDC" align=center><font size="10" >F</font></td>';
									}else{
										$permiso=$this->inasistencia_model->getpermisos($resulta,$id);
										if ($permiso->num_rows>0){
											$cantidad=$permiso->num_rows;
											/*if ($cantidad==2){
												foreach($permiso->result_array() as $permis){
													if ($permis['tiposolicitud']==2){
														$html .= '<td bgcolor= "#DCDCDC" align=center><font size="10" >R</font></td>';
													}else{                       
														
													}
												}
											}else{*/
												$row1 = $permiso->row_array();
												if ($row1['tiposolicitud']==1){
													$html .= '<td bgcolor= "#FAEBD7" align=center><font size="10" >P</font></td>';
												}else{
													if ($row1['tiposolicitud']==2){
														$html .= '<td bgcolor= "#DCDCDC" align=center><font size="10" >R</font></td>';
													}else{
														if ($row1['tiposolicitud']==3){
															$html .= '<td bgcolor= "#CEECF5" align=center><font size="10" >V</font></td>';
														}else{
															$html .= '<td ><font size="10">X</font></td>'; 
														}
													}
												}
											//}		
										}else{
											if (in_array($resulta, $nohabile)) {
												$html .= '<td bgcolor= "#DCDCDC" align=center><font size="10" >F</font></td>';
											}else{
												$result=$result+1;	
												$html .= '<td bgcolor= "#FAE8EA"><font size="10">I</font></td>';
												unset($resulta);
											}
										}
									}
								}
							}
							$html .= '<td><font size="10"><h3>'.mb_convert_case($result,MB_CASE_TITLE, "UTF-8").'</h3></font></td>';
							unset($asist);
							$asist=array();
							$html .='</tr>';
							$html .= '<tr>';
							$html .='<td ><font size="10">'.mb_convert_case($emp["cedula"],MB_CASE_TITLE, "UTF-8").'</font></td>';
							$html .='<td ><font size="10">'.mb_convert_case($emp["nombre"],MB_CASE_TITLE, "UTF-8").'</font></td>';
							$fecha=$emp['fecha'];
							array_push($asist, $fecha);
							$id=$emp['id'];
							$cedemp=$emp['cedula'];
						}else{
							if ($tot==1){
								$html .= '<tr>';
								$html .='<td ><font size="10">'.mb_convert_case($emp["cedula"],MB_CASE_TITLE, "UTF-8").'</font></td>';
								$html .= '<td ><font size="10">'.mb_convert_case($emp["nombre"],MB_CASE_TITLE, "UTF-8").'</font></td>';
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
				foreach($habiles as $resulta){                  
					if (in_array($resulta, $asist)) {
						$html .= '<td ><font size="10">X</font></td>'; 
					}else{
						$permiso=$this->inasistencia_model->getpermisos($resulta,$id);
						if ($permiso->num_rows>0){
							$cantidad=$permiso->num_rows;
							/*if ($cantidad==2){
								foreach($permiso->result_array() as $permis){
									if ($permis['tiposolicitud']==2){
										$html .= '<td bgcolor= "#DCDCDC" align=center><font size="10" >R</font></td>';
									}else{
										
									}
								}
							}else{*/
								$row1 = $permiso->row_array();
								if ($row1['tiposolicitud']==1){
									$html .= '<td bgcolor= "#FAEBD7" align=center><font size="10" >P</font></td>';
								}else{
									if ($row1['tiposolicitud']==2){
										$html .= '<td bgcolor= "#DCDCDC" align=center><font size="10" >R</font></td>';
									}else{
										if ($row1['tiposolicitud']==3){
											$html .= '<td bgcolor= "#CEECF5" align=center><font size="10">V</font></td>';
										}else{
											$html .= '<td ><font size="10">X</font></td>'; 
										}
									}
							//	}
							}		
						}else{
							if (in_array($resulta,$nohabile)) {
								$html .= '<td bgcolor= "#DCDCDC" align=center><font size="10" >F</font></td>';
							}else{
								$result=$result+1;	
								$html .= '<td bgcolor= "#FAE8EA"><font size="10">I</font></td>';
								unset($resulta);
							}
						}
					}
				}
			$html .= '<td><font size="10"><h3>'.mb_convert_case($result,MB_CASE_TITLE, "UTF-8").'</h3></font></td>';
			$html .= '</tr>'; 
			$html .= '</table>';
			$html .= '<p></p>';
			}	
			//$html .= '</table>';
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
        $diasferiados1=$this->inasistencia_model->diasferiadodiames();
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
     public function feriado($fechades,$fechahas) {
    	$feriados=array();
        $diasferiados1=$this->inasistencia_model->diasferiadorango($fechades,$fechahas);
        if($diasferiados1->num_rows()>0){
            foreach ($diasferiados1->result_array() as $row){
                $feriados[] =$row['fecha'];
            }
        }
        return ($feriados);
    }
}


<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');
class Inasistencia extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('pdfs/inasistencia_model');
		$this->load->library('Pdf'); 
		$this->load->library(array('session'));       
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
			if ($data['tipousuario']==1){
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
		$diasferiados= array(); 
		$habiles=$this->habiles($fechades,$fechahas,$diasferiados);
		$pdf = new Pdf('l', 'mm', 'A4', true, 'UTF-8', false);
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
			$html .= "<h2>Listado  de empleados con Inasistencia </h2>";
			$html .= '<table width="100%" border="0" cellpadding="2" cellspacing="2" >';
			foreach($divisiones->result_array() as $div){
				$divisionasis=$div['division'];
				$nombredivision1=$div['nombredivision'];
				$html .= '<tr padding:150px>
					<th colspan="4" ><h3><font color="#000000">'.mb_convert_case($div["nombredivision"],MB_CASE_TITLE, "UTF-8").'</font></h3></th>
					</tr>';
			   	$html .= '<tr padding:300px>
					<th><font size="10"><b>Cédula</b></font></th>
					<th><font size="10"><b>Nombre</b></font></th>
					<th><font size="10"><b>Apellido</b></font></th>
					<th><font size="10"><b>Fecha de Inasistencia</b></font></th>
			   	</tr>';
			   $empleado=$this->inasistencia_model->getempleado($divisionasis,$tiponomina,$cedula,$fechades,$fechahas);
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
								 }else{
								 	$result=$result+1;	
									$html .= '<tr>
									<td></td>
									<td></td>
									<td></td>
									<td><font size="10">'.mb_convert_case(date("d/m/Y", strtotime($resulta)),MB_CASE_TITLE, "UTF-8").'</font></td>
									</tr>'; 
									unset($resulta);
								}
							}
							$html .= '<hr><tr>
									<td></td>
									<td></td>
									<td></td>
									<td>'.mb_convert_case("<h4>Total: ".$result." Días</h4><hr width='80%'>",MB_CASE_TITLE, "UTF-8").'</td>
									</tr><hr>'; 
							unset($asist);
							$asist=array();
							$html .= '<tr>
							<td><font size="10">'.mb_convert_case($emp["cedula"],MB_CASE_TITLE, "UTF-8").'</font></td>
							<td><font size="10">'.mb_convert_case($emp["nombre"],MB_CASE_TITLE, "UTF-8").'</font></td>
							<td><font size="10">'.mb_convert_case($emp["apellido"],MB_CASE_TITLE, "UTF-8").'</font></td>
							</tr>';
							$fecha=$emp['fecha'];
							array_push($asist, $fecha);
							$cedemp=$emp['cedula'];
						}else{
							if ($tot==1){
							$html .= '<tr>
							<td><font size="10">'.mb_convert_case($emp["cedula"],MB_CASE_TITLE, "UTF-8").'</font></td>
							<td><font size="10">'.mb_convert_case($emp["nombre"],MB_CASE_TITLE, "UTF-8").'</font></td>
							<td><font size="10">'.mb_convert_case($emp["apellido"],MB_CASE_TITLE, "UTF-8").'</font></td>
							</tr>';
							$fecha=$emp['fecha'];
							array_push($asist, $fecha);
							$cedemp=$emp['cedula']; 
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
					}else{
						$result=$result+1;	
						$html .= '<tr>
						<td></td>
						<td></td>
						<td></td>
						<td><font size="10">'.mb_convert_case(date("d/m/Y", strtotime($resulta)),MB_CASE_TITLE, "UTF-8").'</font></td>
						</tr>'; 
						unset($resulta);
					}
				}
				$html .= '<hr><tr>
									<td></td>
									<td></td>
									<td></td>
									<td>'.mb_convert_case("<h4>Total: ".$result." Días</h4><hr width='80%'>",MB_CASE_TITLE, "UTF-8").'</td>
									</tr><hr>'; 
			}
			$html .= "</table>";
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
}


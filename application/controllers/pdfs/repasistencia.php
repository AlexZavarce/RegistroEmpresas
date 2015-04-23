<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');
class Repasistencia extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('pdfs/repasistencia_model');
		$this->load->library('Pdf'); 
		$this->load->library(array('session'));       
	}
	public function generarasistencia() {
		$username = $this->session->userdata('datasession');
		$usuarioced = $username['cedula'];
		$usuariodiv=$this->repasistencia_model->getdivisionusu($usuarioced);
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
		$retardos=($this->input->get("retardos"));
		if ($retardos==1){
			$retardos='>"00:15:00"';
		}else{
			if($retardos==2){
				$retardos='<"00:15:00"';
			}else{
				$retardos=" ";
			}
		}
		$cedula=($this->input->get("cedula" )!='null') ?  "LIKE '%".$this->input->get("cedula")."%'":'LIKE "%"';
		$fechades1=($this->input->get("fechades"));
		$fechahas1=($this->input->get("fechahas"));
		$fechades=date("Y-m-d",  strtotime($fechades1));
		$fechahas=date("Y-m-d",  strtotime($fechahas1));
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
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		$pdf->setFontSubsetting(true); 
		$pdf->SetFont('times', '', 9, '', true);
		$pdf->AddPage();
		$html=null;
		$nombre_archivo=null;
		$divisiones=$this->repasistencia_model->getdivision($division,$departamento);
		if($divisiones){
			$html .= "<style type=text/css>";
			$html .= "th{color: #fff; font-weight: bold; background-color: #AAC7E3; align=center}";
			$html .= "td{background-color: #fff; color: #222; align=center}";
			$html .= "</style>";
			$html .= "<h2>Listado  de Asistencia </h2>";
			$html .= '<table width="100%" border="0" cellpadding="2" cellspacing="2" >';
			foreach($divisiones->result_array() as $div){
				$divisionasis=$div['division'];
				$nombredivision1=$div['nombredivision'];
				$html .= '<tr padding:150px>
				<th colspan="7" ><h3><font color="#000000">'.mb_convert_case($div["nombredivision"],MB_CASE_TITLE, "UTF-8").'</font></h3></th>
				</tr>';
				$html .= '<tr>
				   <th><font size="10"><b>Cédula</b></font></th>
					<th><font size="10"><b>Nombre</b></font></th>
					<th><font size="10"><b>Apellido</b></font></th>
					<th><font size="10"><b>Fecha de Asistencia</b></font></th>
					<th><font size="10"><b>Hora Entrada</b></font></th>
					<th><font size="10"><b>Hora Salida</b></font></th>
					<th><font size="10"><b>Tiempo Retardo</b></font></th>
				</tr>';
				$empleado=$this->repasistencia_model->getasistencia($divisionasis,$cedula,$fechades,$fechahas,$tiponomina,$retardos);
				unset($asistencia);
				$cedemp='null';
				$asist=array();
				$numfilas = $empleado->num_rows;
				$tot=0;
				$tot1=0;
				$ret=0;
				foreach($empleado->result_array() as $emp){
					$tot1=$tot1+1;
					if ($cedemp!=$emp['cedula']){
						$tot=$tot+1;
						if ($tot>1){
							$html .= '<tr>
								<td></td>
								<td></td>
								<td></td>
								<td>'.mb_convert_case("<h4>Total: ".($tot)." Días</h4><hr width='80%'>",MB_CASE_TITLE, "UTF-8").'</td>
								<td></td>
								<td></td>
								<td>'.mb_convert_case("<h4> ".(($ret>=0)?$ret." Retardo".(($ret>1)?'s':''):'')."</h4><hr width='80%'>",MB_CASE_TITLE, "UTF-8").'</td><hr>				
							</tr>'; 
							$ret=0;
						}
						if ($emp['fecha']==null){
							$html .= '<tr>
							<td><font size="10">'.mb_convert_case($emp["cedula"],MB_CASE_TITLE, "UTF-8").'</font></td>
							<td><font size="10">'.mb_convert_case($emp["nombre"],MB_CASE_TITLE, "UTF-8").'</font></td>
							<td><font size="10">'.mb_convert_case($emp["apellido"],MB_CASE_TITLE, "UTF-8").'</font></td>
							</tr><hr>';
						}else{
							$retardo=$emp["tiemporetardo"]; 
							$partes=explode(':',$retardo); 
							$horas=(int)$partes[0];
							$minutos=$partes[1];  
							
							$html .= '<tr>';
							$html .= '<td><font size="10">'.mb_convert_case($emp["cedula"],MB_CASE_TITLE, "UTF-8").'</font></td>';
							$html .= '<td><font size="10">'.mb_convert_case($emp["nombre"],MB_CASE_TITLE, "UTF-8").'</font></td>';
							$html .=  '<td><font size="10">'.mb_convert_case($emp["apellido"],MB_CASE_TITLE, "UTF-8").'</font></td>';
							$html .=  '<td>'.mb_convert_case(date("d/m/Y", strtotime($emp["fecha"])),MB_CASE_TITLE, "UTF-8").'</td>';
							$html .= '<td>'.mb_convert_case(date("g:i", strtotime($emp["horaentrada"])),MB_CASE_TITLE, "UTF-8").'</td>';
							$html .='<td>'.mb_convert_case((($emp["horasalida"]>'00:00:00')?(date("g:i", strtotime($emp["horasalida"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
							$permiso=$this->repasistencia_model->getasitenciapermiso($emp["fecha"],$emp["id"]);
							if ($permiso->num_rows>0){
								$html .='<td ><font size="10">Permiso Autorizado</font></td>';
							}else{
								if ($emp["tiemporetardo"]>'00:16:00'){
								$ret=$ret+1;
							}
								$html .='<td>'.((($emp["tiemporetardo"]>'00:16:00')?(($horas>0)?$horas.' hora'.(($horas>1)?'s':''):'').(($minutos>0)?' '.$minutos.'min.':''):'')).'</td>';
							}
							$html .='</tr>';
						}
						$tot=0;
						$id=$emp['id'];
						$cedemp=$emp['cedula']; 
					}else{ 
						$retardo=$emp["tiemporetardo"]; 
						$partes=explode(':',$retardo); 
						$horas=(int)$partes[0];
						$minutos=$partes[1];  
					   	$html .= '<tr>';
						$html .= '<td></td>';
						$html .= '<td></td>';
						$html .= '<td></td>';
						$html .= '<td>'.mb_convert_case(date("d/m/Y", strtotime($emp["fecha"])),MB_CASE_TITLE, "UTF-8").'</td>';
						$html .= '<td>'.mb_convert_case(date("g:i", strtotime($emp["horaentrada"])),MB_CASE_TITLE, "UTF-8").'</td>';
						$html .= '<td>'.mb_convert_case((($emp["horasalida"]>'00:00:00')?(date("g:i", strtotime($emp["horasalida"]))):''),MB_CASE_TITLE, "UTF-8").'</td>';
						$permiso=$this->repasistencia_model->getasitenciapermiso($emp["fecha"],$emp["id"]);
						if ($permiso->num_rows>0){
							$html .='<td ><font size="10">Permiso Autorizado</font></td>';
						}else{
							if ($emp["tiemporetardo"]>'00:16:00'){
							$ret=$ret+1;
						}
							$html .='<td>'.((($emp["tiemporetardo"]>'00:16:00')?(($horas>0)?$horas.' hora'.(($horas>1)?'s':''):'').(($minutos>0)?' '.$minutos.'min.':''):'')).'</td>';
						}
						$html .= '</tr>'; 
						$tot=$tot+1;
						if ($tot1==$numfilas){
						$tot=$tot+1;
							if ($tot>1){
								 $html .= '<hr><tr>
									<td></td>
									<td></td>
									<td></td>
									<td>'.mb_convert_case("<h4>Total: ".($tot)." Días</h4><hr width='80%'>",MB_CASE_TITLE, "UTF-8").'</td>
									<td></td>
									<td></td>
									<td>'.mb_convert_case("<h4> ".(($ret>=0)?$ret." Retardo".(($ret>1)?'s':''):'')."</h4><hr>",MB_CASE_TITLE, "UTF-8").'</td>
								</tr><hr>'; 
							}
						}	
					}
				}
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



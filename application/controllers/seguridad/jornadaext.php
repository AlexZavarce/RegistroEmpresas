<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Jornadaext extends CI_Controller {
	public function __construct(){
		parent::__construct();
		session_start();
		$this->load->helper('url');
		$this->load->database();
		$this->load->library('session');
		$this->load->model('seguridad/jornadaext_model');
	}
	public function diasfinsemana($fechades,$fechahas) {
	    $diasferiados1=$this->diasferiadodiames();
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
			   //	}
		   }
	   	}
	   	return ($diashabiles);
	}
	public function guardarjorext() {
	   	$id=$this->input->post('id');
    	$idemp=$this->input->post('idemp');
    	$descripcion=$this->input->post('descripcion');
        $fechades=$this->input->post('fechades');
        $fechahas = $this->input->post('fechahas');
        $jorext=array(
			'id'=> $this->input->post('id'),
			'empleado'=>$idemp,
			'fechades'=> $fechades,
			'fechahas'=> $fechahas,
			'observacion'=>$descripcion
		);
		$resultado=$this->jornadaext_model->insertarjornada($jorext);
		if($resultado){
            echo json_encode(array(
                "success"   => true,
                "msg"       => "Se Guardo con Éxito." //modificado en la base de datos
            ));
        }else{
            echo json_encode(array(
                "success"   => false,
                "msg"       => "No se puede Guardar." //no se modifico en la base de datos
            ));
        }
	}
	public function sumadias($fechainicio,$dias){
        $datestart= strtotime($fechainicio);
        $diasemana = date('N',$datestart);
        $totaldias = $diasemana+$dias;
        $findesemana =  intval( $totaldias/2) *5 ; 
        $diasabado = $totaldias % 2 ; 
        if ($diasabado==6) $findesemana++;
        if ($diasabado==0) $findesemana=$findesemana++;
        $total = (($dias+$findesemana) * 86400)+$datestart ;  
        return $twstart=date('Y-m-d', $total);
    }
}
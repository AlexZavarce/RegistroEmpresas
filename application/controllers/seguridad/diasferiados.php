<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Diasferiados extends CI_Controller {
	public function __construct(){
		parent::__construct();
		session_start();
		$this->load->helper('url');
		$this->load->database();
		$this->load->library('session');
		$this->load->model('seguridad/diasferiados_model');
	}
	public function guardar_diasferiados() {
        $add    = $_POST['records'];
         if(isset($add)){
            $records = json_decode(stripslashes($add));            
            foreach($records as $record){
                $diaferiado=array(
                    'id' => $record->id,
                    'descripcion'=>$record->$descripcion,
                    'fecha'=> $record->$fecha
                );    
            }
    	
    		$resultado=$this->diasferiados_model->insertardiaferiado($diaferiado);
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
	}
	public function obtenerdiasferiados(){ 
	 	$obtenerdias=$this->diasferiados_model->obtenerdiasferiados();
        if($obtenerdias->num_rows()>0){
            foreach ($obtenerdias->result_array() as $row){
                $data[] = array(                    
                    'id'         => $row['id'],
                    'fecha'      => $row['fecha'],
                    'descripcion' => $row['descripcion']
                );
            }
            $output = array(
                'success' => true,
                'data'    => $data,
            );
            echo json_encode($output);
        }else{
            echo json_encode(array(
                "success"   => false
            ));
        } 
    }
}
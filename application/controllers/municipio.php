<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Municipio extends CI_Controller {
 
    public function __construct(){
        parent::__construct();
        session_start();
        $this->load->model('municipio_model');
        $this->load->helper('url');
        $this->load->database();
        $this->load->library('session');
    }
    
    public function obtenerMunicipio() {
        $estado=($this->input->get('estado')=='')?11:$this->input->get('estado');
        $tipolimi=array();
        if ($tipolimi=$resultdbd=$this->municipio_model->municipio($estado)){
                $this->output->set_content_type('application/json');
                $this->output->set_output(json_encode(array(
                "success" => True,
                'data' => $tipolimi)));
        }   
    }

 
} 
?>
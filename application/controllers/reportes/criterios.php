<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class criterios extends CI_Controller {
  public function __construct(){
        parent::__construct();
        session_start();
        $this->load->helper('url');
        $this->load->database();
        $this->load->library(array('session'));
        $this->load->model('reportes/criterios_model');
        $this->load->model('reportes/criterios_model');
        $this->load->model('pdfs/repasistencia_model');
    }
    
    public function cedula() {
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
            if ($data['tipousuario']==1){
              $division='LIKE "%"'; 
            }else{
              $division='='.$data['divisionusu'];
            }
        } 
        if ($cedula=$resultdbd=$this->criterios_model->cedula($division)){
            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode(array(
            "success" => True,
            'data' => $cedula)));
        }   
    }
    public function nombre() {
        if ($nombre=$resultdbd=$this->criterios_model->nombre()){
            $this->output->set_content_type('application/json');
                $this->output->set_output(json_encode(array(
                "success" => True,
                'data' => $nombre
            )));
        }   
    }
    public function buscarunidad() {
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
            if ($data['tipousuario']==1 || $data['tipousuario']==6 ){
              $division='LIKE "%"'; 
            }else{
              $division='='.$data['divisionusu'];
            }
        } 
        $departamento=$data['departamento'];
        if ($nombre=$this->criterios_model->unidad($division,$departamento)){
            $this->output->set_content_type('application/json');
                $this->output->set_output(json_encode(array(
                "success" => True,
                'data' => $nombre
            )));
        }   
    }
    public function buscarnomina() {
        if ($nomina=$resultdbd=$this->criterios_model->nomina()){
            $this->output->set_content_type('application/json');
                $this->output->set_output(json_encode(array(
                "success" => True,
                'data' => $nomina
            )));
        }   
    }
}
?>
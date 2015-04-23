<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Clase extends CI_Controller {
 
    public function __construct(){
        parent::__construct();
        session_start();
        $this->load->model('empresa/clase_model');
        $this->load->helper('url');
        $this->load->database();
    }
public function obtenerClase(){
    
    if($this->input->get("grupo")==null || $this->input->get("grupo")==''){
      $claseSola = $this->clase_model->obtenerClaseSola();
      foreach ($claseSola->result_array() as $row){
        $data[] = array(
          'id'      => $row['id'],
          'nombre'  => $row['nombre']);
        }
        $output = array(
          'success' => true,
          'data'    => $data,
          'total'   => count($data));
      echo json_encode($output);
    }else{     
      $clases = $this->clase_model->obtenerClase($this->input->get("grupo"));
      foreach ($clases->result_array() as $row){
        $data[] = array(
          'id'      => $row['id'],
          'nombre'  => $row['nombre']);
        }
        $output = array(
          'success' => true,
          'data'    => $data,
          'total'   => count($data));
      echo json_encode($output);
    }
  }
 
}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Division extends CI_Controller {
 
    public function __construct(){
        parent::__construct();
        session_start();
        $this->load->model('empresa/division_model');
        $this->load->helper('url');
        $this->load->database();
    }
public function obtenerDivision(){
    
    if($this->input->get("seccion")==null || $this->input->get("seccion")==''){
      $divisionSola = $this->division_model->obtenerDivisionSola();
      foreach ($divisionSola->result_array() as $row){
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
      $divisiones = $this->division_model->obtenerDivision($this->input->get("seccion"));
      foreach ($divisiones->result_array() as $row){
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
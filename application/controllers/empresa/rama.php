<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rama extends CI_Controller {
 
    public function __construct(){
        parent::__construct();
        session_start();
        $this->load->model('empresa/rama_model');
        $this->load->helper('url');
        $this->load->database();
    }
public function obtenerRama(){
    
    if($this->input->get("clase")==null || $this->input->get("clase")==''){
      $ramaSola = $this->rama_model->obtenerRamaSola();
      foreach ($ramaSola->result_array() as $row){
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
      $ramas = $this->rama_model->obtenerRama($this->input->get("clase"));
      foreach ($ramas->result_array() as $row){
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
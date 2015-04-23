<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Grupo extends CI_Controller {
 
    public function __construct(){
        parent::__construct();
        session_start();
        $this->load->model('empresa/grupo_model');
        $this->load->helper('url');
        $this->load->database();
    }
public function obtenerGrupo(){
    
    if($this->input->get("division")==null || $this->input->get("division")==''){
      $grupoSola = $this->grupo_model->obtenerGrupoSola();
      foreach ($grupoSola->result_array() as $row){
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
      $grupos = $this->grupo_model->obtenerGrupo($this->input->get("division"));
      foreach ($grupos->result_array() as $row){
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
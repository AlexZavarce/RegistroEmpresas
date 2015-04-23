<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Parroquia extends CI_Controller {
 
    public function __construct(){
        parent::__construct();
        session_start();
        $this->load->model('parroquia_model');
        $this->load->helper('url');
        $this->load->database();
    }
public function obtenerParroquia(){
    $this->load->model("Parroquia_model"); 
    if($this->input->get("municipio")==null || $this->input->get("municipio")==''){
      $parroquiaSola = $this->parroquia_model->obtenerParroquiaSola();
      foreach ($parroquiaSola->result_array() as $row){
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
      $parroquias = $this->Parroquia_model->obtenerParroquia($this->input->get("municipio"));
      foreach ($parroquias->result_array() as $row){
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
  public function obtenerComunidad(){
    $this->load->model("comunidad_model"); 
    if($this->input->get("parroquia")==null || $this->input->get("parroquia")==''){
      $comunidadSola = $this->comunidad_model->obtenerComunidadSola();
      foreach ($comunidadSola->result_array() as $row){
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
      $comunidades = $this->comunidad_model->obtenerComunidad($this->input->get("parroquia"));
      foreach ($comunidades->result_array() as $row){
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
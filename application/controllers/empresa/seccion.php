<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Seccion extends CI_Controller {
  public function __construct(){
    parent::__construct();
    session_start();
    $this->load->helper('url');
    $this->load->database();
    $this->load->model('empresa/seccion_model');
    $this->load->library(array('session'));
  }
  public function index() {
    //$this->load->view('administrativo');
  }
  public function obtenerSeccion() {
    $tipolimi=array();
    if ($tipolimi=$resultdbd=$this->seccion_model->seccion()){
      $this->output->set_content_type('application/json');
      $this->output->set_output(json_encode(array(
      "success" => True,
      'data' => $tipolimi)));
    }   
  }
}
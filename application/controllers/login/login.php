<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login extends CI_Controller {
  public function __construct(){
    parent::__construct();
    session_start();
    $this->load->helper('url');
    $this->load->database();
    $this->load->model('login/login_model');
    $this->load->library(array('session'));
  }
  public function index() {
    $this->load->view('administrativo');
  }
  public function captcha(){
    $this->load->helper('captcha');
    $vals = array(
      'word'      => mt_rand(10000,99999),
      'img_path'    => './captcha/',
      'img_url'   => base_url().'/captcha/',
      'font_path'   => './fonts/chun.ttf',
      'img_width'   => 100,
      'img_height'  => 50,
      'expiration'  => 7200
    );
    $captcha = create_captcha($vals);
    $this->cambiarPermisos(base_url().'/captcha/','0777');
    /*while ($captcha['time']==null) {
      $captcha = create_captcha($vals);
    }*/
    if (!isset($_SESSION)){
      session_start();
    }
    $_SESSION['captcha'] = $captcha['word'];
    echo json_encode(array(
        "success" => true,
        "data"    => array('image' => $captcha['time'])
    ));
  }
  public function session() {
    $username = $this->session->userdata('datasession');
    $usu = $username['usuario_id'];
    $password =$username['password'];
    if ($resulta=$this->login_model->verificasession($username['usuario_id'],$username['password']))  {  
      foreach ($resulta->result_array() as $row) {
        $data[] = array(
          'usuario'        => $row['usuario'],
          'foto'           => $row['foto'],
        );
      }
      $dato = array(
            'success' => true,
            'data' => $data,
      );
      echo json_encode($dato);
    }
  }
  public function traersession() {
    $username = $this->session->userdata('datasession');
    $cedula = $username['cedula'];
    $nacionalidad =$username['nacionalidad']; 
    $dato[] = array(
      'cedula'         => $cedula,
      'nacionalidad'   => $nacionalidad,
    );
    $this->output->set_output(json_encode(array(
      'data' => $dato
    ))); 
  }
  public function validar(){
    $username = $this->session->userdata('datasession');
    if($username['login_ok'] ){
      echo json_encode(array(
            "success" => true
        ));
    } else {
        echo json_encode(array(
            "success" => false
        ));
    }
  }
  public function auth() {
    if ($this->input->post('user')){
      $usuario = $this->input->post('user');
      $contrasena = $this->input->post('pass');
      $resultado=array();
      $datasession = array();
      $resultado=$this->login_model->verificaUsuario($_POST['user'], $_POST['pass']);
      if ($resultado->num_rows() >0){
        foreach ($resultado->result_array() as $row){
          $variable='Ok';
          $datasession = array(
          'id'  => $row['id'],
          'cedula'=> $row['cedula'],
          'usuario'=> $row['usuario'],
          'status'=> $row['status'],
          'tipousuario'=>$row['tipousuario'],
          'login_ok' => TRUE,
          'usuario_id'  => $_POST['user'],
          'password'=> $_POST['pass'],
          'nacionalidad' => $row['nacionalidad']);
          if ($datasession['status']==1) {
            $this->session->set_userdata('datasession',$datasession);
            $post_array = $this->session->userdata('datasession');
            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode(array(
              'success' => true,
              'msg' => 'usuario autentificado',
              'tipousuario'=>$datasession['tipousuario'],
              'data' => $datasession
            )));     
          }else{
            $this->output->set_output(json_encode(array(
            'success' => false,
            'msg' => 'Usuario esta inactivo,consulte al Administrador del Sistema'))); 
          }
        } 
      }else {
        $this->output->set_output(json_encode(array(
          'success' => false,
          'msg' => 'usuario o password incorrecto'
        ))); 
      }
      }else{
        $this->output->set_output(json_encode(array(
        'success' => false,
        'msg' => 'usuario o password incorrecto'))); 
      }
    }
  function logout(){
    $this->session->sess_destroy();
    $this->index();
  }
}
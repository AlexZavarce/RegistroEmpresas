<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 class Login_model extends CI_Model {
   function __construct(){
    $this->load->database();
    $this->load->library('session');
     $this->load->library(array('session'));
  }
  function verificasession($usu, $password) {
    $this->db->select('usuario,foto');
    $this->db->where('usuario', $usu);
    $this->db->where('password', $password);
    $resultado= $this->db->get('usuario');
    return $resultado;
  }
  function verificaUsuario($usuario, $contrasena) {
    $this->db->select('id, usuario,status,cedula,nacionalidad,tipousuario');
    $this->db->where('usuario', $usuario);
    $this->db->where('password', $contrasena);
    $this->db->limit(1);
    $query = $this->db->get('usuario');
    return $query;
  }
}


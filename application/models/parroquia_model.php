<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Parroquia_model extends CI_Model {
  
  function __construct(){
    $this->load->database();
  }
  public function obtenerParroquia($municipio){
    $this->db->order_by("nombre", "asc");     
      return $consulta = $this->db->get_where('parroquia',array('municipio' => $municipio));    
    }
    
  public function obtenerParroquiaSola(){ 
    $this->db->order_by("nombre", "asc");     
    return $consulta = $this->db->get_where('parroquia');    
  } 


}


<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Comunidad_model extends CI_Model {
  
  function __construct(){
    $this->load->database();
  }
  public function obtenerComunidad($parroquia){
    $this->db->order_by("id", "asc");     
      return $consulta = $this->db->get_where('comunidad',array('parroquia' => $parroquia));    
    }
    
  public function obtenerComunidadSola(){ 
    $this->db->order_by("id", "asc");     
    return $consulta = $this->db->get_where('comunidad');    
  } 


}
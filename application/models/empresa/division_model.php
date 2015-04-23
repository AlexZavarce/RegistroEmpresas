<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Division_model extends CI_Model {
  
  function __construct(){
    $this->load->database();
  }
  public function obtenerDivision($seccion){
    $this->db->order_by("nombre", "asc");     
      return $consulta = $this->db->get_where('divisionact',array('seccion' => $seccion));    
    }
    
  public function obtenerDivisionSola(){ 
    $this->db->order_by("nombre", "asc");     
    return $consulta = $this->db->get_where('divisionact');    
  } 


}
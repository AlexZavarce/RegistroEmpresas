<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Rama_model extends CI_Model {
  
  function __construct(){
    $this->load->database();
  }
  public function obtenerRama($clase){
    $this->db->order_by("nombre", "asc");     
      return $consulta = $this->db->get_where('ramaact',array('claseact' => $clase));    
    }
    
  public function obtenerRamaSola(){ 
    $this->db->order_by("nombre", "asc");     
    return $consulta = $this->db->get_where('ramaact');    
  } 


}
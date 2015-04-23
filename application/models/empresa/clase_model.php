<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Clase_model extends CI_Model {
  
  function __construct(){
    $this->load->database();
  }
  public function obtenerClase($grupo){
    $this->db->order_by("nombre", "asc");     
      return $consulta = $this->db->get_where('claseact',array('grupoact' => $grupo));    
    }
    
  public function obtenerClaseSola(){ 
    $this->db->order_by("nombre", "asc");     
    return $consulta = $this->db->get_where('claseact');    
  } 


}
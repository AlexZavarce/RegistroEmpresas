<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Grupo_model extends CI_Model {
  
  function __construct(){
    $this->load->database();
  }
  public function obtenerGrupo($division){
    $this->db->order_by("nombre", "asc");     
      return $consulta = $this->db->get_where('grupoact',array('division' => $division));    
    }
    
  public function obtenerGrupoSola(){ 
    $this->db->order_by("nombre", "asc");     
    return $consulta = $this->db->get_where('grupoact');    
  } 


}
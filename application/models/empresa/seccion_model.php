<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Seccion_model extends CI_Model {
  
  function __construct(){
    $this->load->database();
  }
  function  seccion() {
    $query1 = $this->db->query("SELECT * FROM seccion ORDER BY id");
    $tipo=array();  
    if ($query1->num_rows() > 0){
      foreach ($query1->result() as $division)
      {
        $tipo[] = $division; //TRAE EL ARRAY
      }
      return $tipo;
      $query1->free-result();
    } 
  }
  // public function municipio($estado)
  //   {
  //     $this->db->order_by("nombre", "asc");       
  //     return $consulta = $this->db->get_where('municipio',array('estado' => $estado));    
  // }    
}

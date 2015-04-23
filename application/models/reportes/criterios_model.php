<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Criterios_model extends CI_Model {
  
  function __construct(){
    $this->load->database();
  }
  function cedula($division) {
    $query1 = $this->db->query("SELECT empleado.cedula as cedula FROM empleado where empleado.division $division");
    $tipo=array();  
    if ($query1->num_rows() > 0){
      foreach ($query1->result() as $cedula)
      {
        $tipo[] = $cedula; 
      }
      return $tipo;
      $query1->free-result();
    } 
  }
  function nombre() {
    $query1 = $this->db->query("SELECT CONCAT(persona.apellido,' ',persona.nombre) as nombre FROM persona order by nombre");
    $tipo=array();  
    if ($query1->num_rows() > 0){
      foreach ($query1->result() as $nombre)
      {
        $tipo[] = $nombre; 
      }
      return $tipo;
      $query1->free-result();
    } 
  }
  function unidad($division,$departamento) {
    $query1 = $this->db->query("SELECT distinct division.id as id,division.nombre as nombre
    FROM division,empleado,departamento
    WHERE empleado.division=division.id
    AND division.id $division
    AND departamento.id=division.departamento
    AND departamento.id=$departamento");
    $tipo=array();  
    if ($query1->num_rows() > 0){
      foreach ($query1->result() as $nombre)
      {
        $tipo[] = $nombre; 
      }
      return $tipo;
      $query1->free-result();
    } 
  }
  function nomina() {
    $query1 = $this->db->query("SELECT tiponomina.id as id,tiponomina.nombre as nombre FROM tiponomina order by id");
    $tipo=array();  
    if ($query1->num_rows() > 0){
      foreach ($query1->result() as $nombre)
      {
        $tipo[] = $nombre; 
      }
      return $tipo;
      $query1->free-result();
    } 
  }
}
?>

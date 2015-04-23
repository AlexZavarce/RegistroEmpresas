<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 class Empresa_model extends CI_Model {
  function __construct(){
    $this->load->database();
    $this->load->library('session');
     $this->load->library(array('session'));
  }
  function buscarrif(){
    $query = $this->db->query("SELECT usuariolinea.id as id,usuariolinea.cedula as cedula,usuariolinea.correo as correo,usuariolinea.rif as rif,usuariolinea.status as status,usuariolinea.nacionalidad as nacionalidad
    FROM usuariolinea
    WHERE usuariolinea.status=0");
    $resultado = array();
    $resultdb=array();  
    if ($query->num_rows() > 0){
      foreach ($query->result() as $row)
      {
        $resultado[] = $row;
      }
      return $resultado;
      $query->free-result();
    } 
  }
  public function obtenerEmpresa($usuario){
        $sql= "SELECT * FROM empresa WHERE empresa.rif=? ";
        $consulta=$this->db->query($sql,array($usuario));
        if($consulta->num_rows() == 1){
            return $consulta;
        }else{
            return false;
        }   
    }
  function buscaregistro(){
    $query = $this->db->query("SELECT registro.id as id,registro.nombre as nombre
    FROM registro");
    $resultado = array();
    $resultdb=array();  
    if ($query->num_rows() > 0){
      foreach ($query->result() as $row)
      {
        $resultado[] = $row;
      }
      return $resultado;
      $query->free-result();
    }  
  }  
  function insertarempresa($empresa){
    $this->db->set($empresa);
    $this->db->insert('empresa');
   //return  mysql_insert_id();
    return $this->db->insert_id();
  }
}


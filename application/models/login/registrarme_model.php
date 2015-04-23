<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 class Registrarme_model extends CI_Model {
   function __construct(){
    $this->load->database();
    $this->load->library('session');
     $this->load->library(array('session'));
  }
  
  function verificaUsuariolinea($rif) {
    $this->db->select('id,rif,nacionalidad,cedula,status,correo');
    $this->db->where('rif', $rif);
    $this->db->limit(1);
    $query = $this->db->get('usuariolinea');
    return $query;
  }
  function Revisarrif() {
  /*$this->db->select('usuario.id,persona.nombre,persona.correo,persona.apellido');
    $this->db->from('usuario','persona');
    $this->db->where('usuario.tipousuario', 2);
    $this->db->where('usuario.cedula', 'persona.cedula');
    $this->db->where('usuario.nacionalidad', 'persona.nacionalidad');
    $this->db->limit(1);
    $query = $this->db->get('usuario');
    return $query;*/
    $sql="SELECT usuario.id,persona.nombre,persona.correo,persona.apellido 
    FROM persona,usuario
    WHERE usuario.cedula=persona.cedula 
    AND usuario.tipousuario=2
    AND persona.nacionalidad=usuario.nacionalidad";
    $consulta=$this->db->query($sql);  
    if($consulta->num_rows()>0){
        return $consulta;
    }else{          
        return false;
    }
  }
  function insertUsuariolinea($insertarusuariolinea){
      $this->db->set($insertarusuariolinea);
    $this->db->insert('usuariolinea');
   //return  mysql_insert_id();
    return $this->db->insert_id();
  }
}
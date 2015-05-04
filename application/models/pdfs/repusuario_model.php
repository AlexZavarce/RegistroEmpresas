<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Repusuario_model extends CI_Model {
  
  function __construct(){
    $this->load->database();
  }
  function getUsuarioSinEmpresa() {
    $query1 = $this->db->query("SELECT usuario.cedula as cedula, usuariolinea.rif as rif, usuariolinea.razonsocial as razonsocial, usuariolinea.correo as correo FROM usuario inner join usuariolinea on usuario.tipousuario=4 and usuario.cedula = usuariolinea.cedula and usuario.nacionalidad=usuariolinea.nacionalidad and usuariolinea.status=1 and usuario.cedula not in (select cedularep from empresa) group by usuario.cedula");
    
    return $query1;
  }
}
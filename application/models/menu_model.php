<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Menu_model extends CI_Model {
  function __construct(){
    $this->load->database();
    $this->load->library('session','datasession');
  }
  function cargarmenu() {
    $username=$this->session->userdata('datasession');
    $usuario = $username['usuario_id'];
    $pass=$username['password'];
    $queryString= $this->db->query("Select p.menuid menuId 
      FROM usuario u INNER JOIN permisos p ON u.tipousuario= p.grupoid 
      INNER JOIN menu m ON p.menuid = m.id
      WHERE u.usuario ='$usuario' 
      AND u.password='$pass'");
    $folder = array();
    if ($queryString ->num_rows() > 0){
      $in = '('; 
        foreach($queryString->result_array() as $user){
          $in .= $user['menuId'] . ","; 
        }
      $in = substr($in, 0, -1) . ")"; 
      $queryString->free_result(); 
      $sql= $this->db->query(" SELECT * FROM menu WHERE parent_id IS NULL  AND id in $in");
      if ($sql->num_rows() > 0){
        foreach($sql->result_array() as $r){
          $sqlquery = $this->db->query("SELECT * FROM menu WHERE parent_id = '".$r['id'] ."' AND id in $in");
          if ($sqlquery->num_rows() > 0){
            $count =mysql_affected_rows();
            //$count = $sqlquery->num_rows();
              if ($count>0){
              $r['leaf'] = false; 
              $r['items'] = array(); 
              foreach($sqlquery->result_array() as $item ){
                $item['leaf'] = true; 
                $r['items'][] = $item; 
              }
            }else {
              $r['leaf'] = true;
            }
            $folder[] = $r; 
          } 
        }
       return $folder;
      }
    }
  }
}
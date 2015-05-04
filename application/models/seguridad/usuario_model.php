<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 class usuario_model extends CI_Model {
  function __construct(){
    $this->load->database();
  }
  function cargarusuario($cedula,$nacionalidad) {
    $query = $this->db->query("SELECT a.id,a.usuario,a.password,a.tipousuario,d.foto as foto,
      a.cedula,a.nacionalidad,IF(a.status='1', 'Activo', 'Inactivo') as status,
      b.nombre as ntipousuario,c.nombre,c.apellido,c.direccion,c.correo as correo 
      FROM usuario a,tipousuario b,persona c,empleado d,division e
      WHERE a.tipousuario=b.id 
      AND e.id=d.division
      AND e.departamento=(SELECT departamento.id FROM empleado ,division ,departamento, usuario WHERE usuario.cedula='$cedula' AND usuario.nacionalidad='V' AND usuario.cedula=empleado.cedula AND usuario.nacionalidad=empleado.nacionalidad and empleado.division=division.id and division.departamento=departamento.id)
      AND a.cedula=c.cedula 
      AND a.nacionalidad=c.nacionalidad
      AND a.cedula=d.cedula 
      AND a.nacionalidad=d.nacionalidad
      AND d.cedula=c.cedula 
      AND d.nacionalidad=c.nacionalidad");
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
   function cargarusuario2($cedula,$nacionalidad) {
    $query = $this->db->query("SELECT a.id,a.usuario,a.password,a.tipousuario, a.cedula,a.nacionalidad,IF(a.status='1', 'Activo', 'Inactivo') as status, b.nombre as ntipousuario,c.nombre,c.apellido,c.direccion,c.correo as correo FROM usuario a,tipousuario b,persona c,division e WHERE a.tipousuario=b.id AND a.cedula=c.cedula AND a.nacionalidad=c.nacionalidad group by a.id
     
      
  ");
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
  function updateusuariolinea($usuario){
    $query = $this->db->query("UPDATE usuariolinea SET status=1 where rif='$usuario'");
  }
  function existepersona($cedula,$nacionalidad){
   $query =$this->db->query("SELECT * FROM persona where cedula ='$cedula' and nacionalidad='$nacionalidad'");
    if ($query->num_rows() > 0){
      $tipo = $query;
    }else{
       $tipo = '';
    }
    return $tipo;
  }
  function cargarusuariodiv($cedula,$nacionalidad) {
    $query = $this->db->query("SELECT a.id,a.usuario,a.password,a.tipousuario,d.foto as foto,
      a.cedula,a.nacionalidad,IF(a.status='1', 'Activo', 'Inactivo') as status,
      b.nombre as ntipousuario,c.nombre,c.apellido,c.direccion,c.correo as correo 
      FROM usuario a,tipousuario b,persona c,empleado d,division e
      WHERE a.tipousuario=b.id 
      AND d.division=e.id 
      AND  d.division=(SELECT division FROM empleado, usuario WHERE usuario.cedula='$cedula' AND usuario.nacionalidad='V' AND usuario.cedula=empleado.cedula AND usuario.nacionalidad=empleado.nacionalidad)
      AND e.departamento=(SELECT departamento.id FROM empleado ,division ,departamento, usuario WHERE usuario.cedula='$cedula' AND usuario.nacionalidad='V' AND usuario.cedula=empleado.cedula AND usuario.nacionalidad=empleado.nacionalidad and empleado.division=division.id and division.departamento=departamento.id)
      AND a.cedula=c.cedula 
      AND a.nacionalidad=c.nacionalidad
      AND a.cedula=d.cedula 
      AND a.nacionalidad=d.nacionalidad
      AND d.cedula=c.cedula 
      AND d.nacionalidad=c.nacionalidad");
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
   function cargarusuariodiv2($cedula,$nacionalidad) {
    $query = $this->db->query("2SELECT a.id,a.usuario,a.password,a.tipousuario,d.foto as foto,
      a.cedula,a.nacionalidad,IF(a.status='1', 'Activo', 'Inactivo') as status,
      b.nombre as ntipousuario,c.nombre,c.apellido,c.direccion,c.correo as correo 
      FROM usuario a,tipousuario b,persona c,empleado d,division e
      WHERE a.tipousuario=b.id 
     
     
     ");
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
  function tipousuario() {
    $query1 = $this->db->query("SELECT * FROM tipousuario");
    $tipo=array();  
    if ($query1->num_rows() > 0){
      foreach ($query1->result() as $tipousuario)
      {
        $tipo[] = $tipousuario;
      }
      return $tipo;
      $query1->free-result();
    } 
  }
  function insertusuario($datausuario){
      $this->db->set($datausuario);
    $this->db->insert('usuario');
   //return  mysql_insert_id();
    return $this->db->insert_id();
  }
  function insertpersona($datapersona){
    return $this->db->insert('persona', $datapersona);
  }
  function updateusuario($datausuario){
    $this->db->set($datausuario);
    $this->db->where('id', $datausuario['id']);
    return $this->db->update('usuario');
  }
  function updatepersona($datapersona){
    $this->db->set($datapersona);
    $this->db->where('cedula', $datapersona['cedula']);
    $this->db->where('nacionalidad', $datapersona['nacionalidad']);
    return $this->db->update('persona');
  }
  function updateempleado($dataempleado){
    $this->db->set('foto',$dataempleado['foto']);
    $this->db->where('cedula', $dataempleado['cedula']);
    $this->db->where('nacionalidad', $dataempleado['nacionalidad']);
    return $this->db->update('empleado');
  }
  function deletePersona($datopersona){
    $this->db->where('cedula', $datopersona['cedula']);
    $this->db->where('nacionalidad', $datopersona['nacionalidad']);
    return $this->db->delete('persona'); 
    
  }
  function deleteUsuario($datousuario){
    $this->db->where('id', $datousuario['id']);
    return $this->db->delete('usuario'); 
  }
 function existeusuario($cedula, $nacionalidad) {
    $query =$this->db->query("SELECT * FROM usuario where cedula ='$cedula' and nacionalidad='$nacionalidad' ");
    if ($query->num_rows() > 0){
      $tipo = $query;
    }else{
       $tipo = '';
    }
    return $tipo;
  }
  function existecontrasena($cedula, $nacionalidad,$contrasena) {
    $query =$this->db->query("SELECT * FROM usuario where cedula ='$cedula' and nacionalidad='$nacionalidad' and password='$contrasena'");
    if ($query->num_rows() > 0){
      $tipo = $query;
    }else{
       $tipo = '';
    }
    return $tipo;
  }
  function updatecontrasena($datacontrasena){
    $this->db->set($datacontrasena);
     $this->db->where('cedula', $datacontrasena['cedula']);
    $this->db->where('nacionalidad', $datacontrasena['nacionalidad']); 
    return $this->db->update('usuario');
  }
  
  function verificarPersona($cedula,$nacionalidad){
   $query =$this->db->query("SELECT * FROM persona where cedula ='$cedula' ");
    if ($query->num_rows() > 0){
      $tipo = $query;
    }else{
       $tipo = '';
    }
    return $tipo;
  }

  function verificarcorreo($correo){
    $query =$this->db->query("SELECT * FROM usuariolinea where correo ='$correo' ");
    if ($query->num_rows() > 0){
      $tipo = $query;
    }else{
       $tipo = '';
    }
    return $tipo;
   }
}





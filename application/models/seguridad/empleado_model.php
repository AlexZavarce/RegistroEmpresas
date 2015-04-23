<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 class empleado_model extends CI_Model {
  function __construct(){
    $this->load->database();
  }
  function cargarempleado($cedula,$nacionalidad) {
    $query = $this->db->query("SELECT a.id,a.cedula,a.nacionalidad,a.tiponomina,a.estatus ,e.nombre as divisionnombre,
      a.fechaingreso as fechaingreso,a.cargo as cargo,IF(a.estatus='1', 'Activo', 'Inactivo') as estatus,
      a.division as division,a.horario as horario,b.correo as correo,substring(b.movil,4) as movil,substring(b.fijo,4) as fijo,substring(b.movil,1,3) as codmovil,substring(b.fijo,1,3) as codfijo,b.direccion as direccion,b.sexo as sexo,b.edocivil as edocivil,
      b.fechanac as fechanac, a.foto as foto,b.hijos as hijos,b.canthijos as canthijos,b.profesion as profesion,
      a.tiponomina as tiponomina,
      a.foto as foto,
      b.nombre  as nombres,b.apellido as apellido
      FROM persona b,empleado a,division e
      WHERE  e.id=a.division
      AND e.departamento=(SELECT departamento.id FROM empleado ,division ,departamento, usuario WHERE usuario.cedula='$cedula' AND usuario.nacionalidad='V' AND usuario.cedula=empleado.cedula AND usuario.nacionalidad=empleado.nacionalidad and empleado.division=division.id and division.departamento=departamento.id)
      AND a.cedula=b.cedula 
      AND a.nacionalidad=b.nacionalidad
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
  function cargarempleadodiv($cedula,$nacionalidad) {
    $query = $this->db->query("SELECT a.id,a.cedula,a.nacionalidad,a.tiponomina,a.estatus ,e.nombre as divisionnombre,
      a.fechaingreso as fechaingreso,a.cargo as cargo,IF(a.estatus='1', 'Activo', 'Inactivo') as estatus,
      a.division as division,a.horario as horario,b.correo as correo,substring(b.movil,4) as movil,substring(b.fijo,4) as fijo,substring(b.movil,1,3) as codmovil,substring(b.fijo,1,3) as codfijo,b.direccion as direccion,b.sexo as sexo,b.edocivil as edocivil,
      b.fechanac as fechanac, a.foto as foto,b.hijos as hijos,b.canthijos as canthijos,b.profesion as profesion,
      a.tiponomina as tiponomina,
      a.foto as foto,
      b.nombre  as nombres,b.apellido as apellido
      FROM persona b,empleado a,division e
      WHERE  e.id=a.division
      AND  e.id=(SELECT division FROM empleado, usuario WHERE usuario.cedula='$cedula' AND usuario.nacionalidad='V' AND usuario.cedula=empleado.cedula AND usuario.nacionalidad=empleado.nacionalidad)
      AND e.departamento=(SELECT departamento.id FROM empleado ,division ,departamento, usuario
      WHERE usuario.cedula='$cedula'
      AND usuario.nacionalidad='V' 
      AND usuario.cedula=empleado.cedula 
      AND usuario.nacionalidad=empleado.nacionalidad and empleado.division=division.id and division.departamento=departamento.id)
      AND a.cedula=b.cedula 
      AND a.nacionalidad=b.nacionalidad
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
  function buscarFoto($cedula,$nacionalidad){
  $sql="SELECT empleado.foto 
    FROM empleado
    WHERE empleado.cedula='$cedula' 
    AND empleado.nacionalidad='V'";
    $consulta=$this->db->query($sql,array($cedula,$nacionalidad));  
    if($consulta->num_rows()>0){
        return $consulta;
    }else{          
        return false;
    }
  }
  function horario() {
    $query1 = $this->db->query("SELECT horario.id as id,CONCAT(TIME_FORMAT(horario.horaentrada, '%h:%i') ,' - ', (TIME_FORMAT(horario.horasalida, '%h:%i' ))) as hora
     FROM horario");
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
  function cargos() {
    $query1 = $this->db->query("SELECT *
     FROM cargo");
    $cargo=array();  
    if ($query1->num_rows() > 0){
      foreach ($query1->result() as $cargos)
      {
        $cargo[] = $cargos;
      }
      return $cargo;
      $query1->free-result();
    } 
  }
  function existemp($cedula, $nacionalidad) {
    $query =$this->db->query("SELECT * FROM empleado where cedula ='$cedula' and nacionalidad='$nacionalidad' ");
    if ($query->num_rows() > 0){
      $tipo = $query;
    }else{
       $tipo = '';
    }
    return $tipo;
  }
   function insertempleado($dataempleado){
      $this->db->set($dataempleado);
    $this->db->insert('empleado');
   //return  mysql_insert_id();
    return $this->db->insert_id();
  }
  function insertpersona($datapersona){
    return $this->db->insert('persona', $datapersona);
  }
  function updateempleado($dataempleado){
    $this->db->set($dataempleado);
    $this->db->where('id', $dataempleado['id']);
    return $this->db->update('empleado');
  }
  function updatepersona($datapersona){
    $this->db->set($datapersona);
    $this->db->where('cedula', $datapersona['cedula']);
    $this->db->where('nacionalidad', $datapersona['nacionalidad']);
    return $this->db->update('persona');
  }
  function existeempleado($cedula, $nacionalidad) {
    $query =$this->db->query("SELECT * FROM empleado where cedula ='$cedula' and nacionalidad='$nacionalidad' ");
    if ($query->num_rows() > 0){
      $tipo = $query;
    }else{
       $tipo = '';
    }
    return $tipo;
  }
}
<?php 
class Inasistencia_model extends CI_Model
{
	function __construct(){
		parent::__construct();
	}
	public function getempleado($divisionasis,$tiponomina,$cedula,$fechades,$fechahas){
		$query = $this->db->query("SELECT empleado.cedula as cedula,CONCAT(persona.nombre,' ', persona.apellido) as nombre,
		persona.apellido as apellido,asistencia.fecha as fecha,empleado.id as id
		FROM empleado
		INNER JOIN persona on empleado.cedula=persona.cedula and persona.nacionalidad=empleado.nacionalidad
		INNER JOIN division on empleado.division=$divisionasis  and empleado.division=division.id
		INNER JOIN departamento on division.departamento=departamento.id
		LEFT JOIN asistencia on empleado.id=asistencia.empleado  AND  (asistencia.fecha)>='$fechades'
		AND (asistencia.fecha)<='$fechahas'
		WHERE empleado.tiponomina<>1
		AND empleado.tiponomina $tiponomina
		AND empleado.cedula $cedula
		AND empleado.estatus=1");
		return $query;
	}
	public function getempleadodes($divisionasis,$tiponomina,$cedula,$fechades,$fechahas,$departamento){
		$query = $this->db->query("SELECT empleado.cedula as cedula,CONCAT(persona.nombre,' ', persona.apellido) as nombre,
		persona.apellido as apellido,asistencia.fecha as fecha,empleado.id as id
		FROM empleado
		INNER JOIN persona on empleado.cedula=persona.cedula and persona.nacionalidad=empleado.nacionalidad
		INNER JOIN division on (empleado.division=$divisionasis OR empleado.tiponomina=1 )   and empleado.division=division.id
		INNER JOIN departamento on division.departamento=departamento.id and departamento.id=$departamento
		LEFT JOIN asistencia on empleado.id=asistencia.empleado  AND  (asistencia.fecha)>='$fechades'
		AND (asistencia.fecha)<='$fechahas'
		WHERE empleado.tiponomina $tiponomina
		AND empleado.cedula $cedula
		AND empleado.estatus=1");
		return $query;
	}
	
	public function getdivision($division,$departamento){
		$query = $this->db->query("SELECT distinct division.id as division,division.nombre as nombredivision,departamento.id as iddep,departamento.nombre as departamento
		FROM division,empleado,departamento
		WHERE empleado.division=division.id
		AND division.id $division
		AND departamento.id=division.departamento
		and empleado.tiponomina<>1
		AND departamento.id=$departamento");
		return $query;
	}
	public function getdivisionusu($usuarioced){
		$query = $this->db->query("SELECT empleado.division as divisionusu,usuario.tipousuario as tipousuario,departamento.id as departamento,
		CONCAT(persona.nombre,' ', persona.apellido) as nombre,departamento.correodep as correodep,departamento.clave as clave,empleado.cedula as cedulaemp,cargo.nombre as cargoemp 
		FROM empleado 
		INNER JOIN persona on persona.cedula=empleado.cedula and persona.nacionalidad=empleado.nacionalidad
		INNER JOIN usuario on usuario.cedula=empleado.cedula and usuario.nacionalidad=empleado.nacionalidad
		INNER JOIN division on  empleado.division=division.id
		INNER JOIN cargo on empleado.cargo =cargo.id
        INNER JOIN departamento on departamento.id=division.departamento
		WHERE empleado.cedula=$usuarioced");
		return $query;
	}
	public function getpermisos($resulta,$id){
		$query = $this->db->query("SELECT *
			FROM permisosemp 
			WHERE permisosemp.empleado=$id
			AND '$resulta'>=permisosemp.fechadesde 
			AND '$resulta'<=permisosemp.fechahasta
			AND permisosemp.status=1");
		return $query;
	}
	public function gettiponomina($tiponomina){
		$query = $this->db->query("SELECT tiponomina.nombre as nombrenomina
			FROM tiponomina 
			WHERE tiponomina.id $tiponomina
			");
		return $query;
	}
	public function verificarJefes($divisionusu) {
	$query = $this->db->query("SELECT empleado.cedula as cedula,CONCAT(persona.nombre,' ', persona.apellido) as nombre,
		cargo.nombre as cargo,persona.correo as correojef 
		FROM empleado
		INNER JOIN persona on empleado.cedula=persona.cedula and persona.nacionalidad=empleado.nacionalidad
		INNER JOIN tiponomina on empleado.tiponomina =tiponomina.id
		INNER JOIN division on empleado.division=division.id and division.id=$divisionusu
		INNER JOIN cargo on empleado.cargo =cargo.id
		INNER JOIN departamento on division.departamento=departamento.id
		INNER JOIN usuario on usuario.cedula=empleado.cedula and usuario.nacionalidad=empleado.nacionalidad
		where tiponomina.id=1 and empleado.estatus<>0");
		return $query;
	}
	public function verificarJefesdep($departamento) {
	$query = $this->db->query("SELECT empleado.cedula as ceduladep,CONCAT(persona.nombre,' ', persona.apellido) as nombredep,
		cargo.nombre as cargodep,departamento.nombre as departamentonombre 
		FROM empleado
		INNER JOIN persona on empleado.cedula=persona.cedula and persona.nacionalidad=empleado.nacionalidad
		INNER JOIN tiponomina on empleado.tiponomina =tiponomina.id
		INNER JOIN division on empleado.division=division.id 
		INNER JOIN cargo on empleado.cargo =cargo.id and cargo.rango=1
		INNER JOIN departamento on division.departamento=departamento.id and departamento.id=$departamento
		INNER JOIN usuario on usuario.cedula=empleado.cedula and usuario.nacionalidad=empleado.nacionalidad
		where tiponomina.id=1 ");
		return $query;
	}
	public function diasferiadodiames(){
		$sql= "SELECT DATE_FORMAT(fecha,'%Y-%m-%d')as fecha 
		FROM diasferiados";
		$consulta=$this->db->query($sql);  
      	if($consulta->num_rows() >=1)
        	return $consulta;
      	else          
        return false;  
    }
    public function diasferiadorango($fechades,$fechahas){
    	$sql= "SELECT DATE_FORMAT(fecha,'%Y-%m-%d') as fecha 
		FROM diasferiados WHERE fecha>='$fechades'  and fecha<='$fechahas' order by fecha";
		$consulta=$this->db->query($sql);  
      	if($consulta->num_rows()>=1)
        	return $consulta;
      	else          
        return false;   
    }    
}

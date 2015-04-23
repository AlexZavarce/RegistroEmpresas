<?php 
class Repasistencia_model extends CI_Model
{
	function __construct(){
		parent::__construct();
	}
	public function getdivision($division,$departamento){
		$query = $this->db->query("SELECT distinct division.id as division,division.nombre as nombredivision,departamento.id as iddep,departamento.nombre as departamento
		FROM division,empleado,departamento
		WHERE empleado.division=division.id
		AND division.id $division
		AND departamento.id=division.departamento
		AND empleado.tiponomina<>1
		AND departamento.id=$departamento");
		return $query;
	}
	public function getasistencia($divisionasis,$cedula,$fechades,$fechahas,$tiponomina,$retardos){
		$query = $this->db->query("SELECT asistencia.fecha,horario.horaentrada as horarioentrada,
		asistencia.horaentrada as horaentrada,asistencia.horasalida as horasalida, (TIMEDIFF( asistencia.horaentrada, horario.horaentrada )
		)  AS tiemporetardo,empleado.cedula as cedula,persona.nombre as nombre,persona.apellido as apellido,empleado.id as id
		FROM empleado
       	INNER JOIN persona on empleado.cedula=persona.cedula and persona.nacionalidad=empleado.nacionalidad
       	INNER JOIN horario ON horario.id = empleado.horario
       	INNER JOIN division on empleado.division=$divisionasis  and empleado.division=division.id
       	INNER JOIN departamento on division.departamento=departamento.id
		LEFT JOIN asistencia on empleado.id=asistencia.empleado  AND  (asistencia.fecha)>='$fechades'
		AND (asistencia.fecha)<='$fechahas' 
		WHERE empleado.tiponomina<>1 
		AND empleado.tiponomina $tiponomina
		AND empleado.cedula $cedula
		AND (TIMEDIFF( asistencia.horaentrada, horario.horaentrada )) $retardos
		AND empleado.estatus=1");
		return $query;
	}
	public function getdivisionusu($usuarioced){
		$query = $this->db->query("SELECT empleado.division as divisionusu,usuario.tipousuario as tipousuario,departamento.id as departamento
		FROM empleado 
		INNER JOIN usuario on usuario.cedula=empleado.cedula and usuario.nacionalidad=empleado.nacionalidad
		INNER JOIN division on  empleado.division=division.id
        INNER JOIN departamento on departamento.id=division.departamento
		WHERE empleado.cedula=$usuarioced");
		return $query;
	}
	public function getasitenciapermiso($fecha,$id){
		$query = $this->db->query("SELECT permisosemp.fechaentrada 
		FROM permisosemp 
		WHERE permisosemp.empleado='$id' 
		AND permisosemp.fechaentrada='$fecha'
		AND permisosemp.tipopermiso=2 
		AND permisosemp.status=1");
		return $query;
	}
}

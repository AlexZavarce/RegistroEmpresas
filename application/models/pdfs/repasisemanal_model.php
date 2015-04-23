<?php 
class Repasisemanal_model extends CI_Model
{
function __construct(){
		parent::__construct();
	}
	public function getdivision($division,$departamento,$nombres,$cedula){
		$query = $this->db->query("SELECT distinct division.id as division,division.nombre as nombredivision,departamento.id as iddep,departamento.nombre as departamento
		FROM division,empleado,departamento,persona
		WHERE empleado.division=division.id
		AND empleado.cedula=persona.cedula and persona.nacionalidad=empleado.nacionalidad AND persona.nombre $nombres
		AND division.id $division
		AND departamento.id=division.departamento
		AND empleado.tiponomina<>1
		AND empleado.cedula $cedula
		AND departamento.id=$departamento");
		return $query;
	}
	public function getasistencia($divisionasis,$cedula,$fechades,$fechahas,$nombres){
		$query = $this->db->query("SELECT asistencia.fecha,horario.horaentrada as horarioentrada,asistencia.fotoentrada as fotoentrada,asistencia.fotosalida as fotosalida,
			asistencia.fotoalmuerzoent as fotoalmuerzoent,departamento.id as iddep,asistencia.fotoalmuerzosal as fotoalmuerzosal,
		asistencia.horaentrada as horaentrada,asistencia.horasalida as horasalida, (TIMEDIFF( asistencia.horaentrada, horario.horaentrada )
		)  AS tiemporetardo,empleado.cedula as cedula,CONCAT(persona.nombre,' ', persona.apellido) as nombre,empleado.id as id,
		asistencia.almuerzoentrada as almuerzoentrada,asistencia.almuerzosalida as almuerzosalida
		FROM empleado
       	INNER JOIN persona on empleado.cedula=persona.cedula and persona.nacionalidad=empleado.nacionalidad AND persona.nombre $nombres
       	INNER JOIN horario ON horario.id = empleado.horario
       	INNER JOIN division on empleado.division=$divisionasis  and empleado.division=division.id
       	INNER JOIN departamento on division.departamento=departamento.id
		LEFT JOIN asistencia on empleado.id=asistencia.empleado  AND  (asistencia.fecha)>='$fechades'
		AND (asistencia.fecha)<='$fechahas' OR asistencia.empleado IS NULL 
		WHERE empleado.tiponomina<>1 
		AND empleado.cedula $cedula

		AND empleado.estatus=1 order by empleado.id,asistencia.fecha");
		return $query;
	}
}	
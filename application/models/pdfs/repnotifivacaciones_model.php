<?php 
class Repnotifivacaciones_model extends CI_Model
{
	function __construct(){
		parent::__construct();
	}
	public function getsolicitud($id){
		$query = $this->db->query("SELECT empleado.fechaingreso as fechaingreso,empleado.id as empleado,
		cargo.nombre as cargo,division.nombre as division,vacsolicitud.fechasalida as fechasalida,
		vacsolicitud.fechaculminacion as fechaculminacion,vacsolicitud.diassolicitados as diassolicitados,
		departamento.nombre as departamento,vacsolicitud.sueldo as sueldo,vacsolicitud.primahijo as primahijo,
		vacsolicitud.primaantiguedad as primaantiguedad,vacsolicitud.nivelacion as nivelacion
		FROM division,empleado,cargo,vacaciones,vacsolicitud,departamento
		WHERE empleado.id=vacsolicitud.empleado
		AND division.departamento=departamento.id
		AND empleado.division=division.id
		AND empleado.cargo=cargo.id
		AND vacaciones.solicitud=vacsolicitud.id
		AND vacsolicitud.id=$id");
		return $query;
	}
	public function updatestatus($estatusper){
		$this->db->set($estatusper);
    	$this->db->where('id', $estatusper['id']);
    	return $this->db->update('vacperiodoemp');
	}
	public function buscarperiodosrep($id){
        $query = $this->db->query("SELECT vacperiodoemp.status,vacaciones.nroperiodo,vacaciones.periodoini,vacaciones.periodofin,vacperiodoemp.id
        FROM vacsolicitud,vacaciones,vacperiodoemp 
        WHERE vacsolicitud.id=vacaciones.solicitud
        AND vacsolicitud.id=$id 
        AND vacperiodoemp.id=vacaciones.idperiodo");
        return $query;
    }
	public function getnomina($id){
		$query = $this->db->query("SELECT tiponomina.nombre as tiponomina
		FROM tiponomina,empleado,vacsolicitud
		WHERE empleado.id=vacsolicitud.empleado
		AND tiponomina.id=empleado.tiponomina
		AND vacsolicitud.id=$id");
		return $query;
	}
	public function periododisfrutar($id){
		$query = $this->db->query("SELECT vacaciones.periodoini as periodoini,
		vacaciones.periodofin as periodofin
		FROM vacaciones
		WHERE  vacaciones.solicitud=$id");
		return $query;
	}
	public function periodosindisfrutar($empleado){
		$query = $this->db->query("SELECT vacaciones.id, vacaciones.periodoini as periodoini,
        vacaciones.periodofin as periodofin,
        (MAX(vacaciones.diasdisfrute) - SUM(vacaciones.diasdisfrutado)) AS diasxdisfrutar
        FROM vacaciones,vacperiodoemp
        WHERE vacperiodoemp.empleado=$empleado
        And vacperiodoemp.id =vacaciones.idperiodo
        GROUP BY vacaciones.nroperiodo
        HAVING diasxdisfrutar > 0");
		return $query;
	}
	public function ultimasvacaciones($empleado,$id){
		/*$query = $this->db->query("SELECT MAX( vacaciones.fechainicio ) as fechaultima ,max(vacaciones.id) as idvaca
		FROM vacaciones, vacperiodoemp,vacsolicitud
		WHERE vacaciones.idperiodo = vacperiodoemp.id
		AND vacperiodoemp.empleado =$empleado
		AND vacaciones.diasdisfrutado <>0
		AND vacaciones.fechainicio<vacsolicitud.fecharegistro
		AND vacsolicitud.id=vacaciones.solicitud");*/
		$query = $this->db->query("SELECT  min( vacsolicitud.id) as solicitudultima,vacsolicitud.fechasalida as fechaultima
		FROM vacaciones, vacperiodoemp,vacsolicitud
		WHERE vacaciones.idperiodo = vacperiodoemp.id
		AND vacperiodoemp.empleado =$empleado
		AND vacaciones.diasdisfrutado <>0
		AND vacaciones.fechainicio<vacsolicitud.fecharegistro
		AND vacsolicitud.id=vacaciones.solicitud 
		AND vacsolicitud.id<$id ORDER BY vacsolicitud.id DESC");
		return $query;
	}
	public function periodoultimavacaciones($idsolicitud){
		$query = $this->db->query("SELECT vacaciones.periodoini as periodoutlimoini,
		vacaciones.periodofin as periodoutlimofin
		FROM vacaciones
		WHERE  vacaciones.solicitud=$idsolicitud");
		return $query;
	}
	public function retorno($fechaini,$dias){
		$datestart= strtotime($fechaini);
        $diasemana = date('N',$datestart);
        $totaldias = $diasemana+$dias;
        $findesemana =  intval( $totaldias/5) *2 ; 
        $diasabado = $totaldias % 5 ; 
        if ($diasabado==6) $findesemana++;
        if ($diasabado==0) $findesemana=$findesemana-2;
        $total = (($dias+$findesemana) * 86400)+$datestart ;  
        return $twstart=date('Y-m-d', $total);
	}
	public function buscarperiodosprocesado($idrep){
		$query = $this->db->query("SELECT DISTINCT vacaciones.nroperiodo,vacperiodoemp.status,vacaciones.periodoini,vacaciones.periodofin,vacperiodoemp.id
        FROM vacsolicitud,vacaciones,vacperiodoemp 
        WHERE vacsolicitud.id=vacaciones.solicitud
        AND vacperiodoemp.idrep='$idrep'
        AND vacperiodoemp.id=vacaciones.idperiodo
		AND vacperiodoemp.periodo=vacaciones.nroperiodo");
        return $query;
	}
	public function buscarfechainicio($solicitud){
		$query = $this->db->query("SELECT DISTINCT vacsolicitud.fechasalida as fechainicio
        FROM vacsolicitud
        WHERE vacsolicitud.id=$solicitud");
        return $query;
	}

}
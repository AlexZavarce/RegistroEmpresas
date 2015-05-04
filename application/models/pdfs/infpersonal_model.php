<?php 
class Infpersonal_model extends CI_Model
{
	function __construct(){
		parent::__construct();
	}
	public function getinfpersonal($rifs,$nombrecomer,$anoact,$cmbmunicipio,$cmbparroquia,$cmbcomunidad,$cmbtipo,$cmbseccion,$cmbdivision,$cmbgrupo,$cmbclase,$cmbrama){
		$query = $this->db->query("SELECT empresa.rif as rif,claseact.nombre as claseact,grupoact.nombre as grupoact,divisionact.nombre as divisionact,empresa.nombreco as nombreco, empresa.cedularep as cedularep,empresa.nombrerep as nombrerep,municipio.nombre as municipio, parroquia.nombre as parroquia,comunidad.nombre as comunidad,seccion.nombre as seccion, IF(empresa.tipo='0' ,'Servicio', IF(empresa.tipo='1' ,'Produccion', IF(empresa.tipo='2' ,'Ambos', ' ')))as tipo, ramaact.nombre as ramaact FROM empresa,municipio,parroquia,comunidad,seccion,ramaact,divisionact,claseact,grupoact
        WHERE empresa.rif $rifs
        AND empresa.municipio=municipio.id 
        AND empresa.parroquia=parroquia.id 
        AND  empresa.municipio=municipio.id
        AND empresa.parroquia=parroquia.id
        AND empresa.comunidad=comunidad.id
        AND empresa.seccion=seccion.id
     
        AND empresa.ramaact=ramaact.id 
        AND empresa.claseact=claseact.id 
        AND empresa.grupoact=grupoact.id 
        AND empresa.divisionact=divisionact.id 
        
     
        AND empresa.ramaact=ramaact.id 
        AND empresa.claseact=claseact.id 
        AND empresa.grupoact=grupoact.id 
        AND empresa.divisionact=divisionact.id 

        AND empresa.nombreco $nombrecomer 
        AND empresa.municipio $cmbmunicipio
        AND empresa.parroquia $cmbparroquia 
        AND empresa.comunidad $cmbcomunidad 
        AND empresa.tipo $cmbtipo
        AND empresa.seccion $cmbseccion
        AND empresa.divisionact $cmbdivision
        AND empresa.grupoact $cmbgrupo
        AND empresa.claseact $cmbclase
        AND empresa.ramaact $cmbrama");
         
         
  	    return $query;
	}
}
/*SELECT persona.cedula as cedula,CONCAT(persona.nombre,' ',persona.apellido) as nombres,
        CONCAT(persona.movil,'-', persona.fijo)as tlf,
        IF(persona.edocivil='0' ,'Soltero', 
        IF( persona.edocivil='1' , 'Casado',' '))as edocivil,
        IF(persona.sexo='0' ,'Masculino', 
        IF( persona.sexo='1' , 'Femenino',' '))as sexo,
        IF(persona.hijos='0' ,'No', 
        IF( persona.hijos='1' , 'Si',' '))as hijos,
        IF(persona.canthijos='0' ,'No', 
        IF( persona.canthijos='1' , 'Si',' '))as canthijos,
        cargo.nombre as cargos,
        tiponomina.nombre as tiponomina,
        persona.fechanac as fechanacimiento,(year(CURDATE( )) - year(persona.fechanac)) - ( (right(curdate(),5) < right(persona.fechanac,5))) as edad,
        persona.profesion as profesion,CONCAT(horario.horaentrada,' ',horario.horasalida) as horario,division.nombre as division
        FROM persona,empleado,tiponomina,horario,division,cargo
        WHERE persona.cedula=empleado.cedula
        AND  persona.nacionalidad=empleado.nacionalidad
        AND tiponomina.id=empleado.tiponomina
        AND horario.id=empleado.horario
        AND division.id=empleado.division
        AND cargo.id=empleado.cargo
        AND persona.nombre $nombre
        AND persona.apellido $apellido
        AND persona.edocivil $edocivil
        AND persona.sexo $sexo
        AND (year(CURDATE( )) - year(persona.fechanac)) - ((right(curdate(),5) < right(persona.fechanac,5))) $edad*/
<?php 
class Repnivelaca_model extends CI_Model
{
function __construct(){
		parent::__construct();
	}
	function getnivelacademico($nombre,$apellido,$edocivil,$edad,$municipio,$parroquia,$sexo,$institucion,$gradoins,$limitaciones,$condiciones,$deseoestudiar){
 		$sql=   "SELECT distinct(discapacitado.cedula) as cedula,CONCAT(persona.nombre,' ',persona.apellido) as nombres,
	 		persona.movil as tlfmovil, persona.fijo as tlffijo,municipio.nombre as municipio,substr(parroquia.nombre, 4) as parroquia,
	 		persona.fechanac as fechanacimiento,(year(CURDATE( )) - year(persona.fechanac)) - ( (right(curdate(),5) < right(persona.fechanac,5))) as edaddis,
	 		nivelacademico.gradoinstruccion as gradoins, nivelacademico.deseoestudio as deseoestudio,nivelacademico.condicionestudio as condicionfismen,limitacionestudio.nombre as nombrelimitacion
	 		FROM persona, discapacitado,parroquia,municipio,nivelacademico,limitacionestudio
			WHERE persona.cedula=discapacitado.cedula
			AND  persona.nacionalidad=discapacitado.nacionalidad
			And discapacitado.parroquia=parroquia.id
			AND parroquia.municipio=municipio.id
			AND parroquia.id $parroquia 
			AND municipio.id $municipio
			AND persona.nombre $nombre
			AND persona.apellido $apellido
			AND  persona.edocivil $edocivil
			AND  persona.sexo $sexo
			AND (year(CURDATE( )) - year(persona.fechanac)) - 
			((right(curdate(),5) < right(persona.fechanac,5))) $edad
			AND  nivelacademico.limitacionestudio=limitacionestudio.id
			AND nivelacademico.gradoinstruccion $gradoins
			AND nivelacademico.condicionestudio $condiciones
			AND nivelacademico.deseoestudio $deseoestudiar
			AND  limitacionestudio.id $limitaciones
			AND  discapacitado.nivelacademico=nivelacademico.id order by parroquia.nombre asc";
		$query = $this->db->query($sql, array($nombre,$apellido,$edocivil,$edad,$municipio,$parroquia,$sexo,$institucion,$gradoins,$limitaciones,$condiciones,$deseoestudiar));         
    	$data["discapacitado"]=array();
	    if($query->num_rows()>0){
	  		foreach ($query->result() as $fila){	
				$valor3= $fila->gradoins;
				switch ($valor3) {
	      			case '1':
		       		$fila->gradoins='Preescolar';;
	      			break;   
					case '2':
		       		$fila->gradoins='Basico';
	      			break;
	      			case '3':
		       		$fila->gradoins='Diversificada';
	      			break;
	      			case '4':
		       		$fila->gradoins='Técnico';
	      			break;
	      			case '4':
		       		$fila->gradoins='Universitario';
	      			break;
	      			case '5':
		       		$fila->gradoins='Ninguno';
	      			break;
				}	
				$valor2= $fila->deseoestudio;
				switch ($valor2) {
	      			case '1':
		       		$fila->deseoestudio='Si';
	      			break; 
	      			case '0':
	      			$fila->deseoestudio='No';
	      			break;    
				}	
				$valor1= $fila->condicionfismen;
				switch ($valor1) {
	      			case '1':
		       		$fila->condicionfismen='Si';
	      			break; 
	      			case '0':
		       		$fila->condicionfismen='No';
	      			break;    
				}	
				$data["discapacitado"][$fila->cedula]["cedula"] = $fila->cedula;
				$data["discapacitado"][$fila->cedula]["nombres"] = $fila->nombres;
				$data["discapacitado"][$fila->cedula]["tlfmovil"] = $fila->tlfmovil;
				$data["discapacitado"][$fila->cedula]["tlffijo"] = $fila->tlffijo;		
				$data["discapacitado"][$fila->cedula]["municipio"] = $fila->municipio;
				$data["discapacitado"][$fila->cedula]["parroquia"] = $fila->parroquia;
				$data["discapacitado"][$fila->cedula]["fechanacimiento"] = $fila->fechanacimiento;	
				$data["discapacitado"][$fila->cedula]["edaddis"] = $fila->edaddis;
				$data["discapacitado"][$fila->cedula]["gradoins"] = $fila->gradoins;
				$data["discapacitado"][$fila->cedula]["deseoestudio"] = $fila->deseoestudio;
				$data["discapacitado"][$fila->cedula]["condicionfismen"] = $fila->condicionfismen;
				$data["discapacitado"][$fila->cedula]["nombrelimitacion"] = $fila->nombrelimitacion;
			}
			return $data["discapacitado"];
	    }
	}
}

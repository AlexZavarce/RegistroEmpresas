<?php 
class Repsociofami_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	function getsociofamiliar($nombre,$apellido,$edocivil,$edad,$municipio,$parroquia,$sexo,$institucion,$tipovivienda,$atencionnec,$tenenciavivienda,$padres){
 		$sql="SELECT discapacitado.cedula as cedula,CONCAT(persona1.nombre,' ',persona1.apellido) as nombres,
	 		persona1.movil as tlfmovil, persona1.fijo as tlffijo,municipio.nombre as municipio,substr(parroquia.nombre, 4) as parroquia,
	 		persona1.fechanac as fechanacimiento,(year(CURDATE( )) - year(persona1.fechanac)) - ( (right(curdate(),5) < right(persona1.fechanac,5))) as edaddis,
	 		sociofamiliar.tipovivienda as tipovivienda,sociofamiliar.numerohabitantes as numerohabitante,sociofamiliar.numerotrabajan as numerotrabajan,
	 		sociofamiliar.tenenciavivienda as tenencia,sociofamiliar.parentescofamiliar as parentesco ,sociofamiliar.familiardirecto as atiendenec
			FROM persona as persona1, persona as persona2,discapacitado,sociofamiliar,parroquia,municipio 
			WHERE persona2.cedula=sociofamiliar.cedula
			AND  persona2.nacionalidad=sociofamiliar.nacionalidad
			AND sociofamiliar.id=discapacitado.sociofamiliar
			AND persona1.cedula=discapacitado.cedula 
			AND persona1.nacionalidad=discapacitado.nacionalidad 
			AND discapacitado.parroquia=parroquia.id
			AND parroquia.municipio=municipio.id
			AND parroquia.id $parroquia 
			AND municipio.id $municipio
			AND persona1.nombre $nombre 
			AND persona1.apellido $apellido
			AND  persona1.edocivil $edocivil
			AND  persona1.sexo $sexo
			AND (year(CURDATE( )) - year(persona1.fechanac)) - 
	      	((right(curdate(),5) < right(persona1.fechanac,5))) $edad
			AND  discapacitado.institucionproviene $institucion
			AND  sociofamiliar.tipovivienda $tipovivienda
			AND  sociofamiliar.tenenciavivienda $tenenciavivienda
			AND  sociofamiliar.convivenciadiscapa $atencionnec order by parroquia.nombre asc";
		$query = $this->db->query($sql, array($nombre,$edocivil,$municipio,$parroquia,$sexo,$institucion,$tipovivienda,$atencionnec,$tenenciavivienda));         
    	$data["discapacitado"]=array();
    	$valor=array();
    	$valor2=array();
    	$valor3=array();
    	$valor4=array();
	    if($query->num_rows()>0){
			foreach ($query->result() as $fila){
				$valor3= $fila->parentesco;
				switch ($valor3) {
	      			case '1':
		       		$fila->parentesco='Padre';
	      			break;   
					case '2':
		       		$fila->parentesco='Madre';
	      			break;
					case '3':
		       		$fila->parentesco='Ambos';
	      			break;
					case '4':
		       		$fila->parentesco='Ninguno';
	      			break;
				}		
				$valor4= $fila->atiendenec;
				 switch($valor4) {
	      			case '1':
		       		$fila->atiendenec='Padre';
	      			break;   
					case '2':
		       		$fila->atiendenec='Madre';
	      			break;
					case '3':
		       		$fila->atiendenec='Hermanos';
	      			break;
					case '4':
		       		$fila->atiendenec='Hijos';
	      			break;
				}		
				$valor2= $fila->tenencia;
				switch ($valor2) {
	      			case '1':
		       		$fila->tenencia='Alquilada';
	      			break;   
					case '2':
		       		$fila->tenencia='Al cuido';
	      			break;
					case '3':
		       		$fila->tenencia='De Familiar';
	      			break;
					case '4':
		       		$fila->tenencia='Propia';
	      			break;
				}	
				$valor= $fila->tipovivienda;
				switch ($valor) {
	      			case '1':
		       		$fila->tipovivienda='Apartamento';
	      			break;   
					case '2':
		       		$fila->tipovivienda='Casa';
	      			break;
					case '3':
		       		$fila->tipovivienda='Quinta';
	      			break;
					case '4':
		       		$fila->tipovivienda='Rancho';
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
				$data["discapacitado"][$fila->cedula]["tipovivienda"] = $fila->tipovivienda;
				$data["discapacitado"][$fila->cedula]["numerohabitante"] = $fila->numerohabitante;
				$data["discapacitado"][$fila->cedula]["tenencia"] = $fila->tenencia;
				$data["discapacitado"][$fila->cedula]["numerotrabajan"] = $fila->numerotrabajan;
				$data["discapacitado"][$fila->cedula]["atiendenec"] = $fila->atiendenec;
				$data["discapacitado"][$fila->cedula]["parentesco"] = $fila->parentesco;
			}
			return $data["discapacitado"];
	    }
	}
	function getinfsocio($nombre,$apellido,$edocivil){
 		$sql= "SELECT sociofamiliar.id as idsocio,persona1.cedula as ceduladis,CONCAT(persona1.nombre,' ',persona1.apellido) as nombresdis,
	 		persona2.cedula as cedulasoc,CONCAT(persona2.nombre,' ',persona2.apellido) as nombressoc,persona1.movil as tlfmovil, persona1.fijo as tlffijo
			FROM persona as persona1,persona as persona2,sociofamiliar,discapacitado
			WHERE sociofamiliar.cedula=persona2.cedula
			AND  sociofamiliar.nacionalidad= persona2.nacionalidad
			AND discapacitado.sociofamiliar=sociofamiliar.id
			AND discapacitado.cedula=persona1.cedula
			AND discapacitado.nacionalidad= persona1.nacionalidad
			AND persona1.nombre $nombre
			AND persona1.apellido $apellido
			AND  persona1.edocivil $edocivil"; 
    	$query = $this->db->query($sql, array($nombre,$apellido,$edocivil));         
    	$data["discapacitado"]=array();
	    if($query->num_rows()>0){
	  	foreach ($query->result() as $fila){	
			$data["discapacitado"][$fila->idsocio]["ceduladis"] = $fila->ceduladis;
			$data["discapacitado"][$fila->idsocio]["nombresdis"] = $fila->nombresdis;
			$data["discapacitado"][$fila->idsocio]["cedulasoc"] = $fila->cedulasoc;			
			$data["discapacitado"][$fila->idsocio]["nombressoc"] = $fila->nombressoc;
			$data["discapacitado"][$fila->idsocio]["tlfmovil"] = $fila->tlfmovil;
			$data["discapacitado"][$fila->idsocio]["tlffijo"] = $fila->tlffijo;
			}
			return $data["discapacitado"];
		}
	}		
}
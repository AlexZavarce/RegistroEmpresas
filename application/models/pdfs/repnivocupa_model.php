<?php 
class Repnivocupa_model extends CI_Model{
function __construct(){
		parent::__construct();
	}
	function getnivelocupacional($nombre,$apellido,$edocivil,$edad,$municipio,$parroquia,$sexo,$institucion,$habilidad,$actividaddesem,$actiproddesarrollando,$actproductiva,$condiciones,$aprenderofi,$oficio){
 		$sql="SELECT distinct(discapacitado.cedula) as cedula,CONCAT(persona.nombre,' ',persona.apellido) as nombres,
	 		persona.movil as tlfmovil, persona.fijo as tlffijo,municipio.nombre as municipio,substr(parroquia.nombre, 4) as parroquia,
	 		persona.fechanac as fechanacimiento,(year(CURDATE( )) - year(persona.fechanac)) - ( (right(curdate(),5) < right(persona.fechanac,5))) as edaddis,
	 		habilidad.nombre as habilidaddis,nivelocupacional.experiencialaboral as experiencia, actividadrecdep.nombre as actividadrecdep,
	 		nivelocupacional.descripcionexperiencia as descripcionexperiencia,actividadproductiva.oficio as codactividadproductiva,
	 		nivelocupacional.deseoaprender as deseoaprender,oficio.nombre as oficioaprender,oficio1.nombre as actproductiva
			FROM oficioocupacion LEFT JOIN oficio on oficioocupacion.oficio=oficio.id  AND  oficio.id $oficio,
			actividadproductiva LEFT JOIN oficio as oficio1 on actividadproductiva.oficio=oficio1.id  AND  actividadproductiva.oficio $actiproddesarrollando ,
			persona, discapacitado,actividadrecdep,actividades,parroquia,municipio,habilidad,habilidades,nivelocupacional
			WHERE persona.cedula=discapacitado.cedula
			AND  persona.nacionalidad=discapacitado.nacionalidad
			AND discapacitado.parroquia=parroquia.id
			AND parroquia.municipio=municipio.id
			AND parroquia.id $parroquia 
			AND municipio.id $municipio
			AND persona.nombre $nombre
			AND persona.apellido $apellido
			AND  persona.edocivil $edocivil
			AND  persona.sexo $sexo
			AND (year(CURDATE( )) - year(persona.fechanac)) - 
	      	((right(curdate(),5) < right(persona.fechanac,5))) $edad
			AND   actividades.actividadrecdep =actividadrecdep.id 
			AND discapacitado.id=actividades.discapacitado
			AND  actividades.id $actividaddesem
			AND habilidad.id=habilidades.habilidad
			AND  habilidad.id $habilidad
			AND  discapacitado.id= habilidades.discapacitado
			AND discapacitado.condicion $condiciones
			AND nivelocupacional.realizaactividad $actproductiva
			AND nivelocupacional.deseoaprender $aprenderofi
			AND  actividadproductiva.discapacitado=discapacitado.id
			AND  actividadproductiva.nivelocupacional= nivelocupacional.id
			AND oficioocupacion.nivelocupacional=nivelocupacional.id
	 		AND  discapacitado.id= oficioocupacion.discapacitado order by parroquia.nombre asc";
		$query = $this->db->query($sql, array($nombre,$apellido,$edocivil,$edad,$municipio,$parroquia,$sexo,$institucion,$habilidad,$actividaddesem,$actiproddesarrollando,$actproductiva,$condiciones,$aprenderofi,$oficio));         
    	$data["discapacitado"]=array();
	    if($query->num_rows()>0){
	  		foreach ($query->result() as $fila){
	  			$valor3= $fila->experiencia;
	  			switch ($valor3) {
	      			case '1':
		       		$fila->experiencia='Si';
	      			break;   
					case '0':
		       		$fila->experiencia='No';
	      			break;
				}
				$valor4= $fila->deseoaprender;
	  			switch ($valor4) {
	      			case '1':
		       		$fila->deseoaprender='Si';
	      			break;   
					case '0':
		       		$fila->deseoaprender='No';
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
				$data["discapacitado"][$fila->cedula]["habilidaddis"] = $fila->habilidaddis;
				$data["discapacitado"][$fila->cedula]["experiencia"] = $fila->experiencia;
				$data["discapacitado"][$fila->cedula]["descripcionexperiencia"] = $fila->descripcionexperiencia;
				$data["discapacitado"][$fila->cedula]["actividadrecdep"] = $fila->actividadrecdep;
				$data["discapacitado"][$fila->cedula]["deseoaprender"] = $fila->deseoaprender;
				$data["discapacitado"][$fila->cedula]["oficioaprender"] = $fila->oficioaprender;
				$data["discapacitado"][$fila->cedula]["actproductiva"] = $fila->actproductiva;
			}
			return $data["discapacitado"];
	    }
	}
}

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Camara {
	var $nombreFoto;

	public function __construct(){
		$hoy = date("Y-m-d");
		$hora=date("H");
		$min=date("i");
		$ruta="resources/avatars/"."Dep.".$_GET['departamento']."/".$hoy;
		if (file_exists("resources/avatars/"."Dep.".$_GET['departamento'])){ 
			if (file_exists("resources/avatars/"."Dep.".$_GET['departamento']."/".$hoy)){
     			$this->nombreFoto = $ruta.'/'.$_GET['nacionalidad'].$_GET['cedula'].'_'.$hora.'.'.$min.".jpg";
     		}else{
     			mkdir("resources/avatars/"."Dep.".$_GET['departamento']."/".$hoy,0777);
     			$this->nombreFoto = $ruta.'/'.$_GET['nacionalidad'].$_GET['cedula'].'_'.$hora.'.'.$min.".jpg";
     		}	
    	}else{ 
    		mkdir("resources/avatars/"."Dep.".$_GET['departamento']);
    		mkdir("resources/avatars/"."Dep.".$_GET['departamento']."/".$hoy,0777);
         	$this->nombreFoto = $ruta.'/'.$_GET['nacionalidad'].$_GET['cedula'].'_'.$hora.'.'.$min.".jpg";
      	}  
		
	}
	public function guardarFoto(){
		$result = file_put_contents( $this->nombreFoto, file_get_contents('php://input') );
		if (!$result) {
			print "ERROR: Failed to write data to $this->nombreFoto, check permissions\n";
			exit();
		}
		$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . '/' . $this->nombreFoto;
		print "$url\n";
		return file_get_contents('php://input');
	}
}


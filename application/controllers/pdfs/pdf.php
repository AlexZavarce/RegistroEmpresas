<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');
class Pdf extends CI_Controller {
    function __construct() {
        parent::__construct();
    }
   
public function planilla(){
	$bases=$_GET['file'];
	if (!isset($bases) || empty($bases)) {
	 exit();
	}
	$root = "imagen/";
	$file = basename($bases);
	$path = $root.$file;
	$type = '';
	 
	if (is_file($path)) {
	 $size = filesize($path);
	 if (function_exists('mime_content_type')) {
	 $type = mime_content_type($path);
	 } else if (function_exists('finfo_file')) {
	 $info = finfo_open(FILEINFO_MIME);
	 $type = finfo_file($info, $path);
	 finfo_close($info);
	 }
	 if ($type == '') {
	 $type = "application/force-download";
	 }
	 // Definir headers
	 header("Content-Type: $type");
	 header("Content-Disposition: attachment; filename=$file");
	 header("Content-Transfer-Encoding: binary");
	 header("Content-Length: " . $size);
	 // Descargar archivo
	 readfile($path);
	} else {
	 die("El archivo no existe.");
	}
}
}
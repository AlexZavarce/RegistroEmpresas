<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class diasferiados_model extends CI_Model {
	function __construct(){
    	$this->load->database();
  	}
	public function obtenerdiasferiados(){
		$query = $this->db->query("SELECT diasferiados.id as id,diasferiados.fecha as fecha,diasferiados.descripcion as descripcion
	    FROM diasferiados order by fecha ");
	    return $query;
	}
	public function insertardiaferiado($diaferiado){
    	$this->db->insert('diasferiados',$diaferiado);
    	return $this->db->insert_id();
	}
}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class jornadaext_model extends CI_Model {
	function __construct(){
		$this->load->database();
	}
	function insertarjornada($jorext) {
	    $this->db->set($jorext);
    	$this->db->insert('jornadaext');
  		return $this->db->insert_id();
	} 
}

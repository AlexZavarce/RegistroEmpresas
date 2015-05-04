<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Usuario_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function getUsuarioAutorizacion($autorizacion) {
        $query = $this->db->query("SELECT * FROM `usuario` WHERE claveautorizada='$autorizacion' ");
        return $query;
    }

    function insertusuario($datausuario) {
        $this->db->set($datausuario);
        $this->db->insert('usuario');
        //return  mysql_insert_id();
        return $this->db->insert_id();
    }

    public function updateUsuario($datausuario) {
        $this->db->set($datausuario);
        $this->db->where('id', $datausuario['id']);
        return $this->db->update('usuario');
    }

    public function deleteUsuario($datousuario) {
        $this->db->where('id', $datousuario['id']);
        return $this->db->delete('usuario');
    }

    public function existeusuario($cedula, $nacionalidad) {
        $query = $this->db->query("SELECT * FROM usuario where cedula ='$cedula' and nacionalidad='$nacionalidad' ");
        if ($query->num_rows() > 0) {
            $tipo = $query;
        } else {
            $tipo = '';
        }
        return $tipo;
    }

    public function existeusuariorif($rif) {
        $query = $this->db->query("SELECT * FROM usuario where usuario='$rif' ");
        if ($query->num_rows() > 0) {
            $tipo = $query;
        } else {
            $tipo = '';
        }
        return $tipo;
    }

    public function existecontrasena($cedula, $nacionalidad, $contrasena) {
        $query = $this->db->query("SELECT * FROM usuario where cedula ='$cedula' and nacionalidad='$nacionalidad' and password='$contrasena'");
        if ($query->num_rows() > 0) {
            $tipo = $query;
        } else {
            $tipo = '';
        }
        return $tipo;
    }

    public function updatecontrasena($datacontrasena) {
        $this->db->set($datacontrasena);
        $this->db->where('cedula', $datacontrasena['cedula']);
        $this->db->where('nacionalidad', $datacontrasena['nacionalidad']);
        return $this->db->update('usuario');
    }

}

<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Empresa_model extends CI_Model {

    function __construct() {
        $this->load->database();
        $this->load->library('session');
        $this->load->library(array('session'));
    }

    function buscarrif() {
        $query = $this->db->query("SELECT usuariolinea.id as id,usuariolinea.cedula as cedula,usuariolinea.correo as correo,usuariolinea.rif as rif,usuariolinea.status as status,usuariolinea.nacionalidad as nacionalidad
    FROM usuariolinea
    WHERE usuariolinea.status=0");
        $resultado = array();
        $resultdb = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $resultado[] = $row;
            }
            return $resultado;
            $query->free - result();
        }
    }

    public function obtenerEmpresa($usuario) {
        $sql = "SELECT ul.rif as rif2, ul.razonsocial as raz2, ul.cedula as cedula2,ul.nacionalidad as nacionalidad2, empresa.* FROM usuariolinea as ul left join empresa on empresa.rif=ul.rif WHERE ul.rif=?";
        $consulta = $this->db->query($sql, array($usuario));
        if ($consulta->num_rows() > 0) {
            return $consulta;
        } else {
            return false;
        }
    }
     public function Obtenerempresagrid() {
      $query = $this->db->query("SELECT * FROM empresa");
        $resultado = array();
        $resultdb = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $resultado[] = $row;
            }
            return $resultado;
            $query->free - result();
        }
    }

    function buscaregistro() {
        $query = $this->db->query("SELECT registro.id as id,registro.nombre as nombre
    FROM registro");
        $resultado = array();
        $resultdb = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $resultado[] = $row;
            }
            return $resultado;
            $query->free - result();
        }
    }

    function insertarempresa($empresa) {
        $this->db->set($empresa);
        $this->db->insert('empresa');
        //return  mysql_insert_id();
        return $this->db->insert_id();
    }

    function actualizarempresa($rif, $empresa) {
        $this->db->set($empresa);
        $this->db->where('rif', $rif);
        return $this->db->update('empresa');
    }

}

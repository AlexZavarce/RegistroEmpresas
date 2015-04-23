<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Reportepersonalvacaciones extends CI_Controller {
	public function __construct(){
		parent::__construct();
		session_start();
		$this->load->helper('url');
		$this->load->database();
		$this->load->library('session');
		$this->load->library(array('session')); 
		$this->load->model('permisos/permisos_model');
    }
    public function obtenerEmpleadosGrid(){
        $username = $this->session->userdata('datasession');
        $tipousuario=$username['tipousuario'];
        if ($tipousuario>=3){
            $empleados=$this->permisos_model->obtenerEmpleadosGrid($username['cedula'],$username['nacionalidad']);
            if($empleados->num_rows()>0){
                foreach ($empleados->result_array() as $row){
                    $data[] = array(                    
                        'nacionalidad'      => $row['nacionalidad'],
                        'idemp'             => $row['id'],
                        'cedula'            => $row['cedula'],
                        'nombre'            => $row['nombre'],
                        'usuario'           => $row['nombre'],
                        'correo'            => $row['correo'],      
                        'nombres'           => $row['nombres'],
                        'apellido'          => $row['apellido'],
                        'division'          => $row['division'],
                        'foto'              => $row['foto'],
                        'fechaingreso'      => $row['fechaingreso'],
                        'tiponomina'        => $row['tiponomina'],
                    );
                }
                $output = array(
                    'success' => true,
                    'data'    => $data,
                    'total'   => count($data));
                echo json_encode($output);
            }else{
                echo json_encode(array(
                    "success"   => false
                ));
            }
        }else{
            $empleados=$this->permisos_model->obtenerEmpleadosGridtodos($username['cedula'],$username['nacionalidad']);
            if($empleados->num_rows()>0){
                foreach ($empleados->result_array() as $row){
                    $data[] = array(                    
                        'nacionalidad'      => $row['nacionalidad'],
                        'idemp'             => $row['id'],
                        'cedula'            => $row['cedula'],
                        'nombre'            => $row['nombre'],
                        'usuario'           => $row['nombre'],
                        'correo'            => $row['correo'],      
                        'nombres'           => $row['nombres'],
                        'apellido'          => $row['apellido'],
                        'division'          => $row['division'],
                        'foto'              => $row['foto'],
                        'fechaingreso'      => $row['fechaingreso'],
                        'tiponomina'        => $row['tiponomina'],
                    );
                }
                $output = array(
                    'success' => true,
                    'data'    => $data,
                    'total'   => count($data));
                echo json_encode($output);
            }else{
                echo json_encode(array(
                    "success"   => false
                ));
            }
        }
    }
}

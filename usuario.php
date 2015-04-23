<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class usuario extends CI_Controller {
	public function __construct(){
		parent::__construct();
		session_start();
		$this->load->helper('url');
		$this->load->database();
		$this->load->library('session');
		$this->load->model('seguridad/usuario_model');
	}
	public function buscarusuario() {
	$resultdbd=array();   
	$this->load->model('seguridad/usuario_model');
	if ($resultdbd=$this->usuario_model->cargarusuario())
		{
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode(array(
			"success" => True,
			'data' => $resultdbd)));
		}
	} 
	public function tipousuario() {
	$tipouser=array();   
	$this->load->model('seguridad/usuario_model');
	if ($tipouser=$resultdbd=$this->usuario_model->tipousuario())
		{
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode(array(
			"success" => True,
			'data' => $tipouser)));
		}
	}
	public function guardarusuario() {
		$config['upload_path'] = './imagen/foto';
		$config['allowed_types'] = 'gif|jpg|png';
		$this->load->library('upload', $config);
		$fotoocul=$this->input->post('foto');
		$foto2=$_FILES['foto']['name'];
		if ($fotoocul ==''){
		   $fileName = $_FILES['foto']['name'];
		}else{
			$fileName = $this->input->post('foto');
		}
		$password = "e10adc3949ba59abbe56e057f20f883e"; //123456 - default password
		if ( ! $this->upload->do_upload($fileName)){
			$error = array('error' => $this->upload->display_errors());
		}else{
			$fileName = $_FILES['foto']['name'];
		}
		$datausuario = array(
			'id' =>             $this->input->post('id'),
			'cedula' =>         $this->input->post('cedula'),
			'nacionalidad' =>   $this->input->post('nacionalidad'),
			'usuario' =>        $this->input->post('usuario'),
			'tipousuario' =>    $this->input->post('tipousuario'),
			'password'=>        $password,
			'foto'=>            $fileName,
			'status'=>          $this->input->post('status'),
		);
		$datapersona = array(
			'cedula' =>         $this->input->post('cedula'),
			'nacionalidad' =>   $this->input->post('nacionalidad'),
			'nombre' =>        $this->input->post('nombre'),
			'apellido' =>       $this->input->post('apellido'),
			'direccion' =>      '',
			'movil' =>          '',
			'fijo' =>      '',
			'correo' =>         $this->input->post('correo'),
			'fechanac' =>         '',
			'edocivil' =>         '',
			'sexo' =>               '',
			'estatus' =>         '1'
		);
		if($datausuario['id']==''){
			$result=$this->usuario_model->insertPersona($datapersona);
			$result2=$this->usuario_model->insertUsuario($datausuario);
			if($result && $result2){
				echo json_encode(array(
					"success"   => true,
					"msg"       => "Se Guardo con Éxito." //modificado en la base de datos
				));
			}else{
				echo json_encode(array(
					"success"   => false,
					"msg"       => "No se puedo Guardar." //no se modifico en la base de datos
				));
			}
		}else{
			$result=$this->usuario_model->updatePersona($datapersona);
			$result2=$this->usuario_model->updateUsuario($datausuario);
			if($result && $result2){
				echo json_encode(array(
					"success"   => true,
					"msg"       => " Actualizado con Exito."//$result //modificado en la base de datos
				));
			}else{
				echo json_encode(array(
					"success"   => false,
					"msg"       => "No se puedo Actualizar." //no se modifico en la base de datos
				));
			}
		}
	}
	public function eliminarusuario() {
		$datousuario = array(
			'id' => $this->input->post('id'),
		);
		$datopersona = array(
			'cedula' => $this->input->post('cedula'),
			'nacionalidad' => $this->input->post('nacionalidad'),
		);
		if($datousuario['id']!=''){ 
			$result2=$this->usuario_model->deleteUsuario($datousuario);   
			$result=$this->usuario_model->deletePersona($datopersona);
			if($result && $result2){
				echo json_encode(array(
					"success"   => true,
					"msg"       => " Eliminado con Exito."//$result //modificado en la base de datos
				));
			}else{
				echo json_encode(array(
					"success"   => false,
					"msg"       => "No se pudo Eliminar." //no se modifico en la base de datos
				));
			}
		} 
	}
	public function existeusuario() {
		if ($this->input->post('ced')){
			$cedula = $this->input->post('ced');
			$nacionalidad = $this->input->post('nac');
			($resultado=$this->usuario_model->existeusuario($_POST['ced'], $_POST['nac']));
			if($resultado=='')
			{
				$this->output->set_content_type('application/json');
				$this->output->set_output(json_encode(array(
				"success" => false,
				'msg' =>  "nuevo")));
			}else {
				$this->output->set_output(json_encode(array(
				"success" => true,
				'msg' =>  "ya existe")));
			}
		}
	}
	public function existecontrasena() {
		$username = $this->session->userdata('datasession');
		$cedula = $username['cedula'];
		$nacionalidad =$username['nacionalidad']; 
		$pass = $this->input->post('contrasena');
		($resultado=$this->usuario_model->existecontrasena($cedula,$nacionalidad, $_POST['contrasena']));
		if($resultado==''){
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode(array(
			"success" => false,
			'msg' =>  "Contrasena invalida")));
		}else {
			$this->output->set_output(json_encode(array(
			"success" => true,
			'msg' =>  "puede continuar")));
		}
	} 
	public function updatecontrasena() {

		if ($this->input->post('confcontrasena')){
			$username = $this->session->userdata('datasession');
			$cedula = $username['cedula'];
			$nacionalidad =$username['nacionalidad']; 
			$datacontrasena = array(
				'cedula' =>         $cedula,
				'nacionalidad' =>    $nacionalidad,
				'password' => $this->input->post('confcontrasena')
			);
			($resultado=$this->usuario_model->updatecontrasena($datacontrasena));
			if($resultado){
				echo json_encode(array(
					"success"   => true,
					"msg"       => " Actualizado con Exito."//$result //modificado en la base de datos
				));
			}else{
				echo json_encode(array(
					"success"   => false,
					"msg"       => "No se puedo Actualizar." //no se modifico en la base de datos
				));
			}
		}
	}
}


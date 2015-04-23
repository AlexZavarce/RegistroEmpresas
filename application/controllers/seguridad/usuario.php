<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Usuario extends CI_Controller {
	public function __construct(){
		parent::__construct();
		session_start();
		$this->load->helper('url');
		$this->load->database();
		$this->load->library('session');
		$this->load->model('seguridad/usuario_model');
		$this->load->model('seguridad/empleado_model');
	}
	public function guardar_imagen($nombrefoto,$fotoType,$fotoTmp_name){        
        if ($fotoTmp_name  == '') {
        } else if ($fotoTmp_name != '' && ($fotoType == "image/gif" || $fotoType== "image/jpeg" || $fotoType== "image/png")) {
            $img_tipo   = explode('/', $fotoType);
            $img_nombre = $nombrefoto.".".$img_tipo[1];
            move_uploaded_file($fotoTmp_name,'empleados/'.$img_nombre);
        }
    }
	public function buscarusuario() {
	$resultdbd=array();  
    $username = $this->session->userdata('datasession');
    $cedula=$username['cedula'];
    $nacionalidad=$username['nacionalidad'];
	$this->load->model('seguridad/usuario_model');
	$username = $this->session->userdata('datasession');
    $tipousuario=$username['tipousuario'];
    if ($tipousuario>=3){
		if ($resultdbd=$this->usuario_model->cargarusuariodiv($username['cedula'],$username['nacionalidad'])){
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode(array(
			"success" => True,
			'data' => $resultdbd)));
		}	
	}else{
		if ($resultdbd=$this->usuario_model->cargarusuario($username['cedula'],$username['nacionalidad']))
			{
				$this->output->set_content_type('application/json');
				$this->output->set_output(json_encode(array(
				"success" => True,
				'data' => $resultdbd)));
			}
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
    public function registrarusuario() {
        $add= $_POST['records']; 
        $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
        $cad = "";
        for($i=0;$i<12;$i++) {
            $cad .= substr($str,rand(0,62),1);
        }

        $cad = md5(strtoupper($cad));

        if(isset($add)){
            $records = json_decode(stripslashes($add));
            foreach($records as $record){
                $datausuario = array(
                    'id'              => $this->input->post('id'),
                    'nacionalidad'    =>$record->nacionalidad,
                    'cedula'          => $record->cedula,
                    'usuario'         => $record->rif.$record->rif1.$record->rif2,
                    'password'        => $cad,
                    'status'          =>1,
                    'tipousuario'     =>4
                   
                );
                $datapersona = array(
                    'cedula'      =>   $record->cedula,
                    'nacionalidad'=>   $record->nacionalidad,
                    'nombre'      =>   '',
                    'apellido'    =>   '',
                    'movil'       =>   '',
                    'fijo'        =>   '',
                    'correo'      =>   strtoupper($record->correo),
                    'direccion'   =>   '',
                    'edocivil'    =>   '',  
                    'fechanac'    =>   '',
                    'sexo'        =>   '',
                    'estatus'     =>   '1',
                    'hijos'       =>   '',
                    'canthijos'   =>   '',
                    'profesion'   =>   ''
                );
                $cedula= $record->cedula;
                $correo=$record->correo;
                $usuario=$record->rif.$record->rif1.$record->rif2;
                $result2=$this->usuario_model->insertpersona($datapersona);
                $result3=$this->usuario_model->insertusuario($datausuario);
                $result=$this->usuario_model->updateusuariolinea($cedula);
                $this->Enviarclave($cedula,$correo,$cad,$usuario);

            }
            if(mysql_affected_rows()>0){
              echo json_encode(array(
                "success"   => true,
                "actualizo" => true,
                "msg"       => 'Permisos actualizados exitosamente.'
              ));
            }
        }
    }
    public function Enviarclave($cedula,$correo,$cad){
     
      $this->load->library('email','','correo');
      $configGmail = array(
          'protocol' => 'smtp',
          'smtp_host' => 'ssl://smtp.gmail.com',
          'smtp_port' => 465,
          'smtp_user' => 'pinedaisa@gmail.com',
          'smtp_pass' => 'jinisa2015',
          'mailtype' => 'html',
          'charset' => 'utf-8',
          'newline' => "\r\n" 
      );
    $this->correo->initialize($configGmail);
    $this->correo->from('FUNDAPYME');
    $this->correo->to($correo);
    $this->correo->subject('Usuario y Clave del Sistema Registro de Empresa');
    $this->correo->message('<h1>Usuario y Clave</h1>
    <p>Estimado (a): Usuario
     <p> El siguiente correo es para notificar que el usuario y la clave han sido creados para poder ingresar al sistema </p>
    <p><b>Usuario:'.$usuario.'</b></p>
    <p><b>Clave:' .$cad.'</b></p>
    <p>En la siguiente Dirección puede ingresar al sistema</p>
    <p><b>Sistema de Registro de Empresas Manufatureras</b></p>
    <p><b>Lara... Tierra Progresista</b></p>');
    $this->correo->send();
  }
	public function guardarusuario() {
        //$config['upload_path'] = './imagen/foto';
        //$config['allowed_types'] = 'gif|jpg|png';
        //$this->load->library('upload', $config);
        //$fotoocul=$this->input->post('foto');
        //$foto2=$_FILES['foto']['name'];
        /*if ($fotoocul ==''){
           $fileName = $_FILES['foto']['name'];
        }else{
            $fileName = $this->input->post('foto');
        }*/
        $username = $this->session->userdata('datasession');
        $cedula=$username['cedula'];
    	$nacionalidad=$username['nacionalidad'];
        $row['foto']=0;
        $config['upload_path'] = './imagen/foto';
        $config['allowed_types'] = 'gif|jpg|png';
        $this->load->library('upload', $config);
        $fotoocul=$this->input->post('foto');
        $bdfoto=$this->empleado_model->buscarFoto($cedula,$nacionalidad);
       	if($bdfoto!=false){
            foreach ($bdfoto->result_array() as $row){
                $data[] = array( 
                    'foto'=> $row['foto']
                );
            }
           	$nombrefoto2=$row['foto'];
        }else{
            $img_tipo       = explode('/', $_FILES['foto']['type']);
            $nombrefoto     = "_DSC".$nacionalidad.$cedula;
            $nombrefoto2    = $nacionalidad.$cedula.".".$img_tipo[1];
            $fotoType       = $_FILES['foto']['type'];
            $fotoTmp_name   = $_FILES['foto']['tmp_name'];
            $this->guardar_imagen($nombrefoto,$fotoType,$fotoTmp_name);
        }
        $password = "e10adc3949ba59abbe56e057f20f883e"; //123456 - default password
          /* if ( ! $this->upload->do_upload($fileName)){
            $error = array('error' => $this->upload->display_errors());
        }else{
            $fileName = $_FILES['foto']['name'];
        }*/
        if ($this->input->post('status')=='Activo'){
            $status=1;
        }else{
            $status=0;
        }
        $datausuario = array(
            'id' =>             $this->input->post('id'),
            'cedula' =>         $this->input->post('cedula'),
            'nacionalidad' =>   $this->input->post('nacionalidad'),
            'usuario' =>        $this->input->post('usuario'),
            'tipousuario' =>    $this->input->post('tipousuario'),
            'password'=>        $password,
            'status'=>          $status
        );
        $datapersona = array(
            'cedula' =>         $this->input->post('cedula'),
            'nacionalidad' =>   $this->input->post('nacionalidad'),
            'nombre' =>        $this->input->post('nombre'),
            'apellido' =>       $this->input->post('apellido'),
            'correo' =>         $this->input->post('correo'),
            'estatus' =>         '1'
        );
         $dataempleado = array(
                'cedula' =>         $this->input->post('cedula'),
                'nacionalidad' =>   $this->input->post('nacionalidad'),
                'foto'=>            $nombrefoto2,
            );
        if (!$existuser=$this->usuario_model->existeusuario( $this->input->post('cedula'),$this->input->post('nacionalidad'))){    
            if($datausuario['id']==''){
                $result2=$this->usuario_model->insertusuario($datausuario);
                if($result2){
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
                $result=$this->usuario_model->updatepersona($datapersona);
                $result1=$this->usuario_model->updateempleado($dataempleado);
                $result2=$this->usuario_model->updateusuario($datausuario);
                if($result && $result1 && $result2){
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
        }else{
        	$iddata=$this->input->post('id');
            if($iddata==''){
                $this->output->set_content_type('application/json');
                $this->output->set_output(json_encode(array(
                "success" => false,
                 "msg"       => " Usuario ya existe,por favor verificar")));
            }else{
                $result=$this->usuario_model->updatepersona($datapersona);
                $result1=$this->usuario_model->updateempleado($dataempleado);
                $result2=$this->usuario_model->updateusuario($datausuario);
                if($result && $result1 && $result2){
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
					"msg"       => "No se Actualizo." //no se modifico en la base de datos
				));
			}
		}
	}
}


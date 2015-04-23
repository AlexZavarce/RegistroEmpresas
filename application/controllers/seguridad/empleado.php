<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Empleado extends CI_Controller {
	public function __construct(){
		parent::__construct();
		session_start();
		$this->load->helper('url');
		$this->load->database();
		$this->load->library('session');
		$this->load->model('seguridad/empleado_model');
	}
	public function buscarempleado() {
	$resultdbd=array();  
    $username = $this->session->userdata('datasession');
    $cedula=$username['cedula'];
    $nacionalidad=$username['nacionalidad'];
	$this->load->model('seguridad/empleado_model');
	$username = $this->session->userdata('datasession');
    $tipousuario=$username['tipousuario'];
    if ($tipousuario>=3){
		if ($resultdbd=$this->empleado_model->cargarempleadodiv($username['cedula'],$username['nacionalidad'])){
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode(array(
			"success" => True,
			'data' => $resultdbd)));
		}	
	}else{
		if ($resultdbd=$this->empleado_model->cargarempleado($username['cedula'],$username['nacionalidad']))
			{
				$this->output->set_content_type('application/json');
				$this->output->set_output(json_encode(array(
				"success" => True,
				'data' => $resultdbd)));
			}
		}
	} 
	public function horario() {
	$horario=array();   
	if ($horario=$resultdbd=$this->empleado_model->horario())
		{
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode(array(
			"success" => True,
			'data' => $horario)));
		}
	}
	public function cargos() {
	$cargos=array();   
	if ($cargos=$this->empleado_model->cargos())
		{
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode(array(
			"success" => True,
			'data' => $cargos)));
		}
	}
	public function guardar_imagen($nombrefoto,$fotoType,$fotoTmp_name){        
        if ($fotoTmp_name  == '') {
        } else if ($fotoTmp_name != '' && ($fotoType == "image/gif" || $fotoType== "image/jpeg" || $fotoType== "image/png")) {
            $img_tipo   = explode('/', $fotoType);
            $img_nombre = $nombrefoto.".".$img_tipo[1];
            move_uploaded_file($fotoTmp_name,'empleados/'.$img_nombre);
        }
    }
    public function guardarempleado() {
    	$cedula=$this->input->post('cedula');
        $nacionalidad=$this->input->post('nacionalidad');
        $username = $this->session->userdata('datasession');
        $foto=($this->input->post('cedula').'.jpg');
        $row['foto']=0;
        $config['upload_path'] = './imagen/foto';
        $config['allowed_types'] = 'gif|jpg|png';
        $this->load->library('upload', $config);
        $fotoocul=$this->input->post('foto');
        $seleccion=$this->input->post('seleccionfoto');
        $bdfoto=$this->empleado_model->buscarFoto($cedula,$nacionalidad);
        if($bdfoto!=false ){
            foreach ($bdfoto->result_array() as $row){
                $data[] = array( 
                    'foto'=> $row['foto']
                );
            }
            $nombrefoto2=$row['foto'];
        }
        if($bdfoto==false || $row['foto']==0){
            if($seleccion=='2'){                
                $img_tipo       = explode('/', $_FILES['foto']['type']);
                $nombrefoto     = "_DSC".$nacionalidad.$cedula;
                $nombrefoto2    = $nacionalidad.$cedula.".".$img_tipo[1];
                $fotoType       = $_FILES['foto']['type'];
                $fotoTmp_name   = $_FILES['foto']['tmp_name'];
                $this->guardar_imagen($nombrefoto,$fotoType,$fotoTmp_name);                
            }if($seleccion=='3'){
                $nombrefoto2 ='';
            }
        }else{
            $nombrefoto2=$row['foto'];
        }
        /*if($bdfoto!=false){
            foreach ($bdfoto->result_array() as $row){
                $data[] = array( 
                    'foto'=> $row['foto']
                );
            }
            $nombrefoto2=$row['foto'];
            if ($nombrefoto2==''){
                $img_tipo       = explode('/', $_FILES['foto']['type']);
                $nombrefoto     = "_DSC".$nacionalidad.$cedula;
                $nombrefoto2    = $nacionalidad.$cedula.".".$img_tipo[1];
                $fotoType       = $_FILES['foto']['type'];
                $fotoTmp_name   = $_FILES['foto']['tmp_name'];
                $this->guardar_imagen($nombrefoto,$fotoType,$fotoTmp_name);
            }
        }
        if($bdfoto==false){
            $img_tipo       = explode('/', $_FILES['foto']['type']);
            $nombrefoto     = "_DSC".$nacionalidad.$cedula;
            $nombrefoto2    = $nacionalidad.$cedula.".".$img_tipo[1];
            $fotoType       = $_FILES['foto']['type'];
            $fotoTmp_name   = $_FILES['foto']['tmp_name'];
            $this->guardar_imagen($nombrefoto,$fotoType,$fotoTmp_name);
        }*/
        $password = "e10adc3949ba59abbe56e057f20f883e"; //123456 - default password
        if ($this->input->post('estatus')=='Activo'){
            $status=1;
        }else{
            $status=0;
        }
        $dataempleado = array(
            'id'           =>    $this->input->post('id'),
            'cedula'       =>    $this->input->post('cedula'),
            'nacionalidad' =>    $this->input->post('nacionalidad'),
            'division'     =>    $this->input->post('division'),
            'horario'      =>    $this->input->post('horario'),
            'foto'         =>    $nombrefoto2,
            'estatus'      =>    $status,
            'tiponomina'   =>    $this->input->post('tiponomina'),
            'cargo'        =>    $this->input->post('cargo'),
            'fechaingreso' =>    $this->input->post('fechaingreso'),
        );
        $datapersona = array(
            'cedula'      =>   $this->input->post('cedula'),
            'nacionalidad'=>   $this->input->post('nacionalidad'),
            'nombre'      =>   $this->input->post('nombres'),
            'apellido'    =>   $this->input->post('apellido'),
            'movil'       =>   $this->input->post('codmovil').$this->input->post('movil'),
            'fijo'        =>   $this->input->post('codfijo').$this->input->post('fijo'),
            'correo'      =>   strtoupper($this->input->post('correo')),
            'direccion'   =>   $this->input->post('direccion'),
            'edocivil'    =>   $this->input->post('edocivil'),  
            'fechanac'    =>   $this->input->post('fechanac'),
            'sexo'        =>   strtoupper($this->input->post('sexo')),
            'estatus'     =>   '1',
            'hijos'       =>   $this->input->post('hijos'),
            'canthijos'   =>   $this->input->post('canthijos'),
            'profesion'   =>   $this->input->post('profesion')
        );
       
        if (!$existemp=$this->empleado_model->existemp( $this->input->post('cedula'),$this->input->post('nacionalidad'))){    
            if($dataempleado['id']==''){
                $result2=$this->empleado_model->insertpersona($datapersona);
                $result3=$this->empleado_model->insertempleado($dataempleado);
                if($result2 && $result3){
                    echo json_encode(array(
                        "success"   => true,
                        "msg"       => "Se Guardo con Éxito.",
                         "hola"       =>  $seleccion //modificado en la base de datos
                    ));
                }else{
                    echo json_encode(array(
                        "success"   => false,
                        "msg"       => "No se puedo Guardar." //no se modifico en la base de datos
                    ));
                }
            }else{
                $result=$this->empleado_model->updatepersona($datapersona);
                $result1=$this->empleado_model->updateempleado($dataempleado);
                if($result && $result1){
                    echo json_encode(array(
                        "success"   => true,
                        "msg"       => " Actualizado con Exito.",//$result //modificado en la base de datos
                        "hola"       =>  $seleccion
                    ));
                }else{
                    echo json_encode(array(
                        "success"   => false,
                        "msg"       => "No se puedo Actualizar." //no se modifico en la base de datos
                    ));
                }
            }
        }else{
        
                $result=$this->empleado_model->updatepersona($datapersona);
                $result1=$this->empleado_model->updateempleado($dataempleado);
                //$result2=$this->usuario_model->updateusuario($datausuario);
                if($result && $result1){
                    echo json_encode(array(
                        "success"   => true,
                        "msg"       => " Actualizado con Exito.",//$result //modificado en la base de datos
                        "hola"       =>  $seleccion
                    ));
                }else{
                    echo json_encode(array(
                        "success"   => false,
                        "msg"       => "No se puede Actualizar." //no se modifico en la base de datos
                    ));
                }
            
        }
	}
    public function existeempleado() {
        if ($this->input->post('ced')){
            $cedula = $this->input->post('ced');
            $nacionalidad = $this->input->post('nac');
            ($resultado=$this->empleado_model->existeempleado($_POST['ced'], $_POST['nac']));
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
}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Empresa extends CI_Controller {
  public function __construct(){
    parent::__construct();
    session_start();
    $this->load->helper('url');
    $this->load->database();
    $this->load->model('empresa/empresa_model');
    $this->load->library(array('session'));
  }
  public function index() {
    //$this->load->view('administrativo');
  }
  public function Registro(){
    $resultdbd= array(); 
    if ($resultdbd=$this->empresa_model->buscaregistro()){
      $this->output->set_content_type('application/json');
      $this->output->set_output(json_encode(array(
      "success" => true,
      'data' => $resultdbd)));
    }else{
      $this->output->set_content_type('application/json');
      $this->output->set_output(json_encode(array(
      "success" => false,
      'data' => $resultdbd)));
    }
  }

  public function Riflista(){
   $resultdbd= array(); 
    if ($resultdbd=$this->empresa_model->buscarrif()){
      $this->output->set_content_type('application/json');
      $this->output->set_output(json_encode(array(
      "success" => true,
      'data' => $resultdbd)));
    }else{
      $this->output->set_content_type('application/json');
      $this->output->set_output(json_encode(array(
      "success" => false,
      'data' => $resultdbd)));
    }
  }
  public function guardarempresa() {
    $empresa=array();
    $id=$this->input->post('id');
    if($this->input->post('seleccioncamara1')=='true'){
      $seleccioncamara1=1;
      }else{
        $seleccioncamara1=0;
      };

    if($this->input->post('seleccioncamara2')=='true'){
      $seleccioncamara2=1;
      }else{
        $seleccioncamara2=0;
      };

    if($this->input->post('seleccioncamara3')=='true'){
      $seleccioncamara3=1;
      }else{
        $seleccioncamara3=0;
      };

    if($this->input->post('seleccioncamara4')=='true'){
      $seleccioncamara4=1;
      }else{
        $seleccioncamara4=0;
      };

    $empresa=array(
      'id'              => $this->input->post('id'),
      'rif'             => $this->input->post('rif'). $this->input->post('rif1').$this->input->post('rif2'),
      'nombreco'        => $this->input->post('nombrecomer'),
      'anoact'          =>$this->input->post('anoact'),
      'registromer'     =>$this->input->post('registromer'),
      'razonsoc'        =>$this->input->post('razonsoc'),
      'nacionalidarep'  =>'V',
      'cedularep'       =>$this->input->post('cedula'),
      'nombrerep'       =>$this->input->post('representante'),
      'telfrep'        =>$this->input->post('codmovilrep').$this->input->post('movilrep'),
      'tipo'            =>$this->input->post('tipo'),
      'nombrecont'      =>$this->input->post('nombrecont'),
      'telfcont'        =>$this->input->post('codmovil').$this->input->post('movil'),
      'cedulacont'      =>$this->input->post('cedulacont'),
      'estado'          =>$this->input->post('cmbestado'),
      'municipio'       =>$this->input->post('cmbmunicipio'),
      'parroquia'       =>$this->input->post('cmbparroquia'),
      'comunidad'       =>$this->input->post('cmbcomunidad'),
      'direccion'       =>$this->input->post('direccion'),
      'tlfmovil'        =>$this->input->post('codmovilemp').$this->input->post('movilemp'),
      'tlflocal'        =>$this->input->post('codfijoemp').$this->input->post('fijoemp'),
      'faxemp'          =>$this->input->post('codfaxemp').$this->input->post('faxemp'),
      'emailemp'        =>$this->input->post('correoemp'),
      'pagwebemp'       =>$this->input->post('pagwebemp'),
      'facebemp'        =>$this->input->post('facebookemp'),
      'twitter'         =>$this->input->post('twitteremp'),
      'selecamara1'     =>$seleccioncamara1,
      'selecamara2'     =>$seleccioncamara2,
      'selecamara3'     =>$seleccioncamara3,
      'selecamara4'     =>$seleccioncamara4,
      'seccion'         =>$this->input->post('cmbseccion'),
      'divisionact'     =>$this->input->post('cmbdivision'),
      'grupoact'        =>$this->input->post('cmbgrupo'),
      'claseact'        =>$this->input->post('cmbclase'),
    );
    if($id==null){
      $result2=$this->empresa_model->insertarempresa($empresa);
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

    }
  }
}
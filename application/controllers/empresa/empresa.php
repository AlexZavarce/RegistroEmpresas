<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Empresa extends CI_Controller {

    public function __construct() {
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

    public function Registro() {
        $resultdbd = array();
        if ($resultdbd = $this->empresa_model->buscaregistro()) {
            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode(array(
                "success" => true,
                'data' => $resultdbd)));
        } else {
            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode(array(
                "success" => false,
                'data' => $resultdbd)));
        }
    }

    public function Riflista() {
        $resultdbd = array();
        if ($resultdbd = $this->empresa_model->buscarrif()) {
            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode(array(
                "success" => true,
                'data' => $resultdbd)));
        } else {
            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode(array(
                "success" => false,
                'data' => $resultdbd)));
        }
    }
     public function Obtenerempresagrid(){
        $resultdbd=array();  
        if ($resultdbd=$this->empresa_model->Obtenerempresagrid()){
            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode(array(
            "success" => True,
            'data' => $resultdbd)));
        }
     }

    public function guardarempresa() {
        $empresa = array();
        $id = $this->input->post('id');
        if ($this->input->post('seleccioncamara1') == 'true') {
            $seleccioncamara1 = 1;
        } else {
            $seleccioncamara1 = 0;
        };

        if ($this->input->post('seleccioncamara2') == 'true') {
            $seleccioncamara2 = 1;
        } else {
            $seleccioncamara2 = 0;
        };

        if ($this->input->post('seleccioncamara3') == 'true') {
            $seleccioncamara3 = 1;
        } else {
            $seleccioncamara3 = 0;
        };

        if ($this->input->post('seleccioncamara4') == 'true') {
            $seleccioncamara4 = 1;
        } else {
            $seleccioncamara4 = 0;
        };
         if ($this->input->post('seleccioncamara5') == 'true') {
            $seleccioncamara5 = 1;
        } else {
            $seleccioncamara5 = 0;
        };
        $empresa = array(
           
            'rif' => $this->input->post('rif') . $this->input->post('rif1') . $this->input->post('rif2'),
            'nombreco' => $this->input->post('nombrecomer'),
            'anoact' => $this->input->post('anoact'),
            'registromer' => $this->input->post('registromer'),
            'razonsoc' => $this->input->post('razonsoc'),
            'nacionalidarep' => $this->input->post('nacionalidadrep'),
            'cedularep' => $this->input->post('cedularep'),
            'nombrerep' => $this->input->post('representante'),
            'telfrep' => $this->input->post('codmovilrep') . $this->input->post('movilrep'),
            'tipo' => $this->input->post('tipo'),
            'nombrecont' => $this->input->post('nombrecont'),
            'telfcont' => $this->input->post('codmovilcont') . $this->input->post('movilcont'),
            'nacionalidadcont' => $this->input->post('nacionalidadcont'),
            'cedulacont' => $this->input->post('cedulacont'),
            'estado' => $this->input->post('cmbestado'),
            'municipio' => $this->input->post('cmbmunicipio'),
            'parroquia' => $this->input->post('cmbparroquia'),
            'comunidad' => $this->input->post('cmbcomunidad'),
            'direccion' => $this->input->post('direccion'),
            'tlfmovil' => $this->input->post('codmovilemp').$this->input->post('movilemp'),
            'tlflocal' => $this->input->post('codfijoemp').$this->input->post('fijoemp'),
            'faxemp' => $this->input->post('codfaxemp').$this->input->post('faxemp'),
            'emailemp' => $this->input->post('correoemp'),
            'pagwebemp' => $this->input->post('pagwebemp'),
            'facebemp' => $this->input->post('facebookemp'),
            'twitter' => $this->input->post('twitteremp'),
            'selecamara1' => $seleccioncamara1,
            'selecamara2' => $seleccioncamara2,
            'selecamara3' => $seleccioncamara3,
            'selecamara4' => $seleccioncamara4,
            'selecamara5' => $seleccioncamara5,
            'seccion' => $this->input->post('cmbseccion'),
            'divisionact' => $this->input->post('cmbdivision'),
            'grupoact' => $this->input->post('cmbgrupo'),
            'claseact' => $this->input->post('cmbclase'),
            'ramaact' => $this->input->post('cmbrama'),
        );

        if ($id == null) {
            $empresa += array(
                'fecharegistro'=>date("Y-m-d"),
                'fechamodificacion'=>date("Y-m-d")
            );
            $result2 = $this->empresa_model->insertarempresa($empresa);
            if ($result2) {
                echo json_encode(array(
                    "success" => true,
                    "msg" => "Se Guardo con Éxito." //modificado en la base de datos
                ));
            } else {
                echo json_encode(array(
                    "success" => false,
                    "msg" => "No se puedo Guardar." //no se modifico en la base de datos
                ));
            }
        } else {
            $empresa += array(
                'id'=>$id,
                'fechamodificacion'=>date("Y-m-d")
            );
            $result3 = $this->empresa_model->actualizarempresa($empresa['rif'], $empresa);
            if ($result3) {
                echo json_encode(array(
                    "success" => true,
                    "msg" => "Se Actualizo con Éxito." //modificado en la base de datos
                ));
            } else {
                echo json_encode(array(
                    "success" => false,
                    "msg" => "No se puedo Actualizar." //no se modifico en la base de datos
                ));
            }
        }
    }
    public function Obtenerverempresa(){
        $rif=$this->input->get('rif');
        $empresa = $this->empresa_model->obtenerEmpresa($rif);
        if ($empresa != false) {
           
                foreach ($empresa->result_array() as $row) {
                    $data[] = array(
                        'id' => $row['id'],
                        'rif' => SUBSTR($row['rif'], 0, 1),
                        'rif1' => SUBSTR($row['rif'], 1, strlen($row['rif']) - 2),
                        'rif2' => $row['rif'][strlen($row['rif']) - 1],
                        'nombrecomer' => $row['nombreco'],
                        'anoact' => $row['anoact'],
                        'registromer' => $row['registromer'],
                        'razonsoc' => $row['razonsoc'],
                        'nacionalidadrep' => $row['nacionalidarep'],
                        'cedularep' => $row['cedularep'],
                        'representante' => $row['nombrerep'],
                        'codmovilrep' => SUBSTR($row['telfrep'], 0, 3),
                        'movilrep' => SUBSTR($row['telfrep'], 3),
                        'tipo' => $row['tipo'],
                        'nombrecont' => $row['nombrecont'],
                        'codmovilcont' => SUBSTR($row['telfcont'], 0, 3),
                        'movilcont' => SUBSTR($row['telfcont'], 3),
                        'nacionalidadcont' => $row['nacionalidadcont'],
                        'cedulacont' => $row['cedulacont'],
                        'cmbestado' => $row['estado'],
                        'cmbmunicipio' => $row['municipio'],
                        'cmbparroquia' => $row['parroquia'],
                        'cmbcomunidad' => $row['comunidad'],
                        'direccion' => $row['direccion'],
                        'codmovilemp' => SUBSTR($row['tlfmovil'], 0, 3),
                        'movilemp' => SUBSTR($row['tlfmovil'], 3),
                        'codfijoemp' => SUBSTR($row['tlflocal'], 0, 3),
                        'fijoemp' => SUBSTR($row['tlflocal'], 3),
                        'codfaxemp' => SUBSTR($row['faxemp'], 0, 3),
                        'faxemp' => SUBSTR($row['faxemp'], 3),
                        'correoemp' => $row['emailemp'],
                        'pagwebemp' => $row['pagwebemp'],
                        'facebookemp' => $row['facebemp'],
                        'twitteremp' => $row['twitter'],
                        'seleccioncamara1' => $row['selecamara1'],
                        'seleccioncamara2' => $row['selecamara2'],
                        'seleccioncamara3' => $row['selecamara3'],
                        'seleccioncamara4' => $row['selecamara4'],
                        'seleccioncamara5' => $row['selecamara5'],
                        'cmbseccion' => $row['seccion'],
                        'cmbdivisionact' => $row['divisionact'],
                        'cmbgrupo' => $row['grupoact'],
                        'cmbclase' => $row['claseact'],
                        'cmbrama' => $row['ramaact'],
                        'total' => 1
                    );
                }
            }
        
        $output = array(
            'success' => true,
            'data' => $data,
            );
        echo json_encode($output);
    }


    public function obtenerEmpresa() {
        $username = $this->session->userdata('datasession');
        if ($username['login_ok'] == TRUE) {
            $usuario = $username['usuario'];
            //$nacionalidad =$username['nacionalidad']; 
        } else {
            //$usuario= $this->input->get("cedula");
            //$nacionalidad= $this->input->get("nacionalidad");
        }
        $empresa = $this->empresa_model->obtenerEmpresa($usuario);
        if ($empresa != false) {
            if ($username['login_ok'] == TRUE) {
                foreach ($empresa->result_array() as $row) {
                    
                    if( $row['id']!="" &&  $row['id']!=null)  {


                            $data[] = array(
                                'id' => $row['id'],
                                'rif' => SUBSTR($row['rif2'], 0, 1),
                                'rif1' => SUBSTR($row['rif2'], 1, strlen($row['rif2']) - 2),
                                'rif2' => $row['rif2'][strlen($row['rif2']) - 1],
                                'nombrecomer' => $row['nombreco'],
                                'anoact' => $row['anoact'],
                                'registromer' => $row['registromer'],
                                'razonsoc' => $row['raz2'],
                                'nacionalidadrep' => $row['nacionalidarep'],
                                'cedularep' => $row['cedula2'],
                                'representante' => $row['nombrerep'],
                                'codmovilrep' => SUBSTR($row['telfrep'], 0, 3),
                                'movilrep' => SUBSTR($row['telfrep'], 3),
                                'tipo' => $row['tipo'],
                                'nombrecont' => $row['nombrecont'],
                                'codmovilcont' => SUBSTR($row['telfcont'], 0, 3),
                                'movilcont' => SUBSTR($row['telfcont'], 3),
                                'nacionalidadcont' => $row['nacionalidadcont'],
                                'cedulacont' => $row['cedulacont'],
                                'cmbestado' => $row['estado'],
                                'cmbmunicipio' => $row['municipio'],
                                'cmbparroquia' => $row['parroquia'],
                                'cmbcomunidad' => $row['comunidad'],
                                'direccion' => $row['direccion'],
                                'codmovilemp' => SUBSTR($row['tlfmovil'], 0, 3),
                                'movilemp' => SUBSTR($row['tlfmovil'], 3),
                                'codfijoemp' => SUBSTR($row['tlflocal'], 0, 3),
                                'fijoemp' => SUBSTR($row['tlflocal'], 3),
                                'codfaxemp' => SUBSTR($row['faxemp'], 0, 3),
                                'faxemp' => SUBSTR($row['faxemp'], 3),
                                'correoemp' => $row['emailemp'],
                                'pagwebemp' => $row['pagwebemp'],
                                'facebookemp' => $row['facebemp'],
                                'twitteremp' => $row['twitter'],
                                'seleccioncamara1' => $row['selecamara1'],
                                'seleccioncamara2' => $row['selecamara2'],
                                'seleccioncamara3' => $row['selecamara3'],
                                'seleccioncamara4' => $row['selecamara4'],
                                'seleccioncamara5' => $row['selecamara5'],
                                'cmbseccion' => $row['seccion'],
                                'cmbdivisionact' => $row['divisionact'],
                                'cmbgrupo' => $row['grupoact'],
                                'cmbclase' => $row['claseact'],
                                'cmbrama' => $row['ramaact'],
                                'total' => 1
                            );
                    }else{
                        $data[] = array(
                                    'rif' => SUBSTR($row['rif2'], 0, 1),
                                    'rif1' => SUBSTR($row['rif2'], 1, strlen($row['rif2']) - 2),
                                    'rif2' => $row['rif2'][strlen($row['rif2']) - 1],
                                    'razonsoc' => $row['raz2'],
                                    'nacionalidadrep' => $row['nacionalidad2'],
                                    'cedularep' => $row['cedula2'],
                                    'total' => 1
                                );    
                    }
                }
            }
        } else {
            $data[] = array(
                'total' => 0
            );
        }
        $output = array(
            'success' => true,
            'data' => $data,
            'total' => count($data));
        echo json_encode($output);
    }

}

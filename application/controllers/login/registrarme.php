<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Registrarme extends CI_Controller {

    public function __construct() {
        parent::__construct();
        session_start();
        $this->load->helper('url');
        $this->load->database();
        $this->load->helper('recaptchalib_helper');
        $this->load->model('login/registrarme_model');
        $this->load->model('seguridad/usuario_model');

        $this->load->library(array('session'));
    }

    public function index() {
        //$this->load->view('administrativo');
    }

    public function guardarusuariolinea() {
        $rif = $this->input->post('rif') . $this->input->post('rif1') . $this->input->post('rif2');
        $razonsocial = $this->input->post('razonsocial');
        $nacionalidad = $this->input->post('nacionalidad');
        $cedula = $this->input->post('cedula');
        $correo = strtoupper($this->input->post('correo'));
        $privatekey = "6LcJAPUSAAAAABsytFmd3-n5h9oQ4NEoJY0Nbwmj";
        $resp = recaptcha_check_answer($privatekey, $_SERVER["REMOTE_ADDR"], $this->input->post("recaptcha_challenge_field"), $this->input->post("recaptcha_response_field"));

        $correoexiste = $this->usuario_model->verificarcorreo($correo);
        if (!$correoexiste) {
            if (!$resp->is_valid) {
                //si el captcha introducido es incorrecto se lo decimos
                echo json_encode(array(
                    "success" => false,
                    'msg' => 'Captcha no Valida'
                ));
            } else {
                $resultado = array();
                $resultado = $this->registrarme_model->verificaUsuariolinea($rif);

                if ($resultado->num_rows() > 0) {
                    foreach ($resultado->result_array() as $row) {

                        $emprevisarrif = $this->registrarme_model->Revisarrif();
                        if ($emprevisarrif) {
                            foreach ($emprevisarrif->result_array() as $row1) {
                                $dataempleado = array(
                                    'correo' => $row1['correo'],
                                    'nombre' => $row1['nombre'],
                                    'apellido' => $row1['apellido'],
                                );
                            }
                            $nombreemp = $dataempleado['nombre'];
                            $apellidoemp = $dataempleado['apellido'];
                            $correoemp = $dataempleado['correo'];
                            $this->Enviarcorreo($nombreemp, $apellidoemp, $correoemp, $rif, $razonsocial);
                        }
                        $this->output->set_output(json_encode(array(
                            'success' => true,
                            'msg' => 'Su contraseña sera enviada en las proximas horas al correo: ' . $correo)));
                    }
                } else {
                    $insertarusuariolinea = array(
                        'id' => $this->input->post('id'),
                        'rif' => $rif,
                        'nacionalidad' => $nacionalidad,
                        'cedula' => $cedula,
                        'razonsocial' => $razonsocial,
                        'correo' => $correo,
                        'status' => 0,
                    );
                    $resultado = $this->registrarme_model->insertUsuariolinea($insertarusuariolinea);
                    $emprevisarrif = $this->registrarme_model->Revisarrif();
                    if ($emprevisarrif) {
                        foreach ($emprevisarrif->result_array() as $row1) {
                            $dataempleado = array(
                                'correo' => $row1['correo'],
                                'nombre' => $row1['nombre'],
                                'apellido' => $row1['apellido'],
                            );
                        }
                        $nombreemp = $dataempleado['nombre'];
                        $apellidoemp = $dataempleado['apellido'];
                        $correoemp = $dataempleado['correo'];
                        $this->Enviarcorreo($nombreemp, $apellidoemp, $correoemp, $rif, $razonsocial);
                    }
                    $this->output->set_output(json_encode(array(
                        'success' => true,
                        'msg' => 'Transacción Exitosa,Se enviara un correo en las proximas horas'
                    )));
                }
            }
        }
        else
        {
             echo json_encode(array(
                    "success" => false,
                    'msg' => 'Correo Existente, Por Favor ingrese un correo diferente'
                ));
        }
    }

    public function Enviarcorreo($nombreemp, $apellidoemp, $correoemp, $rif, $razonsocial) {

        $this->load->library('email', '', 'correo');
        $configGmail = array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.gmail.com',
            'smtp_port' => 465,
            'smtp_user' => 'validacionregistrolae@gmail.com',
            'smtp_pass' => 'vlcr457g.h',
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n"
        );
        $this->correo->initialize($configGmail);
        $this->correo->from('LAE');
        $this->correo->to($correoemp);
        $this->correo->subject('Verificar RIF');
        $this->correo->message('<h1>Verificación de Rif</h1>
    <p>Estimado (a): <b>' . $nombreemp . '&nbsp;</b><b>&nbsp;' . $apellidoemp . '</p>
     <p> El siguiente correo es para solicitar efectúe la consulta de la siguiente empresa  en el portal del SENIAT :</p>
    <p><b>RIF:</b></p>
    <p><b>' . $rif . '&nbsp;</b></p>
    <p><b>Razon Social:</b></p>
    <p><b>' . $razonsocial . '&nbsp;</b></p>
    <p>Una vez validada la empresa ante el SENIAT debe ingresar al sistema REGISTRO LAE y proceder  a efectuar autorización del R.I.F. a los  fines de que se remita  vía  correo la generación del usuario y contraseña que se asignará a la empresa antes citada .</p>
    <p><b>Sistema de Registro de Empresas Manufatureras</b></p>
    <p><b>Lara... Tierra Progresista</b></p>');
        $this->correo->send();
    }

    function logout() {
        $this->session->sess_destroy();
        $this->index();
    }

}

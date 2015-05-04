<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Olvidoclave extends CI_Controller {

    public function __construct() {
        parent::__construct();
        session_start();
        $this->load->helper('url');
        $this->load->database();
        $this->load->helper('recaptchalib_helper');
        $this->load->model('login/registrarme_model');
        $this->load->model('usuario/usuario_model');
        $this->load->library(array('session'));
    }

    public function index() {
        //$this->load->view('administrativo');
    }

    public function recuperarclave() {
        $rif = $this->input->post('rif');

        $resultado = array();
        $resultado = $this->usuario_model->existeusuariorif($rif);
        $resultado2 = $this->registrarme_model->verificaUsuariolinea($rif);

        if ($resultado->num_rows() > 0) {
            foreach ($resultado->result_array() as $row1) {
               
                $id= $row1['id'];
            }

            foreach ($resultado2->result_array() as $row2) {
               
                $correo = $row2['correo'];
            }

            $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
            $cad = "";
            for ($i = 0; $i < 12; $i++) {
                $cad .= substr($str, rand(0, 62), 1);
            }
            $cad2 = strtoupper($cad);
            $cad = md5(strtoupper($cad));

            $this->output->set_output(json_encode(array(
                'success' => true,
                'msg' => 'Transacción Exitosa,Se enviara un correo con su nueva contraseña'
            )));
            $usuario = array(
                'id' => $id,
                'password' => $cad
            );
            $result = $this->usuario_model->updateUsuario($usuario);
            $this->Enviarclave($correo, $cad2, $usuario,$rif);
        } else {
            echo json_encode(array(
                "success" => false,
                'msg' => 'El RIF no se encuentra reguistrado, por favor verifique'
            ));
        }
    }

    public function Enviarclave($correo, $cad, $usuario,$rif) {

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
        $this->correo->from('FUNDAPYME');
        $this->correo->to($correo);
        $this->correo->subject('Usuario y Clave del Sistema Registro de Empresa');
        $this->correo->message('<h1>Usuario y Clave</h1>
    <p>Estimado (a): Usuario
     <p> Correo de recuperacion de contraseña de ingreso al sistema </p>
    <p><b>Usuario:' . $rif . '</b></p>
    <p><b>Clave:' . $cad . '</b></p>
    <p>En la siguiente Dirección puede ingresar al sistema</p>
    <p><b>Sistema de Registro de Empresas Manufatureras</b></p>
    <p><b>Lara... Tierra Progresista</b></p>');
        $this->correo->send();
    }

}

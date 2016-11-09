<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

header('Content-Type: text/html; charset=utf-8');
class LoginCalificador extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->database('default');
        $this->load->model('Login_model');
    }
	
	public function index() {
        $this->load->view('LoginCalificador_view');
	}

    public function guardarIngreso() {
        $this->session->set_userdata('correoCalificador', $_POST['correoCalificador']);
        $this->session->set_userdata('idTokenCalificador', $_POST['idToken']);
        $this->session->set_userdata('accessTokenCalificador', $_POST['accessToken']);
        
        date_default_timezone_set('America/Monterrey');
        $hora = date("H:i:s");
        $fecha = date("Y-m-d");
        $lista = array(
            'ingreso' => 'si',
            'hora'    => $hora,
            'fecha'   => $fecha,
            'nombre'  => $_POST['nombre'],
            'correo'  => $_POST['correoCalificador']
        );
        $this->Login_model->ingresoACalificador($lista);
        $datos['exito'] = true;

        print_r(json_encode($datos));
    }

}

?>

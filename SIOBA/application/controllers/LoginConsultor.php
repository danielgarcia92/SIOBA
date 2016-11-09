<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

header('Content-Type: text/html; charset=utf-8');
class LoginConsultor extends CI_Controller{

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->database('default');
        $this->load->model('Login_model');
    }

	public function index() {
        $this->load->view('LoginConsultor_view');
	}

    public function guardarIngreso() {
        $this->session->set_userdata('correoConsultor', $_POST['correoConsultor']);
        $this->session->set_userdata('idTokenConsultor', $_POST['idToken']);
        $this->session->set_userdata('accessTokenConsultor', $_POST['accessToken']);

        date_default_timezone_set('America/Monterrey');
        $nombre = $_POST['nombre'];
        $correo = $_POST['correoConsultor'];
        $hora = date("H:i:s");
        $fecha = date("Y-m-d");
        
        $admin = $this->Login_model->adminSelCorreo($correo);
        if ($admin['longitud'] != 0) {      //Comprueba si es administrador
            $datos['exito'] = true;
            $datos['correo'] = $correo;
            $datos['usuario'] = 'admin';
            $data = array(
                'nombre' => $nombre,
                'hora' => $hora,
                'fecha' => $fecha,
                'correo' => $correo,
                'ingreso' => 'si'
            );
            $this->Login_model->ingresoAConsultor($data);
            $this->session->set_userdata('usuario', 'admin');
        }else
            $datos['exito'] = false;

        if (!isset($datos['usuario'])) {    //Comprueba si es jefe de división
            $divisiones = $this->Login_model->divisionesSelCorreo($correo);
            if ($divisiones['longitud'] > 0) {
                $datos['exito'] = true;
                $datos['correo'] = $correo;
                $datos['usuario'] = 'division';
                $data = array(
                    'nombre' => $nombre,
                    'hora' => $hora,
                    'fecha' => $fecha,
                    'correo' => $correo,
                    'ingreso' => 'si'
                );
                $this->Login_model->ingresoAConsultor($data);
                $this->session->set_userdata('usuario', 'division');
            }
        }

        if (!isset($datos['usuario'])) {    //Comprueba si es facilitador divisional
            $divisiones = $this->Login_model->facilitadoresSelCorreo($correo);
            if ($divisiones['longitud'] > 0) {
                $datos['exito'] = true;
                $datos['correo'] = $correo;
                $datos['usuario'] = 'division';
                $data = array(
                    'nombre' => $nombre,
                    'hora' => $hora,
                    'fecha' => $fecha,
                    'correo' => $correo,
                    'ingreso' => 'si'
                );
                $this->Login_model->ingresoAConsultor($data);
                $this->session->set_userdata('usuario', 'division');
            }
        }

        if (!isset($datos['usuario'])) {    //Comprueba si es jefe de departamento
            $departamentos = $this->Login_model->departamentosSelCorreo($correo);
            if ($departamentos['longitud'] > 0) {
                $datos['exito'] = true;
                $datos['usuario'] = 'departamento';
                $datos['correo'] = $correo;
                $data = array(
                    'nombre' => $nombre,
                    'hora' => $hora,
                    'fecha' => $fecha,
                    'correo' => $correo,
                    'ingreso' => 'si'
                );
                $this->Login_model->ingresoAConsultor($data);
                $this->session->set_userdata('usuario', 'departamento');
            }
        }

        if ($datos['exito'] == false) {
            $data = array(
                'nombre' => $nombre,
                'hora' => $hora,
                'fecha' => $fecha,
                'correo' => $correo,
                'ingreso' => 'no'
            );
            $this->Login_model->ingresoAConsultor($data);
            $this->session->set_userdata('usuario', '');
        }

        print_r(json_encode($datos));

    }

}

?>

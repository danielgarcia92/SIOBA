<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

header('Content-Type: text/html; charset=utf-8');
class Calificador extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->database('default');
        $this->load->model('Calificador_model');
    }
	
	public function index() {
        if( isset($_POST['correoCalificador']) && isset($_SESSION['correoCalificador']))
            $this->load->view('Calificador_view');
        else
            redirect('LoginCalificador');
	}

    public function cerrarSesion() {
        $resultado = file_get_contents('https://accounts.google.com/o/oauth2/revoke?token='.$this->session->userdata('accessTokenCalificador'));
        $this->session->unset_userdata('correoCalificador');
        $this->session->unset_userdata('idTokenCalificador');
        $this->session->unset_userdata('accessTokenCalificador');
        $this->session->sess_destroy();
        redirect('LoginCalificador');
    }

    public function comprobarExistente($periodo, $tipo, $profesor, $departamentoId) {
        $listaResultados = array(
            'periodo'          => $periodo,
            'tipo_encuesta'    => $tipo,
            'pidm_profesor'    => $profesor,
            'id_departamentos' => $departamentoId
        );
        $existe = $this->Calificador_model->comprobarExistente($listaResultados);
        return $existe;
    }

    public function cursosSel() {
        $periodo = $this->periodoActual();
        $datos = $this->Calificador_model->cursosSel($periodo, $_POST['pidm']);
        print_r(json_encode($datos));
    }

    public function departamentosSel() {
        $datos = $this->Calificador_model->departamentosSel();
        print_r(json_encode($datos));
    }

    public function divisionesSel()  {
        $datos = $this->Calificador_model->divisionesSel();
        print_r(json_encode($datos));
    }

    public function insertar() {
        date_default_timezone_set('America/Monterrey');
        $fecha = date("Y-m-d");
        $hora = date("H:i:s");
        $fechaIngreso = $fecha . ' a las ' . $hora;
        if(isset($_POST['observador']))
            $observador = $_POST['observador'];
        else
            $observador = 0;

        $periodo = $this->periodoActual();
        $existe = $this->comprobarExistente($periodo['codigo'], $_POST['tipo'], $_POST['profesor'], $_POST['departamento']);
        if($existe != 0) {
            $datos['tipo'] = $_POST['tipo'];
            $datos['folio'] = '';
            $datos['exito'] = false;
        }else {
            $numeroInserciones = 0;
            while ($variables = each($_POST)){
                $encontrar = 'opciones';
                $funcion = strpos($variables[0], $encontrar);
                if ($funcion === false){
                }else{
                    $idCatalogo[] = $variables[1];
                    $numeroInserciones += 1;
                }
            }
            
            $idComentario = $this->insertarComentarios($periodo['codigo'], $_POST['tipo'], $_POST['fortaleza'], $_POST['oportunidad'], $_POST['comGenerales']);

            if ($idComentario == 0 || $idComentario == '') {
                $datos['tipo'] = '';
                $datos['folio'] = '';
                $datos['exito'] = false;
            }else {
                $error = false;
                if ($numeroInserciones == 0) {
                    $listaResultados = array(
                        'id'               => '',
                        'folio'            => $idComentario,
                        'periodo'          => $periodo['codigo'],
                        'tipo_encuesta'    => $_POST['tipo'],
                        'pidm_profesor'    => $_POST['profesor'],
                        'pidm_observador'  => $observador,
                        'id_divisiones'    => $_POST['division'],
                        'id_departamentos' => $_POST['departamento'],
                        'crn'              => $_POST['curso'],
                        'fecha'            => $_POST['fecha'],
                        'id_comentarios'   => $idComentario,
                        'id_catalogo'      => 75,
                        'bandera_catalogo' => 0,
                        'fecha_ingreso'    => $fechaIngreso,
                        'correo_ingreso'   => $this->session->userdata('correoCalificador')
                    );
                    $insertarResultados = $this->Calificador_model->insertarResultados($listaResultados);
                    if($insertarResultados == 0 || $insertarResultados =='')
                        $error = true;
                } else {
                    for ($i = 0; $i < $numeroInserciones; $i++) {
                        $listaResultados = array(
                            'id'               => '',
                            'folio'            => $idComentario,
                            'periodo'          => $periodo['codigo'],
                            'tipo_encuesta'    => $_POST['tipo'],
                            'pidm_profesor'    => $_POST['profesor'],
                            'pidm_observador'  => $observador,
                            'id_divisiones'    => $_POST['division'],
                            'id_departamentos' => $_POST['departamento'],
                            'crn'              => $_POST['curso'],
                            'fecha'            => $_POST['fecha'],
                            'id_comentarios'   => $idComentario,
                            'id_catalogo'      => $idCatalogo[$i],
                            'bandera_catalogo' => 1,
                            'fecha_ingreso'    => $fechaIngreso,
                            'correo_ingreso'   => $this->session->userdata('correoCalificador')
                        );
                        $insertarResultados = $this->Calificador_model->insertarResultados($listaResultados);
                        if($insertarResultados == 0 || $insertarResultados =='')
                            $error = true;
                    }
                }
                if($error == true) {
                    $datos['tipo'] = '';
                    $datos['folio'] = '';
                    $datos['exito'] = false;
                } else {
                    $datos['tipo'] = $_POST['tipo'];
                    $datos['folio'] = $idComentario;
                    $datos['exito'] = true;
                }
            }
        }
        $this->load->view('Captura_view', $datos);
    }

    public function insertarComentarios($periodo, $tipo, $fortaleza, $oportunidad, $comGenerales) {
        $listaComentarios = array(
            'id'            => '',
            'periodo'       => $periodo,
            'tipo_encuesta' => $tipo,
            'fortalezas'    => $fortaleza,
            'oportunidades' => $oportunidad,
            'generales'     => $comGenerales
        );
        $idComentario = $this->Calificador_model->insertarComentarios($listaComentarios);
        return $idComentario;
    }

    public function observadoresSel() {
        $datos = $this->Calificador_model->observadoresSel();
        print_r(json_encode($datos));
    }

    public function periodoActual() {
        $datos = $this->Calificador_model->periodoActual();
        return $datos;
    }

    public function periodoSel() {
        $datos = $this->Calificador_model->periodoActual();
        print_r(json_encode($datos));
    }

    public function profesoresSel() {
        $datos = $this->Calificador_model->profesoresSel();
        print_r(json_encode($datos));
    }

}

?>

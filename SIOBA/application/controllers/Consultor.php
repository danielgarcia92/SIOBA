<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

header('Content-Type: text/html; charset=utf-8');
class Consultor extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->database('default');
        $this->load->model('Consultor_model');
    }
	
	public function index() {
        if( isset($_POST['correoConsultor']) && isset($_POST['usuario']) && isset($_SESSION['correoConsultor'])) {
            $datos['correoConsultor'] = $this->session->userdata('correoConsultor');
            $datos['usuario'] = $this->session->userdata('usuario');
            $this->load->view('Consultor_view', $datos);
        }else
            redirect('LoginConsultor');
    }

    public function cerrarSesion() {
        $resultado = file_get_contents('https://accounts.google.com/o/oauth2/revoke?token='.$this->session->userdata('accessTokenConsultor'));
        print_r($resultado);
        $this->session->unset_userdata('usuario');
        $this->session->unset_userdata('correoConsultor');
        $this->session->unset_userdata('idTokenConsultor');
        $this->session->unset_userdata('accessTokenConsultor');
        $this->session->sess_destroy();
        redirect('LoginConsultor');
    }

    public function concentradoDep() {
    	if ( isset($_POST['departamentoId']) ) {
        	$resultados = $this->Consultor_model->concentradoDep($_POST['departamentoId']);

        	$datos['colMenos'] = 0;
        	$datos['colTotal'] = 0;
        	$datos['colEsperado'] = 0;
        	$datos['colSobresaliente'] = 0;
        	for ($i=0; $i < $resultados['longitud']; $i++) {
        		$datos['filaMenos'][$i] = 0;
        		$datos['filaEsperado'][$i] = 0;
        		$datos['filaSobresaliente'][$i] = 0;
        		$datos['longitud'] = $resultados['longitud'];
        		$datos['resultados'][$i] = $resultados['resultados'][$i];
        		$idCatalogo = $this->Consultor_model->obtenerIdSeccion($resultados['resultados'][$i]->folio);

        		for ($j=0; $j < $idCatalogo['longitud']; $j++) {
        			if ( $idCatalogo['resultados'][$j]->seccionId == 1 )
        				$datos['filaMenos'][$i] += 1;
        			if ( $idCatalogo['resultados'][$j]->seccionId == 2 )
        				$datos['filaEsperado'][$i] += 1;
                    if ( $idCatalogo['resultados'][$j]->seccionId == 3 )
                    	$datos['filaSobresaliente'][$i] += 1; 
        		}

        		$datos['filaTotal'][$i] = $datos['filaMenos'][$i] + $datos['filaEsperado'][$i] + $datos['filaSobresaliente'][$i];

        		if ( $datos['filaTotal'][$i] != 0 ) {
        			$datos['filaPorcMenos'][$i] = round($datos['filaMenos'][$i] * 100 / $datos['filaTotal'][$i], 0);
        			$datos['filaPorcEsperado'][$i] = round($datos['filaEsperado'][$i] * 100 / $datos['filaTotal'][$i], 0);
        			$datos['filaPorcSobresaliente'][$i] = round($datos['filaSobresaliente'][$i] * 100 / $datos['filaTotal'][$i], 0);
        		} else {
        			$datos['filaPorcMenos'][$i] = 0;
        			$datos['filaPorcEsperado'][$i] = 0;
        			$datos['filaPorcSobresaliente'][$i] = 0;
        		}
        		
        		$datos['filaPorcTotal'][$i] = $datos['filaPorcMenos'][$i] + $datos['filaPorcEsperado'][$i] + $datos['filaPorcSobresaliente'][$i];

        		$datos['colMenos'] += $datos['filaMenos'][$i];
        		$datos['colEsperado'] += $datos['filaEsperado'][$i];
        		$datos['colSobresaliente'] += $datos['filaSobresaliente'][$i];
        		$datos['colTotal'] += $datos['filaTotal'][$i];
        	}

        	if ($datos['colTotal'] != 0) {
        		$datos['colPorcMenos'] = round($datos['colMenos'] * 100 / $datos['colTotal']);
        		$datos['colPorcTotal'] = round($datos['colTotal'] * 100 / $datos['colTotal']);
        		$datos['colPorcEsperado'] = round($datos['colEsperado'] * 100 / $datos['colTotal']);
        		$datos['colPorcSobresaliente'] = round($datos['colSobresaliente'] * 100 / $datos['colTotal']);
        	} else {
        		$datos['colPorcMenos'] = 0;
        		$datos['colPorcTotal'] = 0;
        		$datos['colPorcEsperado'] = 0;
        		$datos['colPorcSobresaliente'] = 0;
        	}

        	$this->load->view('concentradoDepPDF_view', $datos);
        	$data['exito'] = true;
        	$data['departamento'] = $resultados['resultados'][0]->departamento;
        	print_r(json_encode($data));
        } else
        	redirect($this->cerrarSesion());
    }

    public function concentradoDiv() {
        if ( isset($_POST['divisionId']) ) {
            $datos['numDep'] = $this->Consultor_model->obtenerNumDep($_POST['divisionId']);

            for ($i=0; $i < $datos['numDep']['longitud']; $i++) {
            	$datos['resultados'][$i] = $this->Consultor_model->concentradoDep($datos['numDep']['resultados'][$i]->departamentoId);

            	$datos['colMenos'][$i] = 0;
        		$datos['colTotal'][$i] = 0;
        		$datos['colEsperado'][$i] = 0;
        		$datos['colSobresaliente'][$i] = 0;
        		for ($j=0; $j < $datos['resultados'][$i]['longitud']; $j++) {
	        		$datos['filaMenos'][$i][$j] = 0;
	        		$datos['filaEsperado'][$i][$j] = 0;
	        		$datos['filaSobresaliente'][$i][$j] = 0;
	        		$idCatalogo[$j] = $this->Consultor_model->obtenerIdSeccion($datos['resultados'][$i]['resultados'][$j]->folio);

	        		for ($k=0; $k < $idCatalogo[$j]['longitud']; $k++) {
	        			if ( $idCatalogo[$j]['resultados'][$k]->seccionId == 1 )
	        				$datos['filaMenos'][$i][$j] += 1;
	        			if ( $idCatalogo[$j]['resultados'][$k]->seccionId == 2 )
	        				$datos['filaEsperado'][$i][$j] += 1;
	                    if ( $idCatalogo[$j]['resultados'][$k]->seccionId == 3 )
	                    	$datos['filaSobresaliente'][$i][$j] += 1; 
	        		}

	        		$datos['filaTotal'][$i][$j] = $datos['filaMenos'][$i][$j] + $datos['filaEsperado'][$i][$j] + $datos['filaSobresaliente'][$i][$j];

	        		if ( $datos['filaTotal'][$i][$j] != 0 ) {
	        			$datos['filaPorcMenos'][$i][$j] = round($datos['filaMenos'][$i][$j] * 100 / $datos['filaTotal'][$i][$j], 0);
	        			$datos['filaPorcEsperado'][$i][$j] = round($datos['filaEsperado'][$i][$j] * 100 / $datos['filaTotal'][$i][$j], 0);
	        			$datos['filaPorcSobresaliente'][$i][$j] = round($datos['filaSobresaliente'][$i][$j] * 100 / $datos['filaTotal'][$i][$j], 0);
	        		} else {
	        			$datos['filaPorcMenos'][$i][$j] = 0;
	        			$datos['filaPorcEsperado'][$i][$j] = 0;
	        			$datos['filaPorcSobresaliente'][$i][$j] = 0;
	        		}
	        		
	        		$datos['filaPorcTotal'][$i][$j] = $datos['filaPorcMenos'][$i][$j] + $datos['filaPorcEsperado'][$i][$j] + $datos['filaPorcSobresaliente'][$i][$j];

	        		$datos['colMenos'][$i] += $datos['filaMenos'][$i][$j];
	        		$datos['colEsperado'][$i] += $datos['filaEsperado'][$i][$j];
	        		$datos['colSobresaliente'][$i] += $datos['filaSobresaliente'][$i][$j];
	        		$datos['colTotal'][$i] += $datos['filaTotal'][$i][$j];
	        	}
	        	if ($datos['colTotal'][$i] != 0) {
	        		$datos['colPorcMenos'][$i] = round($datos['colMenos'][$i] * 100 / $datos['colTotal'][$i]);
	        		$datos['colPorcTotal'][$i] = round($datos['colTotal'][$i] * 100 / $datos['colTotal'][$i]);
	        		$datos['colPorcEsperado'][$i] = round($datos['colEsperado'][$i] * 100 / $datos['colTotal'][$i]);
	        		$datos['colPorcSobresaliente'][$i] = round($datos['colSobresaliente'][$i] * 100 / $datos['colTotal'][$i]);
	        	} else {
	        		$datos['colPorcMenos'] = 0;
	        		$datos['colPorcTotal'] = 0;
	        		$datos['colPorcEsperado'] = 0;
	        		$datos['colPorcSobresaliente'] = 0;
	        	}
            }
            $this->load->view('concentradoDivPDF_view', $datos);
            $data['exito'] = true;
        	$data['division'] = $datos['numDep']['resultados'][0]->division;
        	print_r(json_encode($data));
        }else
            redirect($this->cerrarSesion());
    }

    public function divisionesAdmin() {
        $datos = $this->Consultor_model->divisionesAdmin();
        print_r(json_encode($datos));
    }

    public function divisionesDivDir() {
        $datos = $this->Consultor_model->divisionesDivDir($_POST['correoConsultor']);
        if ($datos['longitud'] == 0) {
            $datos = $this->Consultor_model->divisionesDivFac($_POST['correoConsultor']);
        }
        print_r(json_encode($datos));
    }

    public function departamentosDepDir() {
        $datos = $this->Consultor_model->departamentosDepDir($_POST['correoConsultor']);
        print_r(json_encode($datos));
    }

    public function departamentosSel() {
        $datos = $this->Consultor_model->departamentosSel($_POST['divisionId']);
        print_r(json_encode($datos));
    }

    public function resultadosAut() {
        $datos = $this->Consultor_model->resultadosAut($_POST['departamentoId']);
        print_r(json_encode($datos));
    }

    public function resultadosObs() {
        $datos = $this->Consultor_model->resultadosObs($_POST['departamentoId']);
        print_r(json_encode($datos));
    }

    public function resultadosAmbos() {
        $datos = $this->Consultor_model->resultadosAmbos($_POST['departamentoId']);
        print_r(json_encode($datos));
    }

}

?>

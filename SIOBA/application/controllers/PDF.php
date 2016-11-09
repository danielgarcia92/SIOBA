<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

header('Content-Type: text/html; charset=utf-8');
class PDF extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database('default');
        $this->load->model('PDF_model');
        $this->load->library('session');
        $this->load->helper(array('url'));
    }

    public function index() {
        redirect('LoginCalificador');
    }

    public function consultorPDF() {
        if ( isset($_POST['folio']) ) {
            $resultados = $this->PDF_model->resultadosConsultor($_POST['folio']);
            $idCatalogo = $this->PDF_model->obtenerIdCatalogo($_POST['folio']);
            for ($i = 1; $i <= 74; $i++)
                $datos['id'][$i] = 'no';
            for ($i = 0; $i < $idCatalogo['longitudCatalogo']; $i++)
                $datos['id'][$idCatalogo['idCatalogo'][$i]] = 'si';
            $datos['resultados'] = $resultados;
            $this->load->view('PDF_view', $datos);

            $data['exito'] = true;
            $data['profesor'] = $resultados->profesor;
            $data['tipoEncuesta'] = $resultados->tipoEncuesta;
            print_r(json_encode($data));
        }else
            redirect('LoginConsultor');
    }
	
	public function calificadorPDF() {
        if ( isset($_POST['folio']) ) {
        	$resultados = $this->PDF_model->resultadosCalificador($_POST['folio']);

        	for ($i = 1; $i <=  $resultados['longitud']; $i++) {
        		$idCatalogo = $this->PDF_model->obtenerIdCatalogo($resultados['resultados'][$i]->folio);
        		$datos['resultados'] = $resultados['resultados'][$i];
        		for ($j = 1; $j <= 74; $j++)
                    $datos['id'][$j] = 'no';
                for ($k = 0; $k < $idCatalogo['longitudCatalogo']; $k++)
                    $datos['id'][$idCatalogo['idCatalogo'][$k]] = 'si';
                $this->load->view('PDF_view', $datos);
        	}

        	$data['exito'] = true;
        	print_r(json_encode($data));
        }else
        	redirect('LoginCalificador');
    }

}

?>

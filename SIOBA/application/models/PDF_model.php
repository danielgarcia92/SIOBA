<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PDF_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
	}

	public function resultadosConsultor($folio) {
		$this->db->select('COM.generales');
		$this->db->select('COM.fortalezas');
		$this->db->select('COM.oportunidades');
		$this->db->select('RES.fecha AS fecha');
		$this->db->select('RES.folio AS folio');
		$this->db->select('CUR.nombre AS curso');
		$this->db->select('DIVI.codigo AS division');
		$this->db->select('PROFE.nombre AS profesor');
		$this->db->select('OBS.nombre AS observador');
		$this->db->select('PER.descripcion AS periodo');
		$this->db->select('RES.tipo_encuesta AS tipoEncuesta');
		$this->db->select('DEP.nombre_departamento AS departamento');
		$this->db->join('periodoactual PER', 'RES.periodo = PER.periodo', 'inner');
		$this->db->join('divisiones DIVI', 'RES.id_divisiones = DIVI.id', 'inner');
		$this->db->join('observadores OBS', 'RES.pidm_observador = OBS.pidm', 'left');
		$this->db->join('profesores PROFE', 'RES.pidm_profesor = PROFE.pidm', 'inner');
		$this->db->join('departamentos DEP', 'RES.id_departamentos = DEP.id', 'inner');
		$this->db->join('cursos CUR', 'RES.crn = cur.crn AND CUR.periodo = RES.periodo', 'inner');
		$this->db->join('comentarios COM', 'RES.id_comentarios = COM.id AND COM.periodo = RES.periodo AND RES.tipo_encuesta = COM.tipo_encuesta', 'inner');
		$this->db->where('RES.folio', $folio);
		$this->db->group_by('RES.folio');
		$consulta = $this->db->get('resultados RES');
		$longitud = $consulta->num_rows();
		for ($i = 1; $i <= $longitud; $i++)
			$datos = $consulta->row($i);

		return $datos;
	}

	public function resultadosCalificador($folio) {
		$this->db->select('RES.periodo AS periodoCodigo');
		$this->db->select('RES.pidm_profesor AS profesorPIDM');
		$this->db->select('RES.id_departamentos AS departamentoId');
		$this->db->where('RES.folio', $folio);
		$this->db->group_by('RES.folio');
		$consulta1 = $this->db->get('resultados RES');
		$data = $consulta1->row();

		$this->db->select('RES.folio');
		$this->db->select('COM.generales');
		$this->db->select('COM.fortalezas');
		$this->db->select('COM.oportunidades');
		$this->db->select('RES.fecha AS fecha');
		$this->db->select('RES.folio AS folio');
		$this->db->select('CUR.nombre AS curso');
		$this->db->select('DIVI.codigo AS division');
		$this->db->select('PROFE.nombre AS profesor');
		$this->db->select('OBS.nombre AS observador');
		$this->db->select('PER.descripcion AS periodo');
		$this->db->select('RES.tipo_encuesta AS tipoEncuesta');
		$this->db->select('DEP.nombre_departamento AS departamento');
		$this->db->join('periodoactual PER', 'RES.periodo = PER.periodo', 'inner');
		$this->db->join('divisiones DIVI', 'RES.id_divisiones = DIVI.id', 'inner');
		$this->db->join('observadores OBS', 'RES.pidm_observador = OBS.pidm', 'left');
		$this->db->join('profesores PROFE', 'RES.pidm_profesor = PROFE.pidm', 'inner');
		$this->db->join('departamentos DEP', 'RES.id_departamentos = DEP.id', 'inner');
		$this->db->join('cursos CUR', 'RES.crn = cur.crn AND CUR.periodo = RES.periodo', 'inner');
		$this->db->join('comentarios COM', 'RES.id_comentarios = COM.id AND COM.periodo = RES.periodo AND RES.tipo_encuesta = COM.tipo_encuesta', 'inner');
		$this->db->where('RES.periodo', $data->periodoCodigo);
		$this->db->where('RES.pidm_profesor', $data->profesorPIDM);
		$this->db->where('RES.id_departamentos', $data->departamentoId);
		$this->db->group_by('RES.folio');
		$this->db->order_by('RES.tipo_encuesta', 'ASC');
		$consulta2 = $this->db->get('resultados RES');
		$datos['longitud'] = $consulta2->num_rows();
		for ($i = 1; $i <= $datos['longitud']; $i++)
			$datos['resultados'][$i] = $consulta2->row($i-1);

		return $datos;
	}

	public function obtenerIdCatalogo($folio) {
		$this->db->select('id_catalogo');
 		$this->db->where('folio', $folio);
 		$consulta = $this->db->get('resultados');
		$datos['longitudCatalogo'] = $consulta->num_rows();
		for ($i=0; $i < $datos['longitudCatalogo']; $i++)
 			$datos['idCatalogo'][$i] = $consulta->row($i)->id_catalogo;
 		
		return $datos;
	}

}

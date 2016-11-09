<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Correo_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
	}

	public function datosCorreo ($folio) {
		$this->db->select('RES.periodo AS periodoCodigo');
		$this->db->select('RES.pidm_profesor AS profesorPIDM');
		$this->db->select('RES.id_departamentos AS departamentoId');
		$this->db->where('RES.folio', $folio);
		$this->db->group_by('RES.folio');
		$consulta1 = $this->db->get('resultados RES');
		$data = $consulta1->row();

		$this->db->select('CUR.clave AS clave');
		$this->db->select('CUR.nombre AS cursoNombre');
		$this->db->select('PROFE.nombre AS profesorNombre');
		$this->db->select('PROFE.correo AS profesorCorreo');
		$this->db->select('OBS.nombre AS observadorNombre');
		$this->db->select('OBS.correo AS observadorCorreo');
		$this->db->select('RES.pidm_Profesor AS profesorPIDM');
		$this->db->select('RES.tipo_encuesta AS tipoEncuesta');
		$this->db->select('PER.descripcion AS periodoDescripcion');
		$this->db->select('RES.fecha_ingreso AS fechaIngreso');
		$this->db->join('periodoactual PER', 'RES.periodo = PER.periodo', 'inner');
		$this->db->join('observadores OBS', 'RES.pidm_observador = OBS.pidm', 'left');
		$this->db->join('profesores PROFE', 'RES.pidm_profesor = PROFE.pidm', 'inner');
		$this->db->join('cursos CUR', 'RES.crn = cur.crn AND CUR.periodo = RES.periodo', 'inner');
		$this->db->where('RES.periodo', $data->periodoCodigo);
		$this->db->where('RES.pidm_profesor', $data->profesorPIDM);
		$this->db->where('RES.id_departamentos', $data->departamentoId);
		$this->db->group_by('RES.folio');
		$this->db->order_by('RES.tipo_encuesta', 'ASC');
		$consulta2 = $this->db->get('resultados RES');
		$datos['longitud'] = $consulta2->num_rows();
		for ($i = 1; $i <= $datos['longitud']; $i++)
			$datos['resultados'][$i] = $consulta2->row($i);

		return $datos;
	}

}

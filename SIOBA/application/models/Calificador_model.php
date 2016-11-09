<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Calificador_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
	}

	public function comprobarExistente($listaResultados) {
		$this->db->select('periodo');
		$this->db->select('tipo_encuesta');
		$this->db->select('pidm_profesor');
		$this->db->where('periodo', $listaResultados['periodo']);
		$this->db->where('tipo_encuesta', $listaResultados['tipo_encuesta']);
		$this->db->where('pidm_profesor', $listaResultados['pidm_profesor']);
		$this->db->where('id_departamentos', $listaResultados['id_departamentos']);
		$query = $this->db->get('resultados');
		$datos['longitud'] = $query->num_rows();
		return $datos['longitud'];
	}

	public function cursosSel($periodo, $pidm) {
		$this->db->select('RPC.crn');
		$this->db->select('CUR.nombre AS curso');
		$this->db->select('CUR.clave AS clave');
		$this->db->join('cursos CUR', 'RPC.crn = CUR.crn', 'inner');
		$this->db->where('CUR.periodo', $periodo['codigo']);
		$this->db->where('RPC.periodo', $periodo['codigo']);
		$this->db->where('RPC.pidm', $pidm);
        $query = $this->db->get('relacionprofesorcurso RPC');
		$datos['longitud'] = $query->num_rows();
		for ($i=0; $i < $datos['longitud']; $i++){
			$datos['crn'][$i] = $query->row($i)->crn;
			$datos['curso'][$i] = $query->row($i)->curso;
			$datos['clave'][$i] = $query->row($i)->clave;
		}
		return $datos;
	}

	public function departamentosSel() {
		$this->db->select('id');
		$this->db->select('nombre_departamento');
		$this->db->select('id_divisiones');
		$query = $this->db->get('departamentos');
		$datos['longitud'] = $query->num_rows();
		for ($i=0; $i < $datos['longitud']; $i++)
			$datos['departamento'][$i] = $query->row($i);
		return $datos;
	}

	public function divisionesSel() {
		$this->db->select('id');
		$this->db->select('codigo');
		$query = $this->db->get('divisiones');
		$datos['longitud'] = $query->num_rows();
		for ($i=0; $i < $datos['longitud']; $i++)
			$datos['division'][$i] = $query->row($i);
		return $datos;
	}

	public function insertarComentarios($listaComentarios) {
		$this->db->insert('comentarios', $listaComentarios);
   		$insert_id = $this->db->insert_id();
   		return  $insert_id;
	}

	public function insertarResultados($listaResultados){
		$resultados = $this->db->insert('resultados', $listaResultados);
   		return  $resultados;
	}

	public function observadoresSel() {
		$this->db->select('pidm');
		$this->db->select('nombre');
		$this->db->select('correo');
		$this->db->order_by('nombre', 'ASC');
        $query = $this->db->get('observadores');
		$datos['longitud'] = $query->num_rows();
		for ($i = 0; $i < $datos['longitud']; $i++) {
			$datos['pidm'][$i] = $query->row($i)->pidm;
            $datos['nombre'][$i] = $query->row($i)->nombre;
            $datos['correo'][$i] = $query->row($i)->correo;
        }
		return $datos;
	}

	public function periodoActual() {
		$this->db->select('periodo');
		$this->db->select('descripcion');
		$query = $this->db->get('periodoactual');
		$listaPeriodos = $query->num_rows();
		for ($i=0; $i < $listaPeriodos; $i++) {
			$datos['codigo'] = $query->row($i)->periodo;
			$datos['descripcion'] = $query->row($i)->descripcion;
		}
		return $datos;
	}

	public function profesoresSel() {
		$this->db->select('pidm');
		$this->db->select('nombre');
		$this->db->select('correo');
		$this->db->order_by('nombre', 'ASC');
        $query = $this->db->get('profesores');
		$datos['longitud'] = $query->num_rows();
		for ($i = 0; $i < $datos['longitud']; $i++) {
			$datos['pidm'][$i] = $query->row($i)->pidm;
            $datos['nombre'][$i] = $query->row($i)->nombre;
            $datos['correo'][$i] = $query->row($i)->correo;
        }
		return $datos;
	}

}

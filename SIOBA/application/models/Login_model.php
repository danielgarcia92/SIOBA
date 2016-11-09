<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
	}

	public function ingresoACalificador($datos) {
		$this->db->insert('ingresoacalificador', $datos);
	}

	public function ingresoAConsultor($datos) {
		$this->db->insert('ingresoaconsultor', $datos);
	}

	public function adminSelCorreo($correo) {
		$this->db->select('correo');
		$this->db->where('correo', $correo);
		$query = $this->db->get('administradores');
		$datos['longitud'] = $query->num_rows();
		return $datos;
	}

	public function divisionesSelCorreo($correo) {
		$this->db->select('correo_director');
		$this->db->where('correo_director', $correo);
        $query = $this->db->get('divisiones');
		$datos['longitud'] = $query->num_rows();
		return $datos;
	}

	public function facilitadoresSelCorreo($correo) {
		$this->db->select('correo_facilitador');
		$this->db->where('correo_facilitador', $correo);
        $query = $this->db->get('divisiones');
		$datos['longitud'] = $query->num_rows();
		return $datos;
	}

	public function departamentosSelCorreo($correo) {
		$this->db->select('correo_director');
		$this->db->where('correo_director', $correo);
        $query = $this->db->get('departamentos');
		$datos['longitud'] = $query->num_rows();
		return $datos;
	}

}

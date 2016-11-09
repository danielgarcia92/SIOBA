<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Consultor_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
	}

	public function concentradoDep($departamentoId) {
		$this->db->select('RES.folio AS folio');
		$this->db->select('CUR.nombre AS nombreCurso');
		$this->db->select('PROFE.nombre AS nombreProfesor');
		$this->db->select('OBS.nombre AS nombreObservador');
		$this->db->select('DEP.nombre_departamento AS departamento');
		$this->db->join('periodoactual PER', 'RES.periodo = PER.periodo', 'inner');
		$this->db->join('departamentos DEP', 'RES.id_departamentos = DEP.id', 'inner');
		$this->db->join('profesores PROFE', 'RES.pidm_profesor = PROFE.pidm', 'inner');
		$this->db->join('observadores OBS', 'RES.pidm_observador = OBS.pidm', 'left');
		$this->db->join('cursos CUR', 'RES.crn = CUR.crn AND CUR.periodo = PER.periodo', 'inner');
		$this->db->where('tipo_encuesta', 'O');
		$this->db->where('RES.id_departamentos', $departamentoId);
		$this->db->group_by('RES.folio');
		//$this->db->order_by('PROFE.nombre', 'ASC');
		$query = $this->db->get('resultados RES');
		$datos['longitud'] = $query->num_rows();
		for ($i=0; $i < $datos['longitud']; $i++)
 			$datos['resultados'][$i] = $query->row($i);

 		return $datos;
	}

	public function departamentosDepDir($correo) {
		$this->db->select('id');
		$this->db->select('id_divisiones');
		$this->db->select('nombre_departamento');
		$this->db->where('correo_director', $correo);
        $query1 = $this->db->get('departamentos');
		$datos['longitud'] = $query1->num_rows();
		for ($i = 0; $i < $datos['longitud']; $i++){
			$datos['id'][$i] = $query1->row($i)->id;
			$datos['divisionesId'][$i] = $query1->row($i)->id_divisiones;
			$datos['departamentosNombre'][$i] = $query1->row($i)->nombre_departamento;
		}

		$this->db->select('codigo');
		$this->db->where('id', $datos['divisionesId'][0]);
        $query2 = $this->db->get('divisiones');
		$datos['divisionNombre'] = $query2->row()->codigo;

		return $datos;
	}

	public function departamentosSel($divisionId) {
		$this->db->select('id');
		$this->db->select('nombre_departamento');
		$this->db->where('id_divisiones', $divisionId);
		$query = $this->db->get('departamentos');
		$datos['longitud'] = $query->num_rows();
		for ($i=0; $i < $datos['longitud']; $i++){
			$datos['id'][$i] = $query->row($i)->id;
			$datos['nombre'][$i] = $query->row($i)->nombre_departamento;
		}
		return $datos;
	}

	public function divisionesAdmin() {
		$this->db->select('codigo');
		$query = $this->db->get('divisiones');
		$datos['longitud'] = $query->num_rows();
		for ($i=0; $i < $datos['longitud']; $i++)
			$datos['nombre'][$i] = $query->row($i)->codigo;
		return $datos;
	}

	public function divisionesDivDir($correo) {
		$this->db->select('id');
		$this->db->select('codigo');
		$this->db->where('correo_director', $correo);
        $query = $this->db->get('divisiones');
		$datos['longitud'] = $query->num_rows();
		for ($i = 0; $i < $datos['longitud']; $i++){
			$datos['id'][$i] = $query->row($i)->id;
			$datos['nombre'][$i] = $query->row($i)->codigo;
		}
		return $datos;
	}

	public function divisionesDivFac($correo) {
		$this->db->select('id');
		$this->db->select('codigo');
		$this->db->where('correo_facilitador', $correo);
        $query = $this->db->get('divisiones');
		$datos['longitud'] = $query->num_rows();
		for ($i = 0; $i < $datos['longitud']; $i++){
			$datos['id'][$i] = $query->row($i)->id;
			$datos['nombre'][$i] = $query->row($i)->codigo;
		}
		return $datos;
	}

	/*public function resultadosAmbos($departamentoId) {
		$this->db->select('CUR.clave AS clave');
		$this->db->select('CUR.nombre AS nombreCurso');
		$this->db->select('PROFE.nombre AS nombreProfesor');
		$this->db->select('OBS.nombre AS nombreObservador');
		$this->db->select('(select distinct(EA.folio) from  resultados EA where EA.pidm_profesor = RES.pidm_profesor and EA.tipo_encuesta = "A" and EA.periodo = PER.periodo and EA.id_departamentos = '.$departamentoId.' ) as folioA');
		$this->db->select('(select distinct(EO.folio) from  resultados EO where EO.pidm_profesor = RES.pidm_profesor and EO.tipo_encuesta = "O" and EO.periodo = PER.periodo and EO.id_departamentos = '.$departamentoId.' ) as folioO');
		$this->db->join('periodoactual PER', 'RES.periodo = PER.periodo', 'inner');
		$this->db->join('observadores OBS', 'RES.pidm_observador = OBS.pidm', 'left');
		$this->db->join('profesores PROFE', 'RES.pidm_profesor = PROFE.pidm', 'inner');
		$this->db->join('cursos CUR', 'RES.crn = CUR.crn AND CUR.periodo = PER.periodo', 'inner');
		$this->db->where('(	select distinct(EA.pidm_profesor)
	   		from  resultados EA 
	   		where EA.pidm_profesor = RES.pidm_profesor and EA.tipo_encuesta = "A" and EA.periodo = PER.periodo and EA.id_departamentos = '.$departamentoId.' ) IS NOT NULL
			AND   (select distinct(EO.pidm_profesor)
	   		from  resultados EO 
	   		where EO.pidm_profesor = RES.pidm_profesor and EO.tipo_encuesta = "O" and EO.periodo = PER.periodo and EO.id_departamentos = '.$departamentoId.') IS NOT NULL');
		$this->db->group_by('RES.pidm_profesor');
		//$this->db->order_by('PROFE.nombre', 'ASC');
		$consulta = $this->db->get('resultados RES');
		$datos['longitudResultados'] = $consulta->num_rows();
		for ($i=0; $i < $datos['longitudResultados']; $i++)
 			$datos['resultados'][$i] = $consulta->row($i);

 		return $datos;
	}*/

	public function resultadosAmbos($departamentoId) {
		$this->db->select('CUR.clave AS clave');
		$this->db->select('CUR.nombre AS nombreCurso');
		$this->db->select('PROFE.nombre AS nombreProfesor');
		$this->db->select('OBS.nombre AS nombreObservador');
		$this->db->select('RES.folio AS folioO');
		$this->db->select('RES.pidm_profesor AS pidmProfesor');
		$this->db->join('periodoactual PER', 'RES.periodo = PER.periodo', 'inner');
		$this->db->join('observadores OBS', 'RES.pidm_observador = OBS.pidm', 'left');
		$this->db->join('profesores PROFE', 'RES.pidm_profesor = PROFE.pidm', 'inner');
		$this->db->join('cursos CUR', 'RES.crn = CUR.crn AND CUR.periodo = PER.periodo', 'inner');
		$this->db->where('RES.tipo_encuesta', 'O');
		$this->db->where('RES.id_departamentos', $departamentoId);
		$this->db->group_by('RES.pidm_profesor');

		$consulta1 = $this->db->get('resultados RES');

		$cont = 0;
		$datos['longitudResultados'] = $consulta1->num_rows();
		for ($i=0; $i < $datos['longitudResultados']; $i++){
			$this->db->select('RES.folio AS folioA');
	 		$this->db->join('periodoactual PER', 'RES.periodo = PER.periodo', 'inner');
	 		$this->db->where('RES.tipo_encuesta', 'A');
			$this->db->where('RES.id_departamentos', $departamentoId);
			$this->db->where('RES.pidm_profesor', $consulta1->row($i)->pidmProfesor);
			$this->db->group_by('RES.pidm_profesor');

			$consulta2 = $this->db->get('resultados RES');
			
			if ($consulta2->row() != null) {
				$datos['resultados'][$cont]['clave'] = $consulta1->row($i)->clave;
				$datos['resultados'][$cont]['nombreCurso'] = $consulta1->row($i)->nombreCurso;
				$datos['resultados'][$cont]['nombreProfesor'] = $consulta1->row($i)->nombreProfesor;
				$datos['resultados'][$cont]['nombreObservador'] = $consulta1->row($i)->nombreObservador;
				$datos['resultados'][$cont]['folioA'] = $consulta2->row()->folioA;
				$datos['resultados'][$cont]['folioO'] = $consulta1->row($i)->folioO;
				$cont += 1;
			}

		}

		$datos['longitudResultados'] = $cont;
 		return $datos;
	}

	public function resultadosAut($departamentoId) {
		$this->db->select('RES.folio AS folio');
		$this->db->select('CUR.clave AS clave');
		$this->db->select('CUR.nombre AS nombreCurso');
		$this->db->select('PROFE.nombre AS nombreProfesor');
		$this->db->join('periodoactual PER', 'RES.periodo = PER.periodo', 'inner');
		$this->db->join('profesores PROFE', 'RES.pidm_profesor = PROFE.pidm', 'left');
		$this->db->join('cursos CUR', 'RES.crn = CUR.crn AND CUR.periodo = PER.periodo', 'inner');
		$this->db->where('tipo_encuesta', 'A');
		$this->db->where('RES.periodo = PER.periodo');
		$this->db->where('RES.id_departamentos', $departamentoId);
		$this->db->group_by('RES.folio');
		$this->db->order_by('PROFE.nombre', 'ASC');
		$query = $this->db->get('resultados RES');
		$datos['longitudResultados'] = $query->num_rows();
		for ($i=0; $i < $datos['longitudResultados']; $i++)
 			$datos['resultados'][$i] = $query->row($i);

 		return $datos;
	}

	public function resultadosObs($departamentoId) {
		$this->db->select('RES.folio AS folio');
		$this->db->select('CUR.clave AS clave');
		$this->db->select('CUR.nombre AS nombreCurso');
		$this->db->select('PROFE.nombre AS nombreProfesor');
		$this->db->select('OBS.nombre AS nombreObservador');
		$this->db->join('periodoactual PER', 'RES.periodo = PER.periodo', 'inner');
		$this->db->join('profesores PROFE', 'RES.pidm_profesor = PROFE.pidm', 'inner');
		$this->db->join('observadores OBS', 'RES.pidm_observador = OBS.pidm', 'left');
		$this->db->join('cursos CUR', 'RES.crn = CUR.crn AND CUR.periodo = PER.periodo', 'inner');
		$this->db->where('tipo_encuesta', 'O');
		$this->db->where('RES.periodo = PER.periodo');
		$this->db->where('RES.id_departamentos', $departamentoId);
		$this->db->group_by('RES.folio');
		//$this->db->order_by('OBS.nombre', 'ASC');
		$query = $this->db->get('resultados RES');
		$datos['longitudResultados'] = $query->num_rows();
		for ($i=0; $i < $datos['longitudResultados']; $i++)
 			$datos['resultados'][$i] = $query->row($i);

 		return $datos;
	}

	public function obtenerIdSeccion($folio) {
		$this->db->select('RES.folio AS folio');
		$this->db->select('id_seccion AS seccionId');
		$this->db->select('id_catalogo AS catalogoId');
		$this->db->join('catalogo CAT', 'RES.id_Catalogo = CAT.id', 'inner');
 		$this->db->where('folio', $folio);
 		$this->db->order_by('seccionId', 'ASC');
 		$consulta = $this->db->get('resultados RES');
		$datos['longitud'] = $consulta->num_rows();
		for ($i=0; $i<$datos['longitud']; $i++)
 			$datos['resultados'][$i] = $consulta->row($i);

		return $datos;
	}

	public function obtenerNumDep($divisionId) {
		$this->db->select('DIVI.codigo AS division');
		$this->db->select('DEP.id AS departamentoId');
		$this->db->select('DEP.nombre_departamento AS departamento');
		$this->db->join('periodoactual PER', 'RES.periodo = PER.periodo', 'inner');
		$this->db->join('divisiones DIVI', 'RES.id_divisiones = DIVI.id', 'inner');
		$this->db->join('departamentos DEP', 'RES.id_departamentos = DEP.id', 'inner');
		$this->db->where('tipo_encuesta', 'O');
		$this->db->where('RES.id_divisiones', $divisionId);
		$this->db->group_by('DEP.id');
		$this->db->order_by('DEP.id', 'ASC');
		$query = $this->db->get('resultados RES');
		$datos['longitud'] = $query->num_rows();
		for ($i=0; $i < $datos['longitud']; $i++)
 			$datos['resultados'][$i] = $query->row($i);

 		return $datos;
	}

	public function periodoActual() {
		$query = $this->db->get('periodoactual');
		$listaPeriodos = $query->num_rows();
		for ($i=0; $i < $listaPeriodos; $i++) {
			$datos['periodo'] = $query->row($i)->periodo;
			$datos['descripcion'] = $query->row($i)->descripcion;
		}
		return $datos;
	}

}

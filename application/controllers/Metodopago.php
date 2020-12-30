<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Metodopago extends MY_Controller {
	
	public function __construct(){
		parent::__construct(); 
		$this->load->model('M_Gestores','m_gestores');
	}
	
	public function index()
	{
		$config['css']['style']=array('../../core/libs/dataTables-1.10.20/datatables','../../custom/css/gestores');
		$config['js']['script']=array('../../core/libs/dataTables-1.10.20/datatables','../../core/libs/dataTables-1.10.20/datatables-defaults','gestores','metodopago');
		$config['nav']['menu_active']='25';
		//
		$config['data']['icon']='fa fa-utensils';
		$config['data']['title']='Métodos de pago';
		$config['view']='operacion/metodo_pago/index';
		$config['data']['message']='Desde aqui podras configurar un nuevo comercio para la plataforma turno.';
		
		
		$this->view($config);
    }
    public function getTablaMetodoPago()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$params['tabla'] = 'ms_metodo_pago';

		$condicionesDePago = $this->m_gestores->getDataDeUnaTabla($params)->result_array();

		$result['result'] = 1;
		if (count($condicionesDePago) == 0) {
			$result['data']['html'] = $this->noDataResultado;
		} else {
			$dataParaVista = array();
			$dataParaVista['data'] = $condicionesDePago;
			$result['data']['html'] = $this->load->view("operacion/metodo_pago/tablaMetodoPago", $dataParaVista, true);
		}

		echo json_encode($result);
    }
    
	public function cambiarEstado()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

        $title = 'Activar/Desactivar';
        $est = $post['tipo'];
        // echo $est ;exit();
		$input = array('estado' => $est, 'fechaModificacion' => getActualDateTime());

        if($est == 0){
            $input['estado'] = 0;
        }

        if ($post['menuActivo'] == 'metodopago') {
			$tabla = 'ms_metodo_pago';
			$id = 'id_metodo_pag';
		} 

		$where = array($id => $post['ix']);
		$estado = $this->m_gestores->actualizar($tabla, $input, $where);

		if (!$estado) {
			$result['result'] = 0;
			$result['msg']['title'] = $title;
			$result['msg']['content'] = '<a href="javascript:;"><i class="fa fa-times-circle" ></i></a> No se logró cambiar el estado, inténtelo nuevamente.';
		} else {
			$result['result'] = 1;
			$result['msg']['title'] = $title;
			$result['msg']['content'] = '<a href="javascript:;"><i class="fa fa-check-circle" ></i></a> Información actualizada con éxito.';
		}
		echo json_encode($result);
    }
    
	public function getFormNewMetodoPago()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);

		$dataParaVista = array();

		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view("operacion/metodo_pago/formNewMetodoPago", $dataParaVista, true);
		$result['msg']['title'] = 'Registrar Nuevo Método';

		echo json_encode($result);
	}

	public function registrarMetodoPago()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);
		$nombre = trim($post['nombreMetodoPago']);
		$tabla = 'ms_metodo_pago';

		$whereCheckRepetido = array(
			'nombre' => $nombre
		);
		$existeDoble = $this->m_gestores->verificarRepetido($tabla, $whereCheckRepetido);

		if ($existeDoble) {
			$result['result'] = 0;
			$result['msg']['title'] = 'Registrar Nuevo Método';
			$result['msg']['content'] = 'Ya existe un registro con ese nombre.';
			echo json_encode($result);
			exit();
        }
     
		$input = array(
            'nombre' => $nombre,
		);
		$registro = $this->m_gestores->guardar($tabla, $input);

		if (!$registro) {
			$result['result'] = 0;
			$result['msg']['title'] = 'Registrar Nuevo Método';
			$result['msg']['content'] = 'Hubo un error en el registro, inténtelo nuevamente.';
		} else {
			$result['result'] = 1;
			$result['msg']['title'] = 'Registrar Nuevo Método';
			$result['msg']['content'] = 'Se ingresó el registro exitosamente.';
		}

		echo json_encode($result);
	}

	public function getFormUpdateMetodoPago()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);
		$id = $post['id'];

		$params['tabla'] = 'ms_metodo_pago';
		$params['where']['id_metodo_pag'] = $id;
		$canal = $this->m_gestores->getDataDeUnaTabla($params)->row_array();

		$dataParaVista['data'] = $canal;
		
		$result['result'] = 1;
		$result['data']['width'] = '45%';
		$result['data']['html'] = $this->load->view("operacion/metodo_pago/formUpdateMetodoPago", $dataParaVista, true);
		$result['msg']['title'] = 'Actualizar Método';

		echo json_encode($result);
	}

	public function actualizarMetodoPago()
	{
		$result = $this->result;
		$post = json_decode($this->input->post('data'), true);
		$nombre = trim($post['nombreMetodoPago']);
		$id = $post['idMetodoPago'];
		$tabla = 'ms_metodo_pago';

		$whereCheckRepetido = array('nombre' => $nombre, 'id_metodo_pag !=' => $id);
		$existeDoble = $this->m_gestores->verificarRepetido($tabla, $whereCheckRepetido);

		if ($existeDoble) {
			$result['result'] = 0;
			$result['msg']['title'] = 'Actualizar Método';
			$result['msg']['content'] = 'Ya existe un registro con ese nombre.';
			echo json_encode($result);
			exit();
		}

		$insert = array(
			'nombre' => $nombre,
			'fechaModificacion' => getActualDateTime()
		);

		$where = array('id_metodo_pag =' => $id);
		$update = $this->m_gestores->actualizar($tabla, $insert, $where);

		if (!$update) {
			$result['result'] = 0;
			$result['msg']['title'] = 'Actualizar Método';
			$result['msg']['content'] = 'Hubo un error en la actualización, inténtelo nuevamente.';
		} else {
			$result['result'] = 1;
			$result['msg']['title'] = 'Actualizar Método';
			$result['msg']['content'] = 'Se actualizó exitosamente.';
		}

		echo json_encode($result);
	}

}

?>
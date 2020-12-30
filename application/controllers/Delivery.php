<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Delivery extends MY_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('M_Delivery','model');
	}
	
	public function index()
	{
		$config['css']['style']=array('../../core/libs/dataTables-1.10.20/datatables');
		$config['js']['script']=array('../../core/libs/dataTables-1.10.20/datatables','../../core/libs/dataTables-1.10.20/datatables-defaults','delivery');
		$config['nav']['menu_active']='10';
		//
		$config['data']['icon']='fa fa-motorcycle';
		$config['data']['title']='Central de Pedidos';
		$config['view']='operacion/mis_pedidos';
		$config['data']['message']='Desde aquí podras acceder a los pedidos realizados a tu comercio y que esten pendientes de despachar.';
		
		$this->view($config);
	}
	
	public function liquidacion()
	{
		$config['css']['style']=array('../../core/libs/dataTables-1.10.20/datatables');
		$config['js']['script']=array('../../core/libs/dataTables-1.10.20/datatables','../../core/libs/dataTables-1.10.20/datatables-defaults','delivery');
		$config['nav']['menu_active']='22';
		//
		$rs = $this->model->find_comercios()->result_array();
		foreach($rs as $row){
			$config['data']['comercios'][$row['id_comercio']] = $row;
			$config['data']['pdv'][$row['id_comercio']][$row['id_pdv']] = $row;
		}
		//
		$config['data']['icon']='fa fa-motorcycle';
		$config['data']['title']='Liquidación de Delivery';
		$config['view']='reportes/liquidacion_delivery';
		
		$config['data']['message']='Reporte de liquidación de delivery, aqui se muestra en resumen y detalle la información de delivery registrados.';
		//$config['data']['tota_pedidos']=count($pedidos);
		$this->view($config);
	}
	
	public function rpt_liquidacion(){
		$data=json_decode($this->input->post('data'));
		//
		//print_r($data);
		$result = $this->result;
		$result['status'] = 0;
		//
		$array = array();
		$fechas_arr = explode(" - ", $data->fechas);
		$this->model->asignar_fechas($fechas_arr[0], $fechas_arr[1]);
		//
		$filtros = '';
		if(!empty($data->id_comercio)) $filtros .= "  AND pv.id_comercio = ".$data->id_comercio;
		if(!empty($data->id_pdv)) $filtros .= "  AND pv.id_pdv = ".$data->id_pdv;
		//
		$rs = $this->model->find_delivery($filtros)->result_array();
		$deliverys=array();
		//
		$rs_detalle = $this->model->find_delivery_detalle($filtros)->result_array();
		$rs_etapas = $this->model->find_delivery_etapas($filtros)->result_array();
		//
		$pedidos = array(); $pedidos_detalle = array(); $pedidos_etapas = array();
		//
		foreach($rs as $row){
			$pedidos[$row['id_pedido']] = $row;
		}
		
		foreach($rs_detalle as $row){
			$pedidos_detalle[$row['id_pedido']] = $row;
		}
		
		foreach($rs_etapas as $row){
			$pedidos_etapas[$row['id_pedido']][$row['idPedidoEtapa']] = $row;
		}
		
		/*
		foreach($rs as $row){
			$pedidos[$row['id_pedido']]['etapas'][$row['id_pedido_etapa']]=$row['tiempo'];
		}
		*/
		//
		$result['result']=1;
		if( count($pedidos)==0 ) {
			$result['data']['html2']= '<p class="p-info"><i class="fa fa-info-circle"></i> No se obtuvieron resultados.</p>';
			//$result['data']['html1']= '';
		} else {
			// $array = array(
			// 	'total_pedidos' => count($pedidos)
			// 	, 'total_pedidos_auto' => count($pedidos_auto)
			// 	, 'total_pedidos_user' => count($pedidos_user)
			// 	, 'pedidos_confirmados' => count($pedidos_conf)
			// );
			// $result['data']['html1']=$this->load->view("reportes/liquidacion_delivery/boxes",$array,true);
			$result['data']['html1']='';
			$array = array(
				'pedidos' => $pedidos
				, 'detalle' => $pedidos_detalle
				, 'etapas' => $pedidos_etapas
			);
			$result['data']['html2']= $this->load->view("reportes/liquidacion_delivery/table",$array,true);
		}
		echo json_encode($result);
	}
	
	public function table_liquidacion(){
		$data=json_decode($this->input->post('data'));
		//
		//print_r($data);
		$result = $this->result;
		$result['status'] = 0;
		//
		$array = array();
		$fechas_arr = explode(" - ", $data->fechas);
		$this->model->asignar_fechas($fechas_arr[0], $fechas_arr[1]);
		//
		$filtros = '';
		if(!empty($data->id_comercio)) $filtros .= "  AND pv.id_comercio = ".$data->id_comercio;
		if(!empty($data->id_pdv)) $filtros .= "  AND pv.id_pdv = ".$data->id_pdv;
		if(!empty($data->auto)) $filtros .= "  AND p.flagAuto = ".(($data->auto == 'no')? 0 : 1 );
		if(!empty($data->etapa)) $filtros .= "  AND p.id_pedido_etapa = ".$data->etapa;
		//
		$rs = $this->model->find_pedidos($filtros)->result_array();
		//
		$pedidos = array(); $pedidos_auto = array(); $pedidos_user = array(); $pedidos_conf = array();
		//
		foreach($rs as $row){
			$pedidos[$row['id_pedido']] = $row;
			if($row['flagAuto']==0){
				$pedidos_user[$row['id_pedido']] = $row;
			} else {
				$pedidos_auto[$row['id_pedido']] = $row;
			}
			//
			if($row['id_pedido_etapa'] > 1){
				$pedidos_conf[$row['id_pedido']] = $row;
			}
		}
		//
		$result['result']=1;
		if( count($pedidos)==0 ) {
			//$result['data']['html1']= '<p class="p-info"><i class="fa fa-info-circle"></i> No se obtuvieron resultados.</p>';
			$result['data']['html2']= '<p class="p-info"><i class="fa fa-info-circle"></i> No se obtuvieron resultados.</p>';
		} else {
			/*$array = array(
				'total_pedidos' => count($pedidos)
				, 'total_pedidos_auto' => count($pedidos_auto)
				, 'total_pedidos_user' => count($pedidos_user)
				, 'pedidos_confirmados' => count($pedidos_conf)
			);
			$result['data']['html1']=$this->load->view("reportes/liquidacion/boxes",$array,true);
			*/
			$array = array(
				'pedidos' => $pedidos
			);
			$result['data']['html2']= $this->load->view("reportes/liquidacion_delivery/table",$array,true);
		}
		echo json_encode($result);
	}
	
	public function nuevo(){
		$data=json_decode($this->input->post('data'));
		//
		$array = array(
			'tipo_doc' => $this->m_ticket->get_tipo_doc()->result_array()
			, 'id_comercio' => (!empty($this->session->userdata('id_comercio'))? $this->session->userdata('id_comercio') : 1)
			, 'id_pdv' => (!empty($this->session->userdata('id_pdv'))? $this->session->userdata('id_pdv') : 7)
		);
		//
		$result = $this->result;
		$result['status'] = 1;
		$result['data']['html']=$this->load->view("operacion/nuevo_pedido",$array,true);
		echo json_encode($result);
	}
	 
}

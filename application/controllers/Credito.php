<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Credito extends MY_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('M_Credito','model');
	}
	
	public function index()
	{
		$config['css']['style']=array('../../core/libs/dataTables-1.10.20/datatables');
		$config['js']['script']=array('../../core/libs/dataTables-1.10.20/datatables','../../core/libs/dataTables-1.10.20/datatables-defaults','credito');
		$config['nav']['menu_active']='10';
		//
		$config['data']['icon']='fa fa-id-card';
		$config['data']['title']='Central de Pedidos';
		$config['view']='operacion/mis_pedidos';
		$config['data']['message']='Desde aquí podras acceder a los pedidos realizados a tu comercio y que esten pendientes de despachar.';
		
		$this->view($config);
	}
	
	public function liquidacion()
	{
		$config['css']['style']=array('../../core/libs/dataTables-1.10.20/datatables');
		$config['js']['script']=array('../../core/libs/dataTables-1.10.20/datatables','../../core/libs/dataTables-1.10.20/datatables-defaults','credito');
		$config['nav']['menu_active']='23';
		//
		$rs = $this->model->find_comercios()->result_array();
		foreach($rs as $row){
			$config['data']['comercios'][$row['id_comercio']] = $row;
			$config['data']['pdv'][$row['id_comercio']][$row['id_pdv']] = $row;
		}
		//
		$config['data']['icon']='fa fa-id-card';
		$config['data']['title']='Liquidación de Creditos';
		$config['view']='reportes/liquidacion_credito';
		
		$config['data']['message']='Reporte de liquidación de creditos, aqui se muestra en resumen y detalle la información de creditos registrados.';
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
		$rs = $this->model->find_credito($filtros)->result_array();
		//
		$pedidos = array(); $pedidos_auto = array(); $pedidos_user = array(); $pedidos_conf = array();
		//
		$gastos = array(); $gastos_comercio = array(); $consumos = array();
		
		foreach($rs as $row){
			$pedidos[$row['id_comercio']] = $row;
			$consumos[$row['id_comercio']][$row['id_pdv']] = $row;
			$gastos[$row['id_comercio']][$row['id_pdv']][$row['id_pedido']] = $row;
			$gastos_comercio[$row['id_comercio']][$row['id_pedido']] = $row;
		}
		
		$pedidos_recarga = array();
		foreach($pedidos as $row){
			$pedidos_recarga[$row['id_comercio']]['creditos'] = $this->model->get_comercio_credito($row['id_comercio'])->result_array();
		}
		
		//print_r($pedidos);
		//
		$result['result']=1;
		if( count($pedidos)==0 ) {
			$result['data']['html1']= '';
			$result['data']['html2']= '<p class="p-info"><i class="fa fa-info-circle"></i> No se obtuvieron resultados.</p>';
		} else {

					// 	'total_pedidos' => count($pedidos)
			// 	, 'total_pedidos_auto' => count($pedidos_auto)
			// 	, 'total_pedidos_user' => count($pedidos_user)
			// 	, 'pedidos_confirmados' => count($pedidos_conf)
			/*if($data->id_comercio!=""){
				$array = array(
					'comercio' =>$this->model->get_comercio($data->id_comercio)->row_array(),
					'fecIni' => $fechas_arr[0],
					'fecFin' => $fechas_arr[1],
					'creditos' =>$this->model->get_comercio_credito($data->id_comercio)->row_array(),
				 );
				$result['data']['html1']=$this->load->view("reportes/liquidacion_credito/boxes",$array,true);
			}else{
				$result['data']['html1']='';
			}*/
			$array = array(
				'pedidos' => $pedidos
				,'gastos' => $gastos
				, 'gastos_comercio' => $gastos_comercio
				, 'consumos' => $consumos
				, 'pedidos_recarga' => $pedidos_recarga
			);
			$result['data']['html2']= $this->load->view("reportes/liquidacion_credito/table",$array,true);
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
		$rs = $this->model->find_credito($filtros)->result_array();
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
			$result['data']['html2']= $this->load->view("reportes/liquidacion_credito/table",$array,true);
		}
		echo json_encode($result);
	}
	
}

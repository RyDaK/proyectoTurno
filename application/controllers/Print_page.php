<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Print_page extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('M_Print','model');
		$this->load->model('M_PedidoOP','m_pedidos');
	}
	
	public function print_delivery(){
		$data=json_decode($this->input->post('data'));
		$input=array();
		$input['id']=$data->id;
		$rs = $this->model->get_data($input['id'])->result_array();
		$view=array();
		foreach($rs as $row){
			$view['idPedido'] = $row['idPedidoCliente'];
			$view['etapas'][$row['idPedidoEtapa']] = $row;
		}
		/*
		$input['id']=$data->id;
		$formato=$data->formato;
		$result=array();
			$result['result']=1;
			$result['url']='';
			$result['data']='';
			$result['msg']['title']='Imprimir';
			$result['msg']['content']='';
				
		*/
		
		$result['data']=$this->load->view('formatos/delivery_ticket',$view,true);
		echo json_encode($result);
	}

	public function print_delivery_produccion(){
		$data=json_decode($this->input->post('data'));
		$input=array();
		$input['id']=$data->id;
		$rs = $this->model->get_data($input['id'])->result_array();
		$view=array();
		$params = array(
			'id_estado_ped' =>2,
			'idPedidoCliente' => $data->id,
		);
		$view['data'] = $this->m_pedidos->find_pedidos_por_confirmarByid($params)->result();
		foreach($rs as $row){
			$view['idPedido'] = $row['idPedidoCliente'];
			$view['etapas'][$row['idPedidoEtapa']] = $row;
		}
		
		$result['data']=$this->load->view('formatos/delivery_ticket_produccion',$view,true);
		echo json_encode($result);
	}

	public function print_delivery_despacho(){
		$data=json_decode($this->input->post('data'));
		$input=array();
		$input['id']=$data->id;
		$rs = $this->model->get_data($input['id'])->result_array();
		$view=array();
		$params = array(
			'id_estado_ped' =>3,
			'idPedidoCliente' => $data->id,
		);
		$view['data'] = $this->m_pedidos->find_pedidos_por_confirmarByid($params)->result();
		foreach($rs as $row){
			$view['idPedido'] = $row['idPedidoCliente'];
			$view['etapas'][$row['idPedidoEtapa']] = $row;
		}
		
		$result['data']=$this->load->view('formatos/delivery_ticket_despacho',$view,true);
		echo json_encode($result);
	}



}

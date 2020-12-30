<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ticket extends MY_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('M_Ticket','model');
	}
	
	public function registrar(){
		$result = $this->result;
		$result['status'] = 0;
		$data=json_decode($this->input->post('data'));
		//
		$status = 0;
		$id_cliente = ''; $filtros = "";
		if(!empty($data->{'tipo_doc'}) && !empty($data->{'numero_doc'})) { 
			$filtros .= " AND c.id_doc_tipo = ".$data->{'tipo_doc'}." AND c.nro_documento = '".$data->{'numero_doc'}."'";
			$rs = $this->model->find_cliente($filtros)->row_array();
			//
			
			if(count($rs) > 0 ){
				$id_cliente = $rs['id_cliente'];
				//
				$filtros = "";
				$filtros .= " AND ct.id_telefono_tipo = 2 AND ct.id_cliente = ".$id_cliente." AND ct.numero = '".$data->{'telefono'}."'";
				$rs_tel = $this->model->find_cliente_telefono($filtros)->row_array();
				if(empty($rs_tel)){
					$params =  array(
					 'numero' => $data->{'telefono'}
					 , 'id_telefono_tipo' => 2
					 , 'id_cliente' => $id_cliente
					);
					$estado = $this->model->set_cliente_telefono($params);
					if(!$estado){
						$status = 1;
					}
				}
			} else {
				$params =  array(
				 'nombres' => $data->{'nombre'}
				 , 'ape_paterno' => $data->{'apePaterno'}
				 , 'ape_materno' => $data->{'apeMaterno'}
				 , 'nro_documento' => $data->{'numero_doc'}
				 , 'id_pdv' => $data->{'pdv'}
				 , 'id_proyecto' => 1
				 , 'id_doc_tipo' => $data->{'tipo_doc'}
				);
				$estado = $this->model->set_cliente($params);
				if($estado){
					$id_cliente = $this->mysql_last_id();
					$params =  array(
					 'numero' => $data->{'nombre'}
					 , 'id_telefono_tipo' => 2
					 , 'id_cliente' => $id_cliente
					);
					$estado = $this->model->set_cliente_telefono($params);
					if(!$estado){
						$status = 1;
					}
				}
			}
		} else {
			$params =  array(
			 'nombres' => $data->{'nombre'}
			 , 'ape_paterno' => $data->{'apePaterno'}
			 , 'ape_materno' => $data->{'apeMaterno'}
			 , 'nro_documento' => $data->{'numero_doc'}
			 , 'id_pdv' => $data->{'pdv'}
			 , 'id_proyecto' => 1
			 , 'id_doc_tipo' => $data->{'tipo_doc'}
			);
			$estado = $this->model->set_cliente($params);
			if($estado){
				$id_cliente = $this->mysql_last_id();
				$params =  array(
				 'numero' => $data->{'telefono'}
				 , 'id_telefono_tipo' => 2
				 , 'id_cliente' => $id_cliente
				);
				$estado = $this->model->set_cliente_telefono($params);
				if(!$estado){
					$status = 1;
				}
			}
		}
		if(!empty($id_cliente) && $status == 0){
			/*
			id_pedido, tiempo_registro, ticket, estado, id_pdv, id_usuario, id_proyecto, id_cliente, id_cupon, tiempo_entrega, id_pedido_etapa
			*/
			$params = array(
				'ticket' => $data->{'ticket'},
				'id_pdv' => $data->{'pdv'},
				'id_proyecto' => 1,
				'id_cliente' => $id_cliente,
				'tiempo_registro' => $this->input->post('datetime'),
				'id_pedido_etapa' => 1,
				'numero' => $data->{'telefono'},
				'id_telefono_tipo' => 2
			);
			$id_user = $this->session->userdata('id_usuario');
			if(isset($id_user)){
				if(!empty($id_user)){
					$params['id_usuario'] = $id_user;
					$params['flagAuto'] = 0;
				}
			}
			$estado = $this->model->set_pedido($params);
			if($estado){
				$id_pedido = $this->mysql_last_id();
				//
					$params = array(
					'id_pedido' => $id_pedido,
					'tiempo' => $this->input->post('datetime'),
					'id_pedido_etapa' => 1
				);
				$estado = $this->model->set_pedido_hist($params);
				if($estado){
					//
					$result['status'] = 1;
					$config = array( 'type' => 1, 'message' => 'Tu Turno se ha registrado correctamente. Te avisaremos a tu celular cuando tu pedido esté listo' );
					$result['msg']['content'] = createMessage($config);
				} else {
					$result['data'] = 0;
					$config = array( 'type' => 2, 'message' => 'No se logro registrar el pedido, intentelo nuevamente' );
					$result['msg']['content'] = createMessage($config);
				}
				
			} else {
				$result['data'] = 0;
				$config = array( 'type' => 2, 'message' => 'No se logro registrar el pedido, intentelo nuevamente' );
				$result['msg']['content'] = createMessage($config);
			}
			//
		} else {
			$result['data'] = 0;
			$config = array( 'type' => 2, 'message' => 'No se logro registrar el pedido, intentelo nuevamente' );
			$result['msg']['content'] = createMessage($config);
		}
		echo json_encode($result);
	}
	
	public function go($value=''){
		//
		$filtros = "";
		if(!empty($value)) $filtros .= " AND pv.ruta = '".$value."'";
		if(!empty($value)){
			$rs = $this->model->get_pdv($filtros)->row_array();
			if(!empty($rs)){
				$config['js']['script']=array('ticket');
				$config['css']['style']=array();
				$config['single'] = true;
				//
				$rs_tipo_doc = $this->model->get_tipo_doc()->result_array();
				//
				$config['data'] = array(
					'id_comercio' => $rs['id_comercio']
					, 'comercio' => $rs['comercio']
					, 'id_pdv' => $rs['id_pdv']
					, 'pdv' => $rs['pdv']
					, 'cc' => $rs['cc']
					, 'departamento' => $rs['departamento']
					, 'provincia' => $rs['provincia']
					, 'distrito' => $rs['distrito']
					, 'direccion' => $rs['direccion']
					, 'tipo_doc' => $rs_tipo_doc					, 'ruta_logo' => $rs['ruta_logo']
				);
				//
				$this->view($config);
			}else {
				$this->fn_404();
			}
		}else {
			$this->fn_404();
		}
	}
}

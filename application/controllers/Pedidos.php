<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pedidos extends MY_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('M_Pedido','model');
		$this->load->model('M_Ticket','m_ticket');
	}
	
	public function index()
	{
		$config['css']['style']=array('../../core/libs/dataTables-1.10.20/datatables');
		$config['js']['script']=array('../../core/libs/dataTables-1.10.20/datatables','../../core/libs/dataTables-1.10.20/datatables-defaults','pedidos');
		$config['nav']['menu_active']='10';
		//
		$config['data']['icon']='pe-7s-rocket';
		$config['data']['title']='Central de Pedidos';
		$config['view']='operacion/mis_pedidos';
		$config['data']['message']='Desde aquí podras acceder a los pedidos realizados a tu comercio y que esten pendientes de despachar.';
		
		$this->view($config);
	}
	
	public function liquidacion()
	{
		$config['css']['style']=array('../../core/libs/dataTables-1.10.20/datatables');
		$config['js']['script']=array('../../core/libs/dataTables-1.10.20/datatables','../../core/libs/dataTables-1.10.20/datatables-defaults','pedidos');
		$config['nav']['menu_active']='12';
		//
		$rs = $this->model->find_comercios()->result_array();
		foreach($rs as $row){
			$config['data']['comercios'][$row['id_comercio']] = $row;
			$config['data']['pdv'][$row['id_comercio']][$row['id_pdv']] = $row;
		}
		//
		$config['data']['icon']='pe-7s-piggy';
		$config['data']['title']='Liquidación de Pedidos';
		$config['view']='reportes/liquidacion_pedidos';
		
		$config['data']['message']='Reporte de liquidación de pedidos, aqui se muestra en resumen y detalle la información de pedidos registrados.';
		//$config['data']['tota_pedidos']=count($pedidos);
		$this->view($config);
	}


	public function editar(){
		$result = $this->result;
		$result['status'] = 0;
		$data=json_decode($this->input->post('data'));
		//
		$status = 0;
		$id_cliente = ''; $filtros = "";
		if(!empty($data->{'tipo_doc'}) && !empty($data->{'numero_doc'})) { 
			$filtros .= " AND c.id_doc_tipo = ".$data->{'tipo_doc'}." AND c.nro_documento = '".$data->{'numero_doc'}."'";
			$rs = $this->m_ticket->find_cliente($filtros)->row_array();
			//
			
			if(count($rs) > 0 ){
				$id_cliente = $rs['id_cliente'];
				//
				$filtros = "";
				$filtros .= " AND ct.id_telefono_tipo = 2 AND ct.id_cliente = ".$id_cliente." AND ct.numero = '".$data->{'telefono'}."'";
				$rs_tel = $this->m_ticket->find_cliente_telefono($filtros)->row_array();
				if(empty($rs_tel)){
					$params =  array(
					 'numero' => $data->{'telefono'}
					 , 'id_telefono_tipo' => 2
					 , 'id_cliente' => $id_cliente
					);
					$estado = $this->m_ticket->set_cliente_telefono($params);
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
				$estado = $this->m_ticket->set_cliente($params);
				if($estado){
					$id_cliente = $this->mysql_last_id();
					$params =  array(
					 'numero' => $data->{'nombre'}
					 , 'id_telefono_tipo' => 2
					 , 'id_cliente' => $id_cliente
					);
					$estado = $this->m_ticket->set_cliente_telefono($params);
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
			$estado = $this->m_ticket->set_cliente($params);
			if($estado){
				$id_cliente = $this->mysql_last_id();
				$params =  array(
				 'numero' => $data->{'telefono'}
				 , 'id_telefono_tipo' => 2
				 , 'id_cliente' => $id_cliente
				);
				$estado = $this->m_ticket->set_cliente_telefono($params);
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
				'id_pedido_etapa' => 1,
				'numero' => $data->{'telefono'},
				'id_telefono_tipo' => 2
			);
			$id_user = $this->session->userdata('id_usuario');
			if(isset($id_user)){
				if(!empty($id_user)){
					$params['id_usuario'] = $id_user;
				}
			}
			$where = array('id_pedido'=>$data->{'id_pedido'});
			$estado = $this->model->update_pedido($params,$where);
			if($estado){
				//
				$result['status'] = 1;
				$config = array( 'type' => 1, 'message' => 'Pedido editado correctamente' );
				$result['msg']['content'] = createMessage($config);
			} else {
				$result['data'] = 0;
				$config = array( 'type' => 2, 'message' => 'No se logro editar el pedido, intentelo nuevamente' );
				$result['msg']['content'] = createMessage($config);
			}
			//
		} else {
			$result['data'] = 0;
			$config = array( 'type' => 2, 'message' => 'No se logro editar el pedido, intentelo nuevamente' );
			$result['msg']['content'] = createMessage($config);
		}
		echo json_encode($result);
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
			$result['data']['html1']= '<p class="p-info"><i class="fa fa-info-circle"></i> No se obtuvieron resultados.</p>';
			$result['data']['html2']= '';
		} else {
			$array = array(
				'total_pedidos' => count($pedidos)
				, 'total_pedidos_auto' => count($pedidos_auto)
				, 'total_pedidos_user' => count($pedidos_user)
				, 'pedidos_confirmados' => count($pedidos_conf)
			);
			$result['data']['html1']=$this->load->view("reportes/liquidacion/boxes",$array,true);
			$array = array(
				'pedidos' => $pedidos
			);
			$result['data']['html2']= $this->load->view("reportes/liquidacion/table",$array,true);
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
			$result['data']['html2']= $this->load->view("reportes/liquidacion/table",$array,true);
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
	
	public function edit_pedido(){
		$data=json_decode($this->input->post('data'));
		//
		$array = array(
			'tipo_doc' => $this->m_ticket->get_tipo_doc()->result_array()
			, 'data' => $data->value
			, 'id' => $data->id
		);
		//
		$result = $this->result;
		$result['status'] = 1;
		$result['data']['html']=$this->load->view("operacion/edit_pedido",$array,true);
		echo json_encode($result);
	}
	
	public function pendientes(){
		$data=json_decode($this->input->post('data'));
		//
		$result = $this->result;
		$result['status'] = 0;
		//
		$array = array();
		$array['data'] = $this->model->find_pendientes('')->result_array();
		//
		$result['result']=1;
		if( count($array['data'])==0 ) {
			$result['data']['html']= '<p class="p-info"><i class="fa fa-info-circle"></i> No se obtuvieron resultados.</p>';
			$result['data']['rows'] = 0;
		} else {
			$result['data']['html']=$this->load->view("operacion/pedidos_pendientes",$array,true);
			$result['data']['rows'] = count($array['data']);
		}
		echo json_encode($result);
	}
	
	public function avisar(){
		$data=json_decode($this->input->post('data'));
		//
		$result = $this->result;
		$result['status'] = 0;
		//
		$envios = array();
		$noenvios = array();
		$str_pedidos = implode(",",$data->pedidos);
		//
		$rs = $this->model->get_configuracion_alerta($str_pedidos)->result_array();
		if(count($rs)>0){
			$mensajes = array(); 
			foreach($rs as $row){ $mensajes[$row['id_pedido']] = $row; }
			foreach($data->pedidos as $row){
				if(isset($mensajes[$row])){
					if(!empty($mensajes[$row]['numero'])){
						$envio = enviar_sms($mensajes[$row]['titulo'],$mensajes[$row]['contenido'],$mensajes[$row]['telefono']);
						//$envio = true;
						if(!$envio){
							array_push($noenvios,"El ticket ".$mensajes[$row]['ticket']." no se logro enviar el mensaje de texto intentelo nuevamente.");
						} else {
							array_push($envios,"El ticket ".$mensajes[$row]['ticket']." se envio correctamente.");
							//
							$params = array(
								'id_pedido_etapa' => 2
								, 'tiempo_entrega' => $this->input->post('datetime')
								, 'id_usuario' => $this->session->userdata('id_usuario')
							);
							$where = array('id_pedido'=>$row);
							$estado = $this->model->update_pedido($params,$where);
							//echo $this->db->last_query();
							if($estado){
								//
								$params = array(
									'id_pedido' => $row,
									'tiempo' => $this->input->post('datetime'),
									'id_pedido_etapa' => 2
								);
								$estado = $this->model->set_pedido_hist($params);
								//
							}
						}
					} else {
						array_push($noenvios,"El ticket ".$mensajes[$row]['ticket']." no fue enviado, no tenia un número de teléfono valido.");
					}
				} else {
					array_push($noenvios,"El ticket ".$row." no fue enviado ya que no tiene una configuracion valida.");
				}
			}
			if(count($noenvios) == 0 ){
				$result['status'] = 1;
				$config_ = array( 'type' => 1, 'message' => 'Envio completado con exíto');
				$result['data']['html']= createMessage($config_);
			} else {
				$mensaje_x = '';
				$result['status'] = 1;
				foreach($envios as $row){
					$mensaje_x .= '<div class="alert alert-success" >'.$row.'</div>';
				}
				foreach($noenvios as $row){
					$mensaje_x .= '<div class="alert alert-danger" >'.$row.'</div>';
				}
				$result['data']['html']= $mensaje_x;
			}
		} else {
			$result['result']=1;
			$config_ = array( 'type' => 2, 'message' => 'No se logro enviar ningun mensaje, intentelo nuevamente');
			$result['data']['html']= createMessage($config_);
		}
		echo json_encode($result);
	}
	
	public function pendientes_online(){
		$data=json_decode($this->input->post('data'));
		//
		$result = $this->result;
		$result['status'] = 0;
		//
		$array = array();
		$array['data'] = $this->model->find_pendientes('')->result_array();
		//
		$result['result']=1;
		if( count($array['data'])==0 ) {
			$result['data']['rows'] = 0;
		} else {
			$result['data']['rows'] = count($array['data']);
		}
		echo json_encode($result);
	}
	
}

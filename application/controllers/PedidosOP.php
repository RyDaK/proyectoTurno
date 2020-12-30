<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class PedidosOP extends MY_Controller {

	

	public function __construct(){

		parent::__construct();

		$this->load->model('M_PedidoOP','model');

		$this->load->model('M_Ticket','m_ticket');

		$this->load->model('M_Login_cliente','m_login_cliente');

        $this->load->helper('My_helper');

    }

	

	public function index()

	{

		$config['css']['style']=array('../../core/libs/dataTables-1.10.20/datatables');

		$config['js']['script']=array('../../core/libs/dataTables-1.10.20/datatables','../../core/libs/dataTables-1.10.20/datatables-defaults','pedidosOP');

		$config['nav']['menu_active']='24';

		//

		$config['data']['icon']='fa fa-home';

		$config['data']['title']='Central de Pedidos';

		$config['view']='operacion/mis_pedidos_op';

		$config['data']['message']='Desde aquí podras acceder a los pedidos realizados a tu comercio y que esten pendientes de despachar.';

		

		$this->view($config);

    }

	public function buscar_usuario(){

		$data=json_decode($this->input->post('data'));

		//

		$result = $this->result;

		$result['status'] = 0;

		//

		if($data->dni == ''){

			$result['result']=0;

			$config_ = array('type' => 2, 'message' => 'Debe ingresar un DNI');

			$result['data']['msg'] = createMessage($config_);

			echo json_encode($result);

			exit();

		}

		$array = array();

		$rs = $this->db->get_where('mc_usuario_cliente',array('nro_documento'=>$data->dni))->row_array(); 

		

		if(count($rs) < 1){

			$result['result']=0;

			$config_ = array('type' => 2, 'message' => 'No se encontró ningún usuario con el Documento: <b>'.$data->dni.'</b>');

			$result['data']['msg'] = createMessage($config_);

			

			echo json_encode($result);

			exit();

			

		}

		$result['result']=1;

		$result['data']['nombre'] = $rs['nombres']; 

		$result['data']['apepat'] = $rs['ape_paterno']; 

		$result['data']['apemat'] = $rs['ape_materno']; 

		$result['data']['email'] = $rs['email']; 

		$result['data']['telefono'] = $rs['telefono']; 





		$config_ = array( 'type' => 1, 'message' => "Se cargaron los datos del usuario: <b>".$rs['nombres']." ".$rs['ape_paterno']." ".$rs['ape_materno']."</b> correctamente");

		$result['data']['msg'] = createMessage($config_);

        

		echo json_encode($result);

	}

	public function cambiar_clave_operario(){

		$data=json_decode($this->input->post('data'));



		$arr_update = array(

			'clave' => $data->nuevaClave,

		);

		$cod_usuario = $this->session->userdata('id_usuario');

		if(!$cod_usuario){

			$config_ = createMessage(array('type'=>2,"message"=>"Debe volver a Iniciar Sesion para cambiar la clave"));

			$result['result'] = 0;

			$result['data']['message'] = $config_; 

			echo json_encode($result);

			exit();

		}	

		$rs = $this->db->update('ms_usuario',$arr_update,array('id_usuario' => $cod_usuario));



		if(!$rs){

			$config_ = createMessage(array('type'=>2,"message"=>"No se pudo cambiar la clave"));

			$result['data']['message'] = $config_; 

			$result['result'] = 0;

			echo json_encode($result);

			exit();



		}else{

			$config_ = createMessage(array('type'=>1,"message"=>"Clave actualizada con éxito"));

			$result['data']['message'] = $config_; 

			$result['result'] = 1;

		}

		echo json_encode($result);



	}



    public function pendientes(){

		$data=json_decode($this->input->post('data'));

		//

		$result = $this->result;

		$result['status'] = 0;

        //

		$array = array();

		$array['data'] = $this->model->find_pedidos_por_confirmar()->result_array();

		//

		$result['result']=1;

		if( count($array['data'])==0 ) {

			$result['data']['html']= '<p class="p-info"><i class="fa fa-info-circle"></i> No se obtuvieron resultados.</p>';

			$result['data']['rows'] = 0;

		} else {

			$result['data']['html']=$this->load->view("operacion/pedidos_pendientes_op",$array,true);

			$result['data']['rows'] = count($array['data']);

        }

			$result['data']['html']=$this->load->view("operacion/pedidos_pendientes_op",$array,true);

        

		echo json_encode($result);

	}

	public function pedidos_proceso(){

		$data=json_decode($this->input->post('data'));



		// if(!isset($data->value)){$data->value = $data->value_;}

		if($data->value == 2){

			$params['id_estado_ped'] = $data->value;

			$array['data'] = $this->model->find_pedidos_confirmado($params)->result_array();

		}else if ($data->value  = 3){

			$params['id_estado_ped'] = $data->value;

			$array['data'] = $this->model->find_pedidos_confirmado($params)->result_array();

		}else if ($data->value = 4){

			$params['id_estado_ped'] = $data->value;

			$array['data'] = $this->model->find_pedidos_confirmado($params)->result_array();

		}else{

			$array['data'] = '';

		}



		$result['result']=1;



		if( count($array['data'])==0 ) {

			$result['data']['html']= '<p class="p-info"><i class="fa fa-info-circle"></i> No se obtuvieron resultados.</p>';

			$result['data']['rows'] = 0;

		} else {

			$result['data']['html']=$this->load->view("operacion/pedidos_pendientes_op",$array,true);

			$result['data']['rows'] = count($array['data']);

        }

			$result['data']['html']=$this->load->view("operacion/pedidos_pendientes_op",$array,true);

		echo json_encode($result);

        

	}

	

	public function frm_confirmar_pedidos(){

		$data=json_decode($this->input->post('data'));

		$result = $this->result;

		$result['status'] = 1;

		$params = array(

			'idPedidoCliente' => $data->pedidos['0'],

			'id_estado_ped' =>$data->cod_estado_ped,

		);



		// print_r ($data->pedidos);exit();

		$paramas_find = array(

			'id_estado_ped' =>$data->cod_estado_ped - 1,

			'idPedidoCliente' => $data->pedidos['0'],



		);

		$params_ = array(

			'id' => $this->session->userdata('id_pdv'),

		);

		$rs = $this->model->cod_comercio($params_)->result();

		foreach($rs as $row){

			$array['idComercio'] = $row->id_comercio;

		}

		$array['metodos_pago'] = $this->model->get_metodo_pago_disponible($array['idComercio'])->result();

		$array['data'] = $this->model->find_pedidos_por_confirmarByid($paramas_find)->result();

		$array['medios_envio'] = $this->model->listar_medios_envio()->result();





		$sql1 = $this->db->get_where('mc_pedido_cliente',array('idPedidoCliente'=> $data->pedidos['0']))->row_array();

		$sql2 = $this->db->get_where('ms_metodo_pago',array('nombre'=>$sql1['medio_pago']))->row_array();



		if( $sql1['estado_pedido'] == 8){

			$paramas_find['data_vista'] = $this->db->get_where('mc_pedido_cliente',array('idPedidoCliente'=>$data->pedidos['0']))->row_array();

			

			$sql1 = $this->db->get_where('mc_pedido_cliente_detalle',array('idPedidoCliente'=>$data->pedidos['0']))->result();

			$total_a_confirmar = 0;

			foreach($sql1 as $row){

				$total_a_confirmar += $row->importe;

			}



			$sql1 =  $this->db->get_where('mc_pedido_cliente',array('idPedidoCliente'=>$data->pedidos['0']))->row_array();

			if($sql1['medio_entrega'] == 1){

				$paramas_find['delivery'] = $sql1['costo_delivery'];

			}else{

				$paramas_find['delivery'] = 0;

			}



			$paramas_find['total_confirmar'] = $total_a_confirmar;

			$result['data']['html']= $this->load->view("operacion/confirmar_pago_pedido",$paramas_find,true);

			$result['data']['rows'] = 0;

			echo json_encode($result);

			exit();

		}

		$array['idPedidoCliente'] = $params['idPedidoCliente'];

		$array['id_estado_ped'] = $paramas_find['id_estado_ped'];

		$result['result']=1;

		







			if( count($array['data'])==0 ) {

			$result['data']['html']= '<p class="p-info"><i class="fa fa-info-circle"></i> No se obtuvieron resultados.</p>';

			$result['data']['rows'] = 0;

			} else {

			if($params['id_estado_ped'] == 2){

				$result['data']['html']=$this->load->view("operacion/confirmar_pedido_op",$array,true);

			}else if($params['id_estado_ped'] == 4){



				$result['data']['html']=$this->load->view("operacion/despachar_pedido_op",$array,true);

			}else if($params['id_estado_ped'] == 3){



				$result['data']['html']=$this->load->view("operacion/produccion_pedido_op",$array,true);

			}

			

			$result['data']['rows'] = count($array['data']);

		// }

	}

		

		echo json_encode($result);

	

	}



	public function frm_nuevo_pedido(){

		$data=json_decode($this->input->post('data'));

		$result = $this->result;



		$params = array(

			'id' => $this->session->userdata('id_pdv'),

		);

		$array = array();

		$array['data'] = $this->model->filtrar_platos_comercio($params)->result();



		$rs = $this->model->cod_comercio($params)->result();



		foreach($rs as $row){

			$array['idComercio'] = $row->id_comercio;

			$array['idLocalComercio'] = $row->id_pdv;

		}

		$array['metodos_pago'] = $this->model->get_metodo_pago_disponible($array['idComercio'])->result();

		$array['distritos'] = $this->m_login_cliente->get_ubigeo_local_1($array['idLocalComercio'])->result_array();

		if(empty($array['distritos'])) $array['distritos'] = $this->m_login_cliente->get_ubigeo_local_2($array['idLocalComercio'])->result_array();

		

		$result['result']=1;

		if( count($array['data'])==0 ) {

			$result['data']['html']= '<p class="p-info"><i class="fa fa-info-circle"></i> No se obtuvieron resultados.</p>';

			$result['data']['rows'] = 0;

		} else {

			$result['data']['html']=$this->load->view("operacion/nuevo_pedido_op",$array,true);

			$result['data']['rows'] = count($array['data']);

		}



		echo json_encode($result);

	}



	public function confirmar_pego_en_linea(){

		$data=json_decode($this->input->post('data'));

		$result = $this->result;



		$params = array(

			'id' => $this->session->userdata('id_pdv'),

			'idPedidoCliente' => $data->id

		);

		$array = array();

		

		$arr_up = array(

			'estado_pedido' => 2,

		);



		$rs = $this->db->Update('mc_pedido_cliente',$arr_up,array('idPedidoCliente' => $data->id));



		if($rs){

			$config_ = array( 'type' => 1, 'message' => "Actualizado Correctamente.");



		}else{

			$config_ = array( 'type' => 1, 'message' => "No se pudo Actualizar.");

		}

		$result['data']['html']=createMessage($config_);

		echo json_encode($result);

	}





	public function pasar_pedido_cliente_despacho(){

		$data=json_decode($this->input->post('data'));



			$data->fecha_pedido;



			list($fecha,$hora) = explode("T",$data->fecha_pedido);

		

			$sess_temp = $this->session->userdata('idUsuarioClienteTemp');

		

		$result['result']=1;

		$arr_insert = array(

			'medio_entrega'=> $data->metodo_despacho,

			'medio_pago' =>$data->metodo_pago,

			'direccion' =>$data->direccion_envio,

			'estado_pedido'=>1,

			'fecha' => $fecha,

			'id_ubigeo' => $data->distrito_envio,

			'costo_delivery' => $data->costo_envio,

			'hora'=>$fecha.' '.$hora

			

		);

		$id_pedido = $this->session->userdata('id_pedido_cliente');

		if($id_pedido){

			$result['result']=1;

			$rsu = $this->db->update('mc_pedido_cliente', $arr_insert, "idPedidoCliente=".$id_pedido);

			if($rsu){

				$arr_insert = array(

					'idPedidoCliente' =>$id_pedido,

					'idPedidoEtapa' =>$arr_insert['estado_pedido']

				);

				$this->db->insert('mc_pedido_etapa_detalle',$arr_insert);

				$result['data']['content']= '<p class="p-info"><i class="fa fa-info-circle"></i> Pedido realizado con exito</p>';

				$this->session->unset_userdata('id_pedido_cliente');

				$this->session->unset_userdata('nombre_comercio_carrito');

			}else{

				$result['data']['content']= '<p class="p-info"><i class="fa fa-info-circle"></i> No se pudo completar el pedido</p>';

			}

			

		}else{

			$result['data']['content']= '<p class="p-info"><i class="fa fa-info-circle"></i> No se pudo completar el pedido</p>';

		}



		echo json_encode($result);



		}

	public function para_el_carrito(){

		$data=json_decode($this->input->post('data'));

		$result = $this->result;



		$params = array(

			'id' => $data->cod_art,

		);

		$array = array();

		$array['data'] = $this->model->articulos_byid($params)->result();



		// $rs = $this->model->cod_comercio($params)->result();



		// foreach($rs as $row){

		// 	$array['idComercio'] = $row->id_comercio;

		// 	$array['idLocalComercio'] = $row->id_pdv;

		// }

		$html = "";

		$i=$data->bucle;

		foreach($array['data'] as $row){

			 

			$html .= "<tr>";

				$html .= "<td><li id='fila_para_carrito' class='fa fa-trash'></li></td>";

				$html .= "<td>".$row->nombre."</td>";

				$html .= "<td  art_cod='".$row->id_articulo."' id='td_precio".$i."'>".dos_decimales($row->precio+$row->costo_empaque)."</td>";

				$html .= "<td><input type='text' art_cod='".$row->id_articulo."' class='form-control cantidad_platos' id='txtcant".$i."'></td>";

				$html .= "<td><input type='text' readonly='readonly' class='form-control' id='txtsubtotal".$i."'></td>";

			$html .= "</tr>";

			$i++;

		}

		$array['carrito'] = " ";

		$result['result']=1;

		$result['result']=1;



	

		if( count($array['data'])==0 ) {

			$result['data']['html']= '<p class="p-info"><i class="fa fa-info-circle"></i> No se obtuvieron resultados.</p>';

			$result['data']['rows'] = 0;

		} else {

			$result['data']['html']=$this->load->view("operacion/tabla_nuevo_pedido_op",$array,true);

			$result['data']['rows'] = count($array['data']);

		}

		$result['data']['tabla'] = $html;

		echo json_encode($result);

	}



	public function actualizar_estado_pedido(){

		$data=json_decode($this->input->post('data'));



		$params = array(

			'cod_ped' => $data->cod_ped,

			'cod_pedido_etapa'=> $data->cod_etapa_ped,

		);



		$arr_update = array(

			'estado_pedido' =>$data->cod_etapa_ped,

		);

		if($params['cod_pedido_etapa'] == 4){

			$arr_update['estado'] = 1;

		}

		if(isset($data->medio_envio) && $data->medio_envio != ""){

			$arr_update['medio_envio'] = $data->medio_envio;

		}

		if(isset($data->medio_envio) && $data->medio_envio == ""){

			$result['data']['status'] = 0;

			$result['result']= 1;

			$config_ = array( 'type' => 2, 'message' => "Debe seleccionar un medio de envío.");

			$result['data']['html']=createMessage($config_);

			echo json_encode($result);

			exit();

		}

		

		$pedidoInfo = $this->db->get_where('mc_pedido_cliente',array('idPedidoCliente'=>$params['cod_ped']))->row_array();



		$pago = $this->db->get_where('ms_metodo_pago',array('nombre' =>$pedidoInfo['medio_pago']))->row_array();



		if ($arr_update['estado_pedido'] == 2){

			$arr_update['estado_pedido']  = 8;

		}



		// print_r($arr_update);exit();

		

		$rs = $this->db->update('mc_pedido_cliente',$arr_update,'idPedidoCliente='.$params['cod_ped']);

		// $array['data'] = $this->model->find_pedidos_por_confirmarByid($params)->result();

		

		// print_r($this->db->last_query());exit();



		// $array['idPedidoCliente'] = $params['idPedidoCliente'];

		if($rs){

			$result['result']=1;

			// $result['data']['html']=$this->load->view("operacion/confirmar_pedido_op",$array,true);

			$config_ = array( 'type' => 1, 'message' => "Se actualizo con exito");

			$result['data']['html']=createMessage($config_);

			$arr_insert = array(

				'idPedidoCliente' =>$params['cod_ped'],

				'idPedidoEtapa' =>$params['cod_pedido_etapa']

			);

			$rs2 = $this->db->insert('mc_pedido_etapa_detalle',$arr_insert);



			$cod_ped_det = $this->db->insert_id();



				$query = $this->db->get_where('mc_pedido_etapa_detalle',array('idPedidoEtapaDet'=>$cod_ped_det));

				foreach($query->result() as $row){

					$detalle_fecha_hora = $row->fecha;

				}



				$query = $this->db->get_where('mc_pedido_cliente',array('idPedidoCliente'=>$data->cod_ped));

				foreach($query->result() as $row){

					$id_comercio = $row->idComercio;

					$id_usuario_cliente = $row->idUsuarioCliente;

					$id_medio_envio = $row->medio_envio;

					$direccion_fisica = $row->direccion;

					$id_pdv = $row->idComercioLocal;



					if($row->medio_pago !=''){

						$medio_pago = $row->medio_pago;

					}else $medio_pago = '';

					if($row->costo_delivery !=''){

						$costo_envio = $row->costo_delivery;

					}else $costo_envio = 0;

				}

						$cod_medio_pago = $medio_pago;

					



					$query = $this->db->get_where('ms_metodo_pago_comercio',array('id_metodo_pago'=>$cod_medio_pago,'id_comercio'=>$id_comercio));

					foreach($query->result() as $row){

						$numero_tarjeta = $row->numero;

					

					}

					$query = $this->db->get_where('ms_metodo_pago',array('id_metodo_pag'=>$cod_medio_pago));

					foreach($query->result() as $row){

						$medio_pago_nombre = $row->nombre;

					

					}

					$query = $this->db->get_where('mc_pedido_cliente_detalle',array('idPedidoCliente'=>$data->cod_ped));

					$total_final = 0;

					foreach($query->result() as $row){

						$total_final += $row->importe;

					}

				

					$query = $this->db->get_where('ms_comercio',array('id_comercio'=>$id_comercio));

					foreach($query->result() as $row){

						$comercio_nombre = $row->nombre;

						$comercio_razon_social = $row->razon_social;

						$pago_visa = $row->pago_visa;



					}

					$query = $this->db->get_where('mc_usuario_cliente',array('idUsuarioCliente'=>$id_usuario_cliente));

					foreach($query->result() as $row){

						$email_usuario =$row->email;

						$telefono_usuario =$row->telefono;

						$nombres_usuario =$row->nombres;

						$ape_paterno_usuario =$row->ape_paterno;

					}

						if($id_medio_envio != ''){

							$query = $this->db->get_where('ms_medio_envio',array('id_medio_env'=>$id_medio_envio));

							foreach($query->result() as $row){

								$medio_envio =$row->titulo;

								$medio_envio_telf =$row->telefono;

								// $medio_correo =$row->email;

							}

						}else{

							$medio_envio = '';

							$medio_envio_telf = '';

						}

						$pdv = $this->db->get_where('ms_punto_venta',array('id_pdv'=>$id_pdv))->row_array();



			if($data->cod_etapa_ped == 2 || $data->cod_etapa_ped == 4){

				$config = array( 

					'estado_ped' =>  $data->cod_etapa_ped, 

					'idPedidoCliente' => $data->cod_ped,

					'fecha_hora' => $detalle_fecha_hora,

					'comercio' => $comercio_nombre,

					'razon_social'=>$comercio_razon_social,

					'medio_envio'=>$medio_envio,

					'medio_envio_telf'=>$medio_envio_telf,

					'medio_pago'=>$medio_pago,

					'cod_medio_pago'=>$cod_medio_pago,
					
					'medio_pago_nombre'=>$medio_pago_nombre,

					'numero_tarjeta'=>$numero_tarjeta,

					'direccion_fisica'=>$direccion_fisica,

					'nombres_usuario'=>$nombres_usuario,

					'ape_paterno_usuario'=>$ape_paterno_usuario,

					'pago_visa'=>$pago_visa,

					'total_final_envio'=>$total_final + $costo_envio,

					'direccion_pdv'=> $pdv['nombre']." ubicado en: ".$pdv['zona'].' '.$pdv['via'].' '.$pdv['direccion'],



				);



				$html=$this->load->view("operacion/correo_notificacion_estado_ped",$config,true);

	

				$correo['to'] =$email_usuario;

				if(isset($medio_correo)) $correo['bcc'] =$medio_correo;

			

				$titulo='NOTIFICACIÓN TURNO';

				$this->correo($correo,$titulo,$html);

				//

				if($data->cod_etapa_ped == 2){

					if($id_medio_envio == ''){

						$id_etapa_proceso = '10';

					}else {

						$id_etapa_proceso = '6,8';

					}



				}else if($data->cod_etapa_ped == 4){

					if($id_medio_envio == ''){

						$id_etapa_proceso = '11';

					}else {

						$id_etapa_proceso = '7,9';

					}

				}





				$params = array(

					'idPedido' =>  $data->cod_ped,

					'idEtapa' => $id_etapa_proceso,

				);

				

				$data_mensaje = $this->model->get_configuracion_mensaje($params)->result();

				// print_r($data_mensaje);exit();

				$mensaje_cliente = "";

				$mensaje_motorizado = "";

				foreach($data_mensaje as $row){



						if($row->id_proceso == 6 || $row->id_proceso ==7 || $row->id_proceso == 10 || $row->id_proceso ==11){

							$mensaje_cliente = $row->contenido;

						}else if($row->id_proceso == 8 || $row->id_proceso ==9){

							$mensaje_motorizado = $row->contenido;

						}

						// if($row->id_proceso == 6 || $row->id_proceso ==7){

						// 	$mensaje_cliente = $row->contenido;

						// }

						// if($id_medio_envio != '' && $row->id_proceso == 8 || $row->id_proceso ==9){

						// 	$mensaje_motorizado = $row->contenido;

						// }

						// if($id_medio_envio == '' && $row->id_proceso == 10 || $row->id_proceso ==11){

						// 	$mensaje_cliente = $row->contenido;

						// }





				}

	

				if($data->cod_etapa_ped == 2){

					

				/*SMS CLIENTE =>*/ 	// $envio = enviar_sms('NOTIFICACION TURNO','Estimado '.$config['nombres_usuario'].' su pedido ha sido aceptado por '.$config['razon_social'],'51'.$telefono_usuario);

					

					

				/*SMS MOTORIZADO =>*/ if($medio_envio_telf != '') {

					$envio = enviar_sms('NOTIFICACION TURNO',$mensaje_motorizado,'51'.$medio_envio_telf);

					// echo "telf motorizado:".$medio_envio_telf."<br>";

					// echo $mensaje_motorizado." - " ; die();

				}

				}

				if($data->cod_etapa_ped == 4){

				/*SMS CLIENTE =>*/	$envio = enviar_sms('NOTIFICACION TURNO',$mensaje_cliente,'51'.$telefono_usuario);



				/*SMS MOTORIZADO =>*/ // if($medio_envio_telf != '') $envio = enviar_sms('NOTIFICACION TURNO',$mensaje_motorizado,'51'.$medio_envio_telf);

				}

			}



		}else{

			$result['data']['html']= '<p class="p-info"><i class="fa fa-info-circle"></i> Ocurrio un error</p>';



		}

	





		

		echo json_encode($result);

	

	}



	public function rechazar_pedido(){

		$data=json_decode($this->input->post('data'));



		$params = array(

			'cod_ped' => $data->cod_ped,

		);



		$arr_update = array(

			'estado_pedido' =>$data->cod_etapa_ped,

		);

		

		$rs = $this->db->update('mc_pedido_cliente',$arr_update,'idPedidoCliente='.$params['cod_ped']);

	

		if($rs){

			$result['result']=1;

			// $result['data']['html']=$this->load->view("operacion/confirmar_pedido_op",$array,true);

			$config_ = array( 'type' => 2, 'message' => "Se canceló el pedido");

			$result['data']['html']=createMessage($config_);

			$arr_insert = array(

				'idPedidoCliente' =>$params['cod_ped'],

				// 'idPedidoEtapa' =>$params['cod_pedido_etapa']

				'idPedidoEtapa' => 5

			);

			$rs2 = $this->db->insert('mc_pedido_etapa_detalle',$arr_insert);



			$cod_ped_det = $this->db->insert_id();



				$query = $this->db->get_where('mc_pedido_etapa_detalle',array('idPedidoEtapaDet'=>$cod_ped_det));

				foreach($query->result() as $row){

					$detalle_fecha_hora = $row->fecha;

				}



				$query = $this->db->get_where('mc_pedido_cliente',array('idPedidoCliente'=>$data->cod_ped));

				foreach($query->result() as $row){

					$id_comercio = $row->idComercio;

					$id_usuario_cliente = $row->idUsuarioCliente;

				}

					$query = $this->db->get_where('ms_comercio',array('id_comercio'=>$id_comercio));

					foreach($query->result() as $row){

						$comercio_nombre = $row->nombre;

						$comercio_razon_social = $row->razon_social;

					}

					$query = $this->db->get_where('mc_usuario_cliente',array('idUsuarioCliente'=>$id_usuario_cliente));

					foreach($query->result() as $row){

						$email_usuario =$row->email;

						$telefono_usuario = $row->telefono;

					}



			if($data->cod_etapa_ped == 5){

				$config = array( 

					'estado_ped' =>  $data->cod_etapa_ped, 

					'idPedidoCliente' => $data->cod_ped,

					'fecha_hora' => $detalle_fecha_hora,

					'comercio' => $comercio_nombre,

					'razon_social'=>$comercio_razon_social

				);



				$html=$this->load->view("operacion/correo_notificacion_estado_ped",$config,true);

	

				

				$correo['to'] =$email_usuario;

			

				$titulo='NOTIFICACIÓN TURNO';

				$this->correo($correo,$titulo,$html);



				





				$params = array(

					'idPedido' =>  $data->cod_ped,

					'idEtapa' => $data->cod_etapa_ped,

				);

				$data_mensaje = $this->model->get_configuracion_mensaje($params)->result();

				foreach($data_mensaje as $row){

					if(isset($row->contenido)){

						$mensaje_rechazo = $row->contenido;

					}else $mensaje_rechazo = '';

				}

				if(isset($telefono_usuario) && $telefono_usuario !=''){

					if($mensaje_rechazo != ''){

						$envio = enviar_sms('NOTIFICACION TURNO',$mensaje_rechazo,'51'.$telefono_usuario);

					}

				}



			}



		}else{

			$result['data']['html']= '<p class="p-info"><i class="fa fa-info-circle"></i> Ocurrio un error</p>';



		}

	





		

		echo json_encode($result);

	}



	public function agregar_pedido_op(){

		// $this->session->sess_destroy();exit();



		$data=json_decode($this->input->post('data'));



		$cod_cliente = $this->session->userdata('idUsuarioCliente');

		$nombre_usuario =$this->session->userdata('nombre_usuario');

		$cod_local =$this->session->userdata('id_pdv');

		$user_temp = $this->session->userdata('idUsuarioClienteTemp');

		



		if($data->bucle < 0){

			$config_ = array( 'type' => 2, 'message' => "No hay pedidos para agregar");

			$result['data']['content']=createMessage($config_);

			$result['status'] = 0;

			echo json_encode($result);



			exit();

		}

		if($data->dni == '' && strlen($data->dni) < 8){

			$config_ = array( 'type' => 2, 'message' => "Ingrese un DNI válido");

			$result['data']['content']=createMessage($config_);

			$result['status'] = 0;

			echo json_encode($result);



			exit();

		}

		if($data->metodo_pago ==''){

			$config_ = array( 'type' => 2, 'message' => "Seleccione un metodo de pago");

			$result['data']['content']=createMessage($config_);

			$result['status'] = 0;

			echo json_encode($result);

			exit();

		}

		if($data->metodo_despacho ==''){

			$config_ = array( 'type' => 2, 'message' => "Seleccione un metodo de entrega");

			$result['data']['content']=createMessage($config_);

			$result['status'] = 0;

			echo json_encode($result);

			exit();

		}



		$query = $this->db->get_where('mc_usuario_cliente',array('nro_documento'=>$data->dni));

			

		

		if(($query->num_rows() > 0)){

			foreach($query->result() as $row){

				$cod_cliente =  $row->idUsuarioCliente;

				$nombre = $row->nombres;

				$ape_pat = $row->ape_paterno;

			}

			$mensaje = "El usuario $nombre $ape_pat ya estaba registrado.";

		}else{



			// print_r($data); exit();

			if($data->nombre == ''){

				$config_ = array( 'type' => 2, 'message' => "Debe escribir un Nombre");

				$result['status']=0;

				$result['data']['content']=createMessage($config_);

				echo json_encode($result);

				exit();

			}

			if($data->apepat == ''){

				$config_ = array( 'type' => 2, 'message' => "Debe escribir un Apellido Paterno");

				$result['status']=0;

				$result['data']['content']=createMessage($config_);

				echo json_encode($result);

				exit();

			}

			if($data->apemat == ''){

				$config_ = array( 'type' => 2, 'message' => "Debe escribir un Apellido Materno");

				$result['status']=0;

				$result['data']['content']=createMessage($config_);

				echo json_encode($result);

				exit();

			}

			if (false == filter_var($data->email, FILTER_VALIDATE_EMAIL)) {

				$config_ = array( 'type' => 2, 'message' => "Debe escribir un Email válido");

				$result['status']=0;

				$result['data']['content']=createMessage($config_);

				echo json_encode($result);

				exit();

			}

			if(false == filter_var($data->telf, FILTER_VALIDATE_INT)){

				$config_ = array( 'type' => 2, 'message' => "Debe escribir un Teléfono válido");

				$result['status']=0;

				$result['data']['content']=createMessage($config_);

				echo json_encode($result);

				exit();

			}





			$arr_registro=array(

				'nombre_usuario' =>$data->dni,

				'clave' =>$data->dni,

				'nro_documento' =>$data->dni,

				'telefono'=>$data->telf,

				'nombres'=>$data->nombre,

				'ape_paterno'=>$data->apepat,

				'ape_materno'=>$data->apemat,

				'email'=>$data->email

			);



			$query = $this->db->get_where('mc_usuario_cliente',array('email'=>$data->email));

			if(($query->num_rows() > 0)){

				$config_ = array( 'type' => 2, 'message' => "El Correo ya pertenece a otro usuario");

				$result['data']['content']=createMessage($config_);

				$result['status']=0;

				echo json_encode($result);

				exit();

			}



			$query = $this->db->get_where('mc_usuario_cliente',array('telefono'=>$data->telf));

			if(($query->num_rows() > 0)){

				$config_ = array( 'type' => 2, 'message' => "El Teléfono ya pertenece a otro usuario");

				$result['data']['content']=createMessage($config_);

				$result['status']=0;

				echo json_encode($result);

				exit();

			}



			$rs = $this->db->insert('mc_usuario_cliente',$arr_registro);

			if($rs){

				$cod_cliente = $this->db->insert_id();

				$mensaje = "Se registró el usuario con éxito.";

				

				$config = array( 

					'nombre_usuario' =>  $data->nombre, 

					'usuario' => $data->dni,

					'clave' => $data->dni,

					);



				$html=$this->load->view("operacion/correo_notificacion_cliente_registro",$config,true);

				//enviar mensaje

				//correo del admin

				//$email_admin = $this->session->userdata('email');

	

				$correo['to'] =$data->email;

				// poner dinamico correos

				// del admin y del cliente enviar

				//

				// $email_admin = "aaron.turno@gmail.com";

				// $correo['cc'] = $email_admin;

				$titulo='NOTIFICACIÓN TURNO';

				$this->correo($correo,$titulo,$html);

			}



		}





		if($cod_cliente){



		$result = $this->result;

		$result['status'] = 0;

		

		$query = $this->db->get_where('ms_punto_venta',array('id_pdv'=>$cod_local));

			foreach($query->result() as $row){

				$cod_comercio = $row->id_comercio;

			};

	

	



		$arr_insert = array(

			'idUsuarioCliente' =>$cod_cliente,

			'idComercio' =>$cod_comercio,

			'idComercioLocal'=>$cod_local ,

			'estado_pedido'=>1,

			'medio_entrega'=>$data->metodo_despacho,

			'medio_pago'=>$data->metodo_pago,

			'direccion'=>$data->direccion_envio,

			'fecha'=>$data->fecha_pedido,

			'costo_delivery'=>$data->delivery,

			'id_ubigeo' =>$data->distrito

		);

		$medio_entrega_nuevo_ped = $arr_insert['medio_entrega'];

		$fecha_nuevo_ped = $arr_insert['fecha'];

		

		$this->db->insert('mc_pedido_cliente',$arr_insert);





		$data=json_decode($this->input->post('data'),true);



		$id_pedido_nuevo = $this->db->insert_id();

		$arr_insert_det = array(

			'cantidad' => 0,

			'importe' =>0,

			'idPedidoCliente' =>$id_pedido_nuevo,

			'idPlatoComercio'=>0,

		);

		for ($i=0; $i <= $data['bucle']; $i++) { 

			$arr_insert_det['idPlatoComercio'] =  $data['articulo'.$i];

			$arr_insert_det['cantidad'] = $data['cantidad'.$i];

			$query = $this->db->get_where('ts_articulo',array('id_articulo'=>$data['articulo'.$i]));

			foreach($query->result() as $row){

				$precio_plato = $row->precio;

			}

			$articulo_det = $this->db->get_where('ts_articulo',array('id_articulo' =>$data['articulo'.$i]))->row_array();

			$importe = ($articulo_det['precio'] + $articulo_det['costo_empaque']) * $data['cantidad'.$i];



			$arr_insert_det['importe'] = $importe;



			$rs = $this->db->insert('mc_pedido_cliente_detalle',$arr_insert_det);

			$id_ped_cli_det = $this->db->insert_id();



			if($rs){

				if(isset($id_pedido_nuevo)){

					$result['result']=1;

						$arr_insert = array(

							'idPedidoCliente' =>$id_pedido_nuevo,

							'idPedidoEtapa' =>1

						);

						$this->db->insert('mc_pedido_etapa_detalle',$arr_insert);

						$result['data']['content']= '<p class="p-info"><i class="fa fa-info-circle"></i> Pedido realizado con exito</p>';

						$this->session->unset_userdata('id_pedido_cliente');

						$this->session->unset_userdata('nombre_comercio_carrito');

						$this->session->unset_userdata('id_pedido_cliente');

						$this->session->unset_userdata('nombre_comercio_carrito');

				

						$result['status']=1;

						

				}else{

					$result['data']['content']= '<p class="p-info"><i class="fa fa-info-circle"></i> No se pudo completar el pedido</p>';

				}

			}

		}

	

		$result['result']=1;







				/*Correo al Admin de Comercio*/



				$pedido = $this->db->get_where('mc_pedido_cliente_detalle',array('idPedidoCliente'=>$id_pedido_nuevo))->result();



				if(count($pedido) > 0){

					$total_final = 0;

					foreach($pedido as $row){

						$total_final += $row->importe;

					}

					// print_r($data);exit();

					if($medio_entrega_nuevo_ped == 1){

						$costo_envio = $data['delivery'];

					}else{

						$costo_envio = 0;

					}

					$filtros = "AND uh.id_usuario_perfil = 3";

					$sql = $this->model->get_usuarios_comercio($cod_comercio,$filtros)->result();

					// echo $this->db->last_query();exit();

					$local = $this->db->get_where('ms_punto_venta',array('id_pdv' => $cod_local))->row_array();

					if(count($sql) > 0){

						foreach($sql as $row){

			

							$config = array( 

								'fecha_hora' => $fecha_nuevo_ped,

								'idPedidoCliente' =>$id_pedido_nuevo,

								'total_final_envio'=>$total_final + $costo_envio,

								'punto_de_venta'=>$local['nombre'],

								'Perfil_usuario' => 'Administrador',

							);

			

							$html=$this->load->view("operacion/correo_notificacion_nuevo_pedido",$config,true);

							$correo['to'] =$row->email;

							$titulo='NOTIFICACIÓN TURNO';

							$this->correo($correo,$titulo,$html);

						}

					}

					$id_usuario_perfil = $this->session->userdata('id_usuario_perfil');

					$filtros = "AND uh.id_usuario_perfil = 8 AND pdv.id_pdv = $cod_local";

					$sql = $this->model->get_usuarios_comercio($cod_comercio,$filtros)->result();



					if(count($sql) > 0){

						foreach($sql as $row){

			

							$config = array( 

			

								'fecha_hora' => $fecha_nuevo_ped,

								'idPedidoCliente' =>$id_pedido_nuevo,

								'total_final_envio'=>$total_final + $costo_envio,

								'punto_de_venta'=>$local['nombre'],

							);

			

							$html=$this->load->view("operacion/correo_notificacion_nuevo_pedido",$config,true);

			

							$correo['to'] =$row->email;

							$titulo='NOTIFICACIÓN TURNO';

							$this->correo($correo,$titulo,$html);



						}

					}

				}





	

	}else{



		$result['data']['message'] = "<i class='fas fa-check-circle'></i> Primero debe Iniciar Sesion!" ;

	}

		

		echo json_encode($result);



		// echo json_encode($result);

		

	}



	function correo($correo=array(),$titulo,$contenido,$archivos_adjuntos = array()){

		$email_admin = "aaron.turno@gmail.com";

		$correo['cc'] = $email_admin;

		$config=array(

            'protocol'=>'smtp',

            'smtp_host'=>'ssl://smtp.googlemail.com',

            'smtp_port'=>465,

            'smtp_user'=>'turno.macctec@gmail.com',

            'smtp_pass'=>'fernandez1A',

            'mailtype'=>'html'

        );

        $this->load->library('email',$config);

		$this->email->clear(true);

        $this->email->set_newline("\r\n");



		$archivos_adjuntos = array_unique( $archivos_adjuntos );

		if( sizeof($archivos_adjuntos) > 0 ){

			foreach ( $archivos_adjuntos as $keyFile => $fileName ) {

				$this->email->attach( $fileName );

			}

		}

		

        $this->email->from('turno.macctec@gmail.com','TURNO - Pedido');        

        if(isset($correo['to']) && !empty($correo['to'])){

			$this->email->to($correo['to']);

			if(isset($correo['cc']) && !empty($correo['cc'])) $this->email->cc($correo['cc']);

			if(isset($correo['bcc']) && !empty($correo['bcc'])) $this->email->bcc($correo['bcc']);

			$this->email->subject($titulo);

			$this->email->message($contenido);

			

			if(!$this->email->send()) log_message('error', $this->email->print_debugger());

			else log_message('info', 'Se envió correctamente el correo. -> '.$titulo);

		}

    }

	



}

?>
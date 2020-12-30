<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Home_cliente extends MY_Controller {

	public function __construct(){

		parent::__construct();

		$this->load->model('M_Login_cliente','model');

	}

	public function index()

	{

		$config['css']['style']=array();

		//$config['nav']['menu_active']='10';

		//

		$config['css']['style']=array('../../core/libs/dataTables-1.10.20/datatables','../../core/css/cards');

		$config['js']['script']=array('../../core/libs/dataTables-1.10.20/datatables','../../core/libs/dataTables-1.10.20/datatables-defaults','cliente');

		// $config['js']['script']=array('cliente','cliente_login');

		// $config['data']['icon']='fa fa-home';

		$config['data']['icon']='pe-7s-coffee';



		$config['view']='cliente/index';

		$config['data']['title']='<a href="'.base_url().'Cliente">DIRECTORIO DE ESTABLECIMIENTOS</a>';

		$config['data']['distritos_pdv'] = $this->model->listar_distritos_pdv()->result_array();

		$config['data']['rubros'] = $this->model->listar_rubros()->result_array();

		/*Editar mensaje - Luis */

		$config['data']['message']='';//'Bienvenido al sistema, '.$this->session->userdata('nombres').' '.$this->session->userdata('ape_paterno');

		/*=======*/

		$config['data']['departamentos'] = $this->model->listar_dpts()->result_array();

		$config['data']['comercios'] = $this->model->listar_tipo_comercio()->result_array();

		$config['data']['comercios_afiliados'] = $this->model->listar_comercios_afiliados()->result();



		$sess_temp = $this->session->userdata('idUsuarioClienteTemp');



		// if($sess_temp){

		// 	$this->db->delete('mc_pedido_cliente', array('idUsuarioCliente' => $sess_temp));

		// 	$this->session->unset_userdata('idUsuarioClienteTemp');

		// 	$this->session->unset_userdata('id_pedido_cliente');

		// 	$this->session->unset_userdata('nombre_comercio_carrito');

		// 	$this->session->unset_userdata('idUsuarioCliente');

		// 	$this->session->unset_userdata('nombre_usuario');

		// 	$this->session->unset_userdata('idUsuarioClienteTemp');

		// 	$this->session->unset_userdata('nombres');

		

		// }

		$op_session = $this->session->userdata('id_pdv');

		if($op_session){

			$this->session->sess_destroy();

		}



		$this->view_cliente($config);

	}

	

public function gocomercio($id='')

	{

		if($id ==''){

			redirect('home_cliente','refresh');

		}

		

		$config['css']['style']=array();

		//$config['nav']['menu_active']='10';

		//

		$config['css']['style']=array('../../core/libs/dataTables-1.10.20/datatables','../../core/css/cards');

		$config['js']['script']=array('../../core/libs/dataTables-1.10.20/datatables','../../core/libs/dataTables-1.10.20/datatables-defaults','cliente');

		// $config['js']['script']=array('cliente','cliente_login');

		// $config['data']['icon']='fa fa-home';

		$config['data']['icon']='pe-7s-coffee';



		$config['data']['title']='<a href="'.base_url().'Cliente">DIRECTORIO DE ESTABLECIMIENTOS</a>';

		/*Editar mensaje - Luis */

		$config['data']['message']='';//'Bienvenido al sistema, '.$this->session->userdata('nombres').' '.$this->session->userdata('ape_paterno');

		/*=======*/

		$config['data']['distritos_pdv'] = $this->model->listar_distritos_pdv()->result_array();

		$config['data']['rubros'] = $this->model->listar_rubros()->result_array();

		$cadena = explode("jh",$id);

		// print_r($cadena); exit();





		$config['data']['direct_comercio'] = $this->model->listar_comercios_afiliados_byid($cadena[0])->result();

		

		// print_r($config['data']['direct_comercio']); exit();

		$config['data']['departamentos'] = $this->model->listar_dpts()->result_array();

		$config['data']['comercios'] = $this->model->listar_tipo_comercio()->result_array();

		$params = array(

			'id' => $cadena[0],

		);

		$locales = $this->model->filtrar_locales_comercio($params)->result();

		$array['locales_comercio'] =  $this->model->filtrar_locales_comercio($params)->result();

		$t = $this->db->get_where('ms_comercio',array('id_comercio' => $params['id']))->row_array();



		

		$cod_tipo_comercio = $t['id_giro'];

		$giro = $this->db->get_where("ms_giro",array('id_giro'=>$t['id_giro']))->row_array();

		$tipo_comercio = $giro['nombre'];

		$nombre_comercio= $t['razon_social'];



		// if( count($t)==0 ) {

			$result['data']['html1']= '<p class="p-info"><i class="fa fa-info-circle"></i> No se encontraron locales <b>'.$nombre_comercio.'.</b></p>';

			$result['data']['html2']= "<p><a href='".base_url()."Cliente'>DIRECTORIO DE ESTABLECIMIENTOS</a> / <a nombre_tipo_comercio='".$tipo_comercio."' cod_tipo_comercio=".$cod_tipo_comercio." id ='enlace_filtrado' href='javascript:;'> ".$tipo_comercio."</a> / <b>".$nombre_comercio."</b></p>";

		// } else {

			

		// 	$result['data']['html1']= $this->load->view("cliente/locales_comercio",$array,true);

		// 	$result['data']['html2']= "<p><a href='".base_url()."Cliente'>DIRECTORIO DE ESTABLECIMIENTOS</a> / <a nombre_tipo_comercio='".$tipo_comercio."' cod_tipo_comercio='".$cod_tipo_comercio."' id ='enlace_filtrado' href='javascript:;'> ".$tipo_comercio."</a> / <b>".$nombre_comercio."</b></p>";

		// }



		$config['data']['title']="<p><a href='".base_url()."Cliente'>DIRECTORIO DE ESTABLECIMIENTOS</a> / <a nombre_tipo_comercio='".$tipo_comercio."' cod_tipo_comercio=".$cod_tipo_comercio." id ='enlace_filtrado' href='javascript:;'> ".$tipo_comercio."</a> / <b>".$nombre_comercio."</b></p>";

		if(count($locales)>0){

			$config['data']['locales_comercio'] =$this->model->filtrar_locales_comercio($params)->result();

			$config['view']='cliente/locales_comercio';

		}else{

			$config['data']['mensaje'] ='<p class="p-info"><i class="fa fa-info-circle"></i> No se encontraron locales <b>'.$nombre_comercio.'.</b></p>';

			$config['view']='cliente/locales_comercio_empty';

		}

		

		$sess_temp = $this->session->userdata('idUsuarioClienteTemp');



		if($sess_temp){

			$this->db->delete('mc_pedido_cliente', array('idUsuarioCliente' => $sess_temp));

			$this->session->unset_userdata('idUsuarioClienteTemp');

			$this->session->unset_userdata('id_pedido_cliente');

			$this->session->unset_userdata('nombre_comercio_carrito');

			$this->session->unset_userdata('idUsuarioCliente');

			$this->session->unset_userdata('nombre_usuario');

			$this->session->unset_userdata('idUsuarioClienteTemp');

			$this->session->unset_userdata('nombres');

		

		}

		$op_session = $this->session->userdata('id_pdv');

		if($op_session){

			$this->session->sess_destroy();

		}

		

		$this->view_cliente($config);

	}

public function gopedido($id=''){

		if($id ==''){

			redirect('home_cliente','refresh');

		}
		$id_cadena = explode("=", $id);
		print_r($id_cadena);

		$id = base64_decode($id_cadena[0]);

		// echo $id; exit();

		$config['css']['style']=array();

		//$config['nav']['menu_active']='10';

		//

		$config['css']['style']=array('../../core/libs/dataTables-1.10.20/datatables','../../core/css/cards');

		$config['js']['script']=array('../../core/libs/dataTables-1.10.20/datatables','../../core/libs/dataTables-1.10.20/datatables-defaults','cliente');

		// $config['js']['script']=array('cliente','cliente_login');

		// $config['data']['icon']='fa fa-home';

		$config['data']['icon']='pe-7s-coffee';





/******** */

	



		$pedido = $this->db->get_where('mc_pedido_cliente',array('idPedidoCliente' => $id))->row_array();

		$usuario = $this->db->get_where('mc_usuario_cliente',array('idUsuarioCliente'=>$pedido['idUsuarioCliente']))->row_array();

			$result = $this->result;

			$result['status'] = 0;

			$array = array();



			$params = array(

				'idUsuarioCliente' => $usuario['idUsuarioCliente'],

				'idPedidoCliente' => $pedido['idPedidoCliente']

			);

			// print_r ($params);exit();







			$array['mis_pedidos'] = $this->model->listar_mis_pedidos($params)->result();



			// echo $this->db->last_query();exit();

			$array['listado_pedidos']= $this->model->listado_mis_pedidos($params)->result();



			// print_r ($array['mis_pedidos']);exit();



			$val  = array();

			$i = 0;

			$idLocal = 0;

			foreach($array['listado_pedidos'] as $row){

				$val[$i++] = $row;

				$array['cod_usuario_ped'] = $row->idUsuarioCliente;

				

			}

			$i = 0;

			$val = array();

			foreach($array['mis_pedidos'] as $row){

				$val[$i++] = $row;

			if($row->estado == 0){

				if($row->idPedidoEtapa == 1){

					$array['hora']['realizado'] = $row->hora;

					$array['estado']['realizado'] = "CANCELADO POR EL CLIENTE"; 

				}else if($row->idPedidoEtapa == 2){

					$array['hora']['confirmado'] = $row->hora;

					$array['estado']['confirmado'] = 'NO CONFIRMADO';

				}else if($row->idPedidoEtapa == 3){

					$array['estado']['producido'] = "CANCELADO EN PRODUCCION";

					$array['hora']['producido'] = $row->hora;

				}else if($row->idPedidoEtapa == 4){

					$array['estado']['despacho'] = "CANCELADO EN DESPACHO";

					$array['hora']['despacho'] = $row->hora;

				}

			}else{

			if($row->idPedidoEtapa == 1 && $row->estado == 1){

					$array['estado']['realizado'] = "PEDIDO REALIZADO";

					$array['hora']['realizado'] = $row->hora;

					$array['fecha']['realizado'] = $row->fecha;

			}else if($row->idPedidoEtapa == 2 && $row->estado == 1){

				$array['estado']['confirmado'] = "PEDIDO CONFIRMADO";

				$array['hora']['confirmado'] = $row->hora;

				$array['fecha']['confirmado'] = $row->fecha;

			}else if($row->idPedidoEtapa == 3 && $row->estado == 1){

				$array['estado']['producido'] = "PEDIDO PRODUCIDO";

				$array['hora']['producido'] = $row->hora;

				$array['fecha']['producido'] = $row->fecha;

			}else if($row->idPedidoEtapa == 4 && $row->estado == 1){

				$array['estado']['despacho'] = "PEDIDO DESPACHADO";

				$array['hora']['despacho'] = $row->hora;

				$array['fecha']['despacho'] = $row->fecha;

			}

			}

			}



			if( count($val)==0 ) {

				$result['data']['html1']= '<p class="p-info"><i class="fa fa-info-circle"></i> No se encontraron despachos pendientes.</p>';

			} else {

				$result['data']['html1'] = $this->load->view('operacion/estado_pedido',$array,true); 

				// $result['data']['notificacion']= count($val);

			}







/************ */







		$config['view']='operacion/estado_pedido';

		$config['data']['title']='Detalle de mi Pedido';

		/*Editar mensaje - Luis */

		$config['data']['message']='';//'Bienvenido al sistema, '.$this->session->userdata('nombres').' '.$this->session->userdata('ape_paterno');

		$config['data']['data'] = $array;//'Bienvenido al sistema, '.$this->session->userdata('nombres').' '.$this->session->userdata('ape_paterno');

		/*=======*/

		// print_r($config['data']);exit();

		$config['data']['distritos_pdv'] = $this->model->listar_distritos_pdv()->result_array();

		$config['data']['rubros'] = $this->model->listar_rubros()->result_array();

		$cadena = explode("jh",$id);

		// print_r($cadena); exit();





		$config['data']['direct_comercio'] = $this->model->listar_comercios_afiliados_byid($cadena[0])->result();

		

		// print_r($config['data']['direct_comercio']); exit();

		$config['data']['departamentos'] = $this->model->listar_dpts()->result_array();

		$config['data']['comercios'] = $this->model->listar_tipo_comercio()->result_array();

		$config['data']['comercios_afiliados'] = $this->model->listar_comercios_afiliados()->result();





		$sess_temp = $this->session->userdata('idUsuarioClienteTemp');



		if($sess_temp){

			$this->db->delete('mc_pedido_cliente', array('idUsuarioCliente' => $sess_temp));

			$this->session->unset_userdata('idUsuarioClienteTemp');

			$this->session->unset_userdata('id_pedido_cliente');

			$this->session->unset_userdata('nombre_comercio_carrito');

			$this->session->unset_userdata('idUsuarioCliente');

			$this->session->unset_userdata('nombre_usuario');

			$this->session->unset_userdata('idUsuarioClienteTemp');

			$this->session->unset_userdata('nombres');

		

		}

		$op_session = $this->session->userdata('id_pdv');

		if($op_session){

			$this->session->sess_destroy();

		}

		

		$this->view_cliente($config);

	}

}


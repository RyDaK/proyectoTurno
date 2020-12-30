<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Cliente  extends MY_Controller {

	

	public function __construct(){

		parent::__construct();

		$this->load->model('M_Login_cliente','model');

		$this->load->model('M_PedidoOP','m_pedidos');



	}

	

	public function index()

	{

		$cod_t = $this->input->get('cod_com');

		$config['css']['style']=array('../../core/libs/dataTables-1.10.20/datatables','../../core/css/cards');

		$config['js']['script']=array('../../core/libs/dataTables-1.10.20/datatables','../../core/libs/dataTables-1.10.20/datatables-defaults','cliente');



		// $config['nav']['menu_active']='10';

		//

		//$config['js']['script']=array('cliente');

		$config['data']['icon']='pe-7s-coffee';

		$config['data']['title']='<a href="'.base_url().'Cliente" id="home_link">DIRECTORIO DE ESTABLECIMIENTOS</a>';

		$config['view']='cliente/index';

		$config['data']['message']='';

		// $config['data']['departamentos'] = $this->model->listar_dpts()->result_array();

		$config['data']['distritos_pdv'] = $this->model->listar_distritos_pdv()->result_array();

		$config['data']['comercios'] = $this->model->listar_tipo_comercio()->result_array();

		$config['data']['rubros'] = $this->model->listar_rubros()->result_array();

		$config['data']['departamentos'] = $this->model->listar_dpts()->result_array();

		if(isset($cod_t)){

			$config['view']='cliente/locales_comercio';

			$params=array(

				'id'=> $this->input->get('cod_com'),

			);

			$config['data']['locales_comercio'] = $this->model->filtrar_locales_comercio($params)->result();

		}else{

			$config['data']['comercios_afiliados'] = $this->model->listar_comercios_afiliados()->result();

		}







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

	

	public function tipo_com()

	{

		$x =$this->input->get('tipo_com');

		// $cod_comercio = $this->input->post('cod_comercio');

		$config['css']['style']=array('../../core/libs/dataTables-1.10.20/datatables','../../core/css/cards');

		$config['js']['script']=array('../../core/libs/dataTables-1.10.20/datatables','../../core/libs/dataTables-1.10.20/datatables-defaults','cliente');



		// $config['nav']['menu_active']='10';

		//

		//$config['js']['script']=array('cliente');

		$config['data']['icon']='pe-7s-coffee';

			$config['data']['title']='<a href="'.base_url().'Cliente" id="home_link">DIRECTORIO DE ESTABLECIMIENTOS</a>';

		

		$config['data']['message']='';

		// $config['data']['departamentos'] = $this->model->listar_dpts()->result_array();

		$config['data']['distritos_pdv'] = $this->model->listar_distritos_pdv()->result_array();

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

		$this->view_cliente($config);

		

	}



	//---------------------------------------

	//	Mostrar modal (Libro Reclamaciones)

	//---------------------------------------

	public function mostrar_libro_reclamaciones(){

		$data=json_decode($this->input->post('data'));

		

		$filtros = array(

			'cod_usuario_cliente'=>$data->cod_cliente_usuario,

		);

		

		// $array['datos_cliente'] = $this->model->modal_buscar_cliente($filtros)->result();

		$array['datos_id_reclamo'] = $this->model->modal_buscar_reclamo()->result();



		$result = $this->result;

		$result['status'] = 1;

		$result['data']['html']=$this->load->view("operacion/libro_reclamos",$array,true);

		// $result['data']['html']= "<h1>Hola<h1>";

		

		echo json_encode($result);

		

	}

	//---------------------------------------

	//		Obtener Provincias

	//---------------------------------------

	public function obtener_provincias()

	{

		$result = $this->result;



		if ($this->input->post('cod_departamento')) {

			$provincias = $this->model->listar_provincias($this->input->post('cod_departamento'))->result_array();

			$html = "";



			$params = array (

				'cod_dep'=>$this->input->post('cod_departamento'),

				'filtros'=>''

			);



			$array['locales_comercio'] = $this->model->filtrado_locales_ubigeo($params)->result();

			$res = $this->db->query("Select * from  ms_ubigeo where cod_dep='".$params['cod_dep']."'")->result();



			foreach($res as $row){

				$sitio = $row->departamento;

			}



			$comercios  = array();

			$i = 0;

			

			foreach($array['locales_comercio'] as $row){

				$comercios[$i++] = $row;

				$sitio = $row->departamento;

			}

			if(isset($comercios)){

				if( count($comercios)==0 ) {

					$result['data']['html1']= '<p class="p-info"><i class="fa fa-info-circle"></i> No hay locales disponibles en <b>'.$sitio.'</b></p>';

				} else {

					$result['data']['html1']= $this->load->view("cliente/locales_comercio",$array,true);

				}

			}else{

				$result['data']['html1']= '<p class="p-info"><i class="fa fa-info-circle"></i> No hay locales disponibles en <b>'.$sitio.'</b></p>';

			}



			foreach ($provincias as $provincia) {

				$html .= '<option style="color: black;" value="'.$provincia['cod_prov'].'">'.$provincia['provincia'].'</option>';

			}

			$result['html'] = $html;







			echo json_encode($result);

		}

	}



	public function filtrado_local_ubigeo()

	{

		$result = $this->result;



		// enviar_sms('TURNO','MENSAJE','999718100');exit();



		if ($this->input->post('cod_dep')) {



			$params = array (

				'cod_dep'=>$this->input->post('cod_dep'),

				'cod_prov'=>$this->input->post('cod_prov'),

				'cod_dist'=>$this->input->post('cod_dist'),

				'filtros'=>''

			);



			$res = $this->db->query("Select * from  ms_ubigeo where cod_dist=".$params['cod_dist']." AND cod_prov=".$params['cod_prov']." AND cod_dep='".$params['cod_dep']."'")->result();

			

			

			foreach($res as $row){

				$params['id_ubigeo_pdv'] = $row->id_ubigeo;

				$sitio = $row->distrito;

			}



			$params['filtros']= "AND cod_prov=".$params['cod_prov']." AND cod_dist =".$params['cod_dist'];

			// $array['locales_comercio'] = $this->model->filtrado_locales_ubigeo($params)->result();

			$array['locales_comercio'] = $this->model->filtrado_locales_ubigeo_pdv($params)->result();





			$counter  = array();

			$i = 0;

			

			foreach($array['locales_comercio'] as $row){

				$counter[$i++] = $row;

				$sitio = $row->distrito;

			}

				if( count($counter)==0 ) {

					$result['data']['html1']= '<p class="p-info"><i class="fa fa-info-circle"></i> No hay locales disponibles en <b>'.$sitio.'</b></p>';

				} else {

					$result['data']['html1']= $this->load->view("cliente/locales_comercio",$array,true);

				}

		

			echo json_encode($result);

		}

	}



	public function filtrar_por_distrito_pdv()

	{

		$data=json_decode($this->input->post('data'));

		$result = $this->result;



		// enviar_sms('TURNO','MENSAJE','999718100');exit();



		if ($data->distrito_pdv) {

			$params = array (

				'cod_dist'=>$data->distrito_pdv,

				'comercio_activo'=>$data->comercio_activo,

				'filtros'=>''

			);

			if(isset($params['comercio_activo']) && $params['comercio_activo'] != 0){

				$params['filtros']= " AND tipo_comercio=".$params['comercio_activo'];

			}



			$array['locales_comercio'] = $this->model->filtrado_locales_ubigeo_pdv($params)->result();

			$res = $this->db->query("Select * from  ms_ubigeo where id_ubigeo=".$params['cod_dist']. "")->result();



			$sitio="";

			foreach($res as $row){

				$sitio = $row->distrito;

			}



			$counter  = array();

			$i = 0;

			

			foreach($array['locales_comercio'] as $row){

				$counter[$i++] = $row;

				$sitio = $row->distrito;

			}

				if( count($counter)==0 ) {

					$result['data']['html1']= '<p class="p-info"><i class="fa fa-info-circle"></i> No hay locales disponibles en <b>'.$sitio.'</b></p>';

				} else {

					$result['data']['html1']= $this->load->view("cliente/locales_comercio",$array,true);

				}

		

			}

			echo json_encode($result);

	}

	//---------------------------------------

	//		Obtener Distritos

	//---------------------------------------

	public function obtener_distritos()

	{

		$result = $this->result;

		if ($this->input->post('cod_provincia')) {



			$params2 = array(

				'cod_provincia' =>$this->input->post('cod_provincia'),

				'cod_dep'=>$this->input->post('cod_dep'),

				'filtros'=>''

			);

			$distritos = $this->model->listar_distritos($params2)->result_array();

			$html = "";



			$params2['filtros']= "AND cod_prov=".$params2['cod_provincia'];



			foreach ($distritos as $distrito) {

				$html .= '<option style="color: black;" value="'.$distrito['cod_dist'].'">'.$distrito['distrito'].'</option>';

			}

			$result['html'] = $html;



			$array['locales_comercio'] = $this->model->filtrado_locales_ubigeo($params2)->result();

			$res = $this->db->query("Select * from  ms_ubigeo where cod_prov=".$params2['cod_provincia']." AND cod_dep='".$params2['cod_dep']."'")->result();



			foreach($res as $row){

				$sitio = $row->provincia;

			}



			$comercios  = array();

			$i = 0;

			

			foreach($array['locales_comercio'] as $row){

				$comercios[$i++] = $row;

				$sitio = $row->provincia;

			}

			if(isset($comercios)){

				if( count($comercios)==0 ) {

					$result['data']['html1']= '<p class="p-info"><i class="fa fa-info-circle"></i> No hay locales disponibles en <b>'.$sitio.'</b></p>';

				} else {

					$result['data']['html1']= $this->load->view("cliente/locales_comercio",$array,true);

				}

			}else{

				$result['data']['html1']= '<p class="p-info"><i class="fa fa-info-circle"></i> No hay locales disponibles en <b>'.$sitio.'</b></p>';

			}







			echo json_encode($result);

		}

	}

	//---------------------------------------

	//		Obtener DIRECTORIO DE ESTABLECIMIENTOS

	//---------------------------------------





	public function acceder(){

		$data=json_decode($this->input->post('data'));

		//

		$params = array(

			'usuario' => $data->username

			, 'password' => $data->password

		);

		$result = $this->result;

		$result['status'] = 0;

		//

		$filtros = "";

		if(!empty($params['usuario']) && !empty($params['password'])) {

			$filtros .= " AND u.nombre_usuario = '".$params['usuario']."' AND u.clave = '".$params['password']."'";

			$rs=$this->model->find_usuario_cliente($filtros);

		}else{

			$config_ = array( 'type' => 2, 'message' => "Ocurrió un error al validar sus datos, vuelva a intentarlo." );

			$rs = 0;

		}

		if(!$rs) $result['msg']['content']=$result['msg']['content']=createMessage($config_);

		else{

			$num_rows=count($rs->result_array());

			$config_ = array( 'type' => 2, 'message' => "Los datos ingresados no permiten el acceso.");

			if($num_rows==0) $result['msg']['content']=createMessage($config_);

			else{

				$result['status']=1;

				//

				$usuario_cliente = $rs->row_array();

				$result['result']=1;

				$result['url']= "Cliente";

				$result['msg']['title']="Acceso";

				$config_ = array( 'type' => 1, 'message' => "Bienvenido al sistema <strong>".$usuario_cliente['nombres']." ".$usuario_cliente['ape_paterno']." ".$usuario_cliente['ape_materno']."</strong>");

				$result['msg']['content']=$result['msg']['content']=createMessage($config_);

				$this->session->set_userdata($usuario_cliente);



				$sess_temp = $this->session->userdata('idUsuarioClienteTemp');



				if($sess_temp){

					$sess_cliente = $this->session->userdata('idUsuarioCliente');

					$data_temp = array(

						'idUsuarioCliente' => $sess_cliente,

					);

					$this->db->update('mc_pedido_cliente',$data_temp,'idUsuarioCliente='.$sess_temp);

					$this->session->unset_userdata('idUsuarioClienteTemp');

				

				}

			}

		}



		



		echo json_encode($result);

	}



	public function logout_cliente(){

		$this->session->unset_userdata('id_pedido_cliente');

		$this->session->unset_userdata('nombre_comercio_carrito');

		$this->session->unset_userdata('idUsuarioCliente');

		$this->session->unset_userdata('nombre_usuario');

		$this->session->unset_userdata('idUsuarioClienteTemp');

		$this->session->unset_userdata('nombres');



		$result=array();

			$result['result']=1;

			$result['url']='cliente/';

			$result['data']='';

			$result['msg']['title']='';

			$result['msg']['content']='';



		echo json_encode($result);

	}

	public function obtener_datos_reniec(){

		$data=json_decode($this->input->post('data'));

		$result = $this->result;



		$site = 'http://dniruc.apisperu.com/api/v1/dni/'.$data->dni.'?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6IndlYm1hc3RlckB0dXJuby5tYWNjdGVjLmNvbSJ9.ANgmBhcpvztFEZB9hMpr4Bk1nd-OVEmtgZX5T-Sky74';

		$datos_reniec = @file_get_contents($site);$datos_reniec = json_decode($datos_reniec);



		if(isset($datos_reniec->dni)){

			if($datos_reniec->nombres!=''){

				$result['result'] = 1;

				$result['data']['nombres']= $datos_reniec->nombres;

				$result['data']['apellidos']= $datos_reniec->apellidoPaterno." ".$datos_reniec->apellidoMaterno;

			}else{

				$result['result'] = 2;

				$result['data']['nombres']= "Podrá actualizar sus datos luego.";

				$result['data']['apellidos']= "Podrá actualizar sus datos luego.";

				

			}

		}

		echo json_encode($result);



	}

	public function registrar_cliente(){

		$data=json_decode($this->input->post('data'));

		$result = $this->result;

		//

		$params = array(

			'dni'=>$data->userdni,

		);



		// if($data->username_registro == ''){

		// 	$config_ = array( 'type' => 2, 'message' => "Debe registrar un nombre");

		// 	$result['msg']['content']=createMessage($config_);

		// 	echo json_encode($result);

		// 	exit();

		// }

		// if($data->userapellidopat == ''){

		// 	$config_ = array( 'type' => 2, 'message' => "Debe registrar un apellido paterno");

		// 	$result['msg']['content']=createMessage($config_);

		// 	echo json_encode($result);

		// 	exit();

		// }

		// if($data->userapellidomat == ''){

		// 	$config_ = array( 'type' => 2, 'message' => "Debe registrar un apellido materno");

		// 	$result['msg']['content']=createMessage($config_);

		// 	echo json_encode($result);

		// 	exit();

		// }

		// if($data->userdni == ''){

		// 	$config_ = array( 'type' => 2, 'message' => "Debe registrar un DNI");

		// 	$result['msg']['content']=createMessage($config_);

		// 	echo json_encode($result);

		// 	exit();

		// }

		// if($data->useremail == ''){

		// 	$config_ = array( 'type' => 2, 'message' => "Debe registrar un correo electrónico");

		// 	$result['msg']['content']=createMessage($config_);

		// 	echo json_encode($result);

		// 	exit();

		// }

		// if($data->usertelefono == ''){

		// 	$config_ = array( 'type' => 2, 'message' => "Debe registrar un telefono");

		// 	$result['msg']['content']=createMessage($config_);

		// 	echo json_encode($result);

		// 	exit();

		// }



		// $site = 'http://dniruc.apisperu.com/api/v1/dni/'.$params['dni'].'?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6IndlYm1hc3RlckB0dXJuby5tYWNjdGVjLmNvbSJ9.ANgmBhcpvztFEZB9hMpr4Bk1nd-OVEmtgZX5T-Sky74';



		// $datos_reniec = @file_get_contents($site);$datos_reniec = json_decode($datos_reniec);

			$query = $this->db->get_where('mc_usuario_cliente',array('nro_documento'=>$data->userdni));

				if(($query->num_rows() > 0)){

					$config_ = array( 'type' => 2, 'message' => "El DNI ya se encuentra registrado.");

					$result['msg']['content']=createMessage($config_);

					echo json_encode($result);

					exit();

				}

			$query = $this->db->get_where('mc_usuario_cliente',array('email'=>$data->useremail));

				if(($query->num_rows() > 0)){

					$config_ = array( 'type' => 2, 'message' => "El Correo ya pertenece a otro usuario.");

					$result['msg']['content']=createMessage($config_);

					echo json_encode($result);

					exit();

				}

				if($data->useremail != $data->useremail2){

					$config_ = array( 'type' => 2, 'message' => "Los Correos no coinciden.");

					$result['msg']['content']=createMessage($config_);

					echo json_encode($result);

					exit();

				}

		

		if(isset($params['dni'])){



			$arr_registro = array(



				'nombres' =>$data->username_registro,

				'ape_paterno'=>$data->userapellidopat,

				'ape_materno'=>$data->userapellidomat,

				'nombre_usuario' =>$data->userdni,

				'clave' =>$data->userdni,

				'email' =>$data->useremail,

				'nro_documento' =>$data->userdni,

				'telefono'=>$data->usertelefono,

			);

			$rs = $this->db->insert('mc_usuario_cliente',$arr_registro);

			if($rs){

				$params['usuario'] = $data->userdni;

				$params['password'] = $data->userdni;



				$result['status'] = 0;

				//

				$filtros = "";

				if(!empty($params['usuario']) && !empty($params['password'])) {

					$filtros .= " AND u.nombre_usuario = '".$params['usuario']."' AND u.clave = '".$params['password']."'";

					$rs=$this->model->find_usuario_cliente($filtros);

				}else{

					$config_ = array( 'type' => 2, 'message' => "Ocurrió un error al validar sus datos, vuelva a intentarlo." );

					$rs = 0;

				}

				if(!$rs) $result['msg']['content']=$result['msg']['content']=createMessage($config_);

				else{

					$num_rows=count($rs->result_array());

					$config_ = array( 'type' => 2, 'message' => "Los datos ingresados no permiten el acceso.");

					if($num_rows==0) $result['msg']['content']=createMessage($config_);

					else{

						$result['status']=1;

						//

						$usuario_cliente = $rs->row_array();

						$result['result']=1;

						$result['url']= "Cliente";

						$result['msg']['title']="Login";

						$config_ = array( 'type' => 1, 'message' => "Bienvenido al sistema <strong>".$usuario_cliente['nombres']." ".$usuario_cliente['ape_paterno']." ".$usuario_cliente['ape_materno']."</strong>");

						$result['msg']['content']=$result['msg']['content']=createMessage($config_);

						$this->session->set_userdata($usuario_cliente);

						$sess_temp = $this->session->userdata('idUsuarioClienteTemp');



						if($sess_temp){

							$sess_cliente = $this->session->userdata('idUsuarioCliente');

							$data_temp = array(

								'idUsuarioCliente' => $sess_cliente,

							);

							$this->db->update('mc_pedido_cliente',$data_temp,'idUsuarioCliente='.$sess_temp);

							$this->db->delete('mc_pedido_cliente', array('idUsuarioCliente' => $sess_temp));

							$this->session->unset_userdata('idUsuarioClienteTemp');

						

						}

						

						// $config = array( 'type' => 1, 'message' => 'Se ha registrado correctamente.' );

						// $result['msg']['content'] = createMessage($config);

			

						

						$config = array( 

							'nombre_usuario' =>  $data->username_registro, 

							'usuario' => $data->userdni,

							'clave' => $data->userdni,

							);



						$html=$this->load->view("operacion/correo_notificacion_cliente_registro",$config,true);

						//enviar mensaje

						//correo del admin

						//$email_admin = $this->session->userdata('email');

			

						$correo['to'] =$data->useremail;

						// poner dinamico correos

						// del admin y del cliente enviar

						//

						//$correo['cc'] = $email_admin;

						$titulo='NOTIFICACIÓN TURNO';

						$this->correo($correo,$titulo,$html);

					}

				}

			}else{

			$config_ = array( 'type' => 2, 'message' => "Ocurrió un error al Registrar sus Datos");

			$result['msg']['content']=$result['msg']['content']=createMessage($config_);

			}

			

		}

		else{

			$config_ = array( 'type' => 2, 'message' => "Por favor Ingrese un DNI válido.");

			$result['msg']['content']=$result['msg']['content']=createMessage($config_);

		}

		echo json_encode($result);

	}





	public function obtener_comercios_afiliados(){



		$result = $this->result;

		$result['status'] = 0;

		$tipo_comercio = $this->input->post('nombre_tipo_comercio');

		$params = array(

			'id' => $this->input->post('cod_comercio'),

			

		);

		$array['comercios_afiliados']= $this->model->filtrar_comercios_afiliados($params)->result();

		//

		$filtros = '';

		// $rs = $this->model->find_pedidos($filtros)->result_array();

		$result['result']=1;

		$comercios  = array();

		$i = 0;

		foreach($array['comercios_afiliados'] as $row){

			$comercios[$i++] = $row;

			

		}

		if( count($comercios)==0 ) {

			$array['mensaje'] = '<p class="p-info"><i class="fa fa-info-circle"></i> No se encontraron <b>'.$tipo_comercio.'.</b></p>';

			$result['data']['html1']= $this->load->view("cliente/comercios_afiliados_empty",$array,true);

			$result['data']['html2']= "<p ><a id='home_link' class='enlaces_filtrado'  href='".base_url()."Cliente'>DIRECTORIO DE ESTABLECIMIENTOS</a> / <b>".$tipo_comercio."</b></p>";

		} else {

			

			$result['data']['html1']= $this->load->view("cliente/comercios_afiliados",$array,true);

			$result['data']['html2']= "<p ><a id='home_link' class='enlaces_filtrado' href='".base_url()."Cliente'>DIRECTORIO DE ESTABLECIMIENTOS</a> / <b>".$tipo_comercio."</b></p>";



		}

		echo json_encode($result);



		// echo json_encode($result);

	}	



	public function obtener_platos_comercio(){



		$result = $this->result;

		$result['status'] = 0;

		

		$tipo_comercio = $this->input->post('tipo_comercio');

		$nombre_comercio = $this->input->post('nombre_comercio');

		$cod_tipo_comercio = $this->input->post('cod_tipo_comercio');

		$nombre_local = $this->input->post('local_comercio');

		$cod_local_comercio = $this->input->post('cod_local_comercio');



		$params = array(

			'id' => $this->input->post('cod_comercio'),

			'idLocal' => $cod_local_comercio 

			

		);

		$array['platos_comercio']= $this->model->filtrar_platos_comercio($params)->result();

		//

		$array['cod_local_comercio'] = $cod_local_comercio;

		$filtros = '';

		// $rs = $this->model->find_pedidos($filtros)->result_array();

		$result['result']=1;

		$comercios  = array();

		$i = 0;

		foreach($array['platos_comercio'] as $row){

			$comercios[$i++] = $row;

			$cod_comercio = $row->id_comercio;

			

		}





		// $t = $this->db->get_where('ms_giro',array('id_giro'=>$cod_tipo_comercio))->row_array();



		// $tipo_comercio = $t['nombre'];

		// echo $tipo_comercio;

		// print_r($cod_tipo_comercio);exit();



		if( count($comercios)==0 ) {

			$array['mensaje'] = '<p class="p-info"><i class="fa fa-info-circle"></i> No se encontraron platos en <b>'.$nombre_comercio.'.</b></p>';

			$result['data']['html1']=  $this->load->view("cliente/platos_comercio_empty",$array,true);

			$result['data']['html2']= "<p><a href='".base_url()."Cliente'>DIRECTORIO DE ESTABLECIMIENTOS</a> / <a nombre_tipo_comercio='".$tipo_comercio."' cod_tipo_comercio=".$cod_tipo_comercio." id ='enlace_filtrado' href='javascript:;'> ".$tipo_comercio."</a> / <a  nombre_tipo_comercio='".$tipo_comercio."' cod_tipo_comercio=".$cod_tipo_comercio." id ='enlace_filtrado_locales' href='javascript:;'>".$nombre_comercio."</a> / <b>".$nombre_local."</b></p>";

		} else {

			

			$result['data']['html1']= $this->load->view("cliente/platos_comercio",$array,true);

			$result['data']['html2']= "<p><a href='".base_url()."Cliente'>DIRECTORIO DE ESTABLECIMIENTOS</a> / <a nombre_tipo_comercio='".$tipo_comercio."' cod_comercio=".$cod_comercio." cod_tipo_comercio=".$cod_tipo_comercio." id ='enlace_filtrado' href='javascript:;'> ".$tipo_comercio."</a> / <a nombre_tipo_comercio='".$tipo_comercio."' cod_tipo_comercio=".$cod_tipo_comercio." id ='enlace_filtrado_locales' href='javascript:;'>".$nombre_comercio."</a> / <b>".$nombre_local."</b></p>";

		

		}

		echo json_encode($result);



		// echo json_encode($result);

		

	}	

	

	public function obtener_comercio_local(){



		$result = $this->result;

		$result['status'] = 0;

		

		$tipo_comercio = $this->input->post('tipo_comercio');

		$nombre_comercio = $this->input->post('nombre_comercio');

		$cod_tipo_comercio = $this->input->post('cod_tipo_comercio');



		$params = array(

			'id' => $this->input->post('cod_comercio'),

			

		);

		$array['locales_comercio']= $this->model->filtrar_locales_comercio($params)->result();

		//

		$filtros = '';

		// $rs = $this->model->find_pedidos($filtros)->result_array();

		$result['result']=1;

		$comercios  = array();

		$i = 0;

		foreach($array['locales_comercio'] as $row){

			$comercios[$i++] = $row;

			

		}



		$t = $this->db->get_where('ms_comercio',array('id_comercio' => $params['id']))->row_array();



		$cod_tipo_comercio = $t['id_giro'];



		if( count($comercios)==0 ) {

			$array['mensaje'] = '<p class="p-info"><i class="fa fa-info-circle"></i> No se encontraron locales <b>'.$nombre_comercio.'.</b></p>';

			$result['data']['html1']= $this->load->view("cliente/locales_comercio_empty",$array,true);

			$result['data']['html2']= "<p><a href='".base_url()."Cliente'>DIRECTORIO DE ESTABLECIMIENTOS</a> / <a nombre_tipo_comercio='".$tipo_comercio."' cod_tipo_comercio=".$cod_tipo_comercio." id ='enlace_filtrado' href='javascript:;'> ".$tipo_comercio."</a> / <b>".$nombre_comercio."</b></p>";

		} else {

			

			$result['data']['html1']= $this->load->view("cliente/locales_comercio",$array,true);

			$result['data']['html2']= "<p><a href='".base_url()."Cliente'>DIRECTORIO DE ESTABLECIMIENTOS</a> / <a nombre_tipo_comercio='".$tipo_comercio."' cod_tipo_comercio='".$cod_tipo_comercio."' id ='enlace_filtrado' href='javascript:;'> ".$tipo_comercio."</a> / <b>".$nombre_comercio."</b></p>";

		}

		echo json_encode($result);



		// echo json_encode($result);

		

	}	



	public function cliente_listar_pedidos(){

		$data=json_decode($this->input->post('data'));

		

		$result = $this->result;

		$result['status'] = 0;

		$idUsuario_cliente = $this->session->userdata('idUsuarioCliente');



		if(!$idUsuario_cliente){

			$idUsuario_cliente = $this->session->userdata('idUsuarioClienteTemp');

		}

		// echo $idUsuario_cliente; exit();

		$params = array(

			'idPedidoCliente' => $idUsuario_cliente,

		);



		$array['listado_pedidos'] = $this->model->lista_pedidos_cliente($params)->result();



		// print_r($array['listado_pedidos']);exit();

		//

		$filtros = '';

		// $rs = $this->model->find_pedidos($filtros)->result_array();

		$result['result']=1;



		$val  = array();

		$i = 0;

		$idLocal = 0;

		foreach($array['listado_pedidos'] as $row){

			$val[$i++] = $row;

			$array['cod_usuario_ped'] = $row->idUsuarioCliente;

			$id_pdv = $row->idComercioLocal;

			$array['id_pedido'] = $row->idPedidoCliente;

		}



		if(count($array['listado_pedidos']) <1){

			$id_pdv = 0;

		}



		$rs = $this->model->getDatosFiltroComercio($id_pdv);



		foreach($rs->result() as $row){

			$array['id_giro'] = $row->id_giro;

			$array['giro'] = $row->giro;

			$array['id_comercio'] = $row->id_comercio;

			$array['comercio'] = $row->comercio;

			$array['id_pdv'] = $row->id_pdv;

			$array['pdv'] = $row->local;

		}

		

		if( count($val)==0 ) {

			$result['data']['html1']= '<p class="p-info"><i class="fa fa-info-circle"></i> No se encontraron pedidos pendientes.</p>';

		} else {

			$result['data']['html1']= $this->load->view("cliente/listado_pedidos_cliente",$array,true);

			// $result['data']['notificacion']= count($val);

		}

		echo json_encode($result);



		// echo json_encode($result);

		

	}	

		public function pasar_pedido_cliente_despacho(){

		$data=json_decode($this->input->post('data'));

		

		// print_r ($data); exit();

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

		$fecha_nuevo_ped = $fecha;



		$medio_entrega_nuevo_ped = $data->metodo_despacho;

		$id_pedido = $this->session->userdata('id_pedido_cliente');

		$id_pedido_nuevo = $id_pedido;

		if($id_pedido){

			$result['result']=1;

			$rsu = $this->db->update('mc_pedido_cliente', $arr_insert, "idPedidoCliente=".$id_pedido);

			if($rsu){

				$arr_insert = array(

					'idPedidoCliente' =>$id_pedido,

					'idPedidoEtapa' =>$arr_insert['estado_pedido']

				);

				$this->db->insert('mc_pedido_etapa_detalle',$arr_insert);

				$config_ = array( 'type' => 1, 'message' => "Te informamos que tu pedido será recibido y confirmado por el establecimiento vía correo electrónico. <p><b>Si elegiste pago en línea, te incluiremos el link de pago</b></b>" );



				$result['data']['content']= createMessage($config_);

				$this->session->unset_userdata('id_pedido_cliente');

				$this->session->unset_userdata('nombre_comercio_carrito');

				$this->session->unset_userdata('id_pedido_cliente');

				$this->session->unset_userdata('nombre_comercio_carrito');







				/*Correo al Admin de Comercio*/



				$pedido = $this->db->get_where('mc_pedido_cliente_detalle',array('idPedidoCliente'=>$id_pedido_nuevo))->result();



				if(count($pedido) > 0){

					$total_final = 0;

					foreach($pedido as $row){

						$total_final += $row->importe;

						

					}

					$pedido =  $this->db->get_where('mc_pedido_cliente',array('idPedidoCliente'=>$id_pedido_nuevo))->row_array();

					$cod_comercio = $pedido['idComercio'];

					$cod_local = $pedido['idComercioLocal'];

					// print_r($arr_insert);exit

					if($medio_entrega_nuevo_ped == 1){

						$costo_envio = $data->costo_envio;

					}else{

						$costo_envio = 0;

					}

					$filtros = "AND uh.id_usuario_perfil = 3";

					$sql = $this->m_pedidos->get_usuarios_comercio($cod_comercio,$filtros)->result();

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

					$sql = $this->m_pedidos->get_usuarios_comercio($cod_comercio,$filtros)->result();



					if(count($sql) > 0){

						foreach($sql as $row){

			

							$config = array( 

			

								'fecha_hora' => $fecha_nuevo_ped,

								'idPedidoCliente' =>$id_pedido_nuevo,

								'total_final_envio'=>$total_final + $costo_envio,

								'punto_de_venta'=>$local['nombre'],

								'Perfil_usuario' => 'Multitareas / Adm Local',



							);

			

							$html=$this->load->view("operacion/correo_notificacion_nuevo_pedido",$config,true);

			

							$correo['to'] =$row->email;

							$titulo='NOTIFICACIÓN TURNO';

							$this->correo($correo,$titulo,$html);



						}

					}

				}

				



			}else{

				$result['data']['content']= '<p class="p-info"><i class="fa fa-info-circle"></i> No se pudo completar el pedido</p>';

			}

			

		}else{

			$result['data']['content']= '<p class="p-info"><i class="fa fa-info-circle"></i> No se pudo completar el pedido</p>';

		}



		echo json_encode($result);



		}



		public function cargar_form_pedido_confirmado(){

		$data=json_decode($this->input->post('data'));



		// print_r($data);exit(); 

		$data->cod_ped;



		$sess_ped = array(

			'id_pedido_cliente' => $data->cod_ped,

		);



		$this->session->set_userdata($sess_ped);

		$result = $this->result;

		$result['status'] = 0;

		$idUsuario_cliente = $this->session->userdata('idUsuarioCliente');

		// echo $idUsuario_cliente; exit();

		if(!$idUsuario_cliente){

			$idUsuario_cliente = $this->session->userdata('idUsuarioClienteTemp');

		}

		



		$params = array(

			'idPedidoCliente' => $idUsuario_cliente,

			'idDetallePedido'=>$data->cod_ped_env_det,



		);

		$array_insert = array(

			'cantidad' => $data->cantidad_confirmada,

			'comentario' =>$data->observaciones,



		);

		

		$row_detalle = $this->model->getSetDetallePedido($params)->row_array();



		$array_insert['importe'] = (($data->cantidad_confirmada*$row_detalle['precio_unitario']) + ($row_detalle['empaque'] *$data->cantidad_confirmada ));



		$rsu = $this->db->update('mc_pedido_cliente_detalle', $array_insert, "idDetallePedido=".$params['idDetallePedido']);

		

		// echo $this->db->last_query();exit();

		$filtros = '';

		$result['result']=1;

		

		$array['listado_pedidos']= $this->model->lista_pedidos_cliente($params)->result();



		$filtros = '';

		$result['result']=1;

		

		// $val  = array();

		$i = 0;

		foreach($array['listado_pedidos'] as $row){

			$array['cod_usuario_ped'] = $row->idUsuarioCliente;

			$params['idComercio'] =$row->idComercio ;

			$idLocal = $row->idComercioLocal;

			$idComercio = $row->idComercio;

			$precio_u = $row->precio_unitario;

			$empaque = $row->empaque;

			$val[$i++] = $row;

		}

		$array['metodos_pago'] = $this->model->get_metodo_pago_disponible($params['idComercio'])->result();

		$array['metodos_entrega'] = $this->model->get_metodo_entrega_disponible($params['idComercio'])->result();

		

		$array['delivery_general'] = $this->model->get_costo_delivery($idComercio)->row_array();

		$array['distritos'] = $this->model->get_ubigeo_local_1($idLocal)->result_array();

		if(empty($array['distritos'])) $array['distritos'] = $this->model->get_ubigeo_local_2($idLocal)->result_array();

		

		// $array['locales_disponibles']= $this->model->filtrar_locales_disponibles($params)->result();;

	

		if( count($val)==0 ) {

			$result['data']['html1']= '<p class="p-info"><i class="fa fa-info-circle"></i> No se encontraron despachos pendientes.</p>';

		} else {

			$result['data']['html1']= $this->load->view("cliente/frm_despacho_pedido",$array,true);



			



			// $result['data']['notificacion']= count($val);

			// $result['data']['html1'] = $params['idDetallePedido']."<br>";

		}

		echo json_encode($result);



	

		

	}	



	public function cliente_agregar_pedidos(){

		// $this->session->sess_destroy();exit();



		$data=json_decode($this->input->post('data'));

		$cod_cliente = $this->session->userdata('idUsuarioCliente');

		$nombre_usuario =$this->session->userdata('nombre_usuario');

		$cod_local =$this->session->userdata('id_local');

		$user_temp = $this->session->userdata('idUsuarioClienteTemp');

		if(!$nombre_usuario){

			if($user_temp){

				$cod_cliente = $this->session->userdata('idUsuarioClienteTemp');

				$nombre_usuario = 'ANONIMO_TEMP';

			}else{



				$reg_temp = array(

					'nombres' => "ANONIMO_TEMP",

				);

				$res_temp = $this->db->insert('mc_usuario_cliente',$reg_temp);

				

				if($res_temp){

					$cod_cliente = $this->db->insert_id();

					$nombre_usuario = $reg_temp['nombres'];

				$sess_temp = array(

					'idUsuarioClienteTemp' => $cod_cliente,

				);



				$this->session->set_userdata($sess_temp);

				

					}

				}

			}



		if($nombre_usuario){



		$result = $this->result;

		$result['status'] = 0;

		

		$params = array(

			'cod_comercio' => $data->cod_comercio,

			'cantidad_platos' => $data->cantidad_pedidos,

			'cod_plato' =>$data->cod_plato,

			'cod_local_comercio' =>$data->cod_local_comercio

		);

		

		if(isset($cod_cliente)){$params['cod_cliente']=$cod_cliente;}





		$filtros = array(

			'idPedidoCliente' => $cod_cliente,	

		);



		$pedido_previo = $this->model->lista_pedidos_cliente($filtros)->result_array();



		if(count($pedido_previo)>0){

			if($pedido_previo[0]['idComercio'] != $params['cod_comercio']){

				$result['result']=1;

				$config_ = array('type'=> 2,'message'=> 'Antes de continuar debe completar la compra pendiente en su carrito');

				$result['data']['message'] = createMessage($config_);

				echo json_encode($result);

				exit();

			}

		}



		$array['comercio_pedido']= $this->model->filtrar_pedido_plato_comercio($params)->result();

		foreach($array['comercio_pedido'] as $row){

			$nombre_comercio = $row->comercio;

			$precio_plato = $row->precio;

			if($row->empaque !=''){

				$costo_empaque = $row->empaque;

			}else $costo_empaque = 0;

		}

		if($nombre_comercio != $this->session->userdata('nombre_comercio_carrito')){

			

			$this->session->unset_userdata('nombre_comercio_carrito');

		}

		/*=====Pedido======*/

		$nombre_comercio_carrito = $this->session->userdata('nombre_comercio_carrito');

		if(!isset($nombre_comercio_carrito)){

			$arr_insert_pedidos = array(

				'idUsuarioCliente' => $params['cod_cliente'],

				'idComercio' => $params['cod_comercio'],

				'idComercioLocal' => $params['cod_local_comercio']

			);

			$rs =$this->db->insert('mc_pedido_cliente',$arr_insert_pedidos);

			$id_pedido = $this->db->insert_id();

			$session_carrito = array(

				'nombre_comercio_carrito' => $nombre_comercio,

				'id_pedido_cliente' => $id_pedido,

			);

			$this->session->set_userdata($session_carrito);



		}else{

			$id_pedido = $this->session->userdata('id_pedido_cliente');

		}

		/*=====Pedido Detalle======*/

		$importe = ($params['cantidad_platos'] * ($precio_plato + $costo_empaque)) ;

		$arr_insert_pedidos_detalles = array(

			'cantidad' => $params['cantidad_platos'],

			'importe' => $importe,

			'idPlatoComercio'=> $params['cod_plato'],

			'idPedidoCliente'=> $id_pedido,

		);

		$filtros = array(

			'idUsuarioCliente' => $cod_cliente,

			'idPlatoComercio' => $params['cod_plato'],

		);



		$plato_previo = $this->model->obtener_plato_pedido_cliente($filtros)->row_array();



		if(count($plato_previo) > 0){



			$importe = ($params['cantidad_platos'] * ($precio_plato + $costo_empaque)) + $plato_previo['importe'] ;

			$arr_insert_pedidos_detalles = array(

				'cantidad' => $params['cantidad_platos'] + $plato_previo['cantidad'],

				'importe' => $importe,

			);

			$this->db->update('mc_pedido_cliente_detalle',$arr_insert_pedidos_detalles,array('idDetallePedido' =>$plato_previo['idDetallePedido'] ));

		}else{

			$rs2 = $this->db->insert('mc_pedido_cliente_detalle',$arr_insert_pedidos_detalles);

		}



		



		$result['result']=1;

	

		if($cod_local){

			$result['data']['message'] = "<i class='fas fa-check-circle'></i> Se envio el pedido al <b>Carrito</b>" ;

		}else{

			$result['data']['message'] = "<i class='fas fa-check-circle'></i> Pedido agregado a <b>"."Carrito"."</b>" ;

		}

	}else{



		$result['data']['message'] = "<i class='fas fa-check-circle'></i> Primero debe Iniciar Sesion!" ;

	}

		

		echo json_encode($result);



		// echo json_encode($result);

		

	}



	public function cargar_login_cliente(){

		$data=json_decode($this->input->post('data'));



		$result = $this->result;

		$result['status'] = 0;

		$array = array();

		$array['redirect'] = $data->redirect;

		$result['data']['html'] = $this->load->view('cliente/login_cliente',$array,true); 

		echo json_encode($result);

	}	



	public function form_cambiar_clave_usuario(){

		$data=json_decode($this->input->post('data'));



		$result = $this->result;

		$array = array();

		$result['data']['html'] = $this->load->view('cliente/cambiar_clave',$array,true); 

		echo json_encode($result);

	}	

	public function cambiar_clave_usuario(){

		$data=json_decode($this->input->post('data'));



		$arr_update = array(

			'clave' => $data->nuevaClave,

		);

		$cod_cliente = $this->session->userdata('idUsuarioCliente');

		if(!$cod_cliente){

			$config_ = createMessage(array('type'=>2,"message"=>"Debe volver a Iniciar Sesion para cambiar la clave"));

			$result['result'] = 0;

			$result['data']['message'] = $config_; 

			echo json_encode($result);

			exit();

		}	

		$rs = $this->db->update('mc_usuario_cliente',$arr_update,array('idUsuarioCliente' => $cod_cliente));



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



	public function listado_mis_pedidos(){

		$data=json_decode($this->input->post('data'));

		$result = $this->result;

		$cod_cliente = $this->session->userdata('idUsuarioCliente');



		$params = array(

			'id' => $cod_cliente,

		);



		$array['data'] = $this->model->listado_de_mis_pedidos($params)->result();



		$result['data']['html'] = $this->load->view('cliente/listado_mis_pedidos',$array,true); 

		echo json_encode($result);



	}

	public function eliminar_articulo_carrito(){

		$data=json_decode($this->input->post('data'));

		$result = $this->result;

		$this->db->trans_begin();

			$rs = $this->db->delete('mc_pedido_cliente_detalle', array('idDetallePedido' => $data->id_det_ped));

		if ($this->db->trans_status() === FALSE)

		{

				$this->db->trans_rollback();

		}

		else

		{

				$this->db->trans_commit();

				$result['result'] = 1;

		}



		echo json_encode($result);



	}



	public function ver_mis_pedidos(){

		$data=json_decode($this->input->post('data'));

		$cod_cliente = $this->session->userdata('idUsuarioCliente');



		$result = $this->result;

		$result['status'] = 0;

		$array = array();



		$params = array(

			'idUsuarioCliente' => $cod_cliente,

			'idPedidoCliente' => $data->pedidos[0]

		);

		

		$array['mis_pedidos'] = $this->model->listar_mis_pedidos($params)->result();

		$array['listado_pedidos']= $this->model->listado_mis_pedidos($params)->result();

		

		// print_r ($array['listado_pedidos']);exit();



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

		

		echo json_encode($result);

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

		

        $this->email->from('turno.macctec@gmail.com','TURNO - Bienvenido');        

        if(isset($correo['to']) && !empty($correo['to'])){

			$this->email->to($correo['to']);

			if(isset($correo['cc']) && !empty($correo['cc'])) $this->email->cc($correo['cc']);



			$this->email->subject($titulo);

			$this->email->message($contenido);

			

			if(!$this->email->send()) log_message('error', $this->email->print_debugger());

			else log_message('info', 'Se envió correctamente el correo. -> '.$titulo);

		}

    }



}


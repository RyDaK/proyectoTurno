<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comercios extends MY_Controller {
	
	public function __construct(){
		parent::__construct(); 
		$this->load->model('M_Comercio','model');
	}
	
	public function index()
	{
		$config['css']['style']=array('../../core/libs/dataTables-1.10.20/datatables');
		$config['js']['script']=array('../../core/libs/dataTables-1.10.20/datatables','../../core/libs/dataTables-1.10.20/datatables-defaults','comercios');
		$config['nav']['menu_active']='19';
		//
		$config['data']['icon']='fa fa-utensils';
		$config['data']['title']='Mis Establecimientos';
		$config['view']='operacion/mis_comercios';
		$config['data']['message']='Desde aqui podras configurar un nuevo establecimiento para el directorio en la web publica de turno';
		$config['data']['giros'] = $this->model->get_giros()->result_array();
		$config['data']['rubros'] = $this->model->get_rubros()->result_array();
		
		$this->view($config);
	}
	public function obtener_giros_rubro(){
		$result = $this->result;
		$result['status'] = 0;

		$data=json_decode($this->input->post('data'));

		$array['data'] = $this->model->get_giros_rubro($data->id_rubro)->result();

		$html ='';
		$html .= "<option value=''>--Seleccione--</option>";

		foreach($array['data'] as $row){
				$html .= "<option value=".$row->id_giro." >".$row->nombre."</option>";
		}
		$result['data']['select'] = $html;

		/*	
		$html.= "	<option value="<?=$row['id_rubro']?>"  <?= isset($comercio['id_rubro']) ? ($comercio['id_rubro']==$row['id_rubro'] ? "SELECTED" : "" ) : "" ?>   ><?=$row['nombre']?></option>"
*/
		echo json_encode($result);


	}
	
	public function registrar2(){
		$config = array( 
			'razon_social' => "prueba", 
			'usuario' => "ISIARO",
			'clave' => "CLAVO"
		 );
		$html=$this->load->view("operacion/correo_notificacion",$config,true);
		//enviar mensaje
		$correo['to'] = 'fernandezcprog@gmail.com';
		$correo['cc'] = 'fernandezcprog@gmail.com';
		$titulo='NOTIFICACION TURNO';
		$this->correo($correo,$titulo,$html);
	}

	public function registrar(){
		$result = $this->result;
		$result['status'] = 0;

		$data=json_decode($this->input->post('data'));
		//
		$nombre_comercial=$data->{'nombre_comercial'};
		//		
		$filtro=" and nombre='".$nombre_comercial."' and nombre not like '' ";
		$rs_nombre_comercial=$this->model->val_comercio($filtro)->result_array();

		if( !count($rs_nombre_comercial)>0 ){
			$params =  array(
				'nombre' => $data->{'nombre_comercial'}
			  , 'razon_social' => $data->{'razon_social'}
			  , 'ruc' => $data->{'ruc'}
			  , 'estado' => 1
			  , 'telefono' => $data->{'telefono'}
			  , 'creditosActual'=> ($data->{'creditos_turno'}!="") ? $data->{'creditos_turno'} :null
			  , 'nro_documento' => $data->{'dni'}
			  ,'id_rubro' => ($data->{'id_rubro_p'}!="") ? $data->{'id_rubro_p'} : null
			 ,'id_giro' =>($data->{'id_giro_p'}!="") ? $data->{'id_giro_p'} : null
			);
			$estado = $this->model->set_comercio($params);
			$id_comercio = $this->mysql_last_id();
	
			if($data->{'creditos_turno'}!=""){
				$params =  array(
					'id_comercio' =>$id_comercio
					, 'fecIni' => date('Y-m-d')
					, 'estado' => 1
					, 'creditosCarga'=> ($data->{'creditos_turno'}!="") ? $data->{'creditos_turno'} :null
				);
				$estado = $this->model->set_comercio_credito($params);
			}
			$metodo_pago = array(
				'id_metodo_pago' =>1,
				'id_comercio' => $id_comercio
			);
			$this->db->insert('ms_metodo_pago_comercio',$metodo_pago);
	
			//usuario
			$usuario= substr($data->{'nombre'},0,1).$data->{'apePaterno'}; //($data->{'dni_representante'}!="")  ? $data->{'dni_representante'} : $data->{'ruc'}  ;
			//clave
			$alphabet = 'abcdefghijklmnopqrstuvwxyz1234567890';
			$clave = array();
			$alphaLength = strlen($alphabet) - 1;
			for ($i = 0; $i < 6; $i++) {
				$n = rand(0, $alphaLength);
				$clave[] = $alphabet[$n];
			}
			$clave_=implode($clave);
	
			$params =  array(
				'nombres' => $data->{'nombre'}
				, 'ape_paterno' => $data->{'apePaterno'}
				, 'ape_materno' => $data->{'apeMaterno'}
				, 'nombre_usuario'=> $usuario
				, 'clave' => $clave_
				, 'email' => $data->{'email'}
				, 'nro_documento' => null//$data->{'dni_representante'}
				, 'estado' => 1
			);
			$estado = $this->model->set_usuario($params);
			$id_usuario = $this->mysql_last_id();
			if($estado){
				$id_pdv = $this->mysql_last_id();
				if(is_array($data->{'proyecto'})){
					for($i=0;$i<sizeof($data->{'proyecto'});$i++){
						$params =  array(
							'fecIni' => date('Y-m-d')
							, 'id_comercio' => $id_comercio
							, 'id_proyecto' => $data->{'proyecto'}[$i]
							,  'estado'=> 1
						);
						$estado = $this->model->set_comercio_historico($params);
					}
				}else{
					$id_proyecto=$data->{'proyecto'};
					$params =  array(
						'fecIni' => date('Y-m-d')
						, 'id_comercio' =>$id_comercio
						, 'id_proyecto' => $id_proyecto
						,  'estado'=> 1
					);
					$estado = $this->model->set_comercio_historico($params);
				}
	
				$params =  array(
					'fecIni' => date('Y-m-d')
					, 'estado' => 1
					, 'id_usuario' => $id_usuario
					, 'id_usuario_perfil' => 2
					, 'id_comercio' => $id_comercio
				);
				$estado = $this->model->set_usuario_hist($params);
	
				//se agregan staticamente los menus de permisos
				// $rs_menus=$this->model->get_menus()->result_array();
				// foreach($rs_menus as $row){
				// 	$params =  array(
				// 		'estado' => 1
				// 		, 'id_menu' => $row['id_menu']
				// 		, 'id_usuario' => $id_usuario
				// 	);
				// 	$this->model->set_usuario_menu($params);
				// }
	
				$params =  array(
					'estado' => 1
					, 'id_menu' => 10
					, 'id_usuario' => $id_usuario
				);
				$estado = $this->model->set_usuario_menu($params);
				
				$params =  array(
					'estado' => 1
					, 'id_menu' => 20
					, 'id_usuario' => $id_usuario
				);
				$estado = $this->model->set_usuario_menu($params);
	
				$params =  array(
					'estado' => 1
					, 'id_menu' => 12
					, 'id_usuario' => $id_usuario
				);
				$estado = $this->model->set_usuario_menu($params);
	
	
				$params =  array(
					'estado' => 1
					, 'id_menu' => 21
					, 'id_usuario' => $id_usuario
				);
				$estado = $this->model->set_usuario_menu($params);
	
				$params =  array(
					'estado' => 1
					, 'id_menu' => 22
					, 'id_usuario' => $id_usuario
				);
				$estado = $this->model->set_usuario_menu($params);
	
				$params =  array(
					'estado' => 1
					, 'id_menu' => 23
					, 'id_usuario' => $id_usuario
				);
				$estado = $this->model->set_usuario_menu($params);
	
				$result['data'] = 0;
				$result['status'] = 1;
				$config = array( 'type' => 1, 'message' => 'Se ha registrado correctamente' );
				$result['msg']['content'] = createMessage($config);
	
				
				$config = array( 
					'nombre' => $data->{'nombre_comercial'},
					'nombre_u' => ($data->{'nombre'}." ".$data->{'apePaterno'}." ".$data->{'apeMaterno'}),
					'razon_social' =>  $data->{'razon_social'}, 
					'usuario' => $usuario,
					'clave' => $clave_
					);
	
				$html=$this->load->view("operacion/correo_notificacion",$config,true);
				//enviar mensaje
				//correo del admin
				//$email_admin = $this->session->userdata('email');
	
				$correo['to'] =$data->{'email'};
				// poner dinamico correos
				// del admin y del cliente enviar
				//
				//$correo['cc'] = $email_admin;
				$titulo='NOTIFICACIÓN TURNO';
				$this->correo($correo,$titulo,$html);
	
			}else{
				$result['status'] = 0;
				$result['data'] = 0;
				$config = array( 'type' => 2, 'message' => 'No se logro registrar el cliente, intentelo nuevamente' );
				$result['msg']['content'] = createMessage($config);
			}

		}else{
			$result = $this->result;
			$result['status'] = 0;
			$result['data'] = 0;
			if(count($rs_nombre_comercial)>0){
				$config = array( 'type' => 2, 'message' => 'No se ha pudo registrar. Ya existe un comercio con el mismo nombre comercial' );
			} else{
				$config = array( 'type' => 2, 'message' => 'No se ha podido registrar, intentelo nuevamente' );
			}
			$result['msg']['content'] = createMessage($config);
		}
		
		//
		echo json_encode($result);
	}

	function correo($correo=array(),$titulo,$contenido,$archivos_adjuntos = array()){
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
		
        $this->email->from('turno.macctec@gmail.com','TURNO - Notificacion');        
        if(isset($correo['to']) && !empty($correo['to'])){
			$this->email->to($correo['to']);
			if(isset($correo['cc']) && !empty($correo['cc'])) $this->email->cc($correo['cc']);

			$this->email->subject($titulo);
			$this->email->message($contenido);
			
			if(!$this->email->send()) log_message('error', $this->email->print_debugger());
			else log_message('info', 'Se envió correctamente el correo. -> '.$titulo);
		}
    }

	public function carga_creditos(){
		$result = $this->result;
		$result['status'] = 0;
		$data=json_decode($this->input->post('data'));
		if(isset($data->{'comercio'})){
			$id_comercio="";
			if(is_array($data->{'comercio'})){
				if( isset($data->{'comercio'}[0]) ){
					$id_comercio=$data->{'comercio'}[0];
				}
			}else{
				$id_comercio=$data->{'comercio'};
			}

			if( $id_comercio!="" ){
				//
				$array = array(
					'comercio' => $this->model->get_comercio($id_comercio)->row_array()
					,'comercio_historico' => $this->model->get_comercio_credito($id_comercio)->result_array()
					, 'id_comercio' => $id_comercio
				);
				$result = $this->result;
				$result['status'] = 1;
				$result['data']['html']=$this->load->view("operacion/carga_creditos",$array,true);
			}else{
				$result['data'] = 0;
				$result['status'] = 2;
				$config = array( 'type' => 2, 'message' => 'No hay comercios seleccionados' );
				$result['msg']['content'] = createMessage($config);
			}

		}else{
			$result['data'] = 0;
			$result['status'] = 2;
			$config = array( 'type' => 2, 'message' => 'No hay comercios seleccionados' );
			$result['msg']['content'] = createMessage($config);
		}
		//
		echo json_encode($result);
	}

	public function agregar_credito(){
		$result = $this->result;
		$result['status'] = 0;
		$data=json_decode($this->input->post('data'));

		$fecFin="";
		if(isset($data->{'txt-fechas_simple'})){
			$fecFin=$data->{'txt-fechas_simple'};
			$fecFin = date("Y-d-m", strtotime($fecFin));
		}

		if(isset($data->{'creditos'})){
			if( $data->{'id_comercio'}!="" ){
				//
				$params = array(
					'id_comercio' => $data->{'id_comercio'}
					,'fecIni' => date('Y-m-d')
					,'estado' => 1
					,'creditosCarga' => $data->{'creditos'}
				);
				//,'fecFin' => ($fecFin!="") ? $fecFin :null
				$estado=$this->model->set_comercio_credito($params);

				if($estado){
					// sumar creditos
					$creditos_actual=0;
					$rs_creditos=$this->model->get_comercio($data->{'id_comercio'})->row_array();
					if( isset($rs_creditos['creditosActual'])){
						if($rs_creditos['creditosActual']!=""){
							$creditos_actual=$rs_creditos['creditosActual'];
						}
					}
					$cred_ant=$creditos_actual;
					$creditos_actual+=$data->{'creditos'};

					$params = array(
						'creditosActual' => $creditos_actual
					);
					$where = array(
						'id_comercio' =>  $data->{'id_comercio'}
					);
					
					$estado=$this->model->update_comercio($params,$where);

					if($estado){
						$fecha=date('Y-m-d');
						$config = array( 
							'comercio' =>  $rs_creditos, 
							'fecha' =>  date_change_format($fecha),
							'creditos_recarga' => $data->{'creditos'},
							'creditos_ant' => $cred_ant,
							'creditos_act' => $creditos_actual
							);
	
						$html=$this->load->view("operacion/correo_notificacion_recarga",$config,true);
						//enviar mensaje
						//correo del admin
						//$email_admin = $this->session->userdata('email');
						$rs_correo=$this->model->get_usuario_perfil($data->{'id_comercio'},$fecha,2)->row_array();
						$correo['to'] =$rs_correo['email'];
						// poner dinamico correos
						// del admin y del cliente enviar
						//
						//$correo['cc'] = $email_admin;
						$titulo='NOTIFICACIÓN TURNO-RECARGA';
						$this->correo($correo,$titulo,$html);
					}
					
				}
				$result = $this->result;
				$result['data'] = 0;
				$config = array( 'type' => 1, 'message' => 'Se ha añadido crédito correctamente' );
				$result['msg']['content'] = createMessage($config);
			}

		}else{
			$result['data'] = 0;
			$config = array( 'type' => 2, 'message' => 'No hay comercios seleccionados' );
			$result['msg']['content'] = createMessage($config);
		}
		//
		echo json_encode($result);
	}

	public function edit_comercio(){
		$result = $this->result;
		$result['status'] = 0;
		$data=json_decode($this->input->post('data'));
		$fecha=date('Y-m-d');
		if(isset($data->{'comercio'})){
			$id_comercio="";
			if(is_array($data->{'comercio'})){
				if( isset($data->{'comercio'}[0]) ){
					$id_comercio=$data->{'comercio'}[0];
				}
			}else{
				$id_comercio=$data->{'comercio'};
			}

			if( $id_comercio!="" ){
				//
				$usuario = $this->model->get_usuario($id_comercio,$fecha)->row_array();
				$id_usuario=$usuario['id_usuario'];

				$arr_hist=array();
				$rs_com_hist=$this->model->get_comercio_historico($id_comercio,$fecha)->result_array();
				foreach($rs_com_hist as $row){
					$arr_hist[$row['id_proyecto']]=$row;
				}

				$array = array(
					  'giros' => $this->model->get_giros()->result_array()
					, 'rubros' => $this->model->get_rubros()->result_array()
					, 'comercio' => $this->model->get_comercio($id_comercio)->row_array()
					, 'puntos_venta' => $this->model->get_puntos_venta($id_comercio)->result_array()
					, 'usuario' => isset($usuario) ? $usuario : null 
					, 'id_comercio' => $id_comercio
					, 'id_usuario' => isset($id_usuario) ? $id_usuario : null
					, 'historico' => $arr_hist
				);
				$array['metodo_pago_comercio'] = $this->model->get_metodo_pago_comercio($id_comercio)->result();
				$evit_metodo= array();
				$ite = 0;
				foreach($array['metodo_pago_comercio'] as $row){

					$evit_metodo[$ite++] = $row->id_metodo_pag; 
				};
				$new_evit_metodo = implode(',',$evit_metodo);
			

				$array['metodos_pago'] = $this->model->get_metodo_pago($new_evit_metodo)->result();
				

				$result = $this->result;
				$result['status'] = 1;
				$result['data']['html']=$this->load->view("operacion/edit_comercio",$array,true);
			}else{
				$result = $this->result;
				$result['data'] = 0;
				$result['status'] = 2;
				$config = array( 'type' => 2, 'message' => 'No hay comercios seleccionados' );
				$result['msg']['content'] = createMessage($config);
			}

		}else{
			$result = $this->result;
			$result['data'] = 0;
			$result['status'] = 2;
			$config = array( 'type' => 2, 'message' => 'No hay comercios seleccionados' );
			$result['msg']['content'] = createMessage($config);
		}
		//
		echo json_encode($result);
	}
	
	public function agregar_metodo_comercio(){
		$result = $this->result;
		$result['status'] = 0;
		$data=json_decode($this->input->post('data'));
			if(is_array($data->{'comercio'})){
				if( isset($data->{'comercio'}[0]) ){
					$id_comercio=$data->{'comercio'}[0];
				}
			}else{
				$id_comercio=$data->{'comercio'};
		}
		$array['fila_metodo_pago'] = $this->model->get_metodo_pago_id($data->id_metodo)->result();

		$array['metodo_pago_comercio'] = $this->model->get_metodo_pago_comercio($id_comercio)->result();
		$evit_metodo= array();
		$ite = 0;
		foreach($array['metodo_pago_comercio'] as $row){

			$evit_metodo[$ite++] = $row->id_metodo_pag; 
		};
		$new_evit_metodo = implode(',',$evit_metodo);
		$array['metodos_pago'] = $this->model->get_metodo_pago($new_evit_metodo)->result();
		

		$html = "";
		$id_temp=0;
		// $i=$data->bucle;
		foreach($array['fila_metodo_pago'] as $row){
			 $id_temp++;
			 $params = array(
				 'id' => $id_temp,
				 'nombre'=> $row->nombre
			 );
			$html .= "<tr id='metodo_temp".$id_temp."'>";
				$html .= "<td><li style='color:red'  onclick='Comercios.eliminar_fila_temp(".json_encode($params).")' class='fas fa-trash'></li></td>";
				$html .= "<td data-idpag='".$row->id_metodo_pag."'>".$row->nombre."</td>";
			$html .= "</tr>";
		}
		if( count($array['fila_metodo_pago'])==0 ) {
			$config = array( 'type' => 2, 'message' => 'Ocurrio un error al agregar el metodo de pago' );
			$result['msg']['content'] = createMessage($config);
			$result['data']['rows'] = 0;
			$result['result']=0;
			echo json_encode($result);
			exit();
		} else {
			$result['result']=1;
			$result['data']['tabla'] = $html;
		}
		$select='<option value="">--Seleccione--</option>';
		foreach($array['metodos_pago'] as $row){
			if(count($array['metodos_pago']) >=1){
				$select .= "<option value=".$row->id_metodo_pag.">".$row->nombre."</option>";
			}
		}
			$result['data']['select'] = $select;


		echo json_encode($result);
	}

	public function eliminar_fila_pago_comercio(){
		$result = $this->result;
		$result['status'] = 0;
		$data=json_decode($this->input->post('data'));
		if(is_array($data->{'comercio'})){
			if( isset($data->{'comercio'}[0]) ){
				$id_comercio=$data->{'comercio'}[0];
			}
		}else{
			$id_comercio=$data->{'comercio'};
	}
	$array['metodo_pago_comercio'] = $this->model->get_metodo_pago_comercio($id_comercio)->result();

	if( count($array['metodo_pago_comercio'])<=1 ) {
		$config = array( 'type' => 2, 'message' => 'Debe tener al menos 1 metodo de pago' );
		$result['msg']['content'] = createMessage($config);
		$result['data']['rows'] = 0;
		$result['result']=0;
		echo json_encode($result);
		exit();
	} else {
		$result['data']['html']=$this->load->view("operacion/tabla_pago_comercio",$array,true);
		$result['result']=1;
	}
	
	$array['fila_metodo_pago'] = $this->model->delete_metodo_pago_comercio($data->id_metodo)->result();
	$result['data']['rows'] = count($array['fila_metodo_pago']);

	echo json_encode($result);
	}

	public function guardar_comercio(){
		$result = $this->result;
		$result['status'] = 0;
		$data=json_decode($this->input->post('data'));
		$nombre_comercial=$data->{'nombre_comercial'};
		//
		$filtro=" and nombre='".$nombre_comercial."' and nombre not like '' ";
		$rs_nombre_comercial=$this->model->val_comercio_act($filtro,$data->{'id_comercio'})->result_array();

		if( !count($rs_nombre_comercial)>0 ){
			$params = array(
				'nombre' => $data->{'nombre_comercial'},
				'razon_social' => $data->{'razon_social'},
				'ruc' => $data->{'ruc'},
				'id_rubro' => ($data->{'id_rubro'}!="") ? $data->{'id_rubro'} : null,
				'id_giro' =>($data->{'id_giro'}!="") ? $data->{'id_giro'} : null,
				'telefono' => $data->{'telefono'},
				'nro_documento' => $data->{'dni_representante'},
				'estado' => isset($data->{'estado'}) ?  ($data->{'estado'}==1 ? 1 : 0) : 0
			);
			$where = array('id_comercio'=>$data->{'id_comercio'});
			$estado = $this->model->update_comercio($params,$where);
	
			if($estado){
				$params = array(
					/*'ape_paterno' => $data->{'apellido_pat'},
					'ape_materno' => $data->{'apellido_mat'},
					'nombres' => $data->{'nombre'},
					'nro_documento' => $data->{'dni*/
					'email' => $data->{'email'}
				);
				$where = array('id_usuario'=>$data->{'id_usuario'});
				$estado = $this->model->update_usuario($params,$where);
	
	
				$params =  array(
					'fecFin' => date('Y-m-d'),
					'estado'=>0
				);
				$where = array('id_comercio'=>$data->{'id_comercio'});
				$estado = $this->model->update_comercio_historico($params,$where);
				if(isset($data->{'proyecto'})){
					
	
					$id_proyecto="";
					if(is_array($data->{'proyecto'})){
						for($i=0;$i<sizeof($data->{'proyecto'});$i++){
							$params =  array(
								'fecFin' => null
								,'estado'=> 1
							);
							$where = array('id_comercio'=>$data->{'id_comercio'},'id_proyecto'=>$data->{'proyecto'}[$i] );
							$estado = $this->model->update_comercio_historico($params,$where);
							if($estado==1 && $estado!=0){
								$params =  array(
									'fecIni' => date('Y-m-d')
									, 'id_comercio' => $data->{'id_comercio'}
									, 'id_proyecto' => $data->{'proyecto'}[$i]
									,  'estado'=> 1
								);
								$estado = $this->model->set_comercio_historico($params);
							}
						}
	
					}else{
						$id_proyecto=$data->{'proyecto'};
	
						$params =  array(
							'fecFin' => null
							,'estado'=> 1
						);
						$where = array('id_comercio'=>$data->{'id_comercio'},'id_proyecto'=>$id_proyecto );
						$estado = $this->model->update_comercio_historico($params,$where);
						if($estado==1 && $estado!=0){
							$params =  array(
								'fecIni' => date('Y-m-d')
								, 'id_comercio' =>$data->{'id_comercio'}
								, 'id_proyecto' => $id_proyecto
								,  'estado'=> 1
							);
							$estado = $this->model->set_comercio_historico($params);
						}
					}
				} 
				
					//
				$result = $this->result;
				$result['status'] = 1;
				$result['data'] = 0;
				$config = array( 'type' => 1, 'message' => 'Se ha actualizado la informacion correctamente' );
				$result['msg']['content'] = createMessage($config);
	
			}else{
				$result['data'] = 0;
				$result['status'] = 0;
				$config = array( 'type' => 2, 'message' => 'No hay comercios seleccionados' );
				$result['msg']['content'] = createMessage($config);
			}
		}else{
			$result = $this->result;
			$result['status'] = 0;
			$result['data'] = 0;
			if(count($rs_nombre_comercial)>0){
				$config = array( 'type' => 2, 'message' => 'No se ha pudo registrar. Ya existe un comercio con el mismo nombre comercial' );
			} else{
				$config = array( 'type' => 2, 'message' => 'No se ha podido registrar, intentelo nuevamente' );
			}
			$result['msg']['content'] = createMessage($config);
		}
		
		
		//
		echo json_encode($result);
	}

	public function cambiar_estado_comercio(){
		$result = $this->result;
		$result['status'] = 0;
		$data=json_decode($this->input->post('data'));

		$params = array(
			'estado' => ($data->{'estado'}==true) ? 1 : 0
		);
		$where = array('id_comercio'=>$data->{'id_comercio'});
		$estado = $this->model->update_comercio($params,$where);

		if($estado){
			$result = $this->result;
			$result['status'] = 1;
			$result['data'] = 0;
			if($data->{'estado'}==true){
				$config = array( 'type' => 1, 'message' => 'Se ha activado el comercio seleccionado' );
			}else{
				$config = array( 'type' => 1, 'message' => 'Se ha desactivado el comercio seleccionado' );
			}
			$result['msg']['content'] = createMessage($config);

		}else{
			$result['data'] = 0;
			$config = array( 'type' => 2, 'message' => 'No hay comercios seleccionados' );
			$result['msg']['content'] = createMessage($config);
		}
		//
		echo json_encode($result);
	}

	public function desactivar_credito(){
		$result = $this->result;
		$result['status'] = 0;
		$data=json_decode($this->input->post('data'));
		$id_hist_cred =$data->{'id_hist_cred'};

		$params = array(
			'estado' => 0
		);
		$where=array('id_comercio_cred'=>$id_hist_cred );
		$estado=$this->model->update_comercio_credito($params,$where);

		if($estado){
			$result = $this->result;
			$result['data'] = 0;
			$config = array( 'type' => 1, 'message' => 'Se ha eliminado correctamente' );
			$result['msg']['content'] = createMessage($config);
		
		}else{
			$result = $this->result;
			$result['data'] = 0;
			$config = array( 'type' => 2, 'message' => 'No se logro eliminar, intentelo nuevamente' );
			$result['msg']['content'] = createMessage($config);
		}
		//
		echo json_encode($result);
	}
	public function actualizar_estado_credito(){
		$result = $this->result;
		$result['status'] = 0;
		$data=json_decode($this->input->post('data'));
		$estado=false;
		$estado_val=false;
		$estado_=$data->{'estado'};

		$id_comercio=$data->{'id_comercio'};
		$comercio=$this->model->get_comercio($id_comercio)->row_array();
		$id_hist_cred= isset($data->{'id_hist_cred'}) ? $data->{'id_hist_cred'} :"" ;
		if($id_hist_cred!=""){
			if( $comercio['creditosActual']!=null){
				if( $estado_==0){
				
					if( $comercio['creditosActual']>=$data->{'credito'} ){
						$params = array(
							'estado' =>$estado_
						);
						$where = array('id_comercio_cred'=>$id_hist_cred);
						$estado = $this->model->update_comercio_credito($params,$where);
						
				
						
						if($estado){
							$creditos=$comercio['creditosActual']-$data->{'credito'};
							$params = array(
								'creditosActual' => $creditos
							);
							$where = array('id_comercio'=>$data->{'id_comercio'});
							$estado = $this->model->update_comercio($params,$where);
						}
					}
					
				}else if( $estado_==1){
					$params = array(
						'estado' =>$estado_
					);
					$where = array('id_comercio_cred'=>$id_hist_cred);
					$estado = $this->model->update_comercio_credito($params,$where);
					if($estado){
						$creditos=$comercio['creditosActual']+$data->{'credito'};
						$params = array(
							'creditosActual' => $creditos
						);
						$where = array('id_comercio'=>$data->{'id_comercio'});
						$estado = $this->model->update_comercio($params,$where);
					}
				}else{
					$estado_val=true;
				}
			
			}	
		}
		
		if($estado){
			$result = $this->result;
			$result['status'] = 1;
			$result['data'] = 0;
			$msg="";
			if($estado_==1){
				$msg='Se ha activado el credito seleccionado';
			}else{
				$msg='Se ha desactivado el credito seleccionado';
			}
			$config = array( 'type' => 1, 'message' => $msg );
			$result['msg']['content'] = createMessage($config);
		}else{
			if($estado_val){
				$result['data'] = 0;
				$config = array( 'type' => 2, 'message' => 'No se logro desactivar, el monto actual es menor' );
				$result['msg']['content'] = createMessage($config);
			}else{
				$result['data'] = 0;
				$config = array( 'type' => 2, 'message' => 'No hay elemento seleccionado' );
				$result['msg']['content'] = createMessage($config);
			}
			
		}
		//
		echo json_encode($result);
	}


	public function obtener_comercios(){
		$data=json_decode($this->input->post('data'));
		//print_r($data);
		$result = $this->result;
		$result['status'] = 0;
		//
		$array = array();
		//
		$filtros = '';
	
		//
		$id_usuario_perfil=$this->session->userdata('id_usuario_perfil');
		$id_usuario=$this->session->userdata('id_usuario');
		$filtro="";
		$comercios=array();
		if($id_usuario_perfil==1){
			$comercios = $this->model->get_comercios()->result_array();
		}else{
			$comercios = $this->model->get_comercios_usuario($id_usuario)->result_array();
		}
		
		// 
	 
		$result['result']=1;
		if( count($comercios)==0 ) {
			$result['data']['html1']= '<p class="p-info"><i class="fa fa-info-circle"></i> No se obtuvieron resultados.</p>';
		} else {
			$array = array(
				'comercios' => $comercios
				
			);
			$result['data']['html1']=$this->load->view("operacion/mis_comercios/comercios_table",$array,true);
		}
		echo json_encode($result);
	}
	
}

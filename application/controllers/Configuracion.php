<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Configuracion extends MY_Controller {
	
	public function __construct(){
		parent::__construct(); 
		$this->load->model('M_Configuracion','model');
	}
	
	public function index()
	{
		$config['css']['style']=array('../../core/libs/dataTables-1.10.20/datatables');
		$config['js']['script']=array('../../core/libs/dataTables-1.10.20/datatables','../../core/libs/dataTables-1.10.20/datatables-defaults','configuracion');
		$config['nav']['menu_active']='20';
		//

		$id_comercio = $this->session->userdata('id_comercio');
		$res_comercio=$this->model->get_comercio($id_comercio)->row_array();
		$config['data']['comercio']=$res_comercio;

		$fecha=date('Y-m-d');

		// $id_pdv = $this->session->userdata('id_pdv');
		// $res_pdv=$this->model->get_punto_venta($id_pdv,$fecha)->row_array();
		// $config['data']['pdv']=$res_pdv;
		
		$id_usuario = $this->session->userdata('id_usuario');
		$res_usuario=$this->model->get_usuario($id_usuario)->row_array();
		$config['data']['usuario']=$res_usuario;

		$fecha = date('Y-m-d');
		 

		$config['data']['giros']=$this->model->get_giros()->result_array();
		$config['data']['rubros']=$this->model->get_rubros()->result_array();

		
		$res_metodo1=$this->model->get_comercio_metodo_edit($id_comercio,1)->row_array();
		$config['data']['envio']=(isset($res_metodo1['estado']) ? ( ($res_metodo1['estado']==1)? true :false ) : false );

		$res_metodo2=$this->model->get_comercio_metodo_edit($id_comercio,2)->row_array();
		$config['data']['recojo']=(isset($res_metodo2['estado']) ? ( ($res_metodo2['estado']==1)? true :false ) : false );

		

		$res_articulos=$this->model->get_articulos($id_comercio)->result_array();
		$config['data']['articulos']=$res_articulos;


		$config['data']['departamentos']=$this->model->get_departamentos()->result_array();
		

		$config['data']['empresas_del']=$this->model->get_empresa_delivery()->result_array();

		$rs =  $this->model->get_metodo_pago_comercio($id_comercio)->result();

		if(count($rs)<=0){
			$rs_ = array(
				'id_metodo_pago' => '1',
				'id_comercio' => $id_comercio,
			);
			$this->db->insert('ms_metodo_pago_comercio',$rs_);
		}

		$config['data']['metodo_pago_comercio'] = $this->model->get_metodo_pago_comercio($id_comercio)->result();
		$evit_metodo= array();
		$ite = 0;
		foreach($config['data']['metodo_pago_comercio'] as $row){

			$evit_metodo[$ite++] = $row->id_metodo_pag; 
		};
		$new_evit_metodo = implode(',',$evit_metodo);
	

		$config['data']['metodos_pago'] = $this->model->get_metodo_pago($new_evit_metodo)->result();


		$config['data']['icon']='fa fa-utensils';
		$config['data']['title']=$res_comercio['nombre_comercio'];
		$config['view']='operacion/mi_configuracion';
		$config['data']['message']='Desde aqui podras configurar tu información de establecimiento';
		
		
		$this->view($config);
	}
	
	public function agregar_metodo_comercio(){
		$result = $this->result;
		$result['status'] = 0;
		$data=json_decode($this->input->post('data'));
		
		$id_comercio = $this->session->userdata('id_comercio');

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
				 'id' => $row->id_metodo_pag,
				 'id_temp' => $id_temp,
				 'nombre'=> $row->nombre,
			 );
			$html .= "<tr id='metodo_temp".$row->id_metodo_pag."'>";
				$html .= "<td><li style='color:red' value=".$row->id_metodo_pag." onclick='Configuracion.eliminar_fila_temp(".json_encode($params).")' class='fas fa-trash'></li></td>";
				$html .= "<td id='new_metodo".$row->id_metodo_pag."'>".$row->nombre."</td>";
				$html .= "<td class='text-center' ><input class='form-control new_numero'  id='new_numero".$row->id_metodo_pag."' style='border:0' type='text' placeholder='Ingrese el número'></td>";
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
		$id_comercio = $this->session->userdata('id_comercio');

		
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
		$config = array( 'type' => 1, 'message' => 'Se eliminó el método de pago' );
		$result['msg']['content'] = createMessage($config);
		$result['result']=1;
	}
	
	$array['fila_metodo_pago'] = $this->model->delete_metodo_pago_comercio($data->id_metodo);
	$result['data']['rows'] = count($array['fila_metodo_pago']);

	echo json_encode($result);
	}
	public function historial_creditos(){
		$result = $this->result;
		$result['status'] = 0;
		$id_comercio = $this->session->userdata('id_comercio');

		if( $id_comercio!="" ){
			//
			$array = array(
				'comercio' => $this->model->get_comercio($id_comercio)->row_array()
				,'comercio_credito' => $this->model->get_comercio_credito($id_comercio)->result_array()
				, 'id_comercio' => $id_comercio
			);
			$result = $this->result;
			$result['status'] = 1;
			$result['data']['html']=$this->load->view("operacion/historial_creditos",$array,true);
		}
		//
		echo json_encode($result);
	}

	public function actualizar_comercio(){
		$result = $this->result;
		$result['status'] = 0;

		$data=json_decode($this->input->post('data'));
		//
		// print_r($data);
	
		

		$id_comercio = $this->session->userdata('id_comercio');
		
		//guardar imagen
		$archivo="";
		$foto_=isset($data->{'img_logo'})? $data->{'img_logo'} : null;
		if( ( $foto_ )!=null ) {
		

			$archivo="logo_".$id_comercio."_".date("His");
			$ruta='./files/logos/';

			if( file_exists($ruta.$archivo.'.jpg') ) unlink($ruta.$archivo.'.jpg');
			$img = explode(",",$foto_);
			$imagen_ = str_replace(' ', '+', $img[1]);
			$base65 = base64_decode($imagen_);
			$file = $ruta.$archivo.'.jpg';
			$success = file_put_contents($file, $base65);
			$foto = $archivo.'.jpg';
		}

		//guardar terminos
		$archivo_terminos="terminos_".$id_comercio;
		$ruta='../files/terminos/';
		$file_=isset($data->{'img_terminos'})? $data->{'img_terminos'} : null;
		if( ( $file_ )!=null ) {
			if( file_exists($ruta.$archivo_terminos.'.pdf') ) unlink($ruta.$archivo_terminos.'.pdf');
			$img = str_replace('data:application/pdf;base64,', '', $file_);
			$img = str_replace(' ', '+', $img);
			$base65 = base64_decode($img);
			$uniqid = $archivo_terminos;
			$file = $ruta.$uniqid.'.pdf';
			$success = file_put_contents($file, $base65);
			$foto = $uniqid.'.pdf';
		}


		$params =  array(
			'nombre' => $data->{'nomb_comercial'}
			, 'razon_social' => $data->{'razon_social'}
			, 'ruc'=> $data->{'ruc'}
			, 'id_rubro' => ($data->{'id_rubro'}!="") ? $data->{'id_rubro'} : null
			, 'id_giro' => ($data->{'id_giro'}!="") ? $data->{'id_giro'} : null
			, 'costo_delivery' => ($data->{'costo_delivery'}!="") ? $data->{'costo_delivery'} : null 
			, 'telefono' => $data->{'telefono'}
			, 'nro_documento' => $data->{'nro_documento'}
			, 'pago_visa' => $data->{'pago_visa'}
		);
		if( ( $foto_ )!=null ) $params['ruta_logo']=$archivo;
		if( ( $file_ )!=null ) $params['ruta_terminos']=$archivo_terminos;
		$where = array('id_comercio'=>$id_comercio);
		$estado = $this->model->update_comercio($params,$where);

		
		if($estado){
			$id_usuario = $this->session->userdata('id_usuario');
			$params =  array(
			 	 'email' => $data->{'email'}
				, 'nro_documento' => $data->{'nro_documento'}
			);
			$where = array('id_usuario'=>$id_usuario);
			$estado = $this->model->update_usuario($params,$where);

			$result['data'] = 0;
			$config = array( 'type' => 1, 'message' => 'Se actualizo la informacion correctamente' );
			$result['msg']['content'] = createMessage($config);

		}else{
			$result['data'] = 0;
			$config = array( 'type' => 2, 'message' => 'No se logro actualizar, intentelo nuevamente' );
			$result['msg']['content'] = createMessage($config);
		}
		
		for ($i=0; $i <$data->cant_for ; $i++) { 
			$metodo_pago_comercio = array(
				'id_metodo_pago' =>$data->{'row_method'.$i},
				'id_comercio'=> $id_comercio,
				'numero'=>$data->{'numero'.$i}
			);
			$this->db->insert('ms_metodo_pago_comercio',$metodo_pago_comercio);
			
		}
		//
		echo json_encode($result);
	}

	public function configuracion_mensajes(){
		$result = $this->result;
		$result['status'] = 0;
		$id_comercio = $this->session->userdata('id_comercio');

		if( $id_comercio!="" ){
			//
			$array = array(
				'procesos' => $this->model->get_procesos()->result_array()
				, 'comercio' => $this->model->get_comercio($id_comercio)->row_array()
				, 'mensajes' => $this->model->get_configuracion_mensaje($id_comercio)->result_array()
				, 'id_comercio' => $id_comercio
			);
			$result = $this->result;
			$result['status'] = 1;
			$result['data']['html']=$this->load->view("operacion/configuracion_mensajes",$array,true);
		}
		//
		echo json_encode($result);
	}

	public function actualizar_mensaje(){
		$result = $this->result;
		$result['status'] = 0;
		$id_comercio = $this->session->userdata('id_comercio');
		$data=json_decode($this->input->post('data'));

		if($data->{'id_mens'}!=""){
			$filtro=" AND cm.id_conf_mens <> " .$data->{'id_mens'};
			$rs=$this->model->get_configuracion_mensaje_proceso($id_comercio,$data->{'id_proceso_new'},$filtro)->result_array();
			
			if( count($rs)==0){

				$id_mens=$data->{'id_mens'};
				$params =  array(
						'id_proceso' => $data->{'id_proceso_new'},
						'mensaje' => $data->{'mensaje_new'}
				);
				$where = array('id_conf_mens'=>$id_mens);
				$estado=$this->model->update_configuracion_mensaje($params,$where);
  
				if($estado){
					$result['data'] = 0;
					$result['status'] = 1;
					$config = array( 'type' => 1, 'message' => 'Se actualizo la informacion correctamente' );
					$result['msg']['content'] = createMessage($config);
				}else{
					$result = $this->result;
					$result['data'] = 0;
					$config = array( 'type' => 2, 'message' => 'No se logro actualizar, intentelo nuevamente' );
					$result['msg']['content'] = createMessage($config);
				}
			}else{
				$result = $this->result;
				$result['data'] = 0;
				$result['status'] = 0;
				$config = array( 'type' => 2, 'message' => 'Ya existe un mensaje con el tipo seleccionado.No se ha podido registrar' );
				$result['msg']['content'] = createMessage($config);
			}
		}else{
			$result = $this->result;
			$result['data'] = 0;
			$result['status'] = 0;
			$config = array( 'type' => 2, 'message' => 'Ingrese los campos necesarios' );
			$result['msg']['content'] = createMessage($config);
		}
		//
		echo json_encode($result);
	}

	public function editar_mensaje(){
		$result = $this->result;
		$result['status'] = 0;
		$data=json_decode($this->input->post('data'));
		$id_mens = $data->{'id_mens'};
		$res_mensaje=$this->model->get_configuracion_mensaje_edit($id_mens)->row_array();
		$result['data'] = $res_mensaje;
		//
		echo json_encode($result);
	}

	public function agregar_mensaje(){
		$result = $this->result;
		$result['status'] = 0;
		$data=json_decode($this->input->post('data'));
		$id_comercio = $this->session->userdata('id_comercio');
		//


		if($data->{'mensaje_new'}!="" && $data->{'id_proceso_new'}!=""){
			$filtro="";
			$rs=$this->model->get_configuracion_mensaje_proceso($id_comercio,$data->{'id_proceso_new'},$filtro)->result_array();
			if( count($rs)==0){
				$params = array(
					'id_proceso' => $data->{'id_proceso_new'}
					,'estado' => 1
					,'mensaje' => $data->{'mensaje_new'}
					,'id_comercio' => $id_comercio
				);
				$this->model->set_configuracion_mensaje($params);
				$result = $this->result;
				$result['data'] = 0;
				$result['status'] = 1;
				$config = array( 'type' => 1, 'message' => 'Se ha registrado correctamente' );
				$result['msg']['content'] = createMessage($config);
			}else{
				$result = $this->result;
				$result['data'] = 0;
				$result['status'] = 0;
				$config = array( 'type' => 2, 'message' => 'Ya existe un mensaje con el tipo seleccionado. No se ha podido registrar' );
				$result['msg']['content'] = createMessage($config);
			}
		}else{
			$result = $this->result;
			$result['data'] = 0;
			$result['status'] = 0;
			$config = array( 'type' => 2, 'message' => 'Ingrese los campos necesarios' );
			$result['msg']['content'] = createMessage($config);
		}
		
		

		//
		echo json_encode($result);
	}

	public function agregar_medio_envio(){
		$result = $this->result;
		$result['status'] = 0;
		$data=json_decode($this->input->post('data'));
		$id_comercio = $this->session->userdata('id_comercio');
		$id_empresa=null;

		if(isset($data->{'otraEmpresa'})){
			$params = array(
				'nombre' => $data->{'empresa_medio'}
				,'estado' => 1
			);
			$this->model->set_empresa_delivery($params);
			$id_empresa = $this->mysql_last_id();
		}else{
			$id_empresa = ($data->{'id_empresa'}!="") ? $data->{'id_empresa'} : null;
		}
			
		$params = array(
			'id_comercio' => $id_comercio
			,'id_medio_tipo' => isset($data->{'tipo_medio'})? $data->{'tipo_medio'} : null
			,'titulo' => $data->{'titulo_medio'}
			,'email' => $data->{'email_medio'}
			,'telefono' => $data->{'telefono_medio'}
			,'id_empresa_del' => $id_empresa
		);
		$estado=$this->model->set_medio_envio($params);
		if($estado){
			$result = $this->result;
			$result['data'] = 0;
			$config = array( 'type' => 1, 'message' => 'Se ha registrado correctamente' );
			$result['msg']['content'] = createMessage($config);
		
		}else{
			$result = $this->result;
			$result['data'] = 0;
			$config = array( 'type' => 2, 'message' => 'No se logro registrar, intentelo nuevamente' );
			$result['msg']['content'] = createMessage($config);
		}
		echo json_encode($result);
	}

	public function editar_medio_envio(){
		$result = $this->result;
		$result['status'] = 0;
		$data=json_decode($this->input->post('data'));
		$id_medio = $data->{'id_medio'};
		$res_medio_envio=$this->model->get_medio_envio($id_medio)->row_array();
	
		$result['data'] = $res_medio_envio;
		//
		echo json_encode($result);
	}

	public function actualizar_medio_envio(){
		$result = $this->result;
		$result['status'] = 0;
		$data=json_decode($this->input->post('data'));
		$id_medio = $data->{'id_medio'};

		$id_empresa=null;

		if(isset($data->{'otraEmpresa'})){
			$params = array(
				'nombre' => $data->{'empresa_medio'}
				,'estado' => 1
			);
			$this->model->set_empresa_delivery($params);
			$id_empresa = $this->mysql_last_id();
		}else{
			$id_empresa = ($data->{'id_empresa'}!="") ? $data->{'id_empresa'} : null;
		}

		$params = array(
			'titulo' => $data->{'titulo_medio'}  
			,'email' => $data->{'email_medio'}
			,'telefono' => $data->{'telefono_medio'}
			,'id_medio_tipo' => isset($data->{'tipo_medio'}) ? $data->{'tipo_medio'} : null 
			,'id_empresa_del' => $id_empresa
		);
		$where=array('id_medio_env'=>$id_medio );
		$estado=$this->model->update_medio_envio($params,$where);
		
		if($estado){
			$result = $this->result;
			$result['data'] = 0;
			$config = array( 'type' => 1, 'message' => 'Se ha actualizado correctamente' );
			$result['msg']['content'] = createMessage($config);
		
		}else{
			$result = $this->result;
			$result['data'] = 0;
			$config = array( 'type' => 2, 'message' => 'No se logro actualizar, intentelo nuevamente' );
			$result['msg']['content'] = createMessage($config);
		}
		//
		echo json_encode($result);
	}

	public function obtener_provincias(){
		$result = $this->result;
		$result['status'] = 0;
		$data=json_decode($this->input->post('data'));
		$cod_dep = $data->{'cod_dep'};
		//
		if($cod_dep!=""){
			$res_provincias=$this->model->get_provincias($cod_dep)->result_array();
			$result = $this->result;
		
			$result['data'] = $res_provincias;
			$config = array( 'type' => 1, 'message' => 'Se ha registrado correctamente' );
			$result['msg']['content'] = createMessage($config);
		}
		//
		echo json_encode($result);
	}

	public function obtener_distritos(){
		$result = $this->result;
		$result['status'] = 0;
		$data=json_decode($this->input->post('data'));
		$cod_dep = $data->{'cod_dep'};
		$cod_prov = $data->{'cod_prov'};
		if($cod_prov!=""){
			$res_distritos=$this->model->get_distritos($cod_dep,$cod_prov)->result_array();
			$result = $this->result;
		
			$result['data'] = $res_distritos;
			$config = array( 'type' => 1, 'message' => 'Se ha registrado correctamente' );
			$result['msg']['content'] = createMessage($config);
		}
		//
		echo json_encode($result);
	}

	public function agregar_pdv(){
		$result = $this->result;
		$result['status'] = 0;
		$data=json_decode($this->input->post('data'));
		$id_comercio = $this->session->userdata('id_comercio');
		//
		$direccion="";
		if(($data->{'dep_local'})!=""){
			$direccion.=" Dep. ".($data->{'dep_local'});
		}
		if(($data->{'int_local'})!=""){
			$direccion.=" Int. ".($data->{'int_local'});
		}
		if(($data->{'km_local'})!=""){
			$direccion.=" Km. ".($data->{'km_local'});
		}
		if(($data->{'lote_local'})!=""){
			$direccion.=" Lc. ".($data->{'lote_local'});
		}
		if(($data->{'mza_local'})!=""){
			$direccion.=" Mza. ".($data->{'mza_local'});
		}
		if(($data->{'num_local'})!=""){
			$direccion.=" Num. ".($data->{'num_local'});
		}

		$via="";
		if(($data->{'id_via_local'}!="") && ($data->{'via_local'}!="") ){
			$via=($data->{'id_via_local'}).". ".$data->{'via_local'};
		}

		$zona="";
		if(($data->{'id_zona_local'}!="") && ($data->{'zona_local'}!="") ){
			$zona=($data->{'id_zona_local'}).". ".$data->{'zona_local'};
		}


		$fechas_arr = explode(" - ", $data->{'horario_atencion'});
		$params = array(
			'id_comercio' => $id_comercio
			,'nombre' => $data->{'nombre_local'}
			,'direccion' => $direccion
			,'latitud' => $data->{'latitud'}
			,'longitud' => $data->{'longitud'}
			,'id_ubigeo' => ($data->{'distrito_local'}!="") ? $data->{'distrito_local'} :null
			,'via' => $via
			,'zona' => $zona
			,'email' => $data->{'email_local'}
			,'hora_ini' => $fechas_arr[0]
			,'hora_fin' => $fechas_arr[1]
		);
		$estado=$this->model->set_punto_venta($params);
		if($estado){
			$id_pdv = $this->mysql_last_id();
			// $params = array(
			// 	'fecIni' => date('Y-m-d')
			// 	,'estado' => 1
			// 	,'id_pdv' => $id_pdv
			// );
			// $estado=$this->model->set_punto_venta_historico($params);

			$params = array(
				'numero' => $data->{'telefono_local'}
				,'estado' => 1
				,'id_telefono_tipo' => 1
				,'id_pdv' => $id_pdv
			);
			$this->model->set_punto_venta_telefono($params);

			if($estado){
				$result = $this->result;
				$result['data'] = 0;
				$config = array( 'type' => 1, 'message' => 'Se ha registrado correctamente' );
				$result['msg']['content'] = createMessage($config);
			}else{
				$result = $this->result;
				$result['data'] = 0;
				$config = array( 'type' => 2, 'message' => 'No se logro registrar, intentelo nuevamente' );
				$result['msg']['content'] = createMessage($config);
			}
		}else{
			$result = $this->result;
			$result['data'] = 0;
			$config = array( 'type' => 2, 'message' => 'No se logro registrar, intentelo nuevamente' );
			$result['msg']['content'] = createMessage($config);
		}
		//
		echo json_encode($result);
	}

	public function editar_pdv(){
		$result = $this->result;
		$result['status'] = 0;
		$data=json_decode($this->input->post('data'));
		$id_pdv = $data->{'id_pdv'};

		$arr_puntos=array();
		$res_punto_venta=$this->model->get_punto_venta_edit($id_pdv)->result_array();
		foreach($res_punto_venta as $row){
			$arr_punto=$row;
			$arr_punto['telefonos'][$row['id_pdv_telefono']]=$row['numero'];
			$dir=$row['direccion'];


			$cad=substr($dir,strpos($dir,"Dep.")+4);
			if(strpos($dir,"Dep.")!=false){
				if(strpos($cad,".")!=false  ){
					$cad=substr($cad,0,(strpos($cad,".")-3));
				}else{
					$cad=substr($cad,0);
				}
				$arr_punto['dep']=$cad;
			}
			


			$cad=substr($dir,strpos($dir,"Int.")+4);
			if(strpos($dir,"Int.")!=false){
				if(strpos($cad,".")!=false  ){
					$cad=substr($cad,0,(strpos($cad,".")-3));
				}else{
					$cad=substr($cad,0);
				}
				$arr_punto['int']=$cad;
			}

			$cad=substr($dir,strpos($dir,"Km.")+3);
			if(strpos($dir,"Km.")!=false){
				if(strpos($cad,".")!=false  ){
					$cad=substr($cad,0,(strpos($cad,".")-3));
				}else{
					$cad=substr($cad,0);
				}
				$arr_punto['km']=$cad;
			}

			$cad=substr($dir,strpos($dir,"Lt.")+3);
			if(strpos($dir,"Lt.")!=false){
				if(strpos($cad,".")!=false  ){
					$cad=substr($cad,0,(strpos($cad,".")-3));
				}else{
					$cad=substr($cad,0);
				}
				$arr_punto['lt']=$cad;
			}

			$cad=substr($dir,strpos($dir,"Mza.")+4);
			if(strpos($dir,"Mza.")!=false){
				if(strpos($cad,".")!=false  ){
					$cad=substr($cad,0,(strpos($cad,".")-3));
				}else{
					$cad=substr($cad,0);
				}
				$arr_punto['mza']=$cad;
			}

			$cad=substr($dir,strpos($dir,"Num.")+4);
			if(strpos($dir,"Num.")!=false){
				if(strpos($cad,".")!=false  ){
					$cad=substr($cad,0,(strpos($cad,".")-3));
				}else{
					$cad=substr($cad,0);
				}
				$arr_punto['num']=$cad;
			}
			


			$via=$row['via'];
			if(strpos($via,".")!=false){
				$via_abr=substr($via,0,strpos($via,"."));
				$via_cont=substr($via,strpos($via,".")+1);
				$arr_punto['via_abr']=$via_abr;
				$arr_punto['via_cont']=$via_cont;
			}

			$zona=$row['zona'];
			if(strpos($zona,".")!=false){
				$zona_abr=substr($zona,0,strpos($zona,"."));
				$zona_cont=substr($zona,strpos($zona,".")+1);
				$arr_punto['zona_abr']=$zona_abr;
				$arr_punto['zona_cont']=$zona_cont;
			}
			


		}
		$result['data'] = $arr_punto;
		//
		echo json_encode($result);
	}

	public function actualizar_pdv(){
		$result = $this->result;
		$result['status'] = 0;
		$data=json_decode($this->input->post('data'));
		$id_pdv =$data->{'id_pdv'};
		//
		$direccion="";
		if(($data->{'dep_local'})!=""){
			$direccion.=" Dep. ".($data->{'dep_local'});
		}
		if(($data->{'int_local'})!=""){
			$direccion.=" Int. ".($data->{'int_local'});
		}
		if(($data->{'km_local'})!=""){
			$direccion.=" Km. ".($data->{'km_local'});
		}
		if(($data->{'lote_local'})!=""){
			$direccion.=" Lc. ".($data->{'lote_local'});
		}
		if(($data->{'mza_local'})!=""){
			$direccion.=" Mza. ".($data->{'mza_local'});
		}
		if(($data->{'num_local'})!=""){
			$direccion.=" Num. ".($data->{'num_local'});
		}

		$via="";
		if(($data->{'id_via_local'}!="") && ($data->{'via_local'}!="") ){
			$via=($data->{'id_via_local'}).". ".$data->{'via_local'};
		}

		$zona="";
		if(($data->{'id_zona_local'}!="") && ($data->{'zona_local'}!="") ){
			$zona=($data->{'id_zona_local'}).". ".$data->{'zona_local'};
		}


		$fechas_arr = explode(" - ", $data->{'horario_atencion'});
		$params = array(
			'nombre' => $data->{'nombre_local'}
			,'direccion' => $direccion
			,'latitud' => $data->{'latitud'}
			,'longitud' => $data->{'longitud'}
			,'id_ubigeo' => ($data->{'distrito_local'}!="") ? $data->{'distrito_local'} :null
			,'via' => $via
			,'zona' => $zona
			,'email' => $data->{'email_local'}
			,'hora_ini' => $fechas_arr[0]
			,'hora_fin' => $fechas_arr[1]
		);
		$where=array('id_pdv'=>$id_pdv );
		$estado=$this->model->update_punto_venta($params,$where);


		if($data->{'id_telefono'}!=""){
			$params = array(
				'numero' => $data->{'telefono_local'}
			);
			$where=array('id_pdv_telefono'=>$data->{'id_telefono'} );
			$this->model->update_punto_venta_telefono($params,$where);
		}else{
			$params = array(
				'numero' => $data->{'telefono_local'}
				,'estado' => 1
				,'id_telefono_tipo' => 1
				,'id_pdv' => $id_pdv
			);
			$this->model->set_punto_venta_telefono($params);
		}
		


		
		
		$id_pdv = $this->mysql_last_id();
		if($estado){
			$result = $this->result;
			$result['data'] = 0;
			$config = array( 'type' => 1, 'message' => 'Se ha actualizado correctamente' );
			$result['msg']['content'] = createMessage($config);
		
		}else{
			$result = $this->result;
			$result['data'] = 0;
			$config = array( 'type' => 2, 'message' => 'No se logro actualizar, intentelo nuevamente' );
			$result['msg']['content'] = createMessage($config);
		}
		//
		echo json_encode($result);
		//falta actualizar detalle telefono 
		//boton restablecer?
	}

	public function editar_punto_venta_zonas(){
		$result = $this->result;
		$result['status'] = 0;
		$data=json_decode($this->input->post('data'));
		$id_pdv =$data->{'id_pdv'};
		$cod_prov = $data->{'cod_prov'};
		$cod_dep = $data->{'cod_dep'};
		
		if( $id_pdv!="" && $cod_dep!="" && $cod_prov!=""){
			//
			$id_comercio = $this->session->userdata('id_comercio');
			$array = array(
				'comercio' => $this->model->get_comercio($id_comercio)->row_array()
				,'distritos' => $this->model->get_distritos($cod_dep,$cod_prov)->result_array()
				, 'zonas' => $this->model->get_puntos_venta_zona($id_pdv)->result_array()
				, 'pdv' => $this->model->get_punto_venta($id_pdv)->row_array()
				, 'id_pdv' => $id_pdv
			);
			$result = $this->result;
			$result['status'] = 1;
			$result['data']['html']=$this->load->view("operacion/edit_punto_venta_zonas",$array,true);
		}else{
			$result = $this->result;
			$result['status'] = 0;
			$config = array( 'type' => 2, 'message' => 'Debe asignar el Departamento y Provincia para poder editar las zonas' );
			$result['data']['html'] = createMessage($config);
		}
		//
		echo json_encode($result);
	}

	public function actualizar_punto_venta_zonas(){
		$result = $this->result;
		$result['status'] = 0;

		$data=json_decode($this->input->post('data'));
		$costo_def=($data->{'costo_delivery_def'}!="") ? $data->{'costo_delivery_def'}:0;
		if(!is_array($data->{'id_zona'})){
			if( isset($data->{'id_zona'}[0]) ){
				$id_zona=$data->{'id_zona'}[0];
				$params =  array(
					'id_ubigeo' => $data->{'id_ubigeo_zona'}
					, 'costo' => ($data->{'costo_delivery_zona'}!="" ? $data->{'costo_delivery_zona'} : $costo_def )
					
				);
				$where = array('id_pdv_zona'=>$id_zona);
				$this->model->update_punto_venta_zona($params,$where);
			}
		}else{
			$arr_mens=$data->{'id_zona'};

			for($i=0;$i<sizeof($arr_mens);$i++){
				$params =  array(
					'id_ubigeo' => $data->{'id_ubigeo_zona'}[$i]
					, 'costo' => ($data->{'costo_delivery_zona'}[$i]!="" ? $data->{'costo_delivery_zona'}[$i] : $costo_def )
				);
				$where = array('id_pdv_zona'=>$arr_mens[$i]);
				$this->model->update_punto_venta_zona($params,$where);
			}
		}
		$result['data'] = 0;
		$config = array( 'type' => 1, 'message' => 'Se actualizo la informacion correctamente' );
		$result['msg']['content'] = createMessage($config);
		//
		echo json_encode($result);
	}

	public function agregar_punto_venta_zonas(){
		$result = $this->result;
		$result['status'] = 0;
		$data=json_decode($this->input->post('data'));
		$id_pdv = $data->{'id_pdv_zona'};
		//
		
		$costo_def=($data->{'costo_delivery_def'}!="") ? $data->{'costo_delivery_def'}:0;
		if($data->{'id_ubigeo'}!="" ){
			$params = array(
				'id_ubigeo' => $data->{'id_ubigeo'}
				,'estado' => 1
				,'costo' => ($data->{'costo_delivery'}!="" ? $data->{'costo_delivery'} : $costo_def )
				,'id_pdv' => $id_pdv
			);
			$this->model->set_punto_venta_zona($params);
			$result = $this->result;
		}
		
		$result['data'] = 0;
		$config = array( 'type' => 1, 'message' => 'Se ha registrado correctamente' );
		$result['msg']['content'] = createMessage($config);
		//
		echo json_encode($result);
	}



	public function editar_articulo(){
		$result = $this->result;
		$result['status'] = 0;
		$data=json_decode($this->input->post('data'));
		$id_articulo =$data->{'id_articulo'};
			//
		$result['data']=$this->model->get_articulo($id_articulo)->row_array();
		
		$result['status'] = 1;
		//
		echo json_encode($result);
	}

	public function actualizar_articulo(){
		$result = $this->result;
		$result['status'] = 0;
		$data=json_decode($this->input->post('data'));
		$id_articulo =$data->{'id_articulo'};
		$id_comercio = $this->session->userdata('id_comercio');

		//guardar imagen
		print_r($data);exit();

		$archivo="articulo_".$id_articulo."_".date("His");
		$ruta='./files/articulos/';
		$foto_=isset($data->{'img_articulo'})? $data->{'img_articulo'} : null;
		if( ( $foto_ )!=null ) {
			if( file_exists($ruta.$archivo.'.jpg') ) unlink($ruta.$archivo.'.jpg');
			$img = explode(",",$foto_);
			$imagen_ = str_replace(' ', '+', $img[1]);
			$base65 = base64_decode($imagen_);
			$file = $ruta.$archivo.'.jpg';
			$success = file_put_contents($file, $base65);
			$foto = $archivo.'.jpg';
		}
		
		$params = array(
			'nombre' => $data->{'nombre_articulo'}
			,'precio' => $data->{'precio_articulo'}
			,'observacion' => $data->{'observacion_articulo'}
			,'costo_empaque' => $data->{'costo_emp_articulo'}
			,'estado' => 1
		);
		if( ( $foto_ )!=null ) $params['ruta_imagen']=$archivo;
		$where=array('id_articulo'=>$id_articulo );
		$estado=$this->model->update_articulo($params,$where);

		if($estado){
			$result = $this->result;
			$result['data'] = 0;
			$config = array( 'type' => 1, 'message' => 'Se ha actualizado correctamente' );
			$result['msg']['content'] = createMessage($config);
		
		}else{
			$result = $this->result;
			$result['data'] = 0;
			$config = array( 'type' => 2, 'message' => 'No se logro actualizar, intentelo nuevamente' );
			$result['msg']['content'] = createMessage($config);
		}
		//
		echo json_encode($result);
	}

	public function agregar_articulo(){
		$result = $this->result;
		$result['status'] = 0;
		$data=json_decode($this->input->post('data'));
		$id_comercio = $this->session->userdata('id_comercio');
		
		$params = array(
			'nombre' => $data->{'nombre_articulo'}
			,'precio' => $data->{'precio_articulo'}
			,'observacion' => $data->{'observacion_articulo'}
			,'costo_empaque' => $data->{'costo_emp_articulo'}
			,'id_comercio' => $id_comercio
			,'estado' => 1
			, 'visible' => 1
		);
		
	
		$estado=$this->model->set_articulo($params);
		
		if($estado){

			if( isset($data->{'img_articulo'} )){
				if( $data->{'img_articulo'}!=null ){
					$id_articulo = $this->mysql_last_id();


					//guardar imagen
					$archivo="articulo_".$id_articulo;
					$ruta='./files/articulos/';
					$foto_=isset($data->{'img_articulo'})? $data->{'img_articulo'} : null;
					if( ( $foto_ )!=null ) {
						if( file_exists($ruta.$archivo.'.jpg') ) unlink($ruta.$archivo.'.jpg');
						$img = explode(",",$foto_);
						$imagen_ = str_replace(' ', '+', $img[1]);
						$base65 = base64_decode($imagen_);
						$file = $ruta.$archivo.'.jpg';
						$success = file_put_contents($file, $base65);
						$foto = $archivo.'.jpg';
					}
					$params= array( 'ruta_imagen'=> $archivo);
					$where=array('id_articulo'=>$id_articulo );
					$estado=$this->model->update_articulo($params,$where);
				}
			}
			
			$result = $this->result;
			$result['data'] = 0;
			$config = array( 'type' => 1, 'message' => 'Se ha registrado correctamente.' );
			$result['msg']['content'] = createMessage($config);
		
		}else{
			$result = $this->result;
			$result['data'] = 0;
			$config = array( 'type' => 2, 'message' => 'No se logro registrar, intentelo nuevamente' );
			$result['msg']['content'] = createMessage($config);
		}
		//
		echo json_encode($result);
	}

	public function ocultar_articulos(){
		$result = $this->result;
		$result['status'] = 0;
		$data=json_decode($this->input->post('data'));
		$id_comercio = $this->session->userdata('id_comercio');

		$params = array(
			'visible' => 0
		);
		$where=array('id_comercio'=>$id_comercio );
		$estado=$this->model->update_articulo($params,$where);

		if($estado){
			$result = $this->result;
			$result['data'] = 0;
			$config = array( 'type' => 1, 'message' => 'Se han ocultado todos los articulos' );
			$result['msg']['content'] = createMessage($config);
		
		}else{
			$result = $this->result;
			$result['data'] = 0;
			$config = array( 'type' => 2, 'message' => 'No se logro actualizar, intentelo nuevamente' );
			$result['msg']['content'] = createMessage($config);
		}
		//
		echo json_encode($result);
	}


	public function actualizar_visibilidad_articulo(){
		$this->db->trans_start();

		$result = $this->result;
		$result['status'] = 0;
		$data=json_decode($this->input->post('data'));
		$id_articulo =$data->{'id_articulo'};
		$visible =$data->{'visible'};
		$visible_c=( ($visible==1)? 0 : 1 );

		$params = array(
			'visible' => $visible_c
		);
		$where=array('id_articulo'=>$id_articulo );
		$estado=$this->model->update_articulo($params,$where);

		if($estado){
			$result = $this->result;
			$result['data'] = 0;
			if($visible_c==1){
				$config = array( 'type' => 1, 'message' => 'Se ha activado el articulo' );
			}else{
				$config = array( 'type' => 1, 'message' => 'Se ha ocultado el articulo' );
			}
			
			$result['msg']['content'] = createMessage($config);
		
		}else{
			$result = $this->result;
			$result['data'] = 0;
			$config = array( 'type' => 2, 'message' => 'No se logro actualizar, intentelo nuevamente' );
			$result['msg']['content'] = createMessage($config);
		}
		//
		$this->db->trans_complete();
		echo json_encode($result);

	}


	public function desactivar_articulo(){
		$result = $this->result;
		$result['status'] = 0;
		$data=json_decode($this->input->post('data'));
		$id_articulo =$data->{'id_articulo'};

		$params = array(
			'estado' => 0
		);
		$where=array('id_articulo'=>$id_articulo );
		$estado=$this->model->update_articulo($params,$where);

		if($estado){
			$result = $this->result;
			$result['data'] = 0;
			$config = array( 'type' => 1, 'message' => 'Se ha eliminado el articulo' );
			$result['msg']['content'] = createMessage($config);
		
		}else{
			$result = $this->result;
			$result['data'] = 0;
			$config = array( 'type' => 2, 'message' => 'No se logro actualizar, intentelo nuevamente' );
			$result['msg']['content'] = createMessage($config);
		}
		//
		echo json_encode($result);
	}

	public function actualizar_comercio_configuracion(){
		$result = $this->result;
		$result['status'] = 1;
		//
		$data=json_decode($this->input->post('data'));
		$id_comercio = $this->session->userdata('id_comercio');
		$params =  array(
			'configurado' => 1
		);
		$where = array('id_comercio'=>$id_comercio);
		$estado = $this->model->update_comercio($params,$where);
		echo json_encode($result);
	}


	public function actualizar_estado_mensaje(){
		$result = $this->result;
		$result['status'] = 0;
		$data=json_decode($this->input->post('data'));
		$estado=false;
		$estado_=$data->{'estado'};

		$id_mensaje= isset($data->{'id_mensaje'}) ? $data->{'id_mensaje'} :"" ;
		if($id_mensaje!=""){
			$params = array(
				'estado' =>$estado_
			);
			$where = array('id_conf_mens'=>$id_mensaje);
			$estado = $this->model->update_configuracion_mensaje($params,$where);
		}
		
		if($estado){
			$result = $this->result;
			$result['status'] = 1;
			$result['data'] = 0;
			$msg="";
			if($estado_==1){
				$msg='Se ha activado el mensaje seleccionado';
			}else{
				$msg='Se ha desactivado el mensaje seleccionado';
			}
			$config = array( 'type' => 1, 'message' => $msg );
			$result['msg']['content'] = createMessage($config);
		}else{
			$result['data'] = 0;
			$config = array( 'type' => 2, 'message' => 'No hay mensaje seleccionado' );
			$result['msg']['content'] = createMessage($config);
		}
		//
		echo json_encode($result);
	}

	public function actualizar_estado_venta_zona(){
		$result = $this->result;
		$result['status'] = 0;
		$data=json_decode($this->input->post('data'));
		$estado=false;
		$estado_=$data->{'estado'};

		$id_venta_zona= isset($data->{'id_venta_zona'}) ? $data->{'id_venta_zona'} :"" ;
		if($id_venta_zona!=""){
			$params = array(
				'estado' =>$estado_
			);
			$where = array('id_pdv_zona'=>$id_venta_zona);
			$estado = $this->model->update_punto_venta_zona($params,$where);
		}
		
		if($estado){
			$result = $this->result;
			$result['status'] = 1;
			$result['data'] = 0;
			$msg="";
			if($estado_==1){
				$msg='Se ha activado el costo por delivery seleccionado';
			}else{
				$msg='Se ha desactivado el costo por delivery seleccionado';
			}
			$config = array( 'type' => 1, 'message' => $msg );
			$result['msg']['content'] = createMessage($config);
		}else{
			$result['data'] = 0;
			$config = array( 'type' => 2, 'message' => 'No hay mensaje seleccionado' );
			$result['msg']['content'] = createMessage($config);
		}
		//
		echo json_encode($result);
	}

	public function actualizar_estado_medio_envio(){
		$result = $this->result;
		$result['status'] = 0;
		$data=json_decode($this->input->post('data'));
		$estado=false;
		$estado_=$data->{'estado'};

		$id_medio= isset($data->{'id_medio'}) ? $data->{'id_medio'} :"" ;
		if($id_medio!=""){
			$params = array(
				'estado' =>$estado_
			);
			$where = array('id_medio_env'=>$id_medio);
			$estado = $this->model->update_medio_envio($params,$where);
		}
		
		if($estado){
			$result = $this->result;
			$result['status'] = 1;
			$result['data'] = 0;
			$msg="";
			if($estado_==1){
				$msg='Se ha activado el medio envio seleccionado';
			}else{
				$msg='Se ha desactivado el medio envio seleccionado';
			}
			$config = array( 'type' => 1, 'message' => $msg );
			$result['msg']['content'] = createMessage($config);
		}else{
			$result['data'] = 0;
			$config = array( 'type' => 2, 'message' => 'No hay mensaje seleccionado' );
			$result['msg']['content'] = createMessage($config);
		}
		//
		echo json_encode($result);
	}

	public function actualizar_estado_punto_venta(){
		$result = $this->result;
		$result['status'] = 0;
		$data=json_decode($this->input->post('data'));
		$estado=false;
		$estado_=$data->{'estado'};

		$id_pdv= isset($data->{'id_pdv'}) ? $data->{'id_pdv'} :"" ;
		if($id_pdv!=""){
			$params = array(
				'estado' =>$estado_
			);
			$where = array('id_pdv'=>$id_pdv);
			$estado = $this->model->update_punto_venta($params,$where);
		}
		
		if($estado){
			$result = $this->result;
			$result['status'] = 1;
			$result['data'] = 0;
			$msg="";
			if($estado_==1){
				$msg='Se ha activado el punto de venta seleccionado';
			}else{
				$msg='Se ha desactivado el punto de venta seleccionado';
			}
			$config = array( 'type' => 1, 'message' => $msg );
			$result['msg']['content'] = createMessage($config);
		}else{
			$result['data'] = 0;
			$config = array( 'type' => 2, 'message' => 'No hay mensaje seleccionado' );
			$result['msg']['content'] = createMessage($config);
		}
		//
		echo json_encode($result);
	}
 
	public function obtener_articulos(){
		$data=json_decode($this->input->post('data'));
		//print_r($data);
		$result = $this->result;
		$result['status'] = 0;
		//
		$array = array();
		//
		$filtros = '';
		if(!empty($data->nombres)) $filtros .= "  AND nombre LIKE '%".$data->nombres."%'";
	
		//
		$articulos = $this->model->find_articulos($filtros)->result_array();
		// 
	 
		$result['result']=1;
		if( count($articulos)==0 ) {
			$result['data']['html1']= '<p class="p-info"><i class="fa fa-info-circle"></i> No se obtuvieron resultados.</p>';
		} else {
			$array = array(
				'articulos' => $articulos
				
			);
			$result['data']['html1']=$this->load->view("operacion/mi_configuracion/articulos_table",$array,true);
		}
		echo json_encode($result);
	}

	public function obtener_medios_envio(){
		$data=json_decode($this->input->post('data'));
		//print_r($data);
		$result = $this->result;
		$result['status'] = 0;
		//
		$array = array();
		//
		$filtros = '';
		$id_comercio = $this->session->userdata('id_comercio');
		// 
		$medios_envio=$this->model->get_medios_envio($id_comercio)->result_array();
	
		$result['result']=1;
		if( count($medios_envio)==0 ) {
			$result['data']['html1']= '<p class="p-info"><i class="fa fa-info-circle"></i> No se obtuvieron resultados.</p>';
		} else {
			$array = array(
				'medio_envios' => $medios_envio
			);
			$result['data']['html1']=$this->load->view("operacion/mi_configuracion/medio_envio_table",$array,true);
		}
		echo json_encode($result);
	}

	public function obtener_puntos_venta(){
		$data=json_decode($this->input->post('data'));
		//print_r($data);
		$result = $this->result;
		$result['status'] = 0;
		//
		$array = array();
		//
		$filtros = '';
		$id_comercio = $this->session->userdata('id_comercio');
		$fecha=date('Y-m-d');

		$arr_puntos=array();
		$res_punto_venta=$this->model->get_puntos_venta($id_comercio,$fecha)->result_array();
		foreach($res_punto_venta as $row){
			$arr_puntos[$row['id_pdv']]=$row;
			$arr_puntos[$row['id_pdv']]['telefonos'][$row['id_pdv_telefono']]=$row['numero'];
		}
		$result['result']=1;
		if( count($arr_puntos)==0 ) {
			$result['data']['html1']= '<p class="p-info"><i class="fa fa-info-circle"></i> No se obtuvieron resultados.</p>';
		} else {
			$array = array(
				'puntos_venta' => $arr_puntos
			);
			$result['data']['html1']=$this->load->view("operacion/mi_configuracion/punto_venta_table",$array,true);
		}
		echo json_encode($result);
	}



	public function actualizar_comercio_metodos(){
		$result = $this->result;
		$result['status'] = 0;
		$data=json_decode($this->input->post('data'));
		$id_comercio = $this->session->userdata('id_comercio');
		$estado_=true;
		$metodo=1;
		$rs_metodos=$this->model->get_comercio_metodo_edit($id_comercio,$metodo)->result_array();
		
		if(count($rs_metodos)>0){
			$params = array(
				'estado' => $data->{'metodo_1'}
			);
			$where=array('id_comercio'=>$id_comercio,'id_metodo_env'=> $metodo);
			$estado=$this->model->update_comercio_metodo($params,$where);
			if(!$estado){
				$estado_=false;
			}
		}else{
			$params = array(
				'id_comercio'=>$id_comercio,
				'id_metodo_env'=>$metodo,
				'estado' => $data->{'metodo_1'}
			);
			$estado=$this->model->set_comercio_metodo($params);
			if(!$estado){
				$estado_=false;
			}
		}

		$metodo=2;
		$rs_metodos=$this->model->get_comercio_metodo_edit($id_comercio,$metodo)->result_array();
		if(count($rs_metodos)>0){
			$params = array(
				'estado' => $data->{'metodo_2'}
			);
			$where=array('id_comercio'=>$id_comercio,'id_metodo_env'=> $metodo);
			$estado=$this->model->update_comercio_metodo($params,$where);
			if(!$estado){
				$estado_=false;
			}
		}else{
			$params = array(
				'id_comercio'=>$id_comercio,
				'id_metodo_env'=>$metodo,
				'estado' => $data->{'metodo_2'}
			);
			$estado=$this->model->set_comercio_metodo($params);
			if(!$estado){
				$estado_=false;
			}
		}

		if($estado_){
			$result = $this->result;
			$result['data'] = 0;
			$config = array( 'type' => 1, 'message' => 'Se ha actualizado correctamente' );
			$result['msg']['content'] = createMessage($config);
		
		}else{
			$result = $this->result;
			$result['data'] = 0;
			$config = array( 'type' => 2, 'message' => 'No se logro actualizar, intentelo nuevamente' );
			$result['msg']['content'] = createMessage($config);
		}
		//
		echo json_encode($result);
	}
}

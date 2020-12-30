<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gestion_usuarios extends MY_Controller {
	
	public function __construct(){
		parent::__construct(); 
		$this->load->model('M_Gestion_usuario','model');
	}
	
	public function index()
	{
		$config['css']['style']=array('../../core/libs/dataTables-1.10.20/datatables');
		$config['js']['script']=array('../../core/libs/dataTables-1.10.20/datatables','../../core/libs/dataTables-1.10.20/datatables-defaults','gestion_usuarios');
		$config['nav']['menu_active']='21';
		//
		$config['data']['icon']='fa fa-users';
		$config['data']['title']='Gestion de Usuarios';
		$config['view']='configuracion/gestion_usuarios';
		$config['data']['message']='Gestion de usuarios del sistema.';
		$data=array('id_comercio'=> "");
		$config['data']['comercios']=$this->model->get_comercios()->result_array();
		$config['data']['id_perfil']=$this->session->userdata('id_usuario_perfil');

		$this->view($config);
	}

	public function lista_usuarios()
	{
		$data=json_decode($this->input->post('data'));
		
		//
		$result = $this->result;
		$result['status'] = 0;
		//
		$array = array();
		
		
		$filtro="";
		$id_comercio="";
		$id_usuario_perfil=$this->session->userdata('id_usuario_perfil');
		if($id_usuario_perfil==1){
			$id_comercio= isset($data->{'id_comercio'}) ? $data->{'id_comercio'} :'' ;
		}else{
			$id_comercio=$this->session->userdata('id_comercio');
		}

		if($id_usuario_perfil==1){

		}else if($id_usuario_perfil==2){
			$filtro.=" and uh.id_usuario_perfil not in (1,2)";
		}else if($id_usuario_perfil==3){
			$filtro.=" and uh.id_usuario_perfil not in (1,2,3)";
		}
		$filtro.= ($id_comercio!="") ?  " AND uh.id_comercio=".$id_comercio." " : "";
		$array['usuarios']=$this->model->get_usuarios($filtro)->result_array();
		
		//
		$result['result']=1;
		if( count($array['usuarios'])==0 ) {
			$result['data']['html']= '<p class="p-info"><i class="fa fa-info-circle"></i> No se obtuvieron resultados.</p>';
			$result['data']['rows'] = 0;
		} else {
			$result['data']['html']=$this->load->view("configuracion/lista_usuarios",$array,true);
			$result['data']['rows'] = count($array['usuarios']);
		}
		echo json_encode($result);
	}

	
	public function edit_usuario(){
		$result = $this->result;
		$result['status'] = 0;
		$data=json_decode($this->input->post('data'));
		$fecha=date('Y-m-d');
		if(isset($data->{'id_usuario'})){
			$id_usuario=$data->{'id_usuario'};
			$id_usuario_hist=isset($data->{'id_usuario_hist'}) ? $data->{'id_usuario_hist'} : "";

			if( $id_usuario!="" ){
				// 
				$id_usuario_perfil=$this->session->userdata('id_usuario_perfil');
				$rs_menus=$this->model->get_all_menus()->result_array();
				$menus=array();
				foreach($rs_menus as $row){
					$menus['grupos'][$row['id_menu_grupo']]['nombre']=$row['grupo'];
					$menus['grupos'][$row['id_menu_grupo']]['icon']=$row['grupo_icon'];
					$menus['menus'][$row['id_menu_grupo']][$row['id_menu']]= $row;
				}


				$rs_menu_usuario=$this->model->get_usuario_menu($id_usuario)->result_array();
				$menus_usuario=array();
				foreach($rs_menu_usuario as $row){
					$menus_usuario[$row['id_menu']]=$row;
				}

				
				$rs_comercios=array();
				$rs_puntos=null;
				$rs_perfiles=null;
				$rs_hist=null;
				if($id_usuario_hist!=""){
					$rs_hist=$this->model->get_usuario_hist($id_usuario_hist)->row_array();
				}
				

				if($id_usuario_perfil==1){
					if(isset($rs_hist['id_comercio'])){
						$rs_puntos=$this->model->get_punto_venta($rs_hist['id_comercio'])->result_array();
					}
					$rs_comercios=$this->model->get_comercios()->result_array();
					$rs_perfiles=$this->model->get_perfiles_adm()->result_array();
				}else if($id_usuario_perfil==2){
					$id_comercio=$this->session->userdata('id_comercio');
					$rs_comercios=$this->model->get_comercio($id_comercio)->result_array();
					$rs_puntos=$this->model->get_punto_venta($id_comercio)->result_array();
					$filtro="and id_usuario_perfil not in (1,2)";
					$rs_perfiles=$this->model->get_perfiles($filtro)->result_array();
				}else if($id_usuario_perfil==3){
					$id_comercio=$this->session->userdata('id_comercio');
					$rs_comercios=$this->model->get_comercio($id_comercio)->result_array();
					$rs_puntos=$this->model->get_punto_venta($id_comercio)->result_array();
					$filtro="and id_usuario_perfil not in (1,2,3)";
					$rs_perfiles=$this->model->get_perfiles($filtro)->result_array();
				}
				$rs_menus=$this->model->get_all_menus()->result_array();
				$array = array(
					  'usuario' => $this->model->get_usuario($id_usuario)->row_array()
					, 'comercios' => $rs_comercios
					, 'pvds' => $rs_puntos
					, 'perfiles' => $rs_perfiles
					, 'usuario_menu' => $menus_usuario
					, 'menus' =>$menus
					, 'id_usuario' => $id_usuario
				);
				$array['hist']=$rs_hist;
				
				$result = $this->result;
				$result['status'] = 1;
				$result['data']['html']=$this->load->view("configuracion/edit_usuario",$array,true);
			}else{
				$result['data'] = 0;
				$config = array( 'type' => 2, 'message' => 'No hay usuario seleccionado' );
				$result['msg']['content'] = createMessage($config);
			}

		}else{

			$id_usuario_perfil=$this->session->userdata('id_usuario_perfil');
			$rs_comercios=array();
			$rs_puntos=null;
			$rs_perfiles=null;
			$id_comercio=null;
			if($id_usuario_perfil==1){
				$rs_comercios=$this->model->get_comercios()->result_array();
				$rs_perfiles=$this->model->get_perfiles_adm()->result_array();
			}else if($id_usuario_perfil==2){
				$id_comercio=$this->session->userdata('id_comercio');
				$rs_comercios=$this->model->get_comercio($id_comercio)->result_array();
				$rs_puntos=$this->model->get_punto_venta($id_comercio)->result_array();
				$filtro="and id_usuario_perfil not in (1,2)";
				$rs_perfiles=$this->model->get_perfiles($filtro)->result_array();
			}else if($id_usuario_perfil==3){
				$id_comercio=$this->session->userdata('id_comercio');
				$rs_comercios=$this->model->get_comercio($id_comercio)->result_array();
				$rs_puntos=$this->model->get_punto_venta($id_comercio)->result_array();
				$filtro="and id_usuario_perfil not in (1,2,3)";
				$rs_perfiles=$this->model->get_perfiles($filtro)->result_array();
			}
				

			// 
			$id_usuario_perfil=$this->session->userdata('id_usuario_perfil');
			$rs_menus=$this->model->get_all_menus()->result_array();
			$menus=array();
			foreach($rs_menus as $row){
				$menus['grupos'][$row['id_menu_grupo']]['nombre']=$row['grupo'];
				$menus['grupos'][$row['id_menu_grupo']]['icon']=$row['grupo_icon'];
				$menus['menus'][$row['id_menu_grupo']][$row['id_menu']]= $row;
			}
			$array = array(
				 'comercios' => $rs_comercios
				, 'perfiles' => $rs_perfiles
				, 'menus' => $menus
				, 'id_comercio'=>$id_comercio
			);
			
			$result = $this->result;
			$result['status'] = 1;
			$result['data']['html']=$this->load->view("configuracion/edit_usuario",$array,true);
			
		}
		//
		echo json_encode($result);
	}
	public function registrar_usuario(){
		$result = $this->result;
		$result['status'] = 0;
		$data=json_decode($this->input->post('data'));

		$rs_usuarios=array();//$this->model->val_usuario($data->{'usuario'})->result_array();
		$rs_dni=array();//$this->model->val_usuario_dni($data->{'nro_documento'})->result_array();

		if( !count($rs_usuarios)>0 &&  !count($rs_dni)>0){
			$params = array(
				'nombres' => $data->{'nombres'},
				'ape_paterno' => $data->{'apellido_pat'},
				'ape_materno' => $data->{'apellido_mat'},
				'nombre_usuario' => $data->{'usuario'},
				'clave' => $data->{'clave'},
				'email' => $data->{'email'},
				'nro_documento' => $data->{'nro_documento'},
				'estado' => 1
			);
			$estado = $this->model->set_usuario($params);
	
			if($estado){
				$id_usuario = $this->mysql_last_id();
				if($estado){
					
		
					$menus=isset($data->{'menu'})?  $data->{'menu'} : "";
					if( is_array($menus)==true ){
						for($i=0;$i<sizeof($menus);$i++){
							$params =  array(
								'estado' => 1,
								'id_menu'=>$menus[$i],
								'id_usuario'=>$id_usuario
							);
							$estado = $this->model->set_usuario_menu($params);
						}
		
					}else{
						if($menus!=""){
							$params =  array(
								'estado' => 1,
								'id_menu'=>$menus,
								'id_usuario'=>$id_usuario
							);
							$estado = $this->model->set_usuario_menu($params);
						}
					}
		
				}
				
				$params =  array(
					'fecIni' => date('Y-m-d')
					,  'estado'=> 1
					, 'id_usuario' => $id_usuario
					, 'id_usuario_perfil' => $data->{'id_perfil'}
					, 'id_comercio' => ($data->{'id_comercio_usuario'}!="")? $data->{'id_comercio_usuario'}:null
					, 'id_pdv' => ($data->{'id_pdv'}!="") ? $data->{'id_pdv'} : null
				);
				$estado = $this->model->set_usuario_hist($params);
					//
				$result = $this->result;
				$result['status'] = 1;
				$result['data'] = 0;
				$config = array( 'type' => 1, 'message' => 'Se ha registrado el usuario correctamente' );
				$result['msg']['content'] = createMessage($config);
				//
				
				$config = array( 
					'nombre_usuario' =>  $data->{'apellido_pat'} . ' '. $data->{'apellido_mat'}.' '.$data->{'nombres'}, 
					'usuario' => $data->{'usuario'},
					'clave' => $data->{'clave'}
					);

				$html=$this->load->view("operacion/correo_notificacion_usuario_registro",$config,true);
				$correo['to'] =$data->{'email'};
				$titulo='NOTIFICACIÓN TURNO';
				$this->correo($correo,$titulo,$html);
			}else{
				$result['data'] = 0;
				$result['status'] = 0;
				$config = array( 'type' => 2, 'message' => 'No se ha podido registrar, intentelo nuevamente' );
				$result['msg']['content'] = createMessage($config);
			}
		}else{
			$result = $this->result;
			$result['status'] = 0;
			$result['data'] = 0;

			if(count($rs_dni)>0){
				$config = array( 'type' => 2, 'message' => 'No se ha podido registrar.Ya existe un registro con el mismo DNI.' );
			}else if(count($rs_usuarios)>0){
				$config = array( 'type' => 2, 'message' => 'No se ha podido actualizar.Ya existe un registro con el mismo nombre de usuario.' );
			}else{
				$config = array( 'type' => 2, 'message' => 'No se ha podido registrar, intentelo nuevamente' );
			}
			$result['msg']['content'] = createMessage($config);
		}
		
		//
		echo json_encode($result);
	}
	public function actualizar_usuario(){
		$result = $this->result;
		$result['status'] = 0;
		$data=json_decode($this->input->post('data'));

		$id_usuario=$data->{'id_usuario_editar'};
		$id_usuario_hist= $data->{'id_usuario_hist'};


		$rs_usuarios=$this->model->val_usuario_act($data->{'usuario'},$id_usuario)->result_array();
		$rs_dni=$this->model->val_usuario_dni_act($data->{'nro_documento'},$id_usuario)->result_array();
		
		if( !count($rs_usuarios)>0 &&  !count($rs_dni)>0){
			$params = array(
				'nombres' => $data->{'nombres'},
				'ape_paterno' => $data->{'apellido_pat'},
				'ape_materno' => $data->{'apellido_mat'},
				'nombre_usuario' => $data->{'usuario'},
				'clave' => $data->{'clave'},
				'email' => $data->{'email'},
				'nro_documento' => $data->{'nro_documento'}
			);
			$where=array( 'id_usuario' => $id_usuario );
			$estado = $this->model->update_usuario($params,$where);
	
	
			//menus
			$params =  array(
				'estado' => 0
			);
			$where=array( 'id_usuario' =>$id_usuario );
			$this->model->update_usuario_menu($params,$where);
	
			$menus=isset($data->{'menu'})?  $data->{'menu'} : "";
			if( is_array($menus)==true ){
				for($i=0;$i<sizeof($menus);$i++){
					$params =  array(
						'estado' => 1
					);
					$where=array( 'id_menu' => $menus[$i], 'id_usuario' =>$id_usuario );
					$estado = $this->model->update_usuario_menu($params,$where);
	
					if($estado==1){
						$params =  array(
							'estado' => 1,
							'id_menu'=>$menus[$i],
							'id_usuario'=>$id_usuario
						);
						$estado = $this->model->set_usuario_menu($params);
					}
				}
	
			}else{
				if($menus!=""){
					$params =  array(
						'estado' => 1
					);
					$where=array( 'id_menu' => $menus, 'id_usuario' =>$id_usuario );
					$estado = $this->model->update_usuario_menu($params,$where);
	
					if($estado==1){
						$params =  array(
							'estado' => 1,
							'id_menu'=>$menus,
							'id_usuario'=>$id_usuario
						);
						$estado = $this->model->set_usuario_menu($params);
					}
				}
			}
	
	
	
	
			if($id_usuario_hist==""){
				$params =  array(
					'fecIni' => date('Y-m-d')
					,  'estado'=> 1
					, 'id_usuario' => $id_usuario
					, 'id_usuario_perfil' => $data->{'id_perfil'}
					, 'id_comercio' => ($data->{'id_comercio_usuario'}!="")?  $data->{'id_comercio_usuario'}: null 
					, 'id_pdv' => ($data->{'id_pdv'}!="") ? $data->{'id_pdv'} : null
				);
				$estado = $this->model->set_usuario_hist($params);
			}else{
				$params =  array(
					'id_usuario_perfil' => $data->{'id_perfil'}
				  , 'id_comercio' => ($data->{'id_comercio_usuario'}!="")?  $data->{'id_comercio_usuario'}: null 
				  , 'id_pdv' => ($data->{'id_pdv'}!="") ? $data->{'id_pdv'} : null
				);
				$where=array( 'id_usuario_hist' => $id_usuario_hist );
				$estado = $this->model->update_usuario_hist($params,$where);
			}

			$result = $this->result;
			$result['status'] = 1;
			$result['data'] = 0;
			$config = array( 'type' => 1, 'message' => 'Se ha actualizado correctamente.' );
			$result['msg']['content'] = createMessage($config);

		}else{
			$result = $this->result;
			$result['status'] = 0;
			$result['data'] = 0;

			if(count($rs_dni)>0){
				$config = array( 'type' => 2, 'message' => 'No se pudo actualizar.Ya existe un registro con el mismo DNI.' );
			}else if(count($rs_usuarios)>0){
				$config = array( 'type' => 2, 'message' => 'No se pudo actualizar.Ya existe un registro con el mismo nombre de usuario.' );
			}else{
				$config = array( 'type' => 2, 'message' => 'No se ha podido actualizar, intentelo nuevamente' );
			}
			$result['msg']['content'] = createMessage($config);
		}
		
		
		echo json_encode($result);
	}

	public function actualizar_estado_usuario(){
		$result = $this->result;
		$result['status'] = 0;
		$data=json_decode($this->input->post('data'));
		$estado=false;
		$estado_=$data->{'estado'};

		$id_usuario= isset($data->{'id_usuario'}) ? $data->{'id_usuario'} :"" ;
		if($id_usuario!=""){
			$params = array(
				'estado' =>$estado_
			);
			$where = array('id_usuario'=>$id_usuario);
			$estado = $this->model->update_usuario($params,$where);
		}
		
		if($estado){
			$result = $this->result;
			$result['status'] = 1;
			$result['data'] = 0;
			$msg="";
			if($estado_==1){
				$msg='Se ha activado el usuario seleccionado.';
			}else{
				$msg='Se ha desactivado el usuario seleccionado.';
			}
			$config = array( 'type' => 1, 'message' => $msg );
			$result['msg']['content'] = createMessage($config);
		}else{
			$result['data'] = 0;
			$config = array( 'type' => 2, 'message' => 'No hay usuario seleccionado' );
			$result['msg']['content'] = createMessage($config);
		}
		//
		echo json_encode($result);
	}
 

	public function obtener_puntos_venta(){
		$result = $this->result;
		$result['status'] = 0;
		$data=json_decode($this->input->post('data'));
		$id_comercio = $data->{'id_comercio'};
		//
		if($id_comercio!=""){
			$rs_pdv=$this->model->get_punto_venta($id_comercio)->result_array();
			$result = $this->result;
		
			$result['data'] = $rs_pdv;
			$config = array( 'type' => 1, 'message' => 'Se ha registrado correctamente.' );
			$result['msg']['content'] = createMessage($config);
		}
		//
		echo json_encode($result);
	}

	public function obtener_menus(){
		$result = $this->result;
		$result['status'] = 0;
		$data=json_decode($this->input->post('data'));
		$id_usuario_perfil = $data->{'id_usuario_perfil'};
		//
		if($id_usuario_perfil!=""){
			$rs_menus=$this->model->get_menus($id_usuario_perfil)->result_array();
			$result = $this->result;
		
			$result['data'] = $rs_menus;
			$config = array( 'type' => 1, 'message' => 'Se ha registrado correctamente.' );
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

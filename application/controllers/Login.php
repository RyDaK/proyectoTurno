<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('M_Login','model');
	}
	
	public function index()
	{
		$config['css']['style']=array();
		$config['js']['script']=array('login');
		$config['single'] = true;
		$this->view($config);
	}
	
	public function acceder(){
		$data=json_decode($this->input->post('data'));
		//
		$params = array(
			'usuario' => $data->user
			, 'password' => $data->password
		);
		$result = $this->result;
		$result['status'] = 0;
		//
		$filtros = "";
		if(!empty($params['usuario']) && !empty($params['password'])) $filtros .= " AND u.nombre_usuario = '".$params['usuario']."' AND u.clave = '".$params['password']."'";
		$rs=$this->model->find_usuario($filtros);
		$config_ = array( 'type' => 2, 'message' => "Ocurrió un error al validar sus datos, vuelva a intentarlo." );
		if(!$rs) $result['msg']['content']=$result['msg']['content']=createMessage($config_);
		else{
			$num_rows=count($rs->result_array());
			$config_ = array( 'type' => 2, 'message' => "Los datos ingresados no permiten el acceso.");
			if($num_rows==0) $result['msg']['content']=createMessage($config_);
			else{
				$result['status']=1;
				//
				$id_comercio="";
				$comercios = array(); $pdv = array();
				foreach($rs->result_array() as $row ){
					if(!empty($row['id_comercio'])){
						$comercios[$row['id_comercio']] = $row['id_comercio'];
						$id_comercio= $row['id_comercio'];
					} 
					
					if(!empty($row['id_pdv'])) $pdv[$row['id_pdv']] = $row['id_pdv'];
				}
				//
				$usuario = $rs->row_array();
				$menu = $this->model->find_menu($usuario['id_usuario'])->result_array();
				$config_ = array( 'type' => 2, 'message' => 'Usted no tiene permisos asignados, comuniquese con el administrador.' );
				if( count($menu) < 1 ) $result['msg']['content']=createMessage($config_);
				else {
					$result['result']=1;

					if($id_comercio!=""){
						$rs_comercio=$this->model->get_comercio($id_comercio)->row_array();
						if(isset($rs_comercio['configurado'])){
							if($rs_comercio['configurado']!=1){
								$result['url']='configuracion/';
							}
						}
					}
					
					if( !isset($result['url'])){
						if($usuario['id_usuario_perfil'] == 4) $result['url']='pedidos/';
						else $result['url']='home/';
					}
					
					$result['msg']['title']="Login";
					$config_ = array( 'type' => 1, 'message' => "Bienvenido al sistema <strong>".$usuario['nombres']." ".$usuario['ape_paterno']." ".$usuario['ape_materno']."</strong>");
					$result['msg']['content']=$result['msg']['content']=createMessage($config_);
					$usuario['menu'] = $menu;
					$usuario['comercios'] = $comercios;
					$usuario['pdv'] = $pdv;
					$this->session->set_userdata($usuario);
				}
			}
		}
		echo json_encode($result);
	}
}

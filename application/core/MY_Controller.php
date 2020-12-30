<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller{
	var $namespace;
	var $result;
	var $idUsuario;
	var $id_usuario_cliente;

    public function __construct(){
		parent::__construct();
		$this->namespace = $this->router->fetch_class();
		$this->idUsuario = $this->session->userdata('id_usuario');
		$this->id_usuario_cliente = $this->session->userdata('id_usuario_cliente');

		$is_ajax = $this->input->is_ajax_request();
		//
		if( !empty($this->idUsuario) && $this->namespace == 'login') redirect('home','refresh');
		else {
			if( empty($this->idUsuario) && $this->namespace != 'home_cliente' &&  $this->namespace != 'ticket' && $this->namespace != 'login' && $this->namespace != "Cliente"&& $this->namespace != "cliente") {
				if( $is_ajax ){
					$result=array();
					$result['result']=0;
					$result['data']='';
					$result['msg']['title']="Sesión";
					$result['msg']['content']="Su sesi&oacute;n ha caducado. Identifiquese nuevamente <a href='".base_url()."'>aqu&iacute;</a>";
					$result['url']='';
					echo json_encode($result);
					exit;
				}
				else redirect('login','refresh');
			}
		}
		//
		$this->result = array(
			'status' => 0,
			'url' => '',
			'data' => array(),
			'msg' => array( 'title' => 'Alerta', 'content' => '' ),
			'session' => true,
			'result' => 1,
		);
    }
	
	public function logout(){
		$this->session->sess_destroy();
		$result=array();
			$result['result']=1;
			$result['url']='login/';
			$result['data']='';
			$result['msg']['title']='';
			$result['msg']['content']='';

		echo json_encode($result);
	}

	public function fn_404(){
		$config['css']['style']=array();
		$config['single'] = true;
		$config['view'] = 'templates/404';
		$this->view($config);
	}
	
	public function get_dni($dni){
		$result = $this->result;

		/*
			https://www.apisperu.com/ generación de token:
				webmaster@turno.macctec.com
				elmwNY+?Ck8U
		*/

		$site = 'http://dniruc.apisperu.com/api/v1/dni/'.$dni.'?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6IndlYm1hc3RlckB0dXJuby5tYWNjdGVjLmNvbSJ9.ANgmBhcpvztFEZB9hMpr4Bk1nd-OVEmtgZX5T-Sky74';

		$data = @file_get_contents($site);
		//$data = json_decode($data, true);
		//echo $data;
		if(!empty($data)){
			$result['status'] = 1;
		}
		else{
			$result['data'] = 0;
			$config = array( 'type' => 2, 'message' => 'El servicio para verificar el número de DNI no esta disponible' );
			$result['msg']['content'] = createMessage($config);
		}

		$result['data'] = json_decode($data);
		echo json_encode($result);
	}

	public function mysql_last_id(){
		return $this->db->query('SELECT LAST_INSERT_ID() id')->row()->id;
	}
	
	public function view($config=array()){
		if( !isset($config['data']) ) $config['data']=array();
		//
		if( !isset($config['js']['script']) ) $config['js']['script']=array();
		if( !isset($config['css']['style']) ) $config['css']['style']=array();
		//
		//array_push($config['js']['script'],'core/system','core/functions');
		//
		//
		$this->load->view('core/01_head',$config['css']);
		//
		$single = isset($config['single'])? $config['single'] : false;
		$this->load->view('core/02_body', array('single'=> $single));
		if(!$single){
			$this->load->view('core/03_header', array());
			$this->load->view('core/04_container', array());
			$this->load->view('core/05_nav',(isset($config['nav'])? $config['nav'] : array()));
			$this->load->view('core/06_content', array());
			$this->load->view('core/07_content_title', $config['data']);
		}
		$view = isset($config['view'])? $config['view'] : $this->namespace;
		$this->load->view($view,$config['data']);
		if(!$single){
			$this->load->view('core/08_content_end', array());
		}
		$this->load->view('core/09_body_end');
		$this->load->view('core/10_body_js',$config['js']);
		$this->load->view('core/11_body_end');
	}
	
	public function view_cliente($config=array()){
		
		if( !isset($config['data']) ) $config['data']=array();
		//
		if( !isset($config['js']['script']) ) $config['js']['script']=array();
		if( !isset($config['css']['style']) ) $config['css']['style']=array();
		//
		//array_push($config['js']['script'],'core/system','core/functions');
		//
		//
		$this->load->view('core_cliente/01_head',$config['css']);
		//
		$single = isset($config['single'])? $config['single'] : false;
		$this->load->view('core_cliente/02_body', array('single'=> $single));
		if(!$single){
			$this->load->view('core_cliente/03_header', array());
			$this->load->view('core_cliente/04_container', array());
			$this->load->view('core_cliente/05_nav',(isset($config['nav'])? $config['nav'] : $config['data']));
			$this->load->view('core_cliente/06_content', array());
			$this->load->view('core_cliente/07_content_title', $config['data']);
		}
		$view = isset($config['view'])? $config['view'] : $this->namespace;
		$this->load->view($view,$config['data']);
		if(!$single){
			$this->load->view('core_cliente/08_content_end', array());
		}
		$this->load->view('core_cliente/09_body_end');
		$this->load->view('core_cliente/10_body_js',$config['js']);
		$this->load->view('core_cliente/11_body_end');
	}
	
}

?>
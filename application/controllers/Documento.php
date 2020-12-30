<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Documento  extends MY_Controller {
	
	public function __construct(){
		parent::__construct();
		// $this->load->model('M_Login_cliente','model');
	}
	
	public function index()
	{
	
		// // $cod_comercio = $this->input->post('cod_comercio');
		// $config['css']['style']=array('../../core/libs/dataTables-1.10.20/datatables','../../core/css/cards');
		// $config['js']['script']=array('../../core/libs/dataTables-1.10.20/datatables','../../core/libs/dataTables-1.10.20/datatables-defaults','cliente');

		// // $config['nav']['menu_active']='10';
		// //
		// //$config['js']['script']=array('cliente');
		// $config['data']['icon']='pe-7s-coffee';
		// 	$config['data']['title']='<a href="'.base_url().'Cliente">COMERCIOS AFILIADOS</a>';
		// $config['view']='cliente/index';
		// $config['data']['message']='';
		// $config['data']['departamentos'] = $this->model->listar_dpts()->result_array();
		// $config['data']['comercios'] = $this->model->listar_tipo_comercio()->result_array();
		// $config['data']['comercios_afiliados'] = $this->model->listar_comercios_afiliados()->result();

		// $this->view_cliente($config);

		// $this->load->view('documentos/terminos_condiciones');

		$this->load->helper('download');
		$this->uri->segment(3);
		$data   = file_get_contents('../files/TERMINOS_Y_CONDICIONES_DEL_USO_DE_LA_PLATAFORMA_DE_SERVICIOS_TURNO.pdf'.$this->uri->segment(3));
		$name   = $this->uri->segment(3);
		force_download($name, $data);
	}

}
?>
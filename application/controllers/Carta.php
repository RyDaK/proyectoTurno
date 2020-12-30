<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Carta extends MY_Controller {
	
	public function __construct(){
		parent::__construct(); 
		$this->load->model('M_Configuracion','model');
	}
	
	public function index()
	{
		//$config['css']['style']=array('../../core/libs/dataTables-1.10.20/datatables');
		$config['js']['script']=array('mi_carta');
		$config['nav']['menu_active']='26';
		//
		$fecha=date('Y-m-d');
		$id_comercio = $this->session->userdata('id_comercio');
		$res_comercio=$this->model->get_comercio($id_comercio)->row_array();
		
		$id_local = $this->session->userdata('id_pdv');
		$res_local=$this->model->get_punto_venta($id_local)->row_array();
	
		$id_usuario = $this->session->userdata('id_usuario');
		$res_usuario=$this->model->get_usuario($id_usuario)->row_array();
		$config['data']['usuario']=$res_usuario;		

		$res_articulos=$this->model->get_articulos($id_comercio)->result_array();
		$config['data']['articulos']=$res_articulos;

		$config['data']['icon']='fas fa-cart-arrow-down';
		$config['data']['title']=$res_comercio['nombre_comercio'].'/ '.$res_local['nombre'];
		$config['view']='operacion/mi_carta';
		$config['data']['message']='Desde aquí podras poner visible o quitar visibilidad a los articulos de tu carta.';
		
		
		$this->view($config);
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
		$visibilidad = $this->model->find_articulos_local('')->result_array();
		// 
		$array_visibilidad =  array();
		foreach($visibilidad as $row){
			$array_visibilidad[$row['id_articulo']]=$row;
			
		}
		
		
		$result['result']=1;
		if( count($articulos)==0 ) {
			$result['data']['html1']= '<p class="p-info"><i class="fa fa-info-circle"></i> No se obtuvieron resultados.</p>';
		} else {
			$array = array(
				'articulos' => $articulos
				, 'visibilidad' => $array_visibilidad
			);
			$result['data']['html1']=$this->load->view("operacion/mi_carta/articulos_table",$array,true);
		}
		echo json_encode($result);
	}
	
	public function ocultar_articulos(){
		$result = $this->result;
		$result['status'] = 0;
		$data=json_decode($this->input->post('data'));
		$id_comercio = $this->session->userdata('id_comercio');
		$id_local = $this->session->userdata('id_pdv');

		$estado=$this->model->delete_all_articulo_local($id_comercio, $id_local);

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
		$result = $this->result;
		$result['status'] = 0;
		$data=json_decode($this->input->post('data'));
		$id_local = $this->session->userdata('id_pdv');
		$id_articulo =$data->{'id_articulo'};
		$visible =$data->{'visible'};
		$visible_c=( ($visible==1)? 0 : 1 );

		if($visible_c==1){
			$estado=$this->model->delete_articulo_local($id_local, $id_articulo);
		} else {
			$data=array('id_articulo'=>$id_articulo,'id_pdv'=>$id_local );
			$estado=$this->model->insert_articulo_local($data);
		}
		

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
		echo json_encode($result);
	}
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Print extends MY_Model{
	
	public function __construct(){
		parent::__construct();
	}

	public function get_data($id){
		$sql = "
			SELECT *,DATE_FORMAT(hora,'%H:%i:%s') as hora_,
			DATE_FORMAT(fecha, '%Y-%m-%d') as fecha_ FROM aromance_turno_prueba.mc_pedido_etapa_detalle WHERE idPedidoCliente = $id;
		;";
		return $this->db->query($sql);
	}
	public function get_data_local($id){
		$sql = "
			SELECT *,DATE_FORMAT(hora,'%H:%i:%s') as hora_,
			DATE_FORMAT(fecha, '%Y-%m-%d') as fecha_ FROM mc_pedido_etapa_detalle WHERE idPedidoCliente = $id;
		;";
		return $this->db->query($sql);
	}
	
}
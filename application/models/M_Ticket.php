<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Ticket extends MY_Model{
	
	public function __construct(){
		parent::__construct();
	}

	public function find_cliente($filtros){
		$sql = "
			SELECT 
				id_cliente
			FROM 
				ts_cliente c
			WHERE
				c.estado = 1
				$filtros
		;";
		return $this->db->query($sql);
	}
	
	public function find_cliente_telefono($filtros){
		$sql = "
			SELECT 
				id_cliente
			FROM 
				ts_cliente_telefono ct
			WHERE
				ct.estado = 1
				$filtros
		;";
		return $this->db->query($sql);
	}
	
	public function set_cliente($data){
		return $this->db->insert('ts_cliente', $data);
	}
	
	public function set_cliente_telefono($data){
		return $this->db->insert('ts_cliente_telefono', $data);
	}
	
	public function set_pedido($data){
		return $this->db->insert('ts_pedido', $data);
	}
	
	public function set_pedido_hist($data){
		return $this->db->insert('ts_pedido_hist', $data);
	}


	public function get_pdv($filtros){
		$sql = "
			SELECT 
				pv.id_pdv
				, pv.nombre pdv
				, pv.direccion
				, co.id_comercio
				, co.nombre comercio
				, cc.id_centro_comercial
				, cc.nombre cc
				, ub.id_ubigeo
				, ub.departamento
				, ub.provincia
				, ub.distrito								, co.ruta_logo
			FROM 
				ms_punto_venta pv
				JOIN ms_comercio co ON co.id_comercio = pv.id_comercio AND co.estado = 1
				JOIN ms_ubigeo ub ON ub.id_ubigeo = pv.id_ubigeo AND ub.estado = 1
				LEFT JOIN ms_centro_comercial cc ON cc.id_centro_comercial = pv.id_centro_comercial
			WHERE
				pv.estado = 1
				$filtros
		;";
		return $this->db->query($sql);
	}
	
	public function get_tipo_doc(){
		 $sql = "
			SELECT id_doc_tipo value, breve name FROM ms_documento_tipo
		;";
		return $this->db->query($sql);
	}
}
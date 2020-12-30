<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Pedido extends MY_Model{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function get_configuracion_alerta($pedidos){
		$sql = "
			SELECT 
				p.id_pedido
				, p.ticket
				, ca.titulo
				, REPLACE(REPLACE(ca.contenido,'[comercio]',ca.titulo),'[cliente]',c.nombres) contenido
				, p.numero
				, concat('51',p.numero) telefono
			FROM 
				ms_configuracion_alerta ca
				JOIN ms_punto_venta pv ON pv.id_comercio = ca.id_comercio AND pv.estado = 1
				JOIN ts_pedido p ON p.id_pdv = pv.id_pdv AND p.estado = 1
				JOIN ts_cliente c ON c.id_cliente = p.id_cliente
			WHERE
				p.id_pedido IN ($pedidos)
			;
		";
		return $this->db->query($sql);
	}
	
	public function set_pedido_hist($data){
		return $this->db->insert('ts_pedido_hist', $data);
	}
	
	public function update_pedido($data,$where){
		$this->db->set($data);
		$this->db->where($where);
		return $this->db->update('ts_pedido');
	}

	public function find_comercios(){
		$comercios = $this->session->userdata('comercios');
		$pdv = $this->session->userdata('pdv');
		$filtros = '';
		if(!empty($comercios)) $filtros .= " AND pv.id_comercio IN (".implode(",",$comercios).")";
		if(!empty($pdv)) $filtros .= " AND pv.id_pdv IN (".implode(",",$pdv).")";
		//
		$sql = "
			SELECT 
				co.id_comercio, co.nombre comercio, pv.id_pdv, pv.nombre pdv 
			FROM 
				ms_punto_venta pv
				JOIN ms_comercio co ON co.id_comercio = pv.id_comercio AND co.estado = 1
			WHERE 
				pv.estado = 1
				$filtros
			;
		";
		return $this->db->query($sql);
	}
	
	public function find_pendientes(){
		$comercios = $this->session->userdata('comercios');
		$pdv = $this->session->userdata('pdv');
		$filtros = '';
		if(!empty($comercios)) $filtros .= " AND pv.id_comercio IN (".implode(",",$comercios).")";
		if(!empty($pdv)) $filtros .= " AND pv.id_pdv IN (".implode(",",$pdv).")";
		$sql = "
			SELECT 
				p.id_pedido
				, DATE(p.tiempo_registro) fecha_registro
				, TIME(p.tiempo_registro) hora_registro
				, p.ticket
				, co.id_comercio
				, co.nombre comercio
				, pv.id_pdv
				, pv.nombre pdv
				, IFNULL(cc.nombre, pv.direccion) direccion
				, DATE_ADD(now(), INTERVAL 1 HOUR) ahora
				, TIMEDIFF(DATE_ADD(now(), INTERVAL 1 HOUR),p.tiempo_registro) tiempo_transcurrido
				, p.id_pedido_etapa
				, pe.nombre etapa
				, c.nombres cliente
				, c.ape_paterno
				, c.ape_materno
				, c.nro_documento
				, c.id_doc_tipo
				, CONCAT(u.nombres,' ', u.ape_paterno, ' ', u.ape_materno) usuario
				, p.numero telefono
			FROM 
				ts_pedido p
				JOIN ms_pedido_etapa pe ON pe.id_pedido_etapa = p.id_pedido_etapa AND pe.estado = 1
				JOIN ms_punto_venta pv ON pv.id_pdv = p.id_pdv AND pv.estado = 1
				JOIN ms_comercio co ON co.id_comercio = pv.id_comercio AND co.estado = 1
				LEFT JOIN ms_centro_comercial cc ON  cc.id_centro_comercial = pv.id_centro_comercial AND cc.estado = 1
				JOIN ts_cliente c ON c.id_cliente = p.id_cliente AND c.estado = 1
				LEFT JOIN ms_usuario u ON u.id_usuario = p.id_usuario
			WHERE 
				p.id_pedido_etapa = 1
				AND p.estado =1
				AND DATE(p.tiempo_registro) = @fecha
				$filtros
			ORDER BY tiempo_transcurrido ASC
			;
		";
		return $this->db->query($sql);
	}
	
	public function find_pedidos($filtros){
		$comercios = $this->session->userdata('comercios');
		$pdv = $this->session->userdata('pdv');
		if(!empty($comercios)) $filtros .= " AND pv.id_comercio IN (".implode(",",$comercios).")";
		if(!empty($pdv)) $filtros .= " AND pv.id_pdv IN (".implode(",",$pdv).")";
		$sql = "
			SELECT 
				p.id_pedido
				, DATE(p.tiempo_registro) fecha_registro
				, TIME(p.tiempo_registro) hora_registro
				, DATE(p.tiempo_entrega) fecha_atencion
				, TIME(p.tiempo_entrega) hora_atencion
				, p.ticket
				, co.id_comercio
				, co.nombre comercio
				, pv.id_pdv
				, pv.nombre pdv
				, IFNULL(cc.nombre, pv.direccion) direccion
				, DATE_ADD(now(), INTERVAL 1 HOUR) ahora
				, TIMEDIFF(p.tiempo_entrega,p.tiempo_registro) tiempo_transcurrido
				, pe.id_pedido_etapa
				, pe.nombre etapa
				, c.nombres cliente
				, CONCAT(u.nombres,' ', u.ape_paterno, ' ', u.ape_materno) usuario
				, p.numero telefono
				, ph.id_pedido_etapa id_pedido_etapa_hist
				, phe.nombre etapa_hist
				, DATE(ph.tiempo) fecha_etapa
				, TIME(ph.tiempo) hora_etapa
				, p.flagAuto
			FROM 
				ts_pedido p
				JOIN ms_pedido_etapa pe ON pe.id_pedido_etapa = p.id_pedido_etapa AND pe.estado = 1
				JOIN ms_punto_venta pv ON pv.id_pdv = p.id_pdv AND pv.estado = 1
				JOIN ms_comercio co ON co.id_comercio = pv.id_comercio AND co.estado = 1
				LEFT JOIN ms_centro_comercial cc ON  cc.id_centro_comercial = pv.id_centro_comercial AND cc.estado = 1
				JOIN ts_cliente c ON c.id_cliente = p.id_cliente AND c.estado = 1
				LEFT JOIN ms_usuario u ON u.id_usuario = p.id_usuario
				JOIN ts_pedido_hist ph ON ph.id_pedido = p.id_pedido
				JOIN ms_pedido_etapa phe ON phe.id_pedido_etapa = ph.id_pedido_etapa AND phe.estado = 1
			WHERE 
				p.estado =1
				AND  DATE(p.tiempo_registro) BETWEEN @fecIni AND @fecFin
				$filtros
			ORDER BY tiempo_registro ASC
			;
		";
		return $this->db->query($sql);
	}
}
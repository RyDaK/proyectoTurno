<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Delivery extends MY_Model{
	
	public function __construct(){
		parent::__construct();
	} 
	
	public function find_delivery_detalle($filtros){
		$comercios = $this->session->userdata('comercios');
		$pdv = $this->session->userdata('pdv');
		if(!empty($comercios)) $filtros .= " AND pv.id_comercio IN (".implode(",",$comercios).")";
		if(!empty($pdv)) $filtros .= " AND pv.id_pdv IN (".implode(",",$pdv).")";
		$sql = "
			SELECT DISTINCT 
				p.idPedidoCliente id_pedido
				,SUM(importe) total
			FROM `mc_pedido_cliente` p
			JOIN ms_punto_venta pv ON pv.id_pdv=p.idComercioLocal
			JOIN ms_comercio cm ON cm.id_comercio=pv.id_comercio
			JOIN mc_pedido_cliente_detalle d ON d.idPedidoCliente = p.idPedidoCliente
			WHERE p.estado=1
			AND  DATE(p.fecha) BETWEEN @fecIni AND @fecFin
			$filtros
			GROUP BY p.idPedidoCliente
			;
		";
		return $this->db->query($sql);
	}
	
	public function find_delivery_etapas($filtros){
		$comercios = $this->session->userdata('comercios');
		$pdv = $this->session->userdata('pdv');
		if(!empty($comercios)) $filtros .= " AND pv.id_comercio IN (".implode(",",$comercios).")";
		if(!empty($pdv)) $filtros .= " AND pv.id_pdv IN (".implode(",",$pdv).")";
		$sql = "
			SELECT DISTINCT 
				p.idPedidoCliente id_pedido
				, e.idPedidoEtapa
				, e.fecha 
			FROM `mc_pedido_cliente` p
			JOIN ms_punto_venta pv ON pv.id_pdv=p.idComercioLocal
			JOIN ms_comercio cm ON cm.id_comercio=pv.id_comercio
			JOIN mc_pedido_etapa_detalle e ON e.idPedidoCliente = p.idPedidoCliente
			WHERE p.estado=1
			AND  DATE(p.fecha) BETWEEN @fecIni AND @fecFin
			$filtros
			;
		";
		return $this->db->query($sql);
	}
	
	public function find_delivery($filtros){
		$comercios = $this->session->userdata('comercios');
		$pdv = $this->session->userdata('pdv');
		if(!empty($comercios)) $filtros .= " AND pv.id_comercio IN (".implode(",",$comercios).")";
		if(!empty($pdv)) $filtros .= " AND pv.id_pdv IN (".implode(",",$pdv).")";
		$sql = "
			SELECT DISTINCT 
				cm.nombre as 'comercio',
				p.idPedidoCliente id_pedido , 
				pv.nombre as 'local',
				p.hora tiempo_entrega
				, ca.nombre as 'canal'
				, sca.nombre as 'subcanal'
				, p.medio_entrega as 'tipo'
				,  p.costo_delivery as 'monto'
				, cl.nombres,p.direccion,ub.distrito as 'distrito', null numero,p.medio_pago as 'tipo_pago', 
				med.fecha tiempo_registro,
				mev.titulo as 'medio_env', 
				pe.nombre as 'pedido_etapa',
				null flagAuto,pe.idPedidoEtapa id_pedido_etapa,
				med.fecha tiempo,
				ped.nombre as 'etapa'
			FROM `mc_pedido_cliente` p
			JOIN ms_punto_venta pv ON pv.id_pdv=p.idComercioLocal
			JOIN ms_comercio cm ON cm.id_comercio=pv.id_comercio
			JOIN ms_giro sca ON sca.id_giro=cm.id_giro
			JOIN ms_rubro ca ON ca.id_rubro=sca.id_rubro
			
			/*LEFT JOIN ms_metodo_envio me ON me.id_metodo_env=p.id_metodo_envio*/
			LEFT JOIN mc_usuario_cliente cl ON cl.idUsuarioCliente=p.idUsuarioCliente 
			LEFT JOIN ms_ubigeo ub ON ub.id_ubigeo=p.id_ubigeo
			/*LEFT JOIN ms_tipo_pago tp ON tp.id_tipo_pago=p.medio_pago*/
			LEFT JOIN ms_medio_envio mev ON mev.id_medio_env=p.medio_envio
			LEFT JOIN mc_pedido_etapa_detalle med ON med.idPedidoCliente = p.idPedidoCliente
			LEFT JOIN mc_pedido_etapa pe ON pe.idPedidoEtapa=med.idPedidoEtapa
			LEFT JOIN mc_pedido_etapa ped ON ped.idPedidoEtapa=p.estado_pedido
			WHERE p.estado=1
			AND  DATE(p.fecha) BETWEEN @fecIni AND @fecFin
			$filtros
			ORDER BY tiempo_registro ASC
			;
		";
		return $this->db->query($sql);
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
}
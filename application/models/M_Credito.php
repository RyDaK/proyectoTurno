<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Credito extends MY_Model{
	
	public function __construct(){
		parent::__construct();
	} 
	
	public function find_credito($filtros){
		$comercios = $this->session->userdata('comercios');
		$pdv = $this->session->userdata('pdv');
		if(!empty($comercios)) $filtros .= " AND pv.id_comercio IN (".implode(",",$comercios).")";
		if(!empty($pdv)) $filtros .= " AND pv.id_pdv IN (".implode(",",$pdv).")";
		$sql = "
			SELECT DISTINCT 
				pv.id_pdv, cm.id_comercio,cm.nombre as 'comercio',p.idPedidoCliente id_pedido , pv.nombre as 'local', 
				p.fecha tiempo_entrega, null as 'canal',p.medio_entrega as 'tipo',  p.costo_delivery as 'monto', 
				cl.nombres,p.direccion,ub.distrito as 'distrito', null numero,p.medio_pago as 'tipo_pago', 
				med.fecha tiempo_registro,
				mev.titulo as 'medio_env', 
				pe.nombre as 'pedido_etapa',
				null flagAuto,pe.idPedidoEtapa id_pedido_etapa,
				med.fecha tiempo,
				ped.nombre as 'etapa'
			FROM `mc_pedido_cliente` p
			LEFT JOIN ms_punto_venta pv ON pv.id_pdv=p.idComercioLocal
			/*LEFT JOIN ms_canal ca ON ca.id_canal=p.id_canal*/
			LEFT JOIN ms_comercio cm ON cm.id_comercio=pv.id_comercio
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
			//echo $sql;
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

	public function get_comercio($id_comercio){
		$sql = "
			SELECT 
				cm.id_comercio,cm.nombre 'nombre_comercio',cm.razon_social, cm.ruc ,cm.id_rubro,cm.id_giro,cm.costo_delivery,cm.telefono,cm.configurado,cm.creditosActual,cm.ruta_logo,cm.ruta_terminos
			FROM
				ms_comercio cm
			where 
				id_comercio=$id_comercio 
				;
		";
		return $this->db->query($sql);
	}

	public function get_comercio_credito($id_comercio){
		$sql = "
			select
				fecIni,fecFin,creditosCarga from ts_comercio_credito
			where 
				estado=1
				AND (
					fecIni <= IFNULL( fecFin, @fecFin)
					AND (
					fecIni BETWEEN @fecIni AND @fecFin
					OR
					IFNULL( fecFin, @fecFin ) BETWEEN @fecIni AND @fecFin
					OR
					@fecIni BETWEEN fecIni AND IFNULL( fecFin, @fecFin )
					OR
					@fecFin BETWEEN fecIni AND IFNULL( fecFin, @fecFin )
					)
				) 
				and id_comercio=$id_comercio
				;
		";
		return $this->db->query($sql);
	}
}
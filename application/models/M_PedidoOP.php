<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_PedidoOP extends MY_Model{
	
	public function __construct(){
		parent::__construct();
	}
	public function get_usuarios_comercio($idComercio, $filtros = ""){
		$sql = "SELECT u.* from ms_usuario u
		JOIN ts_usuario_hist uh ON uh.id_usuario = u.id_usuario
		JOIN ms_punto_venta pdv ON pdv.id_pdv = uh.id_pdv
		JOIN ms_comercio c ON c.id_comercio = pdv.id_comercio
		WHERE  u.estado = 1 AND uh.estado = 1  AND c.id_comercio = $idComercio $filtros";

		return $this->db->query($sql);

	}

	public function get_metodo_pago_disponible($comercio){
			$sql = "select 
			mp.nombre,
			mp.icono,
			mp.id_metodo_pag,
			mpc.id_metodo_pago_comercio

			from ms_metodo_pago mp
			JOIN ms_metodo_pago_comercio mpc
			ON mp.id_metodo_pag = mpc.id_metodo_pago
			where mpc.id_comercio=$comercio AND estado=1" ;

		return $this->db->query($sql);
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
	
	public function get_configuracion_mensaje($params){
		
		$idPedido= $params['idPedido'];
		$proceso= $params['idEtapa'];
		$sql = "

		SELECT 
                p.idPedidoCliente
                , ca.id_proceso
                , REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(ca.mensaje,'[raz_social]',co.nombre),'[pdv_nombre]',pv.nombre), '[cod_pedido]', p.idPedidoCliente), '[med_envio]', IFNULL(me.titulo, '') ), '[cli_nombres]', c.nombres ) contenido
			FROM 
				ms_configuracion_mensaje ca
				JOIN ms_punto_venta pv ON pv.id_comercio = ca.id_comercio AND pv.estado = 1
				JOIN mc_pedido_cliente p ON p.idComercioLocal = pv.id_pdv AND p.estado = 1
				JOIN mc_usuario_cliente c ON c.idUsuarioCliente = p.idUsuarioCliente
                JOIN ms_comercio co ON co.id_comercio = pv.id_comercio
                LEFT JOIN ms_medio_envio me ON me.id_medio_env = p.medio_envio
			WHERE
				p.idPedidoCliente IN ($idPedido)
				and ca.id_proceso in ($proceso)
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
	
	public function find_pedidos_confirmado($params){
	
		$id_local = $this->session->userdata('id_pdv');
		$filtros = '';
		// if(!empty($comercios)) $filtros .= " AND pv.id_comercio IN (".implode(",",$comercios).")";
		// if(!empty($pdv)) $filtros .= " AND pv.id_pdv IN (".implode(",",$pdv).")";
		$sql = ' 
		select 
			mc.*,
			DATE_FORMAT(mc.hora,"%H:%i:%s") as hora_,
			DATE_FORMAT(mc.fecha, "%Y-%m-%d") as fecha_,
			muc.idUsuarioCliente,
			muc.nombres as cliente,
			muc.telefono,
			mc_pedido_etapa.nombre etapa,
			ms_metodo_envio.nombre medio_entrega_,
			ms_metodo_envio.id_metodo_env,
			ms_metodo_pago.nombre medio_pago_

		from
			mc_pedido_cliente mc
		Join
			mc_usuario_cliente muc
		On
			muc.idUsuarioCliente = mc.idUsuarioCliente
		Join
			mc_pedido_etapa
			On
			mc_pedido_etapa.idPedidoEtapa = mc.estado_pedido
		Join 
		ms_metodo_envio
		on
		ms_metodo_envio.id_metodo_env = mc.medio_entrega
		JOIN
		ms_metodo_pago
		on ms_metodo_pago.id_metodo_pag = mc.medio_pago
		where 
			idComercioLocal = '.$id_local.' AND
			mc.estado = 1 AND
			estado_pedido = '.$params['id_estado_ped'].' 
			AND DATE(mc.fecha) = CURDATE() 
			ORDER BY mc.hora asc
		';
		return $this->db->query($sql);
	}

	public function articulos_byid($params){
		$sql="select * from ts_articulo where id_articulo='".$params['id']. "'  ";
		return $this->db->query($sql);
	}

	public function find_pedidos_por_confirmar(){
	
		$id_local = $this->session->userdata('id_pdv');
		$filtros = '';
		// if(!empty($comercios)) $filtros .= " AND pv.id_comercio IN (".implode(",",$comercios).")";
		// if(!empty($pdv)) $filtros .= " AND pv.id_pdv IN (".implode(",",$pdv).")";
		$sql = ' 
			select 
			mc.*,
			DATE_FORMAT(mc.hora,"%H:%i:%s") as hora_,
			DATE_FORMAT(mc.fecha, "%Y-%m-%d") as fecha_,
			muc.idUsuarioCliente,
			muc.nombres as cliente,
			muc.telefono,
			mc_pedido_etapa.nombre etapa,
			ms_metodo_envio.nombre medio_entrega_,
			ms_metodo_pago.nombre medio_pago_
		from
			mc_pedido_cliente mc
		Join
			mc_usuario_cliente muc
		On
			muc.idUsuarioCliente = mc.idUsuarioCliente
		Join
			mc_pedido_etapa
			On
			mc_pedido_etapa.idPedidoEtapa = mc.estado_pedido
		Join 
			ms_metodo_envio
			on
			ms_metodo_envio.id_metodo_env = mc.medio_entrega
		JOIN
			ms_metodo_pago
			on ms_metodo_pago.id_metodo_pag = mc.medio_pago
		where 
			idComercioLocal = '.$id_local.' AND
			mc.estado = 1 AND
			estado_pedido IN(1,8) AND
			DATE(mc.fecha) = CURDATE() 
			ORDER BY mc.hora asc
		';
		return $this->db->query($sql);
	}

	public function find_pedidos_por_confirmarByid($params){
		$comercios = $this->session->userdata('comercios');
		$pdv = $this->session->userdata('pdv');
		$id_local = $this->session->userdata('id_pdv');
		$filtros = '';
		// if(!empty($comercios)) $filtros .= " AND pv.id_comercio IN (".implode(",",$comercios).")";
		// if(!empty($pdv)) $filtros .= " AND pv.id_pdv IN (".implode(",",$pdv).")";
		$sql = ' 
		Select 
		concat(user.nombres," ",user.ape_paterno," ",user.ape_materno) nombre_usuario,
		mc_pedido_cliente_detalle.idDetallePedido,
		mc_pedido_cliente_detalle.comentario,
		mc_pedido_cliente_detalle.cantidad,
		mc_pedido_cliente.costo_delivery,
		u.distrito distrito,
		(mc_pedido_cliente_detalle.cantidad * plato.precio) importe,
		mc_pedido_cliente.idPedidoCliente,
		importe as importe,
		cantidad as cantidad,
		mc_pedido_cliente.idUsuarioCliente,
		DATE_FORMAT(mc_pedido_cliente.hora,"%H:%i:%s") as hora,
		DATE_FORMAT(mc_pedido_cliente.fecha, "%Y-%m-%d") as fecha,
		mc_pedido_cliente.idComercio id_comercio,
		mc_pedido_cliente.medio_entrega,
		ms_metodo_pago.nombre medio_pago,
		mc_pedido_cliente.direccion,
		mc_pedido_cliente.medio_envio,
		idPlatoComercio,
		plato.ruta_imagen as foto_plato,
		plato.nombre as plato,
		plato.precio as precio_unitario,
		plato.observacion as observacion,
		plato.costo_empaque,
		ms_metodo_envio.nombre medio_entrega_,
		ms_metodo_envio.id_metodo_env
		from 
		mc_pedido_cliente_detalle 
		JOIN
		mc_pedido_cliente
		ON mc_pedido_cliente_detalle.idPedidoCliente = mc_pedido_cliente.idPedidoCliente
		JOIN
			ts_articulo plato
		ON
			plato.id_articulo =  mc_pedido_cliente_detalle.idPlatoComercio
		Join 
		ms_metodo_envio
		on
		ms_metodo_envio.id_metodo_env = mc_pedido_cliente.medio_entrega
		LEFT JOIN ms_ubigeo u
		ON u.id_ubigeo = mc_pedido_cliente.id_ubigeo
		LEFT JOIN mc_usuario_cliente user
		ON user.idUsuarioCliente = mc_pedido_cliente.idUsuarioCliente
		JOIN
		ms_metodo_pago
		on ms_metodo_pago.id_metodo_pag = mc_pedido_cliente.medio_pago
			where
			mc_pedido_cliente.estado = 1 AND
			mc_pedido_cliente.estado_pedido="'.$params['id_estado_ped'].'" AND
			mc_pedido_cliente.idPedidoCliente ="'.$params['idPedidoCliente'].'" AND
			mc_pedido_cliente.idComercioLocal ="'.$id_local.'"
		';
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

	public function cod_comercio($params){
		
		$sql = "select * from ms_comercio
		JOIN ms_punto_venta
		ON ms_punto_venta.id_comercio = ms_comercio.id_comercio
		where id_pdv=".$params['id'].";";
		return $this->db->query($sql);

	}
	public function listar_medios_envio(){

		$sql = "select * from ms_medio_envio where estado = 1";
		return $this->db->query($sql);

	}


	public function filtrar_platos_comercio($params){
		$sql = "SELECT distinct 
		ms_comercio.id_comercio,
		ts_articulo.id_articulo idComercioPlato,
		ms_comercio.nombre as comercio,
		ms_comercio.tipo_comercio,
		ts_articulo.nombre as plato,
		ts_articulo.ruta_imagen as foto_plato,
		ts_articulo.precio,
		ms_punto_venta.id_pdv idComercioLocal

	FROM 
		ms_comercio 
	JOIN
		ts_articulo
	ON 
		ms_comercio.id_comercio = ts_articulo.id_comercio
	JOIN
		ms_punto_venta
	ON 
		ms_punto_venta.id_comercio = ms_comercio.id_comercio
		WHERE
		ms_punto_venta.id_pdv='".$params['id']."'	AND
		ts_articulo.estado = 1 AND
		ts_articulo.visible = 1		
		;
		";
			
		return $this->db->query($sql);
	}
}
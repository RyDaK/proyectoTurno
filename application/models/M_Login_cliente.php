<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Login_cliente extends MY_Model{
	
	public function __construct(){
		parent::__construct();
	}

	public function getDatosFiltroComercio($id_pdv){
		$sql = 
		"SELECT 
		giro.id_giro,
		giro.nombre giro,
		com.id_comercio,
		com.nombre as comercio,
		pdv.id_pdv,
		pdv.nombre local
		from ms_comercio com
		JOIN ms_punto_venta pdv
		ON pdv.id_comercio = com.id_comercio
		JOIN ms_giro giro
		ON giro.id_giro = com.id_giro
		Where pdv.id_pdv = $id_pdv; ";

	return $this->db->query($sql);

	}
	public function get_metodo_entrega_disponible($comercio){
		$sql = "select 
		mp.nombre,
		mp.id_metodo_env,
		mpc.id_comercio_met

		from ms_metodo_envio mp
		JOIN ms_comercio_metodo mpc
		ON mp.id_metodo_env = mpc.id_metodo_env
		where mpc.id_comercio=$comercio AND 
		mpc.estado = 1";

	return $this->db->query($sql);
	}

	public function get_metodo_pago_disponible($comercio){
		$sql = "select 
		mp.nombre,
		mp.id_metodo_pag,
		mp.icono,
		mpc.id_metodo_pago_comercio

		from ms_metodo_pago mp
		JOIN ms_metodo_pago_comercio mpc
		ON mp.id_metodo_pag = mpc.id_metodo_pago
		where mpc.id_comercio=$comercio AND 
		estado = 1";

	return $this->db->query($sql);
	}

	public function get_costo_delivery($id_comercio){
		$sql = "
		SELECT costo_delivery FROM ms_comercio;
		";
		return $this->db->query($sql);
		
	}
	public function get_ubigeo_local_1($id_pdv){
		$sql = "
		SELECT 
			u.id_ubigeo
			, u.distrito
			, p.costo
		FROM
			ms_punto_venta_zona p
			JOIN ms_ubigeo u ON u.id_ubigeo = p.id_ubigeo
		WHERE
			p.id_pdv = $id_pdv
		";
		return $this->db->query($sql);
	}
	
	public function get_ubigeo_local_2($id_pdv){
		$sql = "
		SELECT 
			u2.id_ubigeo, u2.distrito, c.costo_delivery costo
		FROM 
			ms_punto_venta p
			JOIN ms_comercio c on c.id_comercio = p.id_comercio
			JOIN ms_ubigeo u ON u.id_ubigeo = p.id_ubigeo
			JOIN ms_ubigeo u2 ON u2.cod_dep = u.cod_dep and u2.cod_prov =u.cod_prov
		WHERE
			p.id_pdv = $id_pdv
		";
		return $this->db->query($sql);
	}
	
	public function find_usuario($filtros){
		$sql = "
			SELECT 
				u.*
				, uh.*
				, up.nombre perfil
			FROM 
				ms_usuario u
				JOIN ts_usuario_hist uh ON u.id_usuario = uh.id_usuario AND uh.estado = 1
				AND @fecha BETWEEN uh.fecIni AND IFNULL(uh.fecFin,@fecha)
				JOIN ms_usuario_perfil up ON up.id_usuario_perfil = uh.id_usuario_perfil AND up.estado = 1
			WHERE
				u.estado = 1
				$filtros
			;
		";
		return $this->db->query($sql);
	}

	public function listar_rubros (){
		$sql = "
		SELECT Distinct ms_rubro.* FROM ms_rubro
		JOIN ms_giro
		ON ms_rubro.id_rubro = ms_giro.id_rubro
		 where ms_rubro.estado =1;
		";
		return $this->db->query($sql);
	}
	
	public function find_menu($id_usuario){
		$sql = "
			SELECT 
				mg.id_menu_grupo
				, mg.nombre menu_grupo
				, mg.icon icon_menu_grupo
				, m.id_menu
				, m.nombre menu
				, m.icon icon_menu
				, m.ruta ruta_menu
				
			FROM 
				ts_usuario_menu um
				JOIN ms_menu m ON m.id_menu = um.id_menu AND m.estado = 1
				JOIN ms_menu_grupo mg ON mg.id_menu_grupo = m.id_menu_grupo AND mg.estado = 1
			WHERE
				um.estado = 1
				AND um.id_usuario = $id_usuario
			;
		";
		return $this->db->query($sql);
	}

	public function listar_dpts(){
		$sql = "SELECT distinct 
			cod_dep,departamento 
		FROM 
			ms_ubigeo 
		WHERE 
			estado = 1 
		order by 
			departamento
		;
		";
		
		return $this->db->query($sql);
	}
	public function filtra_dpt($params){
		$filtros = $params['filtros'];

		$sql = "Select * 
		from  ms_ubigeo
		where cod_dep = ".$params['cod_dep']." 
		$filtros
		;";
		// echo $this->db->last_qe
		return $this->db->query($sql);
	}
	public function filtrado_locales_ubigeo($params){
		$filtros = $params['filtros'];
		$sql = "
		SELECT 
					ms_punto_venta.id_pdv idComercioLocal,
					ms_punto_venta_telefono.numero,
					ms_punto_venta.nombre local,
					ms_punto_venta.direccion,
					ms_punto_venta.id_ubigeo,
					ms_punto_venta.hora_ini,
					ms_punto_venta.hora_fin,
					ms_punto_venta.via,
					ms_comercio.ruta_logo,
					ms_punto_venta.nombre local,
					ms_comercio.nombre comercio,
					ms_comercio.id_comercio,
					ms_comercio.tipo_comercio,
					ms_comercio.nombre nombre,
					ms_giro.nombre tipoComercio,
					   ms_ubigeo.departamento,
					ms_ubigeo.provincia,
					ms_ubigeo.distrito
				FROM 
					ms_punto_venta 
				JOIN 
					ms_comercio 
				ON
					 ms_comercio.id_comercio = ms_punto_venta.id_comercio
				JOIN 
					ms_giro
				ON 
					ms_giro.id_giro = ms_comercio.id_rubro
				Left join
					ms_punto_venta_telefono
					on ms_punto_venta_telefono.id_pdv = ms_punto_venta.id_pdv
				Left JOIN ms_ubigeo
				ON ms_punto_venta.id_ubigeo = ms_ubigeo.id_ubigeo

				where cod_dep = '".$params['cod_dep']."'
				$filtros
				;";

		return $this->db->query($sql);
	}

	public function filtrado_locales_ubigeo_pdv($params){
		$filtros = $params['filtros'];
		$sql = "
			SELECT Distinct
				ms_punto_venta.id_pdv idComercioLocal,
				ms_punto_venta_telefono.numero,
				ms_punto_venta.nombre local,
				ms_punto_venta.direccion,
				ms_punto_venta.id_ubigeo,
				ms_punto_venta.hora_ini,
				ms_punto_venta.hora_fin,
				ms_punto_venta.via,
				ms_comercio.nombre comercio,
				ms_comercio.tipo_comercio,
				ms_comercio.nombre nombre,
				ms_comercio.id_comercio,
				ms_comercio.ruta_logo,
				ms_giro.nombre tipoComercio,
				ms_ubigeo.distrito
			FROM 
				ms_punto_venta 
			JOIN 
				ms_comercio 	
			ON
				ms_comercio.id_comercio = ms_punto_venta.id_comercio
			JOIN 
				ms_giro
			ON 
				ms_giro.id_giro = ms_comercio.id_rubro
			Join
			ms_punto_venta_zona
			ON ms_punto_venta_zona.id_pdv = ms_punto_venta.id_pdv
			Left join
				ms_punto_venta_telefono
				on ms_punto_venta_telefono.id_pdv = ms_punto_venta.id_pdv
			Left JOIN ms_ubigeo
			ON ms_ubigeo.id_ubigeo = ms_punto_venta.id_ubigeo

				where ms_punto_venta_zona.id_ubigeo = '".$params['id_ubigeo_pdv']."' or
				ms_ubigeo.id_ubigeo = '".$params['id_ubigeo_pdv']."'
			
				;";
		return $this->db->query($sql);
	}

	public function listar_provincias($cod_departamento){

		

		$sql = "SELECT distinct 
			cod_prov,provincia
		FROM 
			ms_ubigeo 
		WHERE 
			estado = 1 and

			cod_dep = '".$cod_departamento."'
		order by 
		provincia
		;
		";
			
		return $this->db->query($sql);
	}

	// public function listar_distritos(){
	// public function listar_distritos($provincia){
	// 	$sql = "SELECT distinct 
	// 		cod_distrito,distrito 
	// 	FROM 
	// 		ubigeo 
	// 	WHERE 
	// 		estado = 1 and 
	// 		provincia =".$provincia."
	// 	order by 
	// 		distrito
	// 	;
	// 	";
			
	// 	return $this->db->query($sql);
	// }
	public function listar_distritos_pdv(){
		$sql = "
		select  
				ms_punto_venta_zona.*,
				ms_ubigeo.distrito
		from ms_punto_venta_zona

		Join ms_ubigeo

		ON ms_ubigeo.id_ubigeo = ms_punto_venta_zona.id_ubigeo;
		;
		";
			
		return $this->db->query($sql);
	}
	public function listar_distritos($params){
		$sql = "SELECT distinct 
			cod_dist,distrito 
		FROM 
			ms_ubigeo 
		WHERE 
			estado = 1  and
			cod_prov = '".$params['cod_provincia']."'AND
			cod_dep = '".$params['cod_dep']."'
		order by 
			distrito
		;
		";
			
		return $this->db->query($sql);
	}
	public function listar_tipo_comercio(){
		$sql = "SELECT distinct 
			*
		FROM 
			ms_giro 
		order by 
			nombre
		;
		";
			
		return $this->db->query($sql);
	}

	public function listar_comercios_afiliados(){
		$sql = "SELECT distinct 
		id_comercio,
		ms_comercio.nombre,
		ms_giro.id_giro as idTipoComercio,
		ms_giro.nombre as tipoComercio,
		ms_comercio.razon_social,
		ms_comercio.telefono,
		ms_comercio.ruta_logo,
		ms_rubro.nombre as rubro,
		ms_rubro.id_rubro
	FROM 
		ms_comercio 
	JOIN
		ms_giro
	On ms_giro.id_giro = ms_comercio.id_giro
	LEFT JOIN 
		ms_rubro
		ON ms_rubro.id_rubro = ms_giro.id_rubro
		";
			
		return $this->db->query($sql);
	}

	public function listar_comercios_afiliados_byid($id){
		$sql = "SELECT distinct 
		id_comercio,
		ms_comercio.nombre,
		ms_giro.id_giro as idTipoComercio,
		ms_giro.nombre as tipoComercio,
		ms_comercio.razon_social,
		ms_comercio.telefono,
		ms_comercio.ruta_logo,
		ms_rubro.nombre as rubro,
		ms_rubro.id_rubro
	FROM 
		ms_comercio 
	JOIN
		ms_giro
	On ms_giro.id_giro = ms_comercio.id_giro
	LEFT JOIN 
		ms_rubro
		ON ms_rubro.id_rubro = ms_giro.id_rubro
		WHERE id_comercio = $id	";
			
		return $this->db->query($sql);
	}

	public function filtrar_comercios_afiliados($params){
		$sql = "SELECT distinct 
			id_comercio,
			ms_comercio.nombre,
			ms_giro.id_giro as idTipoComercio,
			ms_giro.nombre as tipoComercio,
			ms_comercio.razon_social,
			ms_comercio.telefono,
			ms_comercio.ruta_logo,
			ms_rubro.nombre as rubro,
			ms_rubro.id_rubro
		FROM 
			ms_comercio 
		JOIN
			ms_giro
		On ms_giro.id_giro = ms_comercio.id_giro
		LEFT JOIN 
		ms_rubro
		ON ms_rubro.id_rubro = ms_giro.id_rubro
		WHERE
		ms_giro.id_giro='".$params['id']."'		
		;
		";
			
		return $this->db->query($sql);
	}

	public function listado_de_mis_pedidos($params){
		$sql = "select distinct
		mc_pedido_cliente.* ,
        DATE_FORMAT(mc_pedido_cliente.hora,'%H:%i:%s') as hora_,
        DATE_FORMAT(mc_pedido_cliente.fecha, '%Y-%m-%d') as fecha_,
        mc_pedido_etapa.nombre as etapa,
        ms_comercio.nombre as comercio,
		ms_punto_venta.nombre as local,
		ms_metodo_envio.nombre medio_entrega_,
		ms_metodo_pago.nombre medio_pago_
		from mc_pedido_cliente
		JOIN mc_pedido_etapa
		ON mc_pedido_etapa.idPedidoEtapa = mc_pedido_cliente.estado_pedido
		JOIN ms_punto_venta 
		ON ms_punto_venta.id_pdv = mc_pedido_cliente.idComercioLocal
		join ms_comercio
		ON ms_comercio.id_comercio = ms_punto_venta.id_comercio
		join mc_pedido_etapa_detalle
		on mc_pedido_etapa_detalle.idPedidoCliente
		Join 
		ms_metodo_envio
		on
		ms_metodo_envio.id_metodo_env = mc_pedido_cliente.medio_entrega
		JOIN
		ms_metodo_pago
		on ms_metodo_pago.id_metodo_pag = mc_pedido_cliente.medio_pago
		where idUsuarioCliente ='".$params['id']."' AND mc_pedido_cliente.estado = 1
		AND mc_pedido_etapa_detalle.idPedidoCliente = mc_pedido_cliente.idPedidoCliente
		ORDER BY idPedidoCliente desc";

		return $this->db->query($sql);

	}
	public function filtrar_platos_comercio($params){
		$sql = "SELECT distinct 
		ts_articulo.id_comercio,
		id_articulo as idComercioPlato,
		ms_comercio.nombre as comercio,
		ms_comercio.tipo_comercio,
		ts_articulo.nombre as plato,
		ts_articulo.ruta_imagen as foto_plato,
		ts_articulo.precio,
		ts_articulo.observacion
	FROM 
		ms_comercio 
	JOIN
		ts_articulo
	ON 
		ms_comercio.id_comercio = ts_articulo.id_comercio
		WHERE
		ts_articulo.id_comercio='".$params['id']."'
		and ts_articulo.estado = 1	AND
		ts_articulo.visible = 1	
		AND id_articulo NOT IN (
			SELECT id_articulo from ts_articulo_local WHERE id_pdv = '".$params['idLocal']."'
		)
		;
		";
			
		return $this->db->query($sql);
	}

	public function filtrar_locales_comercio($params){
		
	$sql = " SELECT 
	ms_punto_venta.id_pdv idComercioLocal,
	ms_punto_venta_telefono.numero,
	ms_punto_venta.nombre local,
	ms_punto_venta.direccion,
	ms_punto_venta.id_ubigeo,
	ms_punto_venta.hora_ini,
	ms_punto_venta.hora_fin,
	ms_punto_venta.via,
	ms_comercio.nombre comercio,
	ms_comercio.tipo_comercio,
	ms_comercio.nombre nombre,
	ms_comercio.id_comercio,
	ms_comercio.ruta_logo,
	ms_giro.nombre tipoComercio,
	ms_ubigeo.distrito
FROM 
	ms_punto_venta 
JOIN 
	ms_comercio 	
ON
	ms_comercio.id_comercio = ms_punto_venta.id_comercio
JOIN 
	ms_giro
ON 
	ms_giro.id_giro = ms_comercio.id_giro
Left join
	ms_punto_venta_telefono
on ms_punto_venta_telefono.id_pdv = ms_punto_venta.id_pdv
Left JOIN ms_ubigeo
	ON ms_ubigeo.id_ubigeo = ms_punto_venta.id_ubigeo
WHERE
		ms_comercio.id_comercio='".$params['id']."'		
		;
		";
			
		return $this->db->query($sql);
	}

	public function filtrar_pedido_plato_comercio($params){
		$sql = "SELECT distinct 
		ms_comercio.id_comercio,
		ts_articulo.id_articulo idComercioPlato,
		ms_comercio.nombre as comercio,
		ms_comercio.tipo_comercio,
		ts_articulo.nombre as plato,
		ts_articulo.ruta_imagen as foto_plato,
		ts_articulo.precio,
		(ts_articulo.costo_empaque)as  empaque

	FROM 
		ms_comercio 
	JOIN
		ts_articulo
		ON ms_comercio.id_comercio = ts_articulo.id_comercio

		WHERE
			ms_comercio.id_comercio='".$params['cod_comercio']."' AND
			id_articulo='".$params['cod_plato']."'
		;
		";
			
		return $this->db->query($sql);
	}

	public function filtrar_locales_disponibles($params){
		$sql = "
		select 
			ms_comercio_local.idComercioLocal,
			ms_comercio_local.nombre local,
			ms_comercio_local.direccion,
			ms_comercio_local.telefono,
			ms_comercio_local.idUbigeo,
			ms_ubigeo.distrito
			
		from
			ms_comercio_local
		JOIN mc_pedido_cliente
		ON mc_pedido_cliente.idComercio = ms_comercio_local.idComercio
		JOIN ms_ubigeo
		ON ms_comercio_local.idUbigeo = ms_ubigeo.id_ubigeo
		Where ms_comercio_local.idComercio =' ".$params['idComercio']."'";
		return $this->db->query($sql);
	}
	public function find_usuario_cliente($filtros){
		$sql = "
			SELECT 
				u.*
				
			FROM 
				mc_usuario_cliente u
			WHERE
				u.estado = 1
				$filtros
			;
		";
		return $this->db->query($sql);
	}

	public function modal_buscar_cliente($filtros){
		$sql = "
			SELECT 
				u.*
				
			FROM 
				mc_usuario_cliente u
			WHERE
				u.estado = 1 AND
				idUsuarioCliente = ".$filtros['cod_usuario_cliente']."
			;
		";
		return $this->db->query($sql);
	}

	public function modal_buscar_reclamo(){
		$sql = "
			SELECT 
			MAX('idUsuarioCliente') AS id 
			FROM reclamaciones;
		";
		return $this->db->query($sql);
	}

	public function listar_mis_pedidos($params){
		$sql = "
			
		select 
			mc_pedido_etapa_detalle.hora,
			mc_pedido_etapa_detalle.fecha,
			mc_pedido_etapa_detalle.estado,
			mc_pedido_etapa_detalle.idPedidoEtapa,
            mc_pedido_etapa_detalle.idPedidoCliente
			from
			mc_pedido_etapa_detalle
			Join mc_pedido_cliente
			ON mc_pedido_etapa_detalle.idPedidoCliente = mc_pedido_cliente.idPedidoCliente
			where mc_pedido_cliente.idPedidoCliente = ".$params['idPedidoCliente']." AND
			idUsuarioCliente = ".$params['idUsuarioCliente'].";";

		
		return $this->db->query($sql);
	}


	public function lista_pedidos_cliente($filtros){
		$sql = "
		SELECT 
			pcdet.idDetallePedido,
			pcdet.comentario,
			pc.idPedidoCliente,
			pc.idUsuarioCliente,
			pc.fecha,
			pc.hora,
			importe as importe,
			cantidad as cantidad,
			idPlatoComercio,
			cm.nombre as comercio,
			cm.id_comercio as idComercio,
			plato.ruta_imagen as foto_plato,
			plato.nombre as plato,
			plato.precio as precio_unitario,
			pc.idComercioLocal,
			(plato.costo_empaque)as  empaque

		FROM 
			mc_pedido_cliente_detalle pcdet
		JOIN 
			mc_pedido_cliente pc 
		ON 
			pc.idPedidoCliente  =  pcdet.idPedidoCliente
		JOIN
			ts_articulo plato
		ON
			plato.id_articulo =  pcdet.idPlatoComercio
		JOIN
			ms_comercio cm 
		ON
			cm.id_comercio = pc.idComercio
		where pc.idUsuarioCliente ='".$filtros['idPedidoCliente']."' AND
			pcdet.importe > 0 AND
			pc.estado = 1 AND
			pc.estado_pedido = 0
		
		";
		// $this->db->query($sql);
		// echo $this->db->last_query();exit();
		return $this->db->query($sql);
	}

	public function obtener_plato_pedido_cliente($filtros){
		$sql = "
		SELECT 
			pcdet.idDetallePedido,
			pcdet.comentario,
			pc.idPedidoCliente,
			pc.idUsuarioCliente,
			pc.fecha,
			pc.hora,
			importe as importe,
			cantidad as cantidad,
			idPlatoComercio,
			cm.nombre as comercio,
			cm.id_comercio as idComercio,
			plato.ruta_imagen as foto_plato,
			plato.nombre as plato,
			plato.precio as precio_unitario,
			pc.idComercioLocal,
			(plato.costo_empaque)as  empaque

		FROM 
			mc_pedido_cliente_detalle pcdet
		JOIN 
			mc_pedido_cliente pc 
		ON 
			pc.idPedidoCliente  =  pcdet.idPedidoCliente
		JOIN
			ts_articulo plato
		ON
			plato.id_articulo =  pcdet.idPlatoComercio
		JOIN
			ms_comercio cm 
		ON
			cm.id_comercio = pc.idComercio
		where pc.idUsuarioCliente ='".$filtros['idUsuarioCliente']."' AND
			pcdet.importe > 0 AND
			pc.estado = 1 AND
			pc.estado_pedido = 0 AND
			idPlatoComercio = '".$filtros['idPlatoComercio']."'
		
		";
		// $this->db->query($sql);
		// echo $this->db->last_query();exit();
		return $this->db->query($sql);
	}

	public function getSetDetallePedido($filtros){
		$sql = "
		SELECT 
			pcdet.idDetallePedido,
			pcdet.comentario,
			pc.idPedidoCliente,
			pc.idUsuarioCliente,
			pc.fecha,
			pc.hora,
			importe as importe,
			cantidad as cantidad,
			idPlatoComercio,
			cm.nombre as comercio,
			cm.id_comercio as idComercio,
			plato.ruta_imagen as foto_plato,
			plato.nombre as plato,
			plato.precio as precio_unitario,
			pc.idComercioLocal,
			(plato.costo_empaque)as  empaque

		FROM 
			mc_pedido_cliente_detalle pcdet
		JOIN 
			mc_pedido_cliente pc 
		ON 
			pc.idPedidoCliente  =  pcdet.idPedidoCliente
		JOIN
			ts_articulo plato
		ON
			plato.id_articulo =  pcdet.idPlatoComercio
		JOIN
			ms_comercio cm 
		ON
			cm.id_comercio = pc.idComercio
		where pc.idUsuarioCliente ='".$filtros['idPedidoCliente']."' AND
			pcdet.idDetallePedido ='".$filtros['idDetallePedido']."' AND
			pcdet.importe > 0 AND
			pc.estado = 1 AND
			pc.estado_pedido = 0
		
		";
		// $this->db->query($sql);
		// echo $this->db->last_query();exit();
		return $this->db->query($sql);
	}

	public function listado_mis_pedidos($filtros){
		$sql = "SELECT 
		pcdet.idDetallePedido,
		pcdet.comentario,
		pc.idPedidoCliente,
		pc.idUsuarioCliente,
		pc.fecha,
		pc.hora,
		importe as importe,
		cantidad as cantidad,
		idPlatoComercio,
		cm.nombre as comercio,
		cm.id_comercio as idComercio,
		plato.ruta_imagen as foto_plato,
		plato.nombre as plato,
		plato.precio as precio_unitario,
		pc.idComercioLocal,
		(plato.costo_empaque)as  empaque,
		pc.costo_delivery,
		pc.medio_entrega as id_metodo_env
	FROM 
		mc_pedido_cliente_detalle pcdet
	JOIN 
		mc_pedido_cliente pc 
	ON 
		pc.idPedidoCliente  =  pcdet.idPedidoCliente
	JOIN
		ts_articulo plato
	ON
		plato.id_articulo =  pcdet.idPlatoComercio
	JOIN
		ms_comercio cm 
	ON
		cm.id_comercio = pc.idComercio
		where 
			pc.idPedidoCliente = '".$filtros['idPedidoCliente']."'
		";
		// $this->db->query($sql);
		// echo $this->db->last_query();exit();
		return $this->db->query($sql);
	}

	
}

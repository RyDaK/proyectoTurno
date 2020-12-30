<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class M_Configuracion extends MY_Model{

	

	public function __construct(){

		parent::__construct();

	}



	public function get_metodo_pago_comercio($comercio){

		$sql = "select 

					mp.nombre,

					mp.id_metodo_pag,

					mpc.id_metodo_pago_comercio,

					mpc.numero



				from ms_metodo_pago mp

				JOIN ms_metodo_pago_comercio mpc

				ON mp.id_metodo_pag = mpc.id_metodo_pago

				where mpc.id_comercio=$comercio AND mp.estado=1";



			return $this->db->query($sql);

	}

	public function get_metodo_pago($ids){

		$filtro="";

		if($ids!="" && $ids!=null){

			$filtro="and id_metodo_pag not in($ids)";

		}

		$sql = "select 

					*

				From ms_metodo_pago

				where estado=1 $filtro";



			return $this->db->query($sql);

	}

	public function get_metodo_pago_id($id){

		$sql = "select 

					*

				From ms_metodo_pago

				where id_metodo_pag = $id

				AND estado=1";



			return $this->db->query($sql);

	}

	public function delete_metodo_pago_comercio($id){

		$sql = "Delete from ms_metodo_pago_comercio 

		where id_metodo_pago_comercio='".$id."'

		";

		

		return $this->db->query($sql);

	}



	public function get_cliente($id_pdv,$id_usuario){

		$sql = "

			SELECT 

				c.id_cliente,c.nombres,c.ape_paterno,c.nro_documento,c.razon_social,c.direccion,c.id_pdv,c.id_proyecto,

				ct.numero 'telefono',ct.id_cliente_telefono

			FROM 

				`ts_cliente` c

			LEFT JOIN 

				ts_cliente_telefono ct ON ct.id_cliente=c.id_cliente and ct.estado=1

			WHERE 

				c.id_pdv=$id_pdv and c.id_usuario=$id_usuario

				;

		";

		return $this->db->query($sql);

	}



	public function get_comercio($id_comercio){

		$sql = "

			SELECT 

				cm.id_comercio,cm.nombre 'nombre_comercio',cm.razon_social, cm.ruc ,cm.id_rubro,cm.id_giro,cm.costo_delivery,cm.telefono,cm.configurado,cm.creditosActual,cm.ruta_logo,cm.ruta_terminos

				, cm.pago_visa, cm.nro_documento

			FROM

				ms_comercio cm

			where 

				id_comercio=$id_comercio 

				;

		";

		return $this->db->query($sql);

	}



	public function get_punto_venta($id_pdv){

		$sql = "

			SELECT 

				nombre,direccion,latitud,longitud,ruta,id_centro_comercial,id_ubigeo FROM `ms_punto_venta`

			where 

				id_pdv=$id_pdv 

				;

		";

		return $this->db->query($sql);

	}





	public function get_comercio_credito($id_comercio){

		$sql = "

			SELECT 

				fecIni,fecFin,creditosCarga 

			FROM 

				`ts_comercio_credito` 

			WHERE id_comercio=$id_comercio

			;

		";

		return $this->db->query($sql);

	}



	public function get_giros(){

		$sql = "

			SELECT 

				id_giro,nombre FROM `ms_giro`

			where 

				estado=1

			;

		";

		return $this->db->query($sql);

	}



	public function get_rubros(){

		$sql = "

			SELECT Distinct ms_rubro.* FROM ms_rubro

			JOIN ms_giro

			ON ms_rubro.id_rubro = ms_giro.id_rubro

			where ms_rubro.estado =1

			;

		";

		return $this->db->query($sql);

	}



	

	public function set_comercio($data){

		return $this->db->insert('ms_comercio',$data);

	}



	public function set_cliente_telefono($data){

		return $this->db->insert('ts_cliente_telefono',$data);

	}



	public function update_cliente_telefono($data,$where){

		$this->db->set($data);

		$this->db->where($where);

		return $this->db->update('ts_cliente_telefono');

	}



	public function update_usuario($data,$where){

		$this->db->set($data);

		$this->db->where($where);

		return $this->db->update('ms_usuario');

	}

	

	public function update_comercio($data,$where){

		$this->db->set($data);

		$this->db->where($where);

		return $this->db->update('ms_comercio');

	}



	public function get_usuario($id_usuario){

		$sql = "

			SELECT 

				u.id_usuario,u.nombres,u.ape_paterno,u.ape_materno,u.email,u.nro_documento 

			FROM

				ms_usuario u

			where 

				u.id_usuario=$id_usuario

				and u.estado=1

			;

		";

		return $this->db->query($sql);

	}



	public function get_configuracion_mensaje($id_comercio){

		$sql = "

			SELECT 

				cm.id_conf_mens,cm.mensaje,p.id_proceso,p.nombre 'proceso',cm.estado

			FROM 

				`ms_configuracion_mensaje` cm

			JOIN 

				ms_proceso p On p.id_proceso=cm.id_proceso

			WHERE 

				cm.id_comercio=$id_comercio

				and p.estado = 1

			;

		";

		return $this->db->query($sql);

	}

	public function get_configuracion_mensaje_edit($id_conf_mens){

		$sql = "

			SELECT 

				cm.id_conf_mens,cm.mensaje,cm.id_proceso,cm.estado

			FROM 

				`ms_configuracion_mensaje` cm

			WHERE 

				cm.id_conf_mens=$id_conf_mens

			;

		";

		return $this->db->query($sql);

	}



	public function set_configuracion_mensaje($data){

		return $this->db->insert('ms_configuracion_mensaje',$data);

	}



	public function get_procesos(){

		$sql = "

			SELECT 

				id_proceso,nombre FROM `ms_proceso`

			WHERE

				estado=1

				AND id_proceso NOT IN (1,2,3,4)

			;

		";

		return $this->db->query($sql);

	}



	public function update_configuracion_mensaje($data,$where){

		$this->db->set($data);

		$this->db->where($where);

		return $this->db->update('ms_configuracion_mensaje');

	}



	public function get_medios_envio($id_comercio){

		$sql = "

			SELECT 

				me.id_medio_env,me.titulo,me.email,me.telefono,e.nombre 'empresa', e.id_empresa_del,

				mt.id_medio_tipo,mt.nombre 'tipo',me.estado

			FROM 

				`ms_medio_envio` me 

		

			left JOIN ms_medio_tipo mt 

				On mt.id_medio_tipo=me.id_medio_tipo 



			LEFT JOIN ms_empresa_delivery e 

				ON e.id_empresa_del=me.id_empresa_del

			WHERE

				me.id_comercio=$id_comercio

				;

		";

		return $this->db->query($sql);

	}

	public function set_medio_envio($data){

		return $this->db->insert('ms_medio_envio',$data);

	}



	public function get_medio_envio($id_medio){

		$sql = "

			SELECT 

				id_medio_env,titulo,email,telefono,id_medio_tipo,id_empresa_del FROM `ms_medio_envio`

			WHERE

				id_medio_env=$id_medio

				;

		";

		return $this->db->query($sql);

	}



	public function update_medio_envio($data,$where){

		$this->db->set($data);

		$this->db->where($where);

		return $this->db->update('ms_medio_envio');

	}





	public function get_puntos_venta($id_comercio,$fecha){

		$sql = "

			SELECT 

				pdv.id_pdv,pdv.nombre,pdv.direccion,pdv.latitud,pdv.longitud,pdv.ruta,

				pdv.id_centro_comercial,pdv.id_ubigeo, pvt.id_pdv_telefono, pvt.numero,

				u.departamento,u.provincia,u.distrito,u.cod_prov,u.cod_dep,pdv.via,pdv.zona,pdv.email,pdv.estado 'estado_punto'

			FROM 

				`ms_punto_venta` pdv



			LEFT JOIN 

				ms_punto_venta_telefono pvt On pvt.id_pdv=pdv.id_pdv and pvt.estado=1

			LEFT JOIN 

				ms_ubigeo u ON u.id_ubigeo=pdv.id_ubigeo

			WHERE 

				pdv.id_comercio=$id_comercio 

				;

		";

		return $this->db->query($sql);

	}

	public function set_punto_venta($data){

		return $this->db->insert('ms_punto_venta',$data);

	}





	public function get_departamentos(){

		$sql = "

			SELECT distinct 

				cod_dep,departamento 

			FROM 

				`ms_ubigeo` 

			WHERE

				estado=1

			ORDER BY departamento

		";

		return $this->db->query($sql);

	}



	public function get_provincias($cod_dep){

		$sql = "

			SELECT distinct

				cod_prov,provincia

			FROM 

				`ms_ubigeo`

			WHERE

				estado=1 and cod_dep=$cod_dep

			ORDER BY provincia

		";

		return $this->db->query($sql);

	}



	public function get_distritos($cod_dep,$cod_prov){

		$sql = "

			SELECT distinct

				id_ubigeo,distrito

			FROM 

				`ms_ubigeo`

			WHERE

				estado=1 and cod_prov=$cod_prov and cod_dep=$cod_dep

			ORDER BY distrito

		";

		return $this->db->query($sql);

	}



	public function set_punto_venta_historico($data){

		return $this->db->insert('ts_punto_venta_historico',$data);

	}







	public function get_punto_venta_edit($id_pdv){

		$sql = "

			SELECT 

				pdv.id_pdv,pdv.nombre,pdv.direccion,pdv.latitud,pdv.longitud,pdv.ruta,

				pdv.id_centro_comercial,pdv.id_ubigeo, pvt.id_pdv_telefono, pvt.numero, pdv.via,pdv.zona,

				pdv.email,pdv.hora_ini,pdv.hora_fin,

				u.cod_dep,u.cod_prov,u.id_ubigeo

			FROM 

				`ms_punto_venta` pdv

			LEFT JOIN 

				ms_punto_venta_telefono pvt On pvt.id_pdv=pdv.id_pdv and pvt.estado=1

			LEFT JOIN 

				ms_ubigeo u ON u.id_ubigeo=pdv.id_ubigeo

			WHERE 

				pdv.id_pdv=$id_pdv 

				;

		";

		return $this->db->query($sql);

	}

 



	public function update_punto_venta($data,$where){

		$this->db->set($data);

		$this->db->where($where);

		return $this->db->update('ms_punto_venta');

	}





	public function update_punto_venta_telefono($data,$where){

		$this->db->set($data);

		$this->db->where($where);

		return $this->db->update('ms_punto_venta_telefono');

	}

	public function set_punto_venta_telefono($data){

		return $this->db->insert('ms_punto_venta_telefono',$data);

	}



	public function set_punto_venta_zona($data){

		return $this->db->insert('ms_punto_venta_zona',$data);

	}



	public function get_puntos_venta_zona($id_pdv){

		$sql = "

			SELECT 

				pvz.id_pdv_zona , pvz.id_ubigeo , pvz.costo , u.distrito, pvz.estado

			FROM 

				`ms_punto_venta_zona` pvz 

			LEFT JOIN

				ms_ubigeo u ON u.id_ubigeo=pvz.id_ubigeo

			WHERE 

				pvz.id_pdv=$id_pdv

		";

		return $this->db->query($sql);

	}



	public function update_punto_venta_zona($data,$where){

		$this->db->set($data);

		$this->db->where($where);

		return $this->db->update('ms_punto_venta_zona');

	}







	public function set_articulo($data){

		return $this->db->insert('ts_articulo',$data);

	}



	public function get_articulo($id_articulo){

		$sql = "

			SELECT 

				id_articulo,nombre,precio,observacion,costo_empaque,visible,ruta_imagen,estado 

			FROM 

				`ts_articulo`

			WHERE 

				id_articulo=$id_articulo 

		";

		return $this->db->query($sql);

	}



	public function get_articulos($id_comercio){

		$sql = "

			SELECT 

				id_articulo,nombre,precio,observacion,costo_empaque,visible,ruta_imagen,estado 

			FROM 

				`ts_articulo`

			WHERE 

				id_comercio=$id_comercio and estado=1

		";

		return $this->db->query($sql);

	}



	public function update_articulo($data,$where){

		$this->db->set($data);

		$this->db->where($where);

		return $this->db->update('ts_articulo');

	}



	public function insert_articulo_local($data){

		return $this->db->insert('ts_articulo_local',$data);

	}

	

	public function delete_articulo_local($idLocal, $idArticulo){

		$this->db->where('id_pdv', $idLocal);

		$this->db->where('id_articulo', $idArticulo);

		return $this->db->delete('ts_articulo_local');

	}



	public function delete_all_articulo_local($idComercio, $idLocal){

		$sql = "insert into ts_articulo_local (id_articulo, id_pdv) SELECT id_articulo, $idLocal FROM ts_articulo WHERE id_comercio = $idComercio";

		return $this->db->query($sql);

	}

	

	public function get_empresa_delivery(){

		$sql = "

			SELECT 

				id_empresa_del,nombre FROM `ms_empresa_delivery`

			WHERE 

				estado=1

			;

		";

		return $this->db->query($sql);

	}

	

	public function set_empresa_delivery($data){

		return $this->db->insert('ms_empresa_delivery',$data);

	}





	public function get_configuracion_mensaje_proceso($id_comercio,$id_proceso,$filtro){

		$sql = "

			SELECT 

				cm.id_conf_mens

			FROM 

				`ms_configuracion_mensaje` cm

			WHERE 

				cm.id_comercio=$id_comercio and cm.id_proceso=$id_proceso

				$filtro

			;

		";

		return $this->db->query($sql);

	}

	



	public function find_articulos($filtros){

		$id_comercio = $this->session->userdata('id_comercio');

		$sql = "

			SELECT 

				id_articulo,nombre,precio,observacion,costo_empaque,visible,ruta_imagen,estado 

			FROM 

				`ts_articulo`

			WHERE 

				estado=1 and id_comercio=$id_comercio  $filtros

		";
		// echo $this->db->last_query();

		return $this->db->query($sql);

	}

	

	public function find_articulos_local($filtros){

		$id_local = $this->session->userdata('id_pdv');

		$sql = "

			SELECT 

				*

			FROM 

				`ts_articulo_local`

			WHERE 

				estado=1 and id_pdv=$id_local  $filtros

		";

		return $this->db->query($sql);

	}



	public function get_comercio_metodo($id_comercio){

		$sql = "

			SELECT 

				id_comercio_met,id_metodo_env 

			FROM 

				`ms_comercio_metodo` 

			WHERE

				 id_comercio=$id_comercio

			;

		";

		return $this->db->query($sql);

	}

	public function get_comercio_metodo_edit($id_comercio,$id_metodo_env){

		$sql = "

			SELECT 

				id_comercio_met,estado

			FROM 

				`ms_comercio_metodo` 

			WHERE

				id_comercio=$id_comercio	

				and

				id_metodo_env=$id_metodo_env

			;

		";

		return $this->db->query($sql);

	}

	

	public function set_comercio_metodo($data){

		return $this->db->insert('ms_comercio_metodo',$data);

	}



	public function update_comercio_metodo($data,$where){

		$this->db->set($data);

		$this->db->where($where);

		return $this->db->update('ms_comercio_metodo');

	}



}
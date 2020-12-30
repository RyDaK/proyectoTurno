<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Comercio extends MY_Model{
	
	public function __construct(){
		parent::__construct();
	}
	 public function get_giros_rubro($id){
		$sql = "select * from ms_giro 
		where estado=1 AND id_rubro = $id  ";

		return $this->db->query($sql);
	}

	public function get_metodo_pago_comercio($comercio){
		$sql = "select 
					mp.nombre,
					mp.id_metodo_pag,
					mpc.id_metodo_pago_comercio

				from ms_metodo_pago mp
				JOIN ms_metodo_pago_comercio mpc
				ON mp.id_metodo_pag = mpc.id_metodo_pago_comercio
				where mpc.id_comercio=$comercio";

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
				where 1=1 $filtro";

			return $this->db->query($sql);
	}
	public function get_metodo_pago_id($id){
		$sql = "select 
					*
				From ms_metodo_pago
				where id_metodo_pag = $id";

			return $this->db->query($sql);
	}
	public function delete_metodo_pago_comercio($id){
		$sql = "Delete from ms_metodo_pago_comercio 
		where id_metodo_pago_comercio='".$id."'
		";
		
		return $this->db->query($sql);
	}

	public function set_usuario($data){
		return $this->db->insert('ms_usuario',$data);
	}

	public function set_comercio($data){
		return $this->db->insert('ms_comercio',$data);
	}

	public function set_punto_venta($data){
		return $this->db->insert('ms_punto_venta',$data);
	}


	public function set_cliente($data){
		return $this->db->insert('ts_cliente',$data);
	}

	public function set_cliente_telefono($data){
		return $this->db->insert('ts_cliente_telefono',$data);
	}

	public function set_punto_venta_proyecto($data){
		return $this->db->insert('ts_punto_venta_proyecto',$data);
	}

	public function set_usuario_hist($data){
		return $this->db->insert('ts_usuario_hist',$data);
	}

	public function set_usuario_menu($data){
		return $this->db->insert('ts_usuario_menu',$data);
	}

	public function get_usuario_menus($idUsuarioPerfil){
		$sql = "
			SELECT 
				id_menu_opcion
			FROM 
				ms_usuario_perfil_menu_opcion
			WHERE
				estado=1 and id_usuario_perfil=$idUsuarioPerfil
			;
		";
		return $this->db->query($sql);
	}

	public function set_punto_venta_historico($data){
		return $this->db->insert('ts_punto_venta_historico',$data);
	}

	public function get_comercios_usuario($id_Usuario){
		$sql = "
			SELECT distinct
				c.id_comercio,c.nombre,c.razon_social,c.estado,c.ruc,c.creditosActual
			FROM 
				`ms_comercio` c
			JOIN ts_usuario_hist uh ON uh.id_Comercio=c.id_Comercio
			WHERE uh.id_Usuario=$id_Usuario and uh.estado=1
			ORDER BY id_comercio DESC
			;
		";
		return $this->db->query($sql);
	}

	public function get_comercios(){
		$sql = "
				SELECT 
					id_comercio,nombre,razon_social,estado,ruc,creditosActual
				FROM 
					`ms_comercio`  
				ORDER BY id_comercio DESC
			;
		";
		return $this->db->query($sql);
	}

	public function get_comercio($id_comercio){
		$sql = "
				SELECT 
					id_comercio,nombre,razon_social,ruta_logo,estado,ruc,id_rubro,id_giro,costo_delivery,telefono,creditosActual,nro_documento
				FROM 
					`ms_comercio` 
				WHERE id_comercio=$id_comercio
				
			;
		";
		return $this->db->query($sql);
	}

	public function get_comercio_credito($id_comercio){
		$sql = "
			SELECT 
				id_comercio_cred,fecIni,fecFin,creditosCarga,estado
			FROM 
				`ts_comercio_credito` 
			WHERE 
				id_comercio=$id_comercio
			;
		";
		return $this->db->query($sql);
	}

	public function set_comercio_credito($data){
		return $this->db->insert('ts_comercio_credito',$data);
	}

	public function get_puntos_venta($id_comercio){
		$sql = "
			SELECT 
				id_pdv, nombre,direccion,latitud,longitud,ruta,estado,id_ubigeo 
			FROM 
				`ms_punto_venta`
			WHERE 
				id_comercio=$id_comercio
			;
		";
		return $this->db->query($sql);
	}

	public function get_cliente_comercio($id_comercio){
		$sql = "
			SELECT 
				c.id_cliente,c.nombres,c.ape_paterno,c.ape_materno,c.nro_documento,c.razon_social,c.direccion,c.id_proyecto,c.id_usuario FROM `ts_cliente` c
			JOIN 
				ms_punto_venta pv ON pv.id_pdv=c.id_pdv
			WHERE 
				pv.id_comercio=$id_comercio
			;
		";
		return $this->db->query($sql);
	}

	public function get_usuario($id_comercio,$fecha){
		$sql = "
			SELECT 
				u.id_usuario,u.nombres,u.ape_paterno,u.ape_materno,u.email,u.nro_documento FROM `ts_usuario_hist` uh
			JOIN 
				ms_usuario u ON u.id_usuario=uh.id_usuario
			where 
				'$fecha' BETWEEN uh.fecIni and ifnull(uh.fecFin,'$fecha') 
				and uh.estado=1 and uh.id_comercio=$id_comercio
				and u.estado=1
			;
		";
		return $this->db->query($sql);
	}

	public function get_usuario_perfil($id_comercio,$fecha,$id_perfil){
		$sql = "
			SELECT 
				u.id_usuario,u.nombres,u.ape_paterno,u.ape_materno,u.email,u.nro_documento FROM `ts_usuario_hist` uh
			JOIN 
				ms_usuario u ON u.id_usuario=uh.id_usuario
			where 
				'$fecha' BETWEEN uh.fecIni and ifnull(uh.fecFin,'$fecha') 
				and uh.estado=1 and uh.id_comercio=$id_comercio
				and u.estado=1 and uh.id_usuario_perfil=$id_perfil
			;
		";
		return $this->db->query($sql);
	}




	public function update_usuario($data,$where){
		$this->db->set($data);
		$this->db->where($where);
		return $this->db->update('ms_usuario');
	}

	public function update_cliente($data,$where){
		$this->db->set($data);
		$this->db->where($where);
		return $this->db->update('ts_cliente');
	}

	public function update_comercio($data,$where){
		$this->db->set($data);
		$this->db->where($where);
		return $this->db->update('ms_comercio');
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

	public function set_comercio_historico($data){
		return $this->db->insert('ts_comercio_historico',$data);
	}

	public function get_comercio_historico($id_comercio,$fecha){
		$sql = "
			SELECT 
				id_proyecto FROM `ts_comercio_historico`
			WHERE 
				'$fecha' BETWEEN fecIni and IFNULL(fecFin,'$fecha')
			and estado=1 and id_comercio=$id_comercio
			;
		";
		return $this->db->query($sql);
	}

	public function update_comercio_historico($data,$where){
		$this->db->set($data);
		$this->db->where($where);
		if($this->db->update('ts_comercio_historico')){
			if($this->db->affected_rows()==0){
				return 1;
			}else{
				return 2;
			}

		}else{
			return 0;
		} 
	}

	public function get_comercio_credito_edit($id_comercio){
		$sql = "
			SELECT 
				creditosCarga 
			FROM 
				`ts_comercio_credito` 
			WHERE id_comercio=$id_comercio and @fecha between fecIni,IFNULL(fecFin,@fecha)
			and estado=1;
			;
		";
		return $this->db->query($sql);
	}

	public function update_comercio_credito($data,$where){
		$this->db->set($data);
		$this->db->where($where);
		return $this->db->update('ts_comercio_credito');
	}

	public function get_menus(){
		$sql = "
		SELECT 
				u.id_menu,u.nombre
			FROM 
				ms_menu u 
			WHERE 
				u.estado=1 
			;
		";
		return $this->db->query($sql);
	}

	public function val_comercio($filtro){
		$sql = "
			SELECT 
				id_comercio FROM `ms_comercio`
			WHERE 
				1=1 
				$filtro
			;
		";
		return $this->db->query($sql);
	}

	public function val_comercio_act($filtro,$id_comercio){
		$sql = "
			SELECT 
				id_comercio FROM `ms_comercio`
			WHERE 
				1=1 
				and id_comercio NOT LIKE $id_comercio
				$filtro
			;
		";
		return $this->db->query($sql);
	}

	public function val_usuario($filtro){
		$sql = "
			SELECT 
				id_usuario FROM `ms_usuario`
			WHERE 
				1=1 
				$filtro
			;
		";
		return $this->db->query($sql);
	}

	public function val_usuario_act($filtro,$id_usuario){
		$sql = "
			SELECT 
				id_usuario FROM `ms_usuario`
			WHERE 
				1=1 
				and id_usuario NOT LIKE $id_usuario
				$filtro
			;
		";
		return $this->db->query($sql);
	}

}
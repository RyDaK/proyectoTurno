<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Gestion_usuario extends MY_Model{
	
	public function __construct(){
		parent::__construct();
	}

	public function get_usuarios($filtro){
		$sql = "
			SELECT 
				u.id_usuario,u.nombres,u.ape_paterno,u.ape_materno,u.nombre_usuario,u.clave,u.email,u.nro_documento,u.estado ,up.nombre 'perfil',uh.fecIni,uh.fecFin,c.nombre 'comercio'
				,uh.id_usuario_hist
			FROM 
				`ms_usuario` u
			LEFT JOIN 
				ts_usuario_hist uh ON uh.id_usuario=u.id_Usuario
			LEFT JOIN 
				ms_usuario_perfil up ON up.id_usuario_perfil=uh.id_usuario_perfil
			LEFT JOIN
				ms_comercio c On c.id_comercio=uh.id_comercio
			WHERE 
			 	1=1 
				$filtro
			ORDER BY u.id_usuario,u.estado
			;
		";
		return $this->db->query($sql);
	}

	public function set_usuario($data){
		return $this->db->insert('ms_usuario',$data);
	}

	public function update_usuario($data,$where){
		$this->db->set($data);
		$this->db->where($where);
		return $this->db->update('ms_usuario');
	}

	public function set_usuario_hist($data){
		return $this->db->insert('ts_usuario_hist',$data);
	}

	public function update_usuario_hist($data,$where){
		$this->db->set($data);
		$this->db->where($where);
		return $this->db->update('ts_usuario_hist');
	}

	public function get_comercios(){
		$sql = "
			SELECT 
				id_comercio,nombre
			FROM 
				`ms_comercio`
			WHERE 
				estado=1
			;
		";
		return $this->db->query($sql);
	}

	public function get_usuario($id_usuario){
		$sql = "
			SELECT 
				nombres,ape_paterno,ape_materno,nombre_usuario,clave,email,nro_documento
			FROM 
				`ms_usuario`
			WHERE 
				id_usuario=$id_usuario
			;
		";
		return $this->db->query($sql);
	}
	

	public function get_comercio($id_comercio){
		$sql = "
			SELECT 
				cm.id_comercio,cm.nombre,cm.razon_social, cm.ruc ,cm.id_rubro,cm.id_giro,cm.costo_delivery,cm.telefono,cm.configurado
			FROM
				ms_comercio cm
			where 
				id_comercio=$id_comercio 
				;
		";
		return $this->db->query($sql);
	}

	public function get_punto_venta($id_comercio){
		$sql = "
			SELECT 
				id_pdv,nombre,direccion,latitud,longitud,ruta,id_centro_comercial,id_ubigeo FROM `ms_punto_venta`
			where 
				id_comercio=$id_comercio 
				;
		";
		return $this->db->query($sql);
	}
	

	public function get_menus($id_usuario_perfil){
		$sql = "
		SELECT 
			u.id_menu,u.nombre, u.icon ,mg.id_menu_grupo,mg.nombre 'grupo',mg.icon 'grupo_icon'
			FROM 
			 ms_usuario_perfil_menu_opcion um
            LEFT JOIN ms_menu u ON u.id_menu= um.id_menu
            LEFT JOIN ms_menu_grupo mg ON mg.id_menu_grupo=u.id_menu_grupo
			WHERE 
				um.estado=1 and um.id_usuario_perfil=$id_usuario_perfil
				;
		";
		return $this->db->query($sql);
	}

	public function get_all_menus(){
		$sql = "
			SELECT 
				u.id_menu,u.nombre, u.icon ,mg.id_menu_grupo,mg.nombre 'grupo',mg.icon 'grupo_icon'
			FROM 
			ms_menu u
			LEFT JOIN ms_menu_grupo mg ON mg.id_menu_grupo=u.id_menu_grupo
			WHERE 
			u.estado=1;
		";
		return $this->db->query($sql);
	}

	

	

	public function get_usuario_hist($id_usuario_hist){
		$sql = "
				SELECT
					id_usuario_hist,fecIni,fecFin,id_usuario_perfil,id_comercio,id_pdv 
				FROM 
					`ts_usuario_hist`
				WHERE 
					id_usuario_hist=$id_usuario_hist 
				;
		";
		return $this->db->query($sql);
	}

	public function get_perfiles_adm(){
		$sql = "
			SELECT 
				id_usuario_perfil,nombre 
			FROM 
				`ms_usuario_perfil` 
			WHERE 
				estado=1
				;
		";
		return $this->db->query($sql);
	}

	public function get_perfiles($filtro){
		$sql = "
			SELECT 
				id_usuario_perfil,nombre 
			FROM 
				`ms_usuario_perfil` 
			WHERE 
				estado=1
				$filtro
				;
		";
		return $this->db->query($sql);
	}

	public function get_usuario_menu($id_usuario){
		$sql = "
			SELECT 
				id_menu FROM `ts_usuario_menu`
			WHERE
				estado=1 and id_usuario=$id_usuario
				;
		";
		return $this->db->query($sql);
	}
	

	public function set_usuario_menu($data){
		return $this->db->insert('ts_usuario_menu',$data);
	}

	public function update_usuario_menu($data,$where){
		$this->db->set($data);
		$this->db->where($where);
		if($this->db->update('ts_usuario_menu')){
			if($this->db->affected_rows()==0){
				return 1;
			}else{
				return 2;
			}

		}else{
			return 0;
		} 
	}

	public function val_usuario($usuario){
		$sql = "
			SELECT 
				id_usuario FROM `ms_usuario`
			WHERE 
				nombre_usuario='$usuario' 
			;
		";
		return $this->db->query($sql);
	}
	

	public function val_usuario_act($usuario,$id_usuario){
		$sql = "
			SELECT 
				id_usuario FROM `ms_usuario`
			WHERE 
				nombre_usuario='$usuario' 
				and id_usuario NOT LIKE '$id_usuario'
			;
		";
		return $this->db->query($sql);
	}

	public function val_usuario_dni_act($dni,$id_usuario){
		$sql = "
			SELECT 
				id_usuario FROM `ms_usuario`
			WHERE 
				nro_documento='$dni' AND
				nro_documento NOT LIKE ''
				and id_usuario NOT LIKE '$id_usuario'
			;
		";
		return $this->db->query($sql);
	}

	public function val_usuario_dni($dni){
		$sql = "
			SELECT 
				id_usuario FROM `ms_usuario`
			WHERE 
				nro_documento='$dni' AND
				nro_documento NOT LIKE ''
			;
		";
		return $this->db->query($sql);
	}

}

	
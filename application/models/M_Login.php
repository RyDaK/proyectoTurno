<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Login extends MY_Model{
	
	public function __construct(){
		parent::__construct();
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


	public function get_comercio($id_comercio){
		$sql = "
			SELECT 
				cm.id_comercio,cm.configurado
			FROM
				ms_comercio cm
			where 
				id_comercio=$id_comercio 
				;
		";
		return $this->db->query($sql);
	}
}
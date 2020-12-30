<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model{

	public function __construct(){
		parent::__construct();
		$sql="SET @fecha = CURDATE();";
		$this->db->query($sql);
	}
	
	public function asignar_fechas($fecIni,$fecFin){
		$sql="SET @fecIni = '".date_change_format_bd($fecIni)."', @fecFin = '".(!empty($fecFin)? date_change_format_bd($fecFin): null)."';";
		//echo $sql;
		$this->db->query($sql);
	}
}
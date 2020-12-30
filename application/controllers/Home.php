<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {
	
	public function index()
	{
		$config['css']['style']=array();
		//$config['nav']['menu_active']='10';
		//
		$config['data']['icon']='fa fa-home';
		$config['data']['title']='Home';
		$config['data']['message']='Bienvenido al sistema, '.$this->session->userdata('nombres').' '.$this->session->userdata('ape_paterno');
		$this->view($config);
		
	}
}

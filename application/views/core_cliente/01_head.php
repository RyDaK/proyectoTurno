<!DOCTYPE html>
<html lang="es">
 <!--
=========================================================
* ArchitectUI HTML Theme Dashboard - v1.0.0
=========================================================
* Product Page: https://dashboardpack.com
* Copyright 2019 DashboardPack (https://dashboardpack.com)
* Licensed under MIT (https://github.com/DashboardPack/architectui-html-theme-free/blob/master/LICENSE)
=========================================================
* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta http-equiv="Content-Language" content="es">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
		<title>:.:.: Turno - Development by MACCTEC :.:.:</title>
		
		<meta name="description" content="coming soom.">
		<meta name="msapplication-tap-highlight" content="no">
		<base href="<?=base_url().'public/';?>" site_url="<?=site_url();?>">
		<!--CSS-->
		<link href="core/libs/font-awesome/css/font-awesome.css" rel="stylesheet">
		<link href="core/css/main.css" rel="stylesheet">
		<link href="custom/custom.css" rel="stylesheet">
		<link rel="icon" href="assets/images/icono.png">
		<link href="core/libs/daterangepicker/daterangepicker.css" rel="stylesheet">
		<link rel="stylesheet" href="core/libs/sweetalert/sweetalert.css">
		<!--
		<link rel="stylesheet" href="core/libs/bootstrap/bootstrap-modified.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">
		<link href="core/libs/open-iconic/font/css/open-iconic-bootstrap.css" rel="stylesheet">
		<link href="core/libs/open-iconic/font/css/open-iconic-foundation.css" rel="stylesheet">
		<link href="core/libs/open-iconic/font/css/open-iconic.css" rel="stylesheet">
		<link href="core/libs/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet">
		<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600' rel='stylesheet' type='text/css'>
		-->
		<?foreach($style as $css){?>
			<link href="custom/css/<?=$css?>.css" rel="stylesheet">
		<?}?>
	</head>
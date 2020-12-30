<div id="llenadoOperario">
<style>
.modal-body {
  overflow-x: auto;
}
</style>
<? $perfil_usuario = $this->session->userdata('id_usuario_perfil');
	// if($perfil_usuario == 3){
	// 	$perfil_usuario == 5;
	// }
?>
	<div class="row">
		<div class="col-md-2 col-6 col-sm-6">
				<button  id="btn-print" data-value="2" style="width:100%" type="button" href="javascript:;" class="btn btn-success btn-print" data-toggle="tooltip" data-placement="top" title="" data-original-title="Imprimir Ticket"><i class="fa fa-print" ></i> Imprimir</button>
		</div>
		<br>
		<div class="col-md-3 col-6 col-sm-6">
		<button id="btn_nuevo_op" type="button" style="width:100%" href="javascript:;" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Agregar Pedido"><i class="fa fa-plus" ></i> Nuevo</button>
		</div>
		<br>
	</div>
	<br>
	<div class="row">
		<div class="col-md-2 col-6 col-sm-0">
		
			<button id="btn-refresh" style="width:100%" id_estado_ped="1" type="button" href="javascript:;" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Actualizar Lista" ><i class="fa fa-refresh" ></i> Actualizar</button>
			<button id="btn-refresh-wait" hidden="hidden" disabled="disabled" style="width:100%"  type="button" href="javascript:;" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="" ><i class="fa fa-refresh" ></i> Actualizar</button>
		</div>
		<br>
			<?
			if( $perfil_usuario == 3|| $perfil_usuario == 5 || $perfil_usuario == 6 || $perfil_usuario == 7 || $perfil_usuario == 8){
				$boton = "";
				$id_estado_pedido  = 1;
				if($perfil_usuario == 6){
					$id_estado_pedido  = 2;
				}else if($perfil_usuario == 7){
					$id_estado_pedido  = 3;
				}
			?>
			<?}else{$boton = 'hidden';}?>
		<div class="col-md-3 col-6 col-sm-6">
			<button id="btn-send" <?=$boton ?>  id_rol="<?=$perfil_usuario?>" style="width:100%" id_estado_ped="<?=$id_estado_pedido?>" type="button" href="javascript:;" class="btn btn-success" profile="<?=$perfil_usuario?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Ver Detalle del Pedido"><i class="fa fa-send" ></i>Ver Detalle del Pedido</button>
		</div>
		<div class="col-md-2 col-12 col-sm-12"></div>
		<br>
		<div class="col-md-2 col-6 col-sm-6">
		<button  style="width:100%" id="btn-acceso-regresar" data-value="2" type="button" href="javascript:;" class="btn btn-success " data-toggle="tooltip" data-placement="top" title="" data-original-title="Regresar"><i class="fa fa-arrow-left" ></i> Regresar</button>
		</div>
		<br>

		<div class="col-md-3 col-6 col-sm-6">
			<button  style="width:100%" id="btn-acceso" data-value="2" type="button" href="javascript:;" class="btn btn-success btn-acceso-pedidos" data-toggle="tooltip" data-placement="top" title="" data-original-title="Pedidos Confirmados"><i class="fa fa-check" ></i> Pedidos Confirmados</button>
		</div>
	</div>

	<div class="divider"></div> 
	<div class="main-card mb-3 card">
		<div id="content-table" class="card-body">
			<div class="alert alert-default2"><img src="assets/images/load.gif" /> Buscando registros...</div>          
		</div>
	</div>
	
</div>

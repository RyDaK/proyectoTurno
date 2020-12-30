<style type="text/css">

	th{
		font-size: 12px;
	}

	td{
		font-size: 11px;
	}

	.input-total{
		height: 30px;
		width: 50%;
		padding-top: 3px;
		text-align: center;
		font-size: 80%;
	}

	.input-group-addon{
		width: 50%;
		height: 30px;
		background-color: #57cbb3; 
		color: white;
		text-align: center;
		padding-top: 3px;
		border-top-left-radius: 20px;
		border-bottom-left-radius:20px;
	}
	
	.btn-continuar{
		margin-left: 10px;
	}

	.caja-text-menu{
		padding-left: 0px;
	}

	.total-text-menu{
		width: 50%;
		background-color:red ; 
		color: white;
		font-size: 110%;
		padding-top: 2%;
	}

	.calendario-menu{
		width: 100%;
		border-color: #d1d1d1;
	}
	textarea{
		border-color: #d1d1d1; 
		width: 100%
	}
	.textarea-menu{
		padding-left: 0px;
	}

	.form-control.btn-sm.selectpicker{
		width: 80%;
	}
	.line-container {
	width: 200px;
	height: 20px;
	}
	.single-line {
	width: 100%;
	text-overflow: ellipsis;
	overflow: hidden;
	white-space: pre;
	}
</style>
<div class="container-fluid p-0">
	<div class="divider"></div>
	<div class="">
		<div class="card-body">
		<div class="row col-12 col-sm-12 col-md-12 col-lg-12 mx-auto m-0">
				<div class="row col-12 col-sm-12 col-md-12 col-lg-12 m-0 p-0">
					<table class="table table-bordered ">
					<tr class="line-container single-line">
					      <th class="text-center" style="width:20%" >ARTICULOS</th>
					      <th class="text-center" style="width:20%">DETALLE</th>
					      <th class="text-center" style="width:10%">PRECIO</th>
						  <th class="text-center" style="width:1%">CANTIDAD</th>
					      <th class="text-center" style="width:10%">COSTO EMPAQUES</th>
					      <th class="text-center" style="width:20%">OBSERVACION</th>
					      <th class="text-center" style="width:10%">SUBTOTAL</th>
					    </tr>
					  </thead>
					  <tbody>
						  <?$total_pedido=0; foreach($data as $row){?>
							<tr>
								<td class="text-center"><?=$row->plato?></td>
								<td class="text-center"><?=$row->observacion?></td>
								<td class="text-center"><?='S/.'.dos_decimales($row->precio_unitario)?></td>
								<td class="text-center"><?=$row->cantidad?></td>
								<td class="text-center"><?='S/.'.dos_decimales($row->costo_empaque * $row->cantidad)?></td>
								<td class="text-center"><?=isset($row->comentario)? $row->comentario: '-'?></td>
								<?$nuevo_importe= ($row->importe);?>
								<td class="text-center"><?='S/.'.dos_decimales($row->importe)?></td>
							</tr>
							<?
							$total_pedido += $nuevo_importe;
							$fecha = $row->fecha;
							$hora =$row->hora;
							$pago =$row->medio_pago;
							$entrega = $row->id_metodo_env;
							$direccion = $row->direccion;
							$distrito_envio = $row->distrito;
							$id_comercio = $row->id_comercio;
							$metodo_pago = $row->medio_pago;
							$costo_delivery = $row->costo_delivery;
							$usuario = $row->nombre_usuario;
						}?>
					  </tbody>
					</table>
				</div>
				<div class="row col-12 col-sm-12 col-md-12 col-lg-12 m-0 p-0">
						<div  class="col-md-2"></div>
						<div class="form-group col-md-6"></div>
						<div class="form-group col-md-4">
							<?if($entrega == 1){?>
								<div  class="input-group">
									<span class="input-group-addon" >COSTO ENVÍO: </span>
									<input id="costo_envio" type="text" class="form-control input-total" name="costo_envio" value="<?="S/. ".dos_decimales($costo_delivery)?>" readonly="readonly">
									<input id="costo_envio_num" hidden="hidden" type="text" class="form-control input-total" name="costo_envio" value="<?=dos_decimales($costo_delivery)?>" readonly="readonly">
								</div>
								<?}else{?>
									<input id="costo_envio_num" hidden="hidden" type="text" class="form-control input-total" name="costo_envio" value="0" readonly="readonly">
								
								<?}?>
						</div>
						
				</div>
				<div class="row col-12 col-sm-12 col-md-12 col-lg-12 m-0 p-0">
						<div  class="col-md-2"></div>
						<div class="form-group col-md-6"></div>
						<div class="form-group col-md-4">
							<div  class="input-group">
								<span class="input-group-addon" >TOTAL: </span>
								<input id="total_pedido" type="text" class="form-control input-total" name="total_pedido_det" value="<?="S/. ".dos_decimales($total_pedido)?>" readonly="readonly">
								<input id="total_pedido_num" hidden="hidden" type="text" class="form-control input-total" name="total_pedido_det" value="<?=dos_decimales($total_pedido)?>" readonly="readonly">
							</div>
						</div>
						
				</div>
			</div>
			<!-- <div class="row col-12 col-sm-5 col-md-5 col-lg-5 pull-right m-0 p-0">
				<div class="row col-0 col-sm-6 col-md-6 col-lg-6 m-0 p-1"></div>
				<div class="row col-12 col-sm-6 col-md-6 col-lg-6 p-1">
					<button class="btn btn-success btn-block btn-continuar">CONTINUAR  <i class="fas fa-chevron-right"></i></button>
				</div>
			</div> -->
			<br><br>
			<hr>
			<div class="row col-12 col-md-12 col-lg-12 m-0">
				<div class="row col-12 col-sm-7 col-md-7 col-lg-7 m-0 p-0">
					<div class="col-12 col-sm-6 col-md-6 col-lg-6 p-0">
						<label>Despacho: </label><br>
						<center>
							<div class="custom-control custom-radio custom-control-inline">
							  <input <?=($entrega == 2)? "checked":"disabled"?> type="radio" id="recojo" name="recojo-envio" class="custom-control-input">
							  <label class="custom-control-label" for="recojo">Recojo</label>
							</div>
							<div class="custom-control custom-radio custom-control-inline" >
							  <input <?=($entrega == 1)? "checked":"disabled"?> type="radio" id="envio" name="recojo-envio" class="custom-control-input">
							  <label class="custom-control-label" for="envio"> Envio</label>
							</div>
						</center>
						<br>
					</div>
					<div class="col-12 col-sm-6 col-md-6 col-lg-6 p-0 ">
						<div class="row col-12 col-sm-12 col-md-12 col-lg-12 m-0">
							<label>Fecha: </label>
							<input value="<?=$fecha."  ".$hora ?>" class="calendario-menu form-control" readonly="readonly" type="text" id="start" name="trip-start">
						</div>
						<br>
					</div>
					<?if($entrega == 1){?>
						<div class="col-12 col-sm-12 col-md-12 col-lg-12 textarea-menu">
							<label><i class="fas fa-route"></i> Direccion Registrada: </label>
							<textarea name="" id="" rows="4" readonly="readonly"><?=$direccion?></textarea>
						</div>
					<?}?>
				</div>
				<div class="row col-12 col-sm-5 col-md-5 col-lg-5 m-0 p-0 ">
					<div class="col-6 col-sm-6 col-md-6 col-lg-6 p-0">
						<label>Metodo de Pago: </label><br>
						<?foreach($metodos_pago as $row){?>
							<div class="custom-control custom-radio">
							<input <?=($metodo_pago == $row->nombre)? "checked":"disabled"?> type="radio" id="<?=$row->nombre?>" name="metodo-pago" class="custom-control-input">
							<label class="custom-control-label" for="<?=$row->nombre?>"><?=$row->nombre?></label>
	</div>
						<?}?>
<!-- 
						<div class="custom-control custom-radio">
						  <input  <?=($metodo_pago == 'linea')? "checked":"disabled"?> type="radio" id="linea" name="metodo-pago" class="custom-control-input">
						  <label  class="custom-control-label" for="linea">Línea&nbsp;&nbsp;&nbsp;&nbsp;</label>
						</div>
						<div class="custom-control custom-radio">
						  <input  <?=($metodo_pago == 'tarjeta')? "checked":"disabled"?> type="radio" id="tarjeta" name="metodo-pago" class="custom-control-input">
						  <label  class="custom-control-label" for="tarjeta">Tarjeta&nbsp;&nbsp;</label>
						</div>
						<p></p> -->
						<!-- <select class="form-control btn-sm selectpicker" id="" name="" data-actions-box="true" data-live-search="false"  >
							<option value="">--Seleccionar--</option>
                            <option value="">Visa</option>
                            <option value="">Matercard</option>
                        </select > -->
					</div>
					<div class="col-6 col-sm-6 col-md-6 col-lg-6 p-0">
						<?if($entrega != 2){?>
							<label>Responsable de Envio: </label><br>
							<center>
						<select class="form-control btn-sm selectpicker" id="medio_envio" name="" data-actions-box="true" data-live-search="false"  >
							<option value="">--Seleccionar--</option>
							<?
							$sql = $this->db->get_where('ms_medio_envio',array('id_comercio'=>$id_comercio,'estado'=>1));
							
							?>
							<?foreach($sql->result() as $row){?>
								<option value="<?=$row->id_medio_env?>"><?=$row->titulo?></option>
								<?}?>
							</select >
                        <br>
                        <!-- <div class="form-check form-check-inline">
						  <input class="form-check-input" type="checkbox" id="avisar-menu" value="">
						  <label class="form-check-label" for="avisar-menu">Avisar ahora</label>
						</div> -->
					</center>
					<?}?>
					</div>
						<?if($entrega != 2){?>
						<div class="col-6 col-sm-6 col-md-6 col-lg-6 p-0">
							<label>Distrito de Envio: </label><br>
							<center>
							<input type="text" class="form-control" readonly="readonly" value="<?=$distrito_envio?>">
                        <br>
						</center>
					</div>
					<div class="col-6 col-sm-6 col-md-6 col-lg-6 p-0"></div>
					<?}?>
					<div class="col-12 col-sm-6 col-md-6 col-lg-6 p-1 anucon-button">
					<br>
						<button cod_ped="<?=$idPedidoCliente?>"  id="btn_anular_pedido" class="btn btn-danger btn-block">ANULAR PEDIDO</button>
					</div>
					<div class="col-12 col-sm-6 col-md-6 col-lg-6 p-1 anucon-button">
					<br>
						<button id="btn_confirmar_pedido" onclick="PedidosOP.confirmar_pedidos(<?=$idPedidoCliente?>,'confirmar')" class="btn btn-success btn-block">CONFIRMAR PEDIDO</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
		var $total =  Number(Number($('#costo_envio_num').val()) + Number($('#total_pedido_num').val())).toFixed(2);  

		$('#total_pedido').val("S/."+$total);
    	$('#opciones_tarjeta').hide();
        $('#opciones_recojo').hide();
        $('#direccion_envio').hide();
        
		$('input[name ="metodo-pago"]').on("click",function(e){

			let x = $(this).attr('id');
			if(x =="tarjeta"){
				$('#opciones_tarjeta').show();
			}else{
				$('#opciones_tarjeta').hide();
			}
			// PedidosOP.pago = x;
		});
		
		$('input[name ="recojo-envio"]').on("click",function(e){
            
			let x = $(this).attr('id');
			if(x =="recojo"){
                $('#opciones_recojo').show();
                $('#direccion_envio').hide();
                
			}else{
                $('#opciones_recojo').hide();
                $('#direccion_envio').show();
                
			}
			// PedidosOP.despacho = x;
		});
		
		$("#opciones_recojo_sel"). change(function(){
		var select_local = $(this). children("option:selected"). val();

		PedidosOP.cod_local = select_local;
		});

        
</script>
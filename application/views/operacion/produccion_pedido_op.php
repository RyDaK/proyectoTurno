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

	.input-group{
		border-top-right-radius: 20px;
		border-bottom-right-radius:20px;
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
		<div class="card-body">
			<div class="row" style="padding-left:10px">
				<div  class="col-md-5 col-7 col-sm-6" style="">
					<div  class="input-group">
						<span class="input-group-addon" >PEDIDO N°: </span>
						<input id="n_pedido_vista" type="text" class="form-control input-total" name="idPedido" value="<?=''?>" readonly="readonly">
					</div>
				</div>
				<div class='col-md-1 col-1 col-sm-1'></div>
				<div  class="col-md-6 col-3 col-sm-5">
						<button style="float:right; margin-left: 0.5em" data-id='0' id="btn-print-produccion" data-value="2" type="button" href="javascript:;" class="btn btn-success btn-print" data-toggle="tooltip" data-placement="top" title="" data-original-title="Imprimir Ticket"><i class="fa fa-print" ></i> Imprimir</button>
				</div>
			</div>
				<br>
				<div class="row col-12 col-sm-12 col-md-12 col-lg-12 mx-auto m-0">
					<div class="row col-12 col-sm-12 col-md-12 col-lg-12 m-0 p-0">
					<table class="table table-bordered">
					  <thead>
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
								$id_comercio = $row->id_comercio;
								$idPedidoCliente = $row->idPedidoCliente;
								$costo_delivery = $row->costo_delivery;

							}?>
						</tbody>
						</table>
					</div>
					<div class="row col-12 col-sm-12 col-md-12 col-lg-12 m-0 p-0">
						<div  class="col-md-4" hidden="hidden">
							<div class="input-group">
								<span class="input-group-addon" >PEDIDO N°: </span>
								<input id="n_pedido" type="text" class="form-control input-total" name="idPedido" value="<?=$idPedidoCliente?>" readonly="readonly">
							</div>
						</div>
						<div  class="col-md-8"></div>
						<div class="form-group col-md-4 col-sm-4">
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
						<div  class="col-md-8"></div>
							<input type="text" hidden="hidden" id="id_ped" value="<?=$idPedidoCliente?>">
							
						<div class="form-group col-md-4 col-sm-4">
							<div  class="input-group">
								<span class="input-group-addon" >TOTAL: </span>
								<input id="total_pedido" type="text" class="form-control input-total" name="total_pedido_det" value="<?="S/. ".$total_pedido?>" readonly="readonly">
								<input hidden="hidden" id="total_pedido_num" type="text" class="form-control input-total" name="total_pedido_num" value="<?=$total_pedido?>" readonly="readonly">
							</div>
						</div>
						
					</div>
					<div class="row col-12 col-sm-12 col-md-12 col-lg-12 m-0 p-0">
							<div  class="col-md-8"></div>
							<div class="form-group col-md-4 col-sm-4" >
										<button onclick="PedidosOP.confirmar_pedidos(<?=$idPedidoCliente?>,'produccion')" class="btn btn-success btn-block">PEDIDO PRODUCIDO</button>
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
			PedidosOP.pago = x;
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
			PedidosOP.despacho = x;
		});
		
		$("#opciones_recojo_sel"). change(function(){
		var select_local = $(this). children("option:selected"). val();

		PedidosOP.cod_local = select_local;
		});

        $('#n_pedido_vista').val($('#n_pedido').val());
        $('#btn-print-produccion').attr('data-id',$('#id_ped').val());
</script>
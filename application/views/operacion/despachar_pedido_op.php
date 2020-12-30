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
	<div class="main-card card">
		<div class="card-body">
			<div class="row" style="padding-left:15px">
				<div  class="col-md-4" style="">
					<div  class="input-group">
						<span class="input-group-addon" >PEDIDO N°: </span>
						<input id="n_pedido_vista" type="text" class="form-control input-total" name="idPedido" value="<?=''?>" readonly="readonly">
					</div>
				</div>
				<div class='col-md-5'></div>
				<div  class="col-md-3">
						<button style="margin-left: 30%;" id="btn-print-despacho" data-value="2" type="button" href="javascript:;" class="btn btn-success btn-print" data-toggle="tooltip" data-placement="top" title="" data-original-title="Imprimir Ticket"><i class="fa fa-print" ></i> Imprimir</button>
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
							$medio_envio = $row->medio_envio;
							$medio_pago = $row->medio_pago;
							$costo_delivery = $row->costo_delivery;
							$idPedidoCliente = $row->idPedidoCliente;
							$distrito_envio = $row->distrito;
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
								<input id="total_pedido" type="text" class="form-control input-total" name="total_pedido_det" value="<?="S/. ".$total_pedido?>" readonly="readonly">
								<input id="total_pedido_num" hidden="hidden" type="text" class="form-control input-total" name="total_pedido_det" value="<?=$total_pedido?>" readonly="readonly">
							</div>
						</div>
						
				</div>
			</div>
			<br><br>
			<hr>
			<div class="row col-12 col-md-12 col-lg-12 m-0">
				<div class="row col-12 col-sm-6 col-md-6 col-lg-6 m-0 p-0">
					<div class="col-12 col-sm-6 col-md-6 col-lg-6 p-0">
						<label>Despacho: </label><br>
						<center>
							
							<div class="custom-control custom-radio custom-control-inline">
							  <input <?=($entrega == 2)? "checked":"disabled"?> type="radio" id="recojo" name="recojo-envio" class="custom-control-input">
							  <label class="custom-control-label" for="recojo">Recojo</label>
							</div>
							<div class="custom-control custom-radio custom-control-inline" >
							  <input <?=($entrega == 1)? "checked":"disabled"?> type="radio" id="envio" name="recojo-envio" class="custom-control-input">
							  <label class="custom-control-label" for="envio"> Envío</label>
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
				<input type="text" hidden="hidden" id="id_ped" value="<?=$idPedidoCliente?>">

				<div class="row col-12 col-sm-6 col-md-6 col-lg-6 m-0 p-0">
					<div class="col-12 col-sm-6 col-md-6 col-lg-6 p-0" style="margin-right:10px">
						<label>Pedido N°: </label><br>
						<center>
						<input type="text" class="form-control" id="n_pedido" readonly="readonly" value="<?=$idPedidoCliente?>">
						<br>
					</div>
					<?if($entrega == 1){?>
						<div class="col-12 col-sm-5 col-md-5 col-lg-5 p-0" id="distrito_entrega">
							<label>Distrito de Entrega: </label><br>
							<center>
								<input type="text" class="form-control" readonly="readonly" value="<?=$distrito_envio?>">
								<br>
							</div>
					<?}?>

					<div class="col-12 col-sm-12 col-md-12 col-lg-12 p-0" style="">
						<label>Nombre del Cliente: </label><br>
						<center>
						<input type="text" class="form-control" readonly="readonly" value="<?=$usuario?>">
						<br>
					</div>
					
				</div>
				<div class="row col-12 col-sm-6 col-md-6 col-lg-6 m-0 p-0">
					<div class="col-12 col-sm-6 col-md-6 col-lg-6 p-0">
						<label>Medio de Pago: </label><br>
						<center>
						<?foreach($metodos_pago as $row){?>
						
							<?if($medio_pago == $row->nombre){?>
							<div class="custom-control custom-radio">
							<input <?=($medio_pago == $row->nombre)? "checked":"disabled"?> type="radio" id="<?=$row->nombre?>" name="metodo-pago" class="custom-control-input">
							<label class="custom-control-label" for="<?=$row->nombre?>"><?=$row->nombre?></label>
							</div>
							<?}?>
							<?}?>

						</center>
						<br>
					</div>
					</div>
				<div class="row col-12 col-sm-6 col-md-6 col-lg-6 m-0 p-0 ">
					<div class="col-12 col-sm-12 col-md-12 col-lg-12 p-0">
						<?
							$sql = $this->db->get_where('ms_medio_envio',array('id_medio_env'=>$medio_envio));

							foreach($sql->result() as $row){
								$medio_envio = $row->titulo;
							}
						?>
						<?if($entrega != 2){?>
						<label>Responsable de Envío: </label><br>
						<center>
							<input value="<?=$medio_envio?>" class="form-control" readonly="readonly" type="text">
						</center>
						<?}?>
						
                        <br>
                        <!-- <div class="form-check form-check-inline pull-right">
						  <input class="form-check-input" type="checkbox" id="avisar-menu" value="">
						  <label class="form-check-label" for="avisar-menu">Avisar ahora</label>
						</div> -->
					</div>
					<div class="col-12 col-sm-12 col-md-12 col-lg-12 p-0 m-3 border">
						<button onclick="PedidosOP.confirmar_pedidos(<?=$idPedidoCliente?>,'despacho')" class="btn btn-success btn-block">CONFIRMAR DESPACHO</button>
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
        $('#btn-print-despacho').attr('data-id',$('#id_ped').val());
        
</script>
<?
/*
	if($entrega == 2 ){?>
	<script>
		$('#btn-print-despacho').hide();
	</script>
	<?}
	*/
?>
<? $importetotal=0; foreach($listado_pedidos as $row){ 
	$moneda="S/.";
	?>
	<hr>

<div class="row">
	<div class="col-sm-2" >
	<center>

		<img src="../files/articulos/<?=!empty($row->foto_plato)? $row->foto_plato.".jpg": "default.jpg"?>" alt="Lights" class="" style="text-align: center; height: 100px; width:150px; border-radius: 5px 5px 5px 5px;" >
		</center>
	
	</div>
	<div class="col-sm-7" >
		<h5 class="text-success" ><?= $row->plato?></h5>
		<div class="position-relative form-group">
			<textarea placeholder="Especifíque detalles de su pedido" rows="2" class="form-control"  readonly="readonly"  ><?=$row->comentario?></textarea>
		</div>
	</div>
	<div class="col-sm-3" >
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon" style="width: 100px;">Precio Unit.</span>
				<input value="<?=$moneda?>" class="form-control simbolo_moneda" readonly="readonly" style="flex:none;width:50px" >
				<input type="text" class="form-control" name="precio_plato" value="<?=dos_decimales($row->precio_unitario)?>" readonly="readonly" >
			</div>
		</div>
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon" style="width: 100px;">Cant.</span>
				<input type="text"  patron="requerido,enteros" class="form-control cantidad_platos" readonly="readonly" name="cantidad_platos" value="<?= $row->cantidad?>" >    
			</div>
		</div>
		<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon" style="width: 100px;">Costo Empaque{s}.</span>
				<input value="<?=$moneda?>" class="form-control simbolo_moneda" readonly="readonly" style="flex:none;width:50px" >
					<input id="" ped_cod_env_det="" type="text" class="form-control" name="precio_plato" value="<?=dos_decimales($row->empaque * $row->cantidad)?>" readonly="readonly" >
				</div>
			</div>
		<div class="form-group">
			<div  class="input-group">
				<span class="input-group-addon bg-success text-white" style="width: 100px; padding: 0.5em; border-radius: 5px 0px 0px 5px;" >Sub Total</span>
				<input value="<?=$moneda?>" class="form-control simbolo_moneda" readonly="readonly" style="flex:none;width:50px" >
				<input type="text" class="form-control" name="total_pedido_det" value="<?=dos_decimales($row->importe)?>" readonly="readonly" >                                        
			</div>
		</div>
	</div>
</div>
<?		$importetotal += ($row->importe);
 ?>
<?}?>
<hr />
<div class="row" >
	<div class="col-sm-9" ></div>
	<div class="col-md-3">
		<div class="form-group">
			<div  class="input-group" id="div_costo_envio">
				<span class="input-group-addon bg-success text-white" style="width: 100px; padding: 0.5em; border-radius: 5px 0px 0px 5px;" >Costo Envio</span>
				<input value="<?=$moneda?>" class="form-control simbolo_moneda" readonly="readonly" style="flex:none;width:50px" >
				<input id="txtcosto_envio_vista" type="text" class="form-control" patron="requerido" name="txtcosto_envio_vista" value="" readonly="readonly" >
			</div>
		</div>
	</div>
</div>
<div class="row" >
	<div class="col-sm-9" ></div>
	<div class="col-sm-3" >
		<div class="form-group">
			<div  class="input-group">
				<span class="input-group-addon bg-success text-white" style="width: 100px; padding: 0.5em; border-radius: 5px 0px 0px 5px;" >Total</span>
				<input value="<?=$moneda?>" class="form-control simbolo_moneda" readonly="readonly" style="flex:none;width:50px" >
				<input id="total_pedido" type="text" class="form-control" patron="requerido" name="total_pedido" value="<?=dos_decimales($importetotal)?>" readonly="readonly" >
			</div>
		</div>
	</div>
</div>
<?php
date_default_timezone_set("America/Lima");
$currentDate = date('Y-m-d');
$currentTime = date('H:i');
// echo $currentDateTime;
?> 
<div class="container-fluid p-0">
	<div class="main-card card">
		<div class="card-body">
			<div class="form-row">
				<div class="col-md-4">
					<div class="position-relative form-group">
						<label for="recojo-envio"><strong>Forma de Entrega</strong></label><br />
							<?foreach($metodos_entrega as $row):?>
								<div class="custom-control custom-radio custom-control-inline">
									<input type="radio" id="<?=$row->nombre?>" name="recojo-envio" class="custom-control-input recojo-envio" value="<?=$row->id_metodo_env?>">
									<label class="custom-control-label" for="<?=$row->nombre?>"><?=($row->id_metodo_env == 1)? "Envío a domicilio":"Recojo en local"?></label>
								</div>
							<?endforeach?>

					</div>
				</div>
				<div class="col-md-4">
					<div class="position-relative form-group">
						<label for="recojo-envio"><strong>Medio de Pago</strong></label><br />
						<?foreach($metodos_pago as $row){?>
							<div class="custom-control custom-radio">
								<input id_="<?=$row->id_metodo_pag?>" type="radio" id="<?=$row->nombre?>" name="metodo-pago" class="custom-control-input">
								<label class="custom-control-label" for="<?=$row->nombre?>"><i class="<?=isset($row->icono)?$row->icono:'fa fa-money'?>" ></i> <?=$row->nombre?></label>
							</div>
							<?}?>
						<!-- <div class="custom-control custom-radio">
						  <input  type="radio" id="linea" name="metodo-pago" class="custom-control-input">
						  <label class="custom-control-label" for="linea"><i class="fa fa-laptop" ></i> Pago Web&nbsp;&nbsp;&nbsp;&nbsp;</label>
						</div>
						<div class="custom-control custom-radio">
						  <input  type="radio" id="tarjeta" name="metodo-pago" class="custom-control-input">
						  <label class="custom-control-label" for="tarjeta"><i class="fa fa-credit-card" ></i> Tarjeta&nbsp;&nbsp;</label>
						</div> -->
					</div>
				</div>
				<div class="col-md-3">
					<div class="row">
						<div class="col-md-12">
							<div class="position-relative form-group">
								<label><strong>Fecha</strong></label>
								<input  min="<?=$currentDate.'T'.$currentTime?>" class="form-control calendario-menu" value="<?=$currentDate.'T'.$currentTime?>" type="datetime-local" id="txtfechapedido" name="trip-start">
							</div>
						</div>
					</div>

				</div>
				
			</div>
			<?$costo_default = 0;?>
			<div class="form-row" id="direccion_envio">
				<div class="col-md-2">
					<div class="position-relative form-group">
						<label><strong>Distritos de Cobertura</strong></label>
						<select class="form-control" id="sl_mi_distrito" name="sl_mi_distrito"  >
							<? $ix=0;foreach($distritos as $row){ ?>
								<option value="<?=$row['id_ubigeo']?>" data-delivery="<?=$row['costo']?>" ><?=$row['distrito']?></option>
								<?if($ix==0) $costo_default = $row['costo'];?>
								<?$ix++?>
							<?}?>
						</select >
						
					</div>
				</div>
				<div class="col-md-1"></div>

				<?if($costo_default =='')  $costo_default = 0.00;?>
				<div class="col-md-9">
					<div class="position-relative form-group">
						<label><strong>Dirección de Envio</strong></label>
						<div class="form-row">
								<div class="col-md-6">
									<div class="position-relative form-group">
										<label><strong>Vía</strong></label>
										<div class="row">
											<div class="col-md-6" >
												<select class="form-control" name="id_via_local" id="id_via_local">
												<option value="">--Seleccione--</option>
													<option value="Avenida">Avenida</option>
													<option value="Jiron">Jirón</option>
													<option value="Calle">Calle</option>
													<option value="Pasaje">Pasaje</option>
													<option value="Alameda">Alameda</option>
													<option value="Malecon">Malecón</option>
													<option value="Ovalo">Ovalo</option>
													<option value="Parque">Parque</option>
													<option value="Carretera">Carretera</option>
													<option value="Block">Block</option>
												</select>
											</div>
											<div class="col-md-6" >
												<input name="via_local" id="via_local" placeholder="Escribe Aquí" type="text" class="form-control">
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="position-relative form-group">
										<label><strong>Zona</strong></label>
										<div class="row">
											<div class="col-md-6" >
												<select class="form-control" name="id_zona_local" id="id_zona_local">
												<option value="">--Seleccione--</option>
													<option value="Urbanizacion">Urbanización</option>
													<option value="Pueblo Joven">Pueblo Joven</option>
													<option value="Unidad Vecinal">Unidad Vecinal</option>
													<option value="Conjunto Habitacional">Conjunto Habitacional</option>
													<option value="Asentamiento Humano">Asentamiento Humano</option>
													<option value="Cooperativa">Cooperativa</option>
													<option value="Residencial">Residencial</option>
													<option value="Zona Industrial">Zona Industrial</option>
													<option value="Grupo">Grupo</option>
													<option value="Caserio">Caserio</option>
													<option value="Fundo">Fundo</option>
												</select>
											</div>
											<div class="col-md-6" >
												<input name="zona_local" id="zona_local" placeholder="Escribe Aquí" type="text" class="form-control">
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="form-row">
								<div class="col-md-2">
									<div class="position-relative form-group">
										<input name="km_local" id="km_local" placeholder="Km" type="text" class="form-control">
									</div>
								</div>
								<div class="col-md-2">
									<div class="position-relative form-group">
										<input name="mza_local" id="mza_local" placeholder="Mz" type="text" class="form-control">
									</div>
								</div>
								<div class="col-md-2">
									<div class="position-relative form-group">
										<input name="dep_local" id="dep_local" placeholder="Dep." type="text" class="form-control">
									</div>
								</div>
								<div class="col-md-2">
									<div class="position-relative form-group">
										<input name="int_local" id="int_local" placeholder="Int." type="text" class="form-control">
									</div>
								</div>
								<div class="col-md-2">
									<div class="position-relative form-group">
										<input name="lote_local" id="lote_local" placeholder="Lote" type="text" class="form-control">
									</div>
								</div>
								<div class="col-md-2">
									<div class="position-relative form-group">
										<input name="num_local" id="num_local" placeholder="Num." type="text" class="form-control">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<div  class="input-group" hidden="hidden">
							<span class="input-group-addon bg-success text-white" style="width: 100px; padding: 0.5em; border-radius: 5px 0px 0px 5px;" >Costo Envio</span>
							<input id="txtcosto_envio" type="text" class="form-control" patron="requerido" name="txtcosto_envio" value="<?=$costo_default?>" readonly="readonly" >
						</div>
					</div>
				</div>
				<div class="row">
						<div class="col-md-3"></div>
						<div class="col-md-3"></div>
						<div class="col-md-3"></div>
						<div class="col-md-3">
							<div class="position-relative form-group">
								<?$sess= $this->session->userdata('idUsuarioCliente');?>
								<button onclick="Cliente.enviar_pedido_cliente_despacho();" class="btn btn-success btn-block" id="btn-pasar-a-despacho" validar_sess="<?=($sess)? "1":"0"?>" >ENVIAR PEDIDO</button>
							</div>
						</div>
				</div>
			</div>
		</div>
	</div>
</div><br />
<script>
    	$('#opciones_tarjeta').hide();
        $('#opciones_recojo').hide();
        $('#direccion_envio').hide();
		$('#sl_mi_distrito').hide();
		$('#txtcosto_envio').hide();
		$('#div_costo_envio').hide();
		
		var total_calculado = $('#total_pedido').val();
		$('input[name ="metodo-pago"]').on("click",function(e){


			let a = $(this).attr('id_');

			if(a == 2){
				$('#opciones_tarjeta').show();
			}else{
				$('#opciones_tarjeta').hide();
			}
			let x = $(this).attr('id');
			Cliente.pago = a;
		});
		
		var selectActual = 0;
		$('input[name ="recojo-envio"]').on("click",function(e){
            
			let a = $(this).attr('value');
			// alert(a);
			if(a == 2){
                $('#opciones_recojo').show();
				$('#direccion_envio').hide();
				$('#opciones_recojo_sel').hide();
				// $('#sl_mi_distrito').hide();
				// $('#txtcosto_envio').val = null;
				if( selectActual != 2 && selectActual !=0){
				$('#div_costo_envio	').hide();
				var totalpedido_con_envio = Number($("#total_pedido").val())-Number($('#txtcosto_envio').val());
				$('#total_pedido').val(totalpedido_con_envio);
					selectActual = a;
				}

			}else{
                $('#opciones_recojo').hide();
				$('#direccion_envio').show();
				$('#sl_mi_distrito').show();
				$('#div_costo_envio	').show();
				if(selectActual != 1){
				var totalpedido_con_envio = Number($("#txtcosto_envio").val())+Number($('#total_pedido').val());
				$('#total_pedido').val(totalpedido_con_envio);
					selectActual = a;
				}

			}

			if(a == 1 && selectActual== 0){
				var totalpedido_con_envio = Number($("#txtcosto_envio").val())+Number($('#total_pedido').val());
				$('#total_pedido').val(totalpedido_con_envio);
				selectActual = a;
			}
			let x = $(this).attr('id');

			Cliente.despacho = x;


		});
		
		$("#opciones_recojo_sel"). change(function(){
		var select_local = $(this). children("option:selected"). val();

		Cliente.cod_local = select_local;
		});

		$("#sl_mi_distrito"). change(function(){
			var delivery = $(this).children("option:selected").attr('data-delivery');
			$("#txtcosto_envio").val(delivery);
			$("#txtcosto_envio_vista").val($("#txtcosto_envio").val());
			var totalpedido_con_envio = Number(delivery)+Number(total_calculado);
			$('#total_pedido').val(totalpedido_con_envio);
		});

		$("#txtcosto_envio_vista").val($("#txtcosto_envio").val());

	
		
</script>
			


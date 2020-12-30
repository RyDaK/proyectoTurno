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

</style>
<?
	date_default_timezone_set("America/Lima");
    $currentDate = date('Y-m-d');
    $currentTime = date('H:i');
?>
<div class="container-fluid p-0">
	<div class="row">
			<div class="col-md-3 col-lg-2 col-xs-4 col-sm-3" style="margin-top:30px">
				<button type="button" id="agregar_articulo" onclick class="btn btn-success">Articulos  <i class="fas fa-plus"></i></button>
			</div>
				<div class="col-md-5 col-lg-4 col-xs-4 col-sm-8">
				<label for="sel_articulos">Platos: </label>

					<select name="sel_articulos" id="sel_articulos" class="form-control btn-sm">
	
						<option value="">--Articulos--</option>
						<?foreach($data as $row){?>
							<option value="<?=$row->idComercioPlato?>"><?=$row->plato?></option>
						<?}?>
					</select>
				</div>
			<div class="row col-12 col-sm-4 col-md-4 col-lg-4 m-0">
				<label>Fecha: </label>
				<input  min="<?=$currentDate.'T'.$currentTime?>" class="calendario-menu form-control" value="<?=$currentDate.'T'.$currentTime?>" type="datetime-local" id="txtfechapedido" name="trip-start">
			</div>
	</div>
	<div class="divider"></div>
	<div class="main-card card">
		<div class="card-body" id="llenartabla">
			No se encontraron Articulos en el carrito
			</div>
			<div class="row" >
				<div class="col-sm-7" ></div>
				<div class="form-group col-md-4">
					<div  class="input-group" id="div_costo_envio">
						<span class="input-group-addon " >Costo Envio: </span>
						<input id="txtcosto_envio_vista" type="text" class="form-control input-total" patron="requerido" name="txtcosto_envio_vista" value="" readonly="readonly" >
					</div>
				</div>
			</div>
			<div class="row" >
				<div class="col-sm-7" ></div>
				<div class="form-group col-md-4">
					<div  class="input-group" id="div_total_vista" hidden="hidden">
						<span class="input-group-addon " >TOTAL: </span>
						<input id="txtcosto_total_vista" type="text" class="form-control input-total" patron="requerido" name="txtcosto_total_vista" value="" readonly="readonly" >
					</div>
				</div>
			</div>
		
			<div class="row col-md-12 col-lg-12 m-0 caja-total-menu">
				<div class="form-group col-0 col-sm-6 col-md-6 col-lg-8"></div>
				<div class="form-group col-12 col-sm-6 col-md-6 col-lg-4 text-center caja-text-menu">
	                <div  class="input-group m-0 p-0">
<!-- 						
	                    <span class="input-group-addon total-text-menu">Total: </span>
	                    <input id="" type="text" class="form-control total-total-menu" patron="requerido" name="" value="$/. 1654" readonly="readonly" >                            -->
	                </div>
                </div>
			</div>
			<hr>
			<div class="row col-12 col-md-12 col-lg-12 m-0" hidden="hidden" id="parte_2_op">
				<div class="row col-12 col-sm-6 col-md-6 col-lg-6 m-0 p-0">
					<div class="col-12 col-sm-6 col-md-6 col-lg-6 p-0">
						<label>Despacho: </label><br>
						<center>
							<div class="custom-control custom-radio custom-control-inline">
							  <input type="radio" id="recojo" name="recojo-envio" class="custom-control-input recojo-envio" value="2" checked>
							  <label class="custom-control-label" for="recojo">Recojo</label>
							</div>
							<div class="custom-control custom-radio custom-control-inline" >
							  <input type="radio" id="envio" name="recojo-envio" class="custom-control-input recojo-envio" value="1">
							  <label class="custom-control-label" for="envio"> Envio</label>
                            </div>
                            <!-- <select class="form-control btn-sm" id="opciones_recojo" name="" data-actions-box="true" data-live-search="false"  >
                                <option value="">--Seleccionar--</option>
                                <option value="">1</option>
                                <option value="">1</option>
                            </select> -->
						</center>
						<br>
					</div>

				<div class="col-6 col-sm-6 col-md-6 col-lg-6 p-0">
						<label>Metodo de Pago: </label><br>
						<?foreach($metodos_pago as $row){?>
						<div class="custom-control custom-radio">
						  <input type="radio" id="<?=$row->nombre?>" id_pag="<?=$row->id_metodo_pag?>" name="metodo-pago" class="custom-control-input">
						  <label class="custom-control-label" for="<?=$row->nombre?>"><?=$row->nombre?></label>
						</div>	
						<?}?>
						<p></p>
						<select class="form-control btn-sm" id="opciones_tarjeta" name="" data-actions-box="true" data-live-search="false"  >
							<option value="">--Seleccionar--</option>
                            <option value="">Visa</option>
                            <option value="">Matercard</option>
                        </select>
					</div
				<?$costo_default = 0;?>
					>
					<?php

    // echo $currentDateTime;
?> 
					<div class="col-md-4"></div>
				<div class="col-md-1"></div>

				<?if($costo_default =='')  $costo_default = 0.00;?>
					<div class="col-12 col-sm-12 col-md-12 col-lg-12 textarea-menu" id="direccion_envio">
						<label><i class="fas fa-route"></i> Direccion de Envio: </label>

								<div class="form-row">
									<div class=" form-group sl_mi_distrito" >
									<label><strong>Distritos de Cobertura</strong></label>
									<select class="form-control" id="sl_mi_distrito" name="sl_mi_distrito"  >
										<? $ix=0;foreach($distritos as $row){ ?>
											<option value="<?=$row['id_ubigeo']?>" data-delivery="<?=$row['costo']?>" ><?=$row['distrito']?></option>
											<?if($ix==0) $costo_default = $row['costo'];?>
											<?$ix++?>
										<?}?>
									</select >
									<input type="text" hidden="hidden" data-id="<?=$idLocalComercio?>" id='txtidlocal' name="txtidlocal">
									
									</div>
								</div>
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
					<div class="col-12 col-sm-12 col-md-12 col-lg-12" id="opciones_recojo">
					<!-- AQUI IRIA UN SELECT PERO NOXD -->
                       
					</div>
				</div>
				<div class="row col-12 col-sm-1 col-md-1 col-lg-1 m-0 p-0">
				</div>
				<div class="row col-12 col-sm-5 col-md-5 col-lg-5 m-0 p-0 ">
					<div class="col-12 col-sm-12 col-md-12 col-lg-12 p-0" id="divDNI">
						<div class="row">
							<div class="col-6 col-sm-6 col-md-6 col-lg-6 p-0">
							<label>NOMBRE: </label><br>
								<input type="text" id="txtnombre" class="form-control btn-sm" placeholder="Ingrese su nombre" >
							</div>
							<div class="col-1 col-sm-1 col-md-1 col-lg-1 p-0"></div>
							<div class="col-5 col-sm-5 col-md-5 col-lg-5 p-0">
							<label>APELLIDO PATERNO: </label><br>
								<input type="text" id="txtapepat" class="form-control btn-sm" placeholder="Ingrese su apellido paterno" >
							</div>
						</div>	
						<br>
						<div class="row">
							<div class="col-6 col-sm-6 col-md-6 col-lg-6 p-0">
							<label>APELLIDO MATERNO: </label><br>
								<input type="text" id="txtapemat" class="form-control btn-sm" placeholder="Ingrese su apellido materno" >
							</div>
							<div class="col-1 col-sm-1 col-md-1 col-lg-1 p-0"></div>
							<div class="col-5 col-sm-5 col-md-5 col-lg-5 p-0">
							<label>DNI : <i class="fa fa-search btn btn-success" id="btn_buscar_usuario"></i> </label><br>
								<input type="text" id="txtdniped" class="form-control btn-sm" placeholder="Ingrese su DNI" >
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-6 col-sm-6 col-md-6 col-lg-6 p-0">
							<label>EMAIL: </label><br>
								<input type="text" id="txtemail" class="form-control btn-sm" placeholder="Ingrese su email" >
							</div>
							<div class="col-1 col-sm-1 col-md-1 col-lg-1 p-0"></div>
							<div class="col-5 col-sm-5 col-md-5 col-lg-5 p-0">
							<label>Telefono: </label><br>
								<input type="text" id="txttelfped" patron="requerido" class="form-control btn-sm" placeholder="Ingrese el Telefono" >
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
					
					</div>
					<div class="col-12 col-sm-12 col-md-12 col-lg-12 p-0 m-3 border">
						<button onclick="PedidosOP.registrar_pedido();" class="btn btn-success btn-block">CONFIRMAR PEDIDO</button>
					</div>
				</div>
			</div>
		</div>
	</div>
<script>
    	$('#opciones_tarjeta').hide();
        $('#opciones_recojo').hide();
        $('#direccion_envio').hide();
		$('#medio_envio').hide();
		$('#div_costo_envio').hide();
		$('.sl_mi_distrito').hide();

		var total_calculado = 0;

		
		
		$('input[name ="metodo-pago"]').on("click",function(e){

			let x = $(this).attr('id_pag');
			if(x =="tarjeta"){
				$('#opciones_tarjeta').show();
			}else{
				$('#opciones_tarjeta').hide();
			}
			
			PedidosOP.pago = x;

		});

		var selectActual = 0;
		
		$('input[name ="recojo-envio"]').on("click",function(e){
            
			let x = $(this).attr('id');
			let a = $(this).attr('value');
			if(x =="recojo"){
                $('#opciones_recojo').show();
                $('#direccion_envio').hide();
				$('#medio_envio').hide();
				$('#div_costo_envio	').hide();
				$('.sl_mi_distrito').hide();
				if( selectActual != 2 && selectActual !=0){
				$('#div_costo_envio	').hide();
				var totalpedido_con_envio = Number(Number($("#txtcosto_total_vista").val())-Number($('#txtcosto_envio').val())).toFixed(2);
				$('#txtcosto_total_vista').val(totalpedido_con_envio);
					selectActual = a;
				}
			}else{
                $('#opciones_recojo').hide();
				$('#direccion_envio').show();
				$('#medio_envio').show();
				$('#div_costo_envio	').show();
				$('.sl_mi_distrito').show();
				if(selectActual != 1){
				var totalpedido_con_envio = Number(Number($("#txtcosto_envio").val())+Number($('#txtcosto_total_vista').val())).toFixed(2);
				$('#txtcosto_total_vista').val(totalpedido_con_envio);
					selectActual = a;
				}
			}
			// PedidosOP.despacho = x;
		});
		
		$("#opciones_recojo_sel"). change(function(){
		var select_local = $(this). children("option:selected"). val();

		PedidosOP.cod_local = select_local;
		});

		$("#sl_mi_distrito"). change(function(){
			var delivery = $(this).children("option:selected").attr('data-delivery');
			$("#txtcosto_envio").val(delivery);
			$("#txtcosto_envio_vista").val($("#txtcosto_envio").val());

			
			
			var totalpedido_con_envio = Number(delivery)+Number(total_calculado);
			$('#txtcosto_total_vista').val(totalpedido_con_envio);
		});

		$("#txtcosto_envio_vista").val(Number($("#txtcosto_envio").val()).toFixed(2));
		function confirmar_pedido_op(){

			let cancelar = false;

			$(".cantidad_platos").each(function( index ) {
			console.log( index + ": " + $( this ).val() );
		
			
				let cantidad = ($('#txtcant'+index).val());
				let precio_cu = Number($('#td_precio'+index).text());

				if(cantidad < 1 || !$.isNumeric( cantidad )){

					cancelar =  true;
				}
				
		});

		if(cancelar){
			++modalId;
		
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			let content = "La cantidad debe ser siempre mayor a 0."
		   var btn=new Array();
		   btn[0]={title:'Aceptar',fn:fn};
		   Fn.showModal({ id:modalId,show:true,title:'Alerta!',content:content,btn:btn });

		   return false;
		}


			// $('#parte_1_op').removeAttr('hidden');
			$('.cantidad_platos').attr('readonly','readonly');
			$('#confirmar_temp').hide();
			$('#parte_2_op').removeAttr('hidden');
			$('#confirmar_temp').prop('disabled');
			$('#div_total_vista').removeAttr('hidden');

			$('#txtcosto_total_vista').val($('#total_pedido').val());

			total_calculado = $('#total_pedido').val();

		}
</script>
			


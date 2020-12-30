<form id="frm-libro" class="" onsubmit="return false;" >
	<!--<input type="text" value="<?=$id_comercio?>" id="comercio" name="comercio"/>
	<input type="text" value="<?=$id_pdv?>" id="pdv" name="pdv" />-->
	<div class="form-row border">
		<div class="col-12 col-sm-12 col-md-6 p-0">
			<div class="row col-12 col-md-12 position-relative m-0 form-group bg-danger" style="height: 38px; color: white; padding-top: 8px;">
				<label>LIBRO DE RECLAMACIONES</label>
			</div>
			<div class="row col-12 col-md-12 position-relative m-0 p-2 form-group border">
				<div class="col-2 col-sm-2 col-md-12 col-lg-2 p-1">
					FECHA:
				</div>
				<?php 
					date_default_timezone_set('UTC');
					date_default_timezone_set("America/Lima");
					$fecha = date("Y-m-d");
					$dia= date("d");
					$mes= date('F');
					$año= date("Y");
				 ?>
				<div class="col-3 col-sm-3 col-md-4 col-lg-3 p-1">
					<input name="dia" id="dia" type="number" class="form-control" value="<?=$dia?>" disabled  style="text-align: center;">
				</div>
				<div class="col-4 col-sm-4 col-md-4 p-1">
					<input name="mes" id="mes" type="text" class="form-control" value="<?=$mes?>" disabled style="text-align: center;">
				</div>
				<div class="col-3 col-sm-3 col-md-4 col-lg-3 p-1">
					<input name="año" id="año" type="number" class="form-control" value="<?=$año?>" disabled style="text-align: center;">
				</div>
			</div>
		</div>
		<div class="col-12 col-sm-12 col-md-6 p-0 border">
			<? foreach($datos_id_reclamo as $row){
					$id_reclamo = $row->id;
					//$id_reclamo = 1;
				}
					$contar = 0;
					$resta = 0;
					$newid = 0;
					$contarn = '';
					$conver = '';
					$rst = '';
					$numeros =  array();
					if (is_null($id_reclamo)) {
						$id = 0;
						$newid = $id + 1;
						$conver = strval($newid);
						$rst ='[N° '.'000000000'.$conver.'-'.$año.']';
					}else{
						/*$contar = strlen($id_reclamo);
						$rst = 9 - $contar;		
						$numeros = array(1=>'0',2=>'00',3=>'000',4=>'0000',5=>'00000';6=>'000000',7=>'0000000',8=>'00000000',9=>'000000000');
						
						foreach ($numeros as $valor) {
							$contarn = strlen($valor);
							if ($contarn == 7) {
								$newid = $id_reclamo + 1;
								$conver = strval($newid);
								$rst= '[N° '.$valor.$conver.'-'.$año.']';
								break;
							}
						}*/
					}
			?>
			<div class="position-relative form-group" style="text-align: center;padding-top: 20px;">
				<label ><strong>HOJA DE RECLAMACIÓN</strong></label><BR>
				<!--<label ><strong>[N° 000000001-2020]</strong></label>-->
				<label ><strong><?=$rst?></strong></label>
			</div>
		</div>
		<div class="col-12 col-sm-12 col-md-12 p-0">
			<div class="col-12 col-sm-12 col-md-12 col-lg-6 form-group" style="text-align: center;padding-top: 20px;">
				<label ><strong>Nombre de la persona/Proovedor/VSGV</strong></label>
			</div> 
			<div class="col-6 col-sm-6 col-md-6 col-lg-3 form-group" style="padding-top: 20px;">
				<select class="form-control input-sm selectpicker" id="local" name="local" title="----Seleccionar----"  >
                    <option value=""></option>
                </select >
			</div> 
			<div class="col-6 col-sm-6 col-md-6 col-lg-3 form-group" style="padding-top: 20px;">
			</div> 
		</div>
	</div>
	<div class="form-row border">
		<!-- <? foreach($datos_cliente as $row){?> -->
		<div class="col-12 col-sm-12 col-md-12 p-0 bg-danger">
			<div class="position-relative" style="height:38px; color:white; padding-top:8px; padding-left:12px;">
				<label ><strong>1. IDENTIFICACIÓN DEL CONSUMIDOR RECLAMANTE</strong></label>
			</div>
		</div>
		<div class="row col-12 col-md-12 position-relative m-0 p-2">
			<div class="col-2 col-sm-2 col-md-2 p-1">
				NOMBRE:
			</div>
			<div class="col-10 col-sm-10 col-md-10 p-1">
				<input name="nombre" id="nombre" placeholder="Escribe tu nombre" class="form-control"  value="<?=$row->nombres ?>" readonly required>
			</div>
		</div>
		<div class="row col-12 col-md-12 position-relative m-0 p-2">
			<div class="col-2 col-sm-2 col-md-2 p-1">
				DOMICILIO:
			</div>
			<div class="col-10 col-sm-10 col-md-10 p-1">
				<input name="domicilio" id="domicilio" placeholder="Escribe tu domicilio"class="form-control" value="<?=$row->direccion?>" readonly required>
			</div>
		</div>
		<div class="row col-12 col-md-12 position-relative m-0 p-0">
			<div class="col-4 col-sm-4 col-md-4 p-2 ">
				<div class="col-12 col-sm-12 col-md-12 col-lg-3 p-1">
					DNI/CE:
				</div>
				<div class="col-12 col-sm-12 col-md-12 col-lg-9 p-1">
					<input name="dni" id="dni" placeholder="Escribe tu Dni" type="number" class="form-control" value="<?=$row->nro_documento?>" readonly required>
				</div>
			</div>
			<div class="col-8 col-sm-8 col-md-8 p-2">
				<div class="col-12 col-sm-12 col-md-12 col-lg-4 p-1">
					TELEFONO/EMAIL:
				</div>
				<div class="col-12 col-sm-12 col-md-12 col-lg-8 p-1">
					<input name="telefono" id="telefono" placeholder="Escribe tu Telefono/Email" type="text" class="form-control" value="<?=$row->email?>" readonly required>
				</div>
			</div>
		</div>
		<div class="row col-12 col-md-12 position-relative m-0 p-2">
			<div class="col-4 col-sm-4 col-md-2 p-1">
				PADRE O MADRE:
			</div>
			<div class="col-8 col-sm-8 col-md-10 p-1">
				<input name="apoderado" id="apoderado" placeholder="[ Para el caso de menores de edad ]"class="form-control" required>
			</div>
		</div>
		<!-- <?}?> -->
	</div>
	<div class="form-row border">
		<div class="col-12 col-sm-12 col-md-12 p-0 bg-danger">
			<div class="position-relative" style="height:38px; color:white; padding-top:8px; padding-left:12px;">
				<label ><strong>2. IDENTIFICACIÓN DEL BIEN CONTRATADO</strong></label>
			</div>
		</div>
		<div class="row col-12 col-md-12 position-relative m-0 p-0">
			<div class="row col-12 col-md-12 position-relative m-0 p-0">
				<div class="col-4 col-sm-4 col-md-4 p-2 ">
					<div class="col-12 col-sm-12 col-md-12 p-0">
						<div class="position-relative" style="height:38px; padding-top:8px; padding-left:15px;">
							<label>PRODUCTO</label>
							&nbsp; 
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="producto_servicio" id="producto" value="producto">
								<label class="form-check-label" for="producto_servicio"></label>
							</div>
						</div>
					</div>
					<div class="col-12 col-sm-12 col-md-12 p-0">
						<div class="position-relative" style="height:38px;padding-top:8px; padding-left:15px;">
							<label >SERVICIO</label> 
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="producto_servicio" id="servicio" value="servicio">
								<label class="form-check-label" for="producto_servicio"></label>
							</div>
						</div>
					</div>
				</div>
				<div class="col-8 col-sm-8 col-md-8 p-2">
					<div class="col-12 col-sm-12 col-md-12 col-lg-4 p-1">
						MONTO RECLAMADO:
					</div>
					<div class="col-12 col-sm-12 col-md-12 col-lg-8 p-1">
						<input name="monto" id="monto" placeholder="Escribe tu monto" type="number" class="form-control">
					</div>
					<div class="col-12 col-sm-12 col-md-12 col-lg-4 p-1">
						DESCRIPCION:
					</div>
					<div class="col-12 col-sm-12 col-md-12 col-lg-8 p-1">
						<textarea class="form-control" name="descripcion" id="descripcion" placeholder="Escribe una descripcion" type="text" rows="2"></textarea>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="form-row border">
		<div class="row col-12 col-md-12 col-lg-8 position-relative m-0 p-0 bg-danger">
			<div class="position-relative" style="height:38px; color:white; padding-top:8px; padding-left:12px;">
				<label ><strong>3. DETALLE DE LA RECLAMACION Y PEDIDO DEL CONSUMIDOR</strong></label>
			</div>
		</div>
		<div class="row col-4 col-md-4 col-lg-4 col m-0 p-0 b-0 border">
			<div class="col-12 col-sm-12 col-md-12 col-lg-6 p-0">
				<div class="position-relative" style="height:38px; padding-top:8px; padding-left:15px;">
					<label>RECLAMO</label>
					&nbsp; 
					<div class="form-check form-check-inline">
					  <input class="form-check-input" type="radio" name="reclamo_queja" id="reclamo" value="reclamo">
					  <label class="form-check-label" for="reclamo_queja"></label>
					</div>
				</div>
			</div>
			<div class="col-12 col-sm-12 col-md-12 col-lg-6 p-0">
				<div class="position-relative" style="height:38px;padding-top:8px; padding-left:15px;">
					<label >QUEJA</label> 
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<div class="form-check form-check-inline">
					  <input class="form-check-input" type="radio" name="reclamo_queja" id="queja" value="queja">
					  <label class="form-check-label" for="reclamo_queja"></label>
					</div>
				</div>
			</div>
		</div>
		<div class="row col-8 col-md-8 col-lg-12 position-relative m-0 p-2">
			<div class="col-12 col-sm-12 col-md-12 col-lg-12 p-1">
				DETALLE:
			</div>
			<div class="col-12 col-sm-12 col-md-12 col-lg-12 p-1">
				<textarea class="form-control" name="detalle" id="detalle" placeholder="Escribe al detalle tu reclamo" type="text" rows="2"></textarea>
			</div>
		</div>
		<div class="row col-12 col-md-12 col-lg-12 position-relative m-0 p-2">
			<div class="col-12 col-sm-12 col-md-12 col-lg-12 p-1">
				PEDIDO:
			</div>
			<div class="col-12 col-sm-12 col-md-12 col-lg-12 p-1">
				<textarea class="form-control" name="pedido" id="pedido" placeholder="Escribe tu pedido" type="text" rows="2"></textarea>
			</div>
		</div>
	</div>
	<div class="form-row border">
		<div class="col-12 col-sm-12 col-md-12 p-0 bg-danger">
			<div class="position-relative" style="height:38px; color:white; padding-top:8px; padding-left:12px;">
				<label ><strong>4. OBSERVACIONES Y ACCIONES ADOPTADAS POR EL PROVEEDOR</strong></label>
			</div>
		</div>
		<div class="row col-12 col-md-12 position-relative m-0 p-2 border">
			<div class="col-5 col-sm-5 col-md-5 col-lg-6 p-1">
				FECHA DE COMUNICACION DE LA RESPUESTA:
			</div>
			<div class="col-2 col-sm-2 col-md-2 p-1 date fj-date">
				<input name="diae" id="diae" placeholder="Dia"class="form-control" type="text" required>
			</div>
			<div class="col-3 col-sm-3 col-md-2 p-1 date fj-date">
				<input name="mese" id="mese" placeholder="Mes"class="form-control" type="text" required>
			</div>
			<div class="col-2 col-sm-2 col-md-2 p-1 date fj-date">
				<input name="añoe" id="añoe" placeholder="Año"class="form-control" type="text" required>
			</div>
		</div>
		<div class="row col-12 col-md-12 col-lg-12 position-relative m-0 p-2 ">
			<div class="col-12 col-sm-12 col-md-12 col-lg-12 p-1">
				OBSERVACIÓN:
			</div>
			<div class="col-12 col-sm-12 col-md-12 col-lg-12 p-1">
				<textarea class="form-control" name="observación" id="observacion" placeholder="Escribe tu observación" type="text" rows="2"></textarea>
			</div>
		</div>
		<div class="row col-6 col-md-6 position-relative m-0 p-4 border">
			<div class="col-12 col-sm-12 col-md-12 p-1" style="text-align: center;">
				"RECLAMO": Disconformidad relacionada a los productos o servicios.
			</div>
		</div>
		<div class="row col-6 col-md-6 position-relative m-0 p-4 border">
			<div class="col-12 col-sm-12 col-md-12 p-1" style="text-align: center;">
				"QUEJA": Disconformidad no relacionada a los productos o servicios;o, malestar o descontento respecto a la atención al público.
			</div>
		</div>
		<div class="row col-12 col-md-12 position-relative m-0 p-4">
			<div class="col-12 col-sm-12 col-md-12 p-0" style="text-align: right;">
				Destinatario(consumidor,proveedor o INDECI,segun corresponda).
			</div>
		</div>
	</div>
</form>
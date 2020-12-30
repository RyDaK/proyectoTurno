<form id="frm-register" class="" onsubmit="return false;" >
	<input type="hidden" value="<?=$id_comercio?>" id="comercio" name="comercio"/>
	<input type="hidden" value="<?=$id_pdv?>" id="pdv" name="pdv" />
	<div class="form-row">
		<div class="col-md-6">
			<div class="position-relative form-group">
				<!--<label for="ticket" ><strong>Tu Ticket</strong></label>-->				<label for="ticket" ><strong>Comensales</strong></label>
				<input name="ticket" id="ticket" placeholder="Escribe Aquí" type="text" class="form-control" patron="requerido" >
			</div>
		</div>
		<div class="col-md-6">
			<div class="position-relative form-group">
				<label for="telefono" ><strong>Tu Teléfono</strong></label>
				<input name="telefono" id="telefono" placeholder="Escribe Aquí" type="number" class="form-control" patron="requerido" >
			</div> 
		</div>
	</div>
	<div class="form-row">
		<div class="col-md-6">
			<div class="position-relative form-group">
				<select id="tipo_doc" name="tipo_doc" class="form-control-md form-control" >
					<?foreach($tipo_doc as $row){?>
						<option value="<?=$row['value']?>" ><?=$row['name']?></option>
					<?}?>
				</select>
			</div>
		</div>
		<div class="col-md-6 ">
			<div class="position-relative form-group">
				<label for="numero_doc" >Tu Número de Documento de Identidad</label>
				<input name="numero_doc" id="numero_doc" placeholder="Escribe Aquí" type="text" class="form-control" >
			</div>
		</div>
	</div>
	<div class="form-row">
		<div class="col-md-4">
			<div class="position-relative form-group">
				<label for="nombre" >Tu Nombre</label>
				<input name="nombre" id="nombre" placeholder="Escribe Aquí" type="text" class="form-control" patron="requerido">
			</div>
		</div>
		<div class="col-md-4">
			<div class="position-relative form-group">
				<label for="apePaterno" >Tu Apellido Paterno</label>
				<input name="apePaterno" id="apePaterno" placeholder="Escribe Aquí" type="text" class="form-control">
			</div>
		</div>
		<div class="col-md-4 ">
			<div class="position-relative form-group">
				<label for="apeMaterno" >Tu Apellido Materno</label>
				<input name="apeMaterno" id="apeMaterno" placeholder="Escribe Aquí" type="text" class="form-control">
			</div>
		</div>
	</div>
	
	
</form>
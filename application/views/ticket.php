<div class="app-container">
	<div class="h-100">
		<div class="h-20 no-gutters row">
			<div class="d-flex bg-white justify-content-center align-items-center col-md-12 col-lg-12">
				<div class="mx-auto col-sm-12 col-md-12 col-lg-12">
					<center><img src="assets/images/logo-inverse.png" class="responsive" /></center>
				</div>
			</div>
		</div>
		<div class="h-80 no-gutters row">
			<div class="h-80 bg-white d-flex justify-content-center align-items-center col-md-12 col-lg-12">
				<div class="mx-auto col-sm-12 col-md-12 col-lg-12">
					<form id="frm-register" class="" onsubmit="return false;">
						<div class="divider row"></div>
						<div class="alert alert-success fade show" role="alert"><i class="fa fa-check-circle" ></i> Sitio seguro, la información ingresada solo permite a <strong>Turno</strong> darte aviso bajo tu autorización.</div>
						<div class="form-row">
							<div class="col-md-1">
								<center><img src="../files/logos/<?=$ruta_logo?>.jpg" class="img-fluid img-comercio" /></center>
							</div>
							<div class="col-md-11">
								<input type="hidden" value="<?=$id_comercio?>" id="comercio" name="comercio"/>
								<input type="hidden" value="<?=$id_pdv?>" id="pdv" name="pdv" />
								<div class="position-relative form-group">
									<h3><?=$comercio?></h3>
									<h5><?=$pdv?></h5>
									<p><?=!empty($distrito)? $provincia.' '.$distrito.'<br />': ''?><?=!empty($cc)? $cc.'<br/>': '';?><?=!empty($direccion)? $direccion : '';?></p>
								</div>
							</div>
						</div>
						<div class="divider" ></div>
						<div class="form-row">
							<div class="col-md-12">
								<div class="position-relative form-group">
									<label for="nombre" >Tu Nombre</label>
									<input name="nombre" id="nombre" placeholder="Escribe Aquí" type="text" class="form-control" patron="requerido">
								</div>
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-6 content-more hide">
								<div class="position-relative form-group">
									<label for="apePaterno" >Tu Apellido Paterno</label>
									<input name="apePaterno" id="apePaterno" placeholder="Escribe Aquí" type="text" class="form-control">
								</div>
							</div>
							<div class="col-md-6 content-more hide">
								<div class="position-relative form-group">
									<label for="apeMaterno" >Tu Apellido Materno</label>
									<input name="apeMaterno" id="apeMaterno" placeholder="Escribe Aquí" type="text" class="form-control">
								</div>
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-6 content-more hide">
								<div class="position-relative form-group">
									<select id="tipo_doc" name="tipo_doc" class="form-control-md form-control" >
										<?foreach($tipo_doc as $row){?>
											<option value="<?=$row['value']?>" ><?=$row['name']?></option>
										<?}?>
									</select>
								</div>
							</div>
							<div class="col-md-6 content-more hide">
								<div class="position-relative form-group">
									<label for="numero_doc" >Tu Número de Documento de Identidad</label>
									<input name="numero_doc" id="numero_doc" placeholder="Escribe Aquí" type="text" class="form-control" >
								</div>
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-6">
								<div class="position-relative form-group">
									<!--<label for="ticket" >Tu Ticket</label>-->									<label for="ticket" >Comensales</label>
									<input name="ticket" id="ticket" placeholder="Escribe Aquí" type="text" class="form-control" patron="requerido" >
								</div>
							</div>
							<div class="col-md-6">
								<div class="position-relative form-group">
									<label for="telefono" >Tu Teléfono</label>
									<input name="telefono" id="telefono" placeholder="Escribe Aquí" type="text" class="form-control" patron="requerido" >
								</div> 
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-12">
								<div class="custom-checkbox custom-control">
									<input type="checkbox" id="full-data" class="custom-control-input" />
									<label class="custom-control-label" for="full-data">Registro Completo</label>
								</div>
							</div>
						</div>
						<div class="divider row"></div>
						<div class="form-row">
							<div class="col-md-12">
								<div class="position-relative form-group">
									<button id="btn-meavisan" class="mb-2 mr-2 btn btn-success btn-block"><i  class="fa fa-hand-paper-o" ></i> Me avisan</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
	<div class="row"  id="sec-1">
		<div class="col-md-12">
			<div class="main-card mb-3 card">
				<div id="content-table" class="card-body">
					<form id="frm-register" class="" onsubmit="return false;" >
						<div class="form-row">
							<div class="col-md-10" >
								<label style="color:#52bd5b"><strong>DATOS DEL ESTABLECIMIENTO</strong></label>
							</div>
							<div class="col-md-2 text-right">
								<button type="button" href="javascript:;" class="btn btn-primary btn-go-section" data-section="sec-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Ir a la sección de editar"><i class="fa fa-arrow-down" ></i> Ir a Lista</button>
							</div>
						</div>
						<hr>
						<div class="form-row">
							<div class="col-md-6">
								<div class="position-relative form-group">
									<label for="razon_social" ><strong>Razón Social</strong></label>
									<input name="razon_social" id="razon_social" placeholder="Escribe Aquí" type="text" class="form-control" patron="requerido" >
								</div>
							</div>
							<div class="col-md-6">
								<div class="position-relative form-group">
									<label for="nombre_comercial" ><strong>Nombre Comercial</strong></label>
									<input name="nombre_comercial" id="nombre_comercial" placeholder="Escribe Aquí" type="text" class="form-control" patron="requerido" >
								</div>
							</div>
							
						</div>

						<div class="form-row">
							<div class="col-md-4">
								<div class="position-relative form-group">
									<label for="ruc" ><strong>RUC</strong></label>
									<input name="ruc" id="ruc" placeholder="Escribe Aquí" type="text" maxlength="11" class="form-control" patron="ruc">
								</div> 
							</div>
							<div class="col-md-4">
								<div class="position-relative form-group">
									<label for="dni" ><strong>DNI</strong></label>
									<input name="dni" id="dni" patron="dni" placeholder="Escribe Aquí" type="text" maxlength="8" class="form-control" patron="dni">
								</div> 
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="creditos_turno" ><strong>Creditos Turno</strong></label>
									<input name="creditos_turno" id="creditos_turno" placeholder="Escribe Aquí" type="number" class="form-control" >
								</div>
							</div>
						</div>
						<div class="form-row">
								<div class="col-md-4">
									<div class="position-relative form-group">
										<label for="id_rubro" ><strong>Canal</strong></label>
										<select name="id_rubro_p" class="form-control" id="id_rubro_p">
											<option value="">--Seleccione--</option>
											<? foreach($rubros as $row){ ?>
												<option value="<?=$row['id_rubro']?>"    ><?=$row['nombre']?></option>
											<? } ?>
										</select>
									</div>
								</div>
								<div class="col-md-4">
									<label for="id_giro"><strong>Sub-Canal</strong></label>
									<div class="position-relative form-group">
										<select name="id_giro_p" class="form-control" id="id_giro_p">
											<option value="">--Seleccione--</option>
										</select>
									</div> 
								</div>
						</div>
						<div class="form-row">
							<div class="col-md-12" >
								<label style="color:#52bd5b"><strong>DATOS DE CONTACTO</strong></label>
							</div>
						</div>
						<hr>

						<div class="form-row">
							<div class="col-md-4">
								<div class="position-relative form-group">
									<label for="apePaterno" ><strong>Apellido Paterno</strong></label>
									<input name="apePaterno" id="apePaterno" placeholder="Escribe Aquí" type="text" class="form-control" patron="requerido" >
								</div>
							</div>
							<div class="col-md-4">
								<div class="position-relative form-group">
									<label for="apeMaterno" ><strong>Apellidos Materno</strong></label>
									<input name="apeMaterno" id="apeMaterno" placeholder="Escribe Aquí" type="text" class="form-control" >
								</div>
							</div>
							<div class="col-md-4">
								<div class="position-relative form-group">
									<label for="nombre" ><strong>Nombres</strong></label>
									<input name="nombre" id="nombre" placeholder="Escribe Aquí" type="text" class="form-control" patron="requerido" >
								</div>
							</div>
						</div>

						<div class="form-row">
							<!--<div class="col-md-4">
								<div class="position-relative form-group">
									<label for="dni_representante" ><strong>DNI</strong></label>
									<input name="dni_representante" id="dni_representante" patron="dni" placeholder="Escribe Aquí" type="text" maxlength="8" class="form-control">
								</div> 
							</div>-->
							<div class="col-md-4">
								<div class="position-relative form-group">
									<label for="telefono" ><strong>Teléfono de Contacto</strong></label>
									<input name="telefono" id="telefono" placeholder="Escribe Aquí" type="number" class="form-control" >
								</div>
							</div>
							<div class="col-md-8">
								<div class="position-relative form-group">
									<label for="email" ><strong>Email</strong></label>
									<input name="email" id="email" placeholder="Escribe Aquí" type="email" class="form-control" patron="requerido" >
								</div>
							</div>
						</div>						

						<div class="divider"></div> 
						<label style="color:#52bd5b;display:none;"><strong>PROGRAMAS / PROYECTOS</strong></label>

						<div class="form-row" style="display:none;">
							<div class="col-md-12">
								<div class="form-group">
									<input name="proyecto" id="proyecto_1" type="checkbox" value="1" >
									<label for="proyecto_1" ><strong>Ordenes</strong></label>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<input name="proyecto" id="proyecto_2" type="checkbox" value="2" >
									<label for="proyecto_2" ><strong>Reservas</strong></label>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<input name="proyecto" id="proyecto_3" type="checkbox" value="3" checked >
									<label for="proyecto_3" ><strong>Delivery</strong></label>
								</div>
							</div>
							
						</div>
						<div class="form-row float-right" style="">
							<div class="col-md-12">
								<button id="btn-send" type="button" href="javascript:;" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Guardar Cambios"><i class="fa fa-save" ></i> Guardar</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="row" id="sec-2">
		<div class="col-12">
			<div class="main-card mb-3 card">
				<div id="content-table-comercios" class="">
					<div class="alert alert-default2"><img src="assets/images/load.gif" /> Buscando registros...</div>          
				</div>
			</div>
		</div>
	</div>


	

	

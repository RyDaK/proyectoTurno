<!--<div class="row">
		<div class="col-md-12">
				<div id="content-table" class="card-body">-->
					<form id="frm-edit-comercio" class="" onsubmit="return false;" >
					<input type="hidden" value="<?=$id_comercio?>" id="id_comercio" name="id_comercio"/>
					<input type="hidden" value="<?= isset($cliente['id_cliente'])? $cliente['id_cliente'] :"" ?>" id="id_cliente" name="id_cliente"/>
					<input type="hidden" value="<?=$id_usuario?>" id="id_usuario" name="id_usuario"/>

							<div class="form-row">
								<div class="col-md-6">
									<div class="position-relative form-group">
										<label for="razon_social" ><strong>Razón Social</strong></label>
										<input name="razon_social" id="razon_social" placeholder="Escribe Aquí" type="text" value="<?= isset($comercio['razon_social'])? $comercio['razon_social'] :"" ?>" class="form-control" patron="requerido" >
									</div>
								</div>
								<div class="col-md-6">
									<div class="position-relative form-group">
										<label for="nombre_comercial" ><strong>Nombre Comercial</strong></label>
										<input name="nombre_comercial" id="nombre_comercial" placeholder="Escribe Aquí" type="text" value="<?= isset($comercio['nombre'])? $comercio['nombre'] :"" ?>" class="form-control" patron="requerido" >
									</div>
								</div>
							</div>
							<div class="form-row">
								<div class="col-md-6">
									<label for="ruc"><strong>RUC</strong></label>
									<div class="position-relative form-group">
										<input name="ruc" id="ruc" placeholder="Escribe Aquí" type="text" maxlength="11" class="form-control" value="<?= isset($comercio['ruc']) ?$comercio['ruc']:"" ?>">
									</div> 
								</div>
								<div class="col-md-6">
									<label for="dni_representante"><strong>DNI</strong></label>
									<div class="position-relative form-group">
										<input name="dni_representante" id="dni_representante" placeholder="Escribe Aquí" type="text" maxlength="8" class="form-control"value="<?= isset($comercio['nro_documento']) ?$comercio['nro_documento']:"" ?>">
									</div> 
								</div>
								
							</div>

							<div class="form-row">
								<div class="col-md-4">
									<div class="position-relative form-group">
										<label for="id_rubro" ><strong>Canal</strong></label>
										<select name="id_rubro" class="form-control" id="id_rubro">
											<option value="">--Seleccione--</option>
											<? foreach($rubros as $row){ ?>
												<option value="<?=$row['id_rubro']?>"  <?= isset($comercio['id_rubro']) ? ($comercio['id_rubro']==$row['id_rubro'] ? "SELECTED" : "" ) : "" ?>   ><?=$row['nombre']?></option>
											<? } ?>
										</select>
									</div>
								</div>
								<div class="col-md-4">
									<label for="id_giro"><strong>Sub-Canal</strong></label>
									<div class="position-relative form-group">
										<select name="id_giro" class="form-control" id="id_giro">
											<option value="">--Seleccione--</option>
											<? foreach($giros as $row){ ?>
												<option value="<?=$row['id_giro']?>" <?= isset($comercio['id_giro']) ? ($comercio['id_giro']==$row['id_giro'] ? "SELECTED" : "" ) : "" ?> ><?=$row['nombre']?></option>
											<? } ?>
										</select>
									</div> 
								</div>
								<div class="col-md-2">
									<label for="estado_comercio"><strong>Estado Comercio:</strong></label> <br>
								</div>
								<div class="col-md-2" >
									<br>	<br>
									<input id="estado_comercio" type="checkbox"<?= isset($comercio['estado'])? ( ($comercio['estado']==1) ? "checked" : "" ) : ""  ?>  > Activo
									<!-- <button id="btn-activar-comercio" type="button" href="javascript:;" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Carga Masiva"><i class="fa fa-check" ></i> Activar</button>
									<button id="btn-desactivar-comercio" type="button" href="javascript:;" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Carga Masiva"><i class="fa fa-delete" ></i> Desactivar</button> -->
								</div>
							</div>

							<?/*?>
								<div class="form-row">
					
										<div class="col-md-4">
											<div class="position-relative form-group">
													<label for="id_metodo_pag" ><strong>Metodo Pago</strong></label>
													<div class="row">
														<div class="col-md-10">
															<select name="id_metodo_pag" class="form-control" id="id_metodo_pag">
																<option value="">--Seleccione--</option>
																<? foreach($metodos_pago as $row){ ?>
																	<option id="op<?=$row->id_metodo_pag?>"  value="<?=$row->id_metodo_pag?>" ><?=$row->nombre?></option>
																	<? } ?>
																</select>
															</div>
															<div class= "col-md-2">
																<button class="btn btn-success" onclick="Comercios.agregar_metodo_fila();">+</button>
															</div>
													</div>
											</div>
										</div>
										<div class="col-md-1"></div>
										<?if(count($metodo_pago_comercio)>0 ){?>
										<div class="col-md-6">
											<div class="position-relative form-group">
												<label for="tabla_metodos_comercio" ><strong>Métodos Aceptados</strong></label>
												<table id="tabla_metodos_comercio" class="table table-hover table-striped table-bordered">
													<thead>
																<th> </th>
																<th>Método Pago</th>
													</thead>
													<tbody>	
														<?foreach($metodo_pago_comercio as $row){?>
															<tr>
																<td><li onclick="Comercios.eliminar_metodo_fila(<?=$row->id_metodo_pago_comercio?>)" class="fas fa-trash"></li></td>
																<td data-idpag=<?=$row->id_metodo_pago_comercio?>><?=$row->nombre?></td>
															</tr>
															<?}?>
													</tbody>
												</table>
											</div>
										</div>
									<?}?>
								</div>
															*/?>
						
						<div class="form-row">
							<div class="col-md-12" >
								<label style="color:#52bd5b"><strong>DATOS DE CONTACTO</strong></label>
							</div>
						</div>
						<hr>
						<!--
						<div class="form-row">							
							<div class="col-md-4">
								<div class="position-relative form-group">
									<label for="apellido_pat" ><strong>Apellido Paterno</strong></label>
									<input name="apellido_pat" id="apellido_pat" placeholder="Escribe Aquí" type="text" patron="requerido" class="form-control" value="<?= isset($usuario['ape_paterno'])? $usuario['ape_paterno'] :"" ?>" >
								</div>
							</div>
							<div class="col-md-4">
								<div class="position-relative form-group">
									<label for="apellido_mat" ><strong>Apellido Materno</strong></label>
									<input name="apellido_mat" id="apellido_mat" placeholder="Escribe Aquí" type="text" class="form-control" value="<?= isset($usuario['ape_materno'])? $usuario['ape_materno'] :"" ?>" >
								</div>
							</div>
							<div class="col-md-4">
								<div class="position-relative form-group">
									<label for="nombre" ><strong>Nombres</strong></label>
									<input name="nombre" id="nombre" placeholder="Escribe Aquí" type="text" class="form-control" patron="requerido" value="<?= isset($usuario['nombres'])? $usuario['nombres'] :"" ?>" >
								</div>
							</div>
						</div>
						-->
						<div class="form-row">		
							<!--<div class="col-md-6">
								<div class="position-relative form-group">
									<label for="dni" ><strong>DNI</strong></label>
									<input name="dni" id="dni" placeholder="Escribe Aquí" type="number" class="form-control" patron="requerido" value="<?= isset($usuario['nro_documento'])? $usuario['nro_documento'] :"" ?>">
								</div> 
							</div>-->
							
								<div class="col-md-4">
									<label for="telefono"><strong>Teléfono de Contacto</strong></label>
									<div class="position-relative form-group">
										<input name="telefono" id="telefono" placeholder="Escribe Aquí" type="text" maxlength="12" class="form-control" value="<?= isset($comercio['telefono']) ?$comercio['telefono']:"" ?>">
									</div> 
								</div>
								
								<div class="col-md-8">
									<div class="position-relative form-group">
										<label for="email" ><strong>Email</strong></label>
										<input name="email" id="email" placeholder="Escribe Aquí" type="email"  patron="requerido" class="form-control" value="<?= isset($usuario['email'])? $usuario['email'] : ""  ?>" >
									</div>
								</div>
								
						</div>

						<!-- TABLA LISTA DE TELEFONOS -->
						<label style="display:none;"><strong>PROGRAMAS / PROYECTOS</strong></label>

						<div class="col-md-12" style="display:none;">
							<div class="form-group">
								<input name="proyecto" id="proyecto_1" type="checkbox" value="1" <?= isset($historico[1])?  "CHECKED"  : ""  ?> >
								<label for="proyecto_1" ><strong>Ordenes</strong></label>
							</div>
						</div>
						<div class="col-md-12" style="display:none;">
							<div class="form-group">
								<input name="proyecto" id="proyecto_2" type="checkbox" value="2" <?= isset($historico[2])?  "CHECKED": ""  ?> >
								<label for="proyecto_2" ><strong>Reservas</strong></label>
							</div>
						</div>
						
						<div class="col-md-12" style="display:none;">
							<div class="form-group">
								<input name="proyecto" id="proyecto_3" type="checkbox" value="3" <?= isset($historico[3])? "CHECKED"  : ""  ?>>
								<label for="proyecto_3" ><strong>Delivery</strong></label>
							</div>
						</div>
						<!-- TABLA LISTA DE PROYECTOS -->
						

					</form>
				<!--</div>
		</div>

	</div>-->


	

	

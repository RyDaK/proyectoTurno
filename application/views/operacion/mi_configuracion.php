<ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav">
	<li class="nav-item">
		<a role="tab" class="nav-link show active" id="tab-0" data-toggle="tab" href="#tab-content-0" aria-selected="true">
			<span>Información Básica</span>
		</a>
	</li>
	<li class="nav-item">
		<a role="tab" class="nav-link show" id="tab-1" data-toggle="tab" href="#tab-content-1" aria-selected="false">
			<span>Opciones de Delivery</span>
		</a>
	</li>
	<li class="nav-item">
		<a role="tab" class="nav-link show" id="tab-2" data-toggle="tab" href="#tab-content-2" aria-selected="false">
			<span>Locales</span>
		</a>
	</li>
	<li class="nav-item">
		<a role="tab" class="nav-link show" id="tab-3" data-toggle="tab" href="#tab-content-3" aria-selected="false">
			<span>Artículos</span>
		</a>
	</li>
</ul>
<div class="tab-content">
	<div class="tab-pane tabs-animation fade active show" id="tab-content-0" role="tabpanel">
		<div class="row">
			<div class="col-md-12">
				<div class="main-card mb-3 card">
					<div id="content-table" class="card-body">
						<form id="frm-update-comercio" class="" onsubmit="return false;" >
							<input type="hidden" value="<?= isset($comercio['id_comercio']) ?$comercio['id_comercio']:"" ?>" id="id_comercio" name="id_comercio"/>
							<div class="row" >
								<div class="col-md-3" >
									<div class="alert alert-info fade show" style="font-size:10px" ><i class="fa fa-info-circle"></i> Se recomienda usar imagenes de 640 X 480 JPG</div>
									<img id="img_logo_1" src="<?= isset($comercio['ruta_logo']) ? "../files/logos/".$comercio['ruta_logo'].'.jpg': "../public/assets/images/default-image.jpg" ?>" data-estado="0" class="w-100" >
									<div class="form-row">
										<div class="col-md-4">
											<input id="img_logo" type="file"  style="display:none;" accept="image/png, image/jpeg">
											<button id="btn-img-file" type="button" href="javascript:;" class="btn btn-light w-100" data-toggle="tooltip"  data-original-title="File"><i ></i> File</button>
											<input type="hidden" value="" id="logo_name" name="logo_name"/>
										</div>
										<div class="col-md-8">
											<input id="text-img_1" class="form-control" value="" disabled>
										</div>
									</div>
									
								</div>
								<div class="col-md-9" >
									<div class="form-row">
										<div class="col-md-6">
											<div class="position-relative form-group">
												<label for="razon_social"><strong>Razón Social</strong></label>
												<input name="razon_social" id="razon_social" placeholder="Escribe Aquí" type="text" class="form-control" patron="requerido" value="<?= isset($comercio['razon_social']) ?$comercio['razon_social']:"" ?>" readonly>
											</div>
										</div>
										<div class="col-md-6">
											<div class="position-relative form-group">
												<label for="nomb_comercial"><strong>Nombre Comercial</strong></label>
												<input name="nomb_comercial" id="nomb_comercial" placeholder="Escribe Aquí" type="text" class="form-control" value="<?= isset($comercio['nombre_comercio']) ?$comercio['nombre_comercio']:"" ?>" readonly>
											</div>
										</div>
									</div>
									<div class="form-row">
										<div class="col-md-6">
											<div class="position-relative form-group">
												<label for="email"><strong>Email</strong></label>
												<input name="email" id="email" patron="email" placeholder="Escribe Aquí" type="email" class="form-control" value="<?= isset($usuario['email']) ?$usuario['email']:"" ?>" readonly>
											</div>
										</div>
										<div class="col-md-2">
											<div class="position-relative form-group">
												<label for="telefono" ><strong>Teléfono</strong></label>
												<input name="telefono" id="telefono" placeholder="Escribe Aquí" type="text" maxlength="14" class="form-control" value="<?= isset($comercio['telefono']) ?$comercio['telefono']:"" ?>" readonly >
											</div>
										</div>
										<div class="col-md-2">
											<div class="position-relative form-group" >
												<label for="rud"><strong>RUC</strong></label>
												<input name="ruc" id="ruc" placeholder="Escribe Aquí" type="text" maxlength="11" class="form-control" patron="ruc" value="<?= isset($comercio['ruc']) ?$comercio['ruc']:"" ?>" readonly  >
											</div> 
										</div>
										<div class="col-md-2">
											<div class="position-relative form-group">
												<label for="nro_documento" ><strong>DNI</strong></label>
												<input name="nro_documento" id="nro_documento" placeholder="Escribe Aquí" type="text" maxlength="8" class="form-control" patron="dni" value="<?= isset($comercio['nro_documento']) ?$comercio['nro_documento']:"" ?>" readonly>
											</div>
										</div>
									</div>
									<div class="form-row">
										<div class="col-md-3">
											<div class="position-relative form-group">
												<label for="id_rubro"><strong>Canal</strong></label>
												<select name="id_rubro" class="form-control" id="id_rubro" readonly>
													<option value="">--Seleccione--</option>
													<? foreach($rubros as $row){ ?>
														<option value="<?=$row['id_rubro']?>"  <?= isset($comercio['id_rubro']) ? ($comercio['id_rubro']==$row['id_rubro'] ? "SELECTED" : "" ) : "" ?>   ><?=$row['nombre']?></option>
													<? } ?>
												</select>
											</div>
										</div>
										<div class="col-md-3">
											<div class="position-relative form-group">
												<label for="id_giro"><strong>Sub-Canal</strong></label>
												<select name="id_giro" class="form-control" id="id_giro" readonly>
													<option value="">--Seleccione--</option>
													<? foreach($giros as $row){ ?>
														<option value="<?=$row['id_giro']?>" <?= isset($comercio['id_giro']) ? ($comercio['id_giro']==$row['id_giro'] ? "SELECTED" : "" ) : "" ?> ><?=$row['nombre']?></option>
													<? } ?>
												</select>
											</div>
										</div>
										<div class="col-md-3">
											<div class="position-relative form-group">
												<label for="costo_delivery"><strong>Costo Delivery Estandar</strong></label>
												<input name="costo_delivery" id="costo_delivery" placeholder="Escribe Aquí" type="number" patron="numeros" class="form-control" title="Valor en Soles" value="<?= isset($comercio['costo_delivery']) ?$comercio['costo_delivery']:"" ?>">
											</div>
										</div>
									</div>
								</div>
							</div>
							<hr />
							<div class="row" >
								<div class="col-md-12" >
									<div class="form-row">
										<div class="col-md-3">
											<div class="position-relative form-group">
												<label for="creditos_turno"><strong>Créditos</strong></label>
												<div class="row" >
													<div class="col-md-4">
														<button id="btn-historial-creditos" type="button" href="javascript:;" class="btn btn-light w-100" data-toggle="tooltip" data-placement="top" title="" data-original-title="Historial"><i ></i> Historial</button>
													</div>
													<div class="col-md-8">
														<input name="creditos_turno" id="creditos_turno" placeholder="Escribe Aquí" type="number" class="form-control" patron="requerido"  value="<?= isset($comercio['creditosActual']) ? $comercio['creditosActual']:0 ?>" disabled>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-3">
											<div class="position-relative form-group">
												<label for="link_comp"><strong>Link para Compartir</strong></label>
												<div class="row" >
													<div class="col-md-4">
														<button id="btn-copy-link" type="button" href="javascript:;" class="btn btn-light w-100" data-toggle="tooltip" data-placement="top" title="" data-original-title="Copy"><i ></i> Copy</button>													</div>
													<div class="col-md-8">
														<input name="link_comp" id="link_comp" placeholder="Escribe Aquí" type="text" class="form-control" value="<?=base_url()?>home_cliente/gocomercio/<?=$comercio['id_comercio'].'jhgd5'?>" disabled>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="position-relative form-group">
												<label for="teminos"><strong>Terminos y condiciones</strong></label>
												<div class="row" >
													<div class="col-md-3">
														<input type="hidden" id="img_terminos" name="img_terminos">
														<input id="file_terminos" data-id="0" type="file" class="file_terminos" style="width:100%;display:none;" accept="application/pdf" >
														<button id="btn-img-terminos" data-id="0" type="button" href="javascript:;" class="btn btn-light w-100" data-toggle="tooltip" data-placement="top" data-original-title="File"><i ></i> File</button>
													</div>
													<div class="col-md-3">
														<button id="btn-img-terminos-del" data-id="0" style="width:100%;" type="button" href="javascript:;" class="btn btn-danger w-100" data-toggle="tooltip" data-placement="top" data-original-title="Limpiar"><i ></i> X</button>
													</div>
													<div class="col-md-6">
														<input id="text-img-terminos" class="form-control" value="<?= isset($comercio['ruta_terminos']) ? "Ya registrado" :"Sin registrar" ?>" disabled>
														<?= isset($comercio['ruta_terminos']) ? "<a href='../files/terminos/".$comercio['ruta_terminos'].".pdf' target='_blank'>Descargar</a> " :"" ?>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-2">
											<button id="btn-conf-mensaje" type="button" href="javascript:;" class="btn btn-light" data-toggle="tooltip" data-placement="top" title="" data-original-title="Configuracion de Mensaje"><i ></i> Configuracion de Mensaje</button>
										</div>
									</div>
								</div>
							</div>
							<div class="row" >
								<div class="col-md-12">
									<div class="form-row">
										<div class="col-md-5">
											<div class="position-relative form-group">
													<label for="id_metodo_pag" ><strong>Metodo Pago</strong></label>
													<div class="form-inline">

																<select name="id_metodo_pag" class="form-control" id="id_metodo_pag">
																	<option value="">--Seleccione--</option>
																	<? foreach($metodos_pago as $row){ ?>
																		<option id="op<?=$row->id_metodo_pag?>"  value="<?=$row->id_metodo_pag?>" ><?=$row->nombre?></option>
																		<? } ?>
																	</select>
																	&nbsp
																<button class="btn btn-success" onclick="Configuracion.agregar_metodo_fila();">+</button>

													</div>
											</div>
										</div>
										<!-- <div class="col-md-3">
											<div class="position-relative form-group">
												<button class="btn btn-success" onclick="Configuracion.agregar_metodo_fila();">+</button>
											</div>
										</div> -->
										<?if(count($metodo_pago_comercio)>0 ){?>
											<div class="col-md-7">
												<div class="position-relative form-group">
													<label for="tabla_metodos_comercio" ><strong>Métodos Aceptados</strong></label>
													<table id="tabla_metodos_comercio" class="table table-hover table-striped table-bordered">
														<thead>
																	<th> </th>
																	<th>Método Pago</th>
																	<th>Número</th>
														</thead>
														<tbody>	
															<?foreach($metodo_pago_comercio as $row){?>
																<tr>
																	<td><li onclick="Configuracion.eliminar_metodo_fila(<?=$row->id_metodo_pago_comercio?>)" class="fas fa-trash"></li></td>
																	<td  data-idpag=<?=$row->id_metodo_pago_comercio?>><?=$row->nombre?></td>
																	<td class="text-center"><?=isset($row->numero)?$row->numero:"-"?></td>
																</tr>
																<?}?>
														</tbody>
													</table>
												</div>
											</div>
										<?}?>
									</div>
								</div>
							</div>
							<div class="row" >
								<div class="col-md-12">
											<div class="position-relative form-group">
												<label for="pago_visa"><strong>Pago en linea</strong></label>
												<input name="pago_visa" id="pago_visa"  placeholder="Escribe Aquí" type="text" class="form-control" value="<?= isset($comercio['pago_visa']) ?$comercio['pago_visa']:"" ?>" >
											</div>
										</div>
							</div>
							<div class="row" style="text-align:right;">
								<div class="col-md-12">
									<button id="btn-update" type="button" href="javascript:;" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Actualizar"><i class="fa fa-save" ></i> Actualizar</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="tab-pane tabs-animation fade" id="tab-content-1" role="tabpanel">
		<div class="row">
			<div class="col-md-12">
				<div class="main-card mb-3 card">
					<div id="content-table" class="card-body">
						<form id="frm-medio-envio" class="" onsubmit="return false;" >
						<input type="hidden" value="" id="id_medio" name="id_medio"/>
							<div class="form-row">
								<div class="col-md-4">
									<label><strong>Formato</strong></label>
								</div>
								<div class="col-md-4">
									<input name="metodo_envio" id="metodo_1" type="checkbox" <?= isset($envio) ? ( ($envio==true)? 'checked' : '' ) : '' ?> > Envio a Domicilio
								</div>
								<div class="col-md-4">
									<input name="metodo_recojo" id="metodo_2" type="checkbox" <?= isset($recojo) ? ( ($recojo==true)? 'checked' : '' ) : '' ?> > Recojo en Tienda
								</div>

								<div class="col-md-12" style="text-align:right;" >
									<button id="btn-update-metodos" type="button" href="javascript:;" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Guardar"></i> Actualizar</button>
								</div>
							</div>

							<div class="divider"></div>
							<div id="row_medios_envio" style="<?= isset($envio) ? ( ($envio==true)? '' : 'display:none' ) : 'display:none' ?>">
								<h5 class="text-success" >Metodos de Envío</h5>
								<div class="form-row">
									<div class="col-md-6">
										<div class="position-relative form-group">
											<label for="titulo_medio" ><strong>Nombre de Responsable de Delivery</strong></label>
											<input name="titulo_medio" id="titulo" placeholder="Escribe Aquí" type="text" class="form-control" patron="requerido" >
										</div>
									</div>
									<div class="col-md-6">
										<div class="position-relative form-group">
											<label for="email_medio" ><strong>Email</strong></label>
											<input name="email_medio" id="email_medio" placeholder="Escribe Aquí" type="text" class="form-control"  >
										</div>
									</div>
								</div>
								<div class="form-row">
									<div class="col-md-4">
										<div class="position-relative form-group">
											<label for="telefono_medio" ><strong>Teléfono</strong></label>
											<input name="telefono_medio" id="telefono_medio" placeholder="Escribe Aquí" type="text" class="form-control" >
										</div>
									</div>
								</div>
								<div class="form-row">
									<div class="col-md-2">
										<div class="position-relative form-group">
											<label for="telefono_medio" ><strong>Tipo</strong></label>
											<div class="row" >
												<div class="col-md-12">
													<input name="tipo_medio" id="tipo_1" type="radio" value="1" > Interno<br>
													<input name="tipo_medio" id="tipo_2" type="radio" value="2" > Externo
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-4">
										<div class="position-relative form-group">
											<label for="id_empresa" ><strong>Empresa</strong></label>
											<select id="id_empresa" class="form-control" name="id_empresa">
												<option value="">--Empresa--</option>
												<? foreach($empresas_del as $row){ ?>
													<option value="<?=$row['id_empresa_del']?>"><?=$row['nombre']?></option>
												<? }?>
											</select>
										</div>
									</div>
									<div class="col-md-4">
										<div class="position-relative form-group">
											<label><strong><input id="otraEmpresa" name="otraEmpresa" type="checkbox" value="1" > Otro<br></strong></label>
											<input name="empresa_medio" id="empresa_medio" placeholder="Escribe Aquí" type="text" class="form-control" disabled>  
										</div>
									</div>
									<div class="col-md-2" style="text-align:right;" >
										<button id="btn-add-medio" type="button" href="javascript:;" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Guardar"><i class="fa fa-plus" ></i> Guardar</button>
										<button id="btn-update-medio" style="display:none;" type="button" href="javascript:;" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Actualizar"><i class="fa fa-save" ></i> Actualizar</button>
										<button id="btn-cancel-medio" style="display:none;" type="button" href="javascript:;" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Cancelar">Cancelar</button>
									</div>
								</div>
							</div>
							<hr />
							<div class="form-row" >
								<div class="col-md-12" id="content-table-medio-envio">
									<div class="alert alert-default2"><img src="assets/images/load.gif" /> Buscando registros...</div>          
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="tab-pane tabs-animation fade" id="tab-content-2" role="tabpanel">
		<div class="row">
			<div class="col-md-12">
				<div class="main-card mb-3 card">
				<div id="content-table" class="card-body">
					<form id="frm-register-pdv" class="" onsubmit="return false;" >
					<input type="hidden" value="<?= isset($comercio['configurado']) ?$comercio['configurado']:"" ?>" id="configurado" name="configurado"/>
					<input type="hidden" value="" id="id_pdv" name="id_pdv"/>
					<input type="hidden" value="" id="id_telefono" name="id_telefono"/>

					<input type="hidden" value="" id="latitud" name="latitud"/>
					<input type="hidden" value="" id="longitud" name="longitud"/>
					
					<div class="row">
						<div class="col-md-6">
							<div class="form-row">
								<div class="col-md-8">
									<div class="position-relative form-group">
										<label for="nombre_local" ><strong>Local</strong></label>
										<input name="nombre_local" id="nombre_local" placeholder="Escribe Aquí" type="text" class="form-control" patron="requerido">
									</div>
								</div>
								<div class="col-md-4">
									<div class="position-relative form-group">
										<label for="telefono_local" ><strong>Teléfono</strong></label>
										<input name="telefono_local" id="telefono_local" placeholder="Escribe Aquí" type="text" class="form-control" patron="entero">
									</div>
								</div>
							</div>
							<div class="form-row">
								<div class="col-md-7">
									<div class="position-relative form-group">
										<label for="email_local" ><strong>Email</strong></label>
										<input name="email_local" id="email_local" placeholder="Escribe Aquí" type="text" class="form-control" >
									</div>
								</div>
								<div class="col-md-5">
									<div class="position-relative form-group">
										<label><strong>Horario de Atención</strong></label>
										<input name="horario_atencion" id="horario_atencion" type="text" class="form-control">
									</div>
								</div>
							</div>
							<div class="form-row">
								<div class="col-md-12">
									<div class="position-relative form-group">
										<label><strong>Ubigeo</strong></label>
										<div class="row">
											<div class="col-md-4" >
												<select id="departamento_local" class="form-control" name="departamento_local">
													<option value="">Departamento</option>
													<? foreach($departamentos as $row){ ?>
														<option value="<?=$row['cod_dep']?>"><?=$row['departamento']?></option>
													<? }?>
												</select>
											</div>
											<div class="col-md-4" >
												<select class="form-control" name="provincia_local" id="provincia_local">
													<option value="">Provincia</option>
												</select>
											</div>
											<div class="col-md-4" >
												<select class="form-control" name="distrito_local" id="distrito_local">
													<option value="">Distrito</option>
												</select>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="form-row">
								<div class="col-md-12">
									<label><strong>Dirección</strong></label>
									
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
													<option value="Av">Avenida</option>
													<option value="Jr">Jirón</option>
													<option value="C">Calle</option>
													<option value="P">Pasaje</option>
													<option value="Al">Alameda</option>
													<option value="Ml">Malecón</option>
													<option value="Ov">Ovalo</option>
													<option value="Par">Parque</option>
													<option value="Ca">Carretera</option>
													<option value="Bl">Block</option>
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
													<option value="Urb">Urbanización</option>
													<option value="Pj">Pueblo Joven</option>
													<option value="Uv">Unidad Vecinal</option>
													<option value="Ca">Conjunto Habitacional</option>
													<option value="Ah">Asentamiento Humano</option>
													<option value="Cop">Cooperativa</option>
													<option value="Re">Residencial</option>
													<option value="Zind">Zona Industrial</option>
													<option value="Gr">Grupo</option>
													<option value="Cas">Caserio</option>
													<option value="F">Fundo</option>
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
						<div class="col-md-6">
							<div class="form-row">
								<div class="col-md-12" >
									<div id="map_canvas" class="dv-maps" style="height: 340px;"></div>
									<hr />
								</div>
							</div>
							<div class="form-row" style="text-align:right;">
								<div class="col-md-12" >
									<button id="btn-marcar-mapa" type="button" href="javascript:;" class="btn btn-light" onclick="(new Configuracion.maps()).codeAddress();" data-toggle="tooltip" data-placement="top" title="" data-original-title="Ubicar en el mapa">Ubicar Dirección Ingresada</button>
									<button id="btn-add-pdv" type="button" href="javascript:;" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Guardar"><i class="fa fa-plus" ></i> Guardar</button>
									<button id="btn-update-pdv" style="display:none;" type="button" href="javascript:;" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Actualizar"><i class="fa fa-save" ></i> Actualizar</button>
									<button id="btn-cancel-pdv" style="display:none;" type="button" href="javascript:;" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Cancelar">Cancelar</button>
								</div>
							</div>
						</div>
					</div>
					<hr />
					<div class="row">
						<div class="col-md-12" id="content-table-pdv">
							<div class="alert alert-default2"><img src="assets/images/load.gif" /> Buscando registros...</div>          
						</div>
					</div>
					</form>
				</div>
			</div>
			</div>
		</div>
	</div>
	<div class="tab-pane tabs-animation fade" id="tab-content-3" role="tabpanel">
		<div class="row">
			<div class="col-md-12">
				<div class="main-card mb-3 card">
				<div id="content-table" class="card-body">
					<form id="frm-register-articulos" class="" onsubmit="return false;" >
					<input type="hidden" value="" id="id_articulo" name="id_articulo"/>
					<div class="row">
						<div class="col-md-12 form-group" style="text-align:right;">
							<button id="btn-hide-all-articulos" type="button" href="javascript:;" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Ocultar"><i class="fa fa-eye" ></i> Ocultar Todo</button>
						</div>
					</div>
							
					<div class="row">
						<div class="col-md-3" >
							<div class="alert alert-info fade show" style="font-size:10px" ><i class="fa fa-info-circle"></i> Se recomienda usar imagenes de 640 X 480 JPG</div>

							<img id="img_articulo_0" src="../public/assets/images/default-image.jpg" data-id="0" data-estado="0" class="w-100" >
							<div class="form-row">
								<div class="col-md-4">
									<input id="file_articulo_0" data-id="0" type="file" class="file_articulo" style="width:100%;display:none;" accept="image/png, image/jpeg">
									<button id="btn-img-articulo_0" data-id="0" style="width:100%;" type="button" href="javascript:;" class="btn btn-success btn-img-articulo" data-toggle="tooltip" data-placement="top" data-original-title="File"><i ></i> File</button>
								</div>
								<div class="col-md-8">
									<input id="text-img-articulo_0" class="form-control col-md-12" value="" disabled>
								</div>
							</div>
						</div>
						<div class="col-md-5">
							<div class="form-row">
								<div class="col-md-12">
									<div class="position-relative form-group">
										<label for="nombre_articulo" ><strong>Descripción</strong></label>
										<input name="nombre_articulo" id="nombre_articulo" placeholder="Escribe Aquí" type="text" class="form-control" patron="requerido">
									</div>
								</div>
							</div>
							<div class="form-row">
								<div class="col-md-3">
									<div class="position-relative form-group">
										<label><strong>Precio (S/.)</strong></label>
										<input name="precio_articulo" id="precio_articulo" placeholder="Escribe Aquí" type="number" class="form-control" patron="requerido">
									</div>
								</div>
								<div class="col-md-3">
									<div class="position-relative form-group">
										<label><strong>Empaque (S/.)</strong></label>
										<input name="costo_emp_articulo" id="costo_emp_articulo" placeholder="Escribe Aquí" type="number" class="form-control" >
										
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-row">
								<div class="col-md-12">
									<div class="position-relative form-group">
										<label><strong>Observación</strong></label>
										<!--<input name="observacion_articulo" id="observacion_articulo" placeholder="Escribe Aquí" type="text" class="form-control" patron="requerido">-->
										<textarea name="observacion_articulo" id="observacion_articulo" placeholder="Escribe Aquí" class="form-control" patron="requerido"></textarea>
									</div>
								</div>
							</div>
							<div class="form-row form-group">
								<div class="col-md-12" style="text-align:right;" >
									<div class="form-group" >
										<button id="btn-add-articulo" type="button" href="javascript:;" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Guardar"><i class="fa fa-plus" ></i> Guardar</button>
										<button id="btn-update-articulo" style="display:none;" type="button" href="javascript:;" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Actualizar"><i class="fa fa-save" ></i> Actualizar</button>
										<button id="btn-cancel-articulo" style="display:none;" type="button" href="javascript:;" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Cancelar">Cancelar</button>
									</div>
								</div>
							</div>
						</div>
					</div>
					<hr />
					<div class="row">
						<div class="col-md-4" style="text-align:center;">
						</div>
						<div class="col-md-4" style="text-align:right;">
							<button id="btn-refresh-articulos" type="button" href="javascript:;" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Buscar"></i> Buscar</button>	
						</div>
						<div class="col-md-4" style="text-align:center;">
							<input id="nombre_articulo_bus" placeholder="Escribe Aquí" type="text" class="form-control" >
						</div>
					</div>
					<br />
					<div id="carouselExampleControls" class="carousel slide row"  data-ride="carousel" data-interval="0">
						<div class="col-md-1">
							<a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev" style="background-color: #cccccc; width:100%;">
								<span class="carousel-control-prev-icon" aria-hidden="true"></span>
								<span class="sr-only">Previous</span>
							</a>
						</div>
						<div class="col-md-10" id="content-table-articulo">
							<div class="alert alert-default2"><img src="assets/images/load.gif" /> Buscando registros...</div>          
						</div>
						<div class="col-md-1">
							<a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next" style="background-color: #cccccc; width:100%;">
								<span class="carousel-control-next-icon" aria-hidden="true"></span>
								<span class="sr-only">Next</span>
							</a>
						</div>
						
						
 
							
						 
						</div>
						
					</form>
				</div>
			</div>
			</div>
		</div>
	</div>
</div>
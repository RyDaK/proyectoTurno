<!--<div class="row">
	<div class="col-md-12">
		<div id="content-table" class="card-body">-->
			<form id="frm-usuarios" class="" onsubmit="return false;" >
				<input type="hidden" value="<?=isset($id_usuario)? $id_usuario : "" ?>" id="id_usuario_editar" name="id_usuario_editar"/>
				<input type="hidden" value="<?=isset($hist['id_usuario_hist'])? $hist['id_usuario_hist'] : "" ?>" id="id_usuario_hist" name="id_usuario_hist"/>
				<input type="hidden" value="<?=isset($hist['id_pdv'])? $hist['id_pdv'] : "" ?>" id="id_pdv_sel"/>
				<div class="row" >
					<div class="col-md-7">
						<div class="form-row">
							<div class="col-md-6">
								<div class="position-relative form-group">
									<label for="apellido_pat" ><strong>Apellido Paterno</strong></label>
									<input name="apellido_pat" id="apellido_pat" placeholder="Escribe Aquí" type="text" class="form-control" value="<?=isset($usuario['ape_paterno'])? $usuario['ape_paterno'] : "" ?>" >
								</div>
							</div>
							<div class="col-md-6">
								<div class="position-relative form-group">
									<label for="apellido_mat" >Apellido Materno</label>
									<input name="apellido_mat" id="apellido_mat" placeholder="Escribe Aquí" type="text" class="form-control" value="<?=isset($usuario['ape_materno'])? $usuario['ape_materno'] : "" ?>">
								</div> 
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-8">
								<div class="position-relative form-group">
									<label for="nombres" ><strong>Nombres</strong></label>
									<input name="nombres" id="nombres" placeholder="Escribe Aquí" type="text" class="form-control" value="<?=isset($usuario['nombres'])? $usuario['nombres'] : "" ?>" patron="requerido">
								</div>
							</div>
							<div class="col-md-4">
								<div class="position-relative form-group">
									<label for="nro_documento" ><strong>DNI</strong></label>
									<input name="nro_documento" id="nro_documento" placeholder="Escribe Aquí" type="number" class="form-control" value="<?=isset($usuario['nro_documento'])? $usuario['nro_documento'] : "" ?>"  patron="dni" >
								</div>
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-12">
								<div class="position-relative form-group">
									<label for="email" ><strong>Email</strong></label>
									<input name="email" id="email" placeholder="Escribe Aquí" type="email" class="form-control" value="<?=isset($usuario['email'])? $usuario['email'] : "" ?>"  patron="requerido">
								</div>
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-4">
								<div class="position-relative form-group">
									<label for="id_perfil" ><strong>Perfil</strong></label>
									<select id="id_perfil" name="id_perfil" class="form-control-md form-control" patron="requerido" >
										<option value="" >-- Perfil --</option>
										<?foreach($perfiles as $row){?>
											<option value="<?=$row['id_usuario_perfil']?>" <?=isset($hist['id_usuario_perfil'])? (($hist['id_usuario_perfil']==$row['id_usuario_perfil'])? "SELECTED" :""  ) : "" ?>  ><?=$row['nombre']?></option>
										<?}?>
									</select>
								</div>
							</div>
							<div class="col-md-4">
								<div class="position-relative form-group">
									<label for="usuario" ><strong>Usuario</strong></label>
									<input name="usuario" id="usuario" placeholder="Escribe Aquí" type="text" class="form-control" value="<?=isset($usuario['nombre_usuario'])? $usuario['nombre_usuario'] : "" ?>" patron="requerido">
								</div>
							</div>
							<div class="col-md-2">
								<div class="position-relative form-group">
									<label for="usuario" ><strong>Contraseña</strong></label>
									<input name="clave" id="clave" placeholder="Escribe Aquí" type="text" class="form-control" value="<?=isset($usuario['clave'])? $usuario['clave'] : "" ?>" patron="requerido">
								</div>
							</div>
							<div class="col-md-2">
								<div class="position-relative form-group">
									<br>
									<button id="btn-generar" data-id="0" style="width:100%;" type="button" href="javascript:;" class="btn btn-success" data-toggle="tooltip" data-placement="top" data-original-title="Generar clave"><i ></i> Generar</button>
								</div>
							</div>
						</div>
						<div class="form-row">
							<?
								$estado="";
								$iup=$this->session->userdata('id_usuario_perfil');
								if($iup!=1){
									$estado="display: none;";
								}
							?>
							<div class="col-md-6" style="<?=$estado?>">
								<div class="position-relative form-group">
									<label for="id_comercio_usuario" >Comercio</label>
									
									<select id="id_comercio_usuario" name="id_comercio_usuario" class="form-control-md form-control">
										<option value="" >-- Comercio --</option>
										<?foreach($comercios as $row){?>
											<option value="<?=$row['id_comercio']?>" <?=isset($hist['id_comercio'])? (($hist['id_comercio']==$row['id_comercio'])? "SELECTED" :""  ) :  (isset($id_comercio) ? (($row['id_comercio']==$id_comercio) ? "SELECTED" : "" ) : "") ?>  ><?=$row['nombre']?></option>
										<?}?>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="position-relative form-group">
									<label for="id_pdv" >PDV</label>
									<select id="id_pdv" name="id_pdv" class="form-control" >
										<option value="" >-- PDV --</option>
										<?if($pvds!=null){foreach($pvds as $row){?>
											<option value="<?=$row['id_pdv']?>" <?=isset($hist['id_pdv'])? (($hist['id_pdv']==$row['id_pdv'])? "SELECTED" :""  ) : "" ?>  ><?=$row['nombre']?></option>
										<?}}?>
									</select>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-5">
						<h5 class="text-success" >PERMISOS</h5>
						<hr >
						<div class="form-row">
							<div class="col-md-12">
								<div class="position-relative form-group">
									<?foreach($menus['menus'] as $idGrupo => $row){?>
										<div class="form-row form-group" style="text-align:center;">
											<div class="col-md-12">
												<label><strong><?= $menus['grupos'][$idGrupo]['nombre'] ?> <i class="<?=$menus['grupos'][$idGrupo]['icon'] ?>"></i></strong></label>
											</div>
										</div>
										<div class="form-row">
											<?	foreach($menus['menus'][$idGrupo] as $id =>$row_menu){
												?>
												<div class="col-md-3">
													<div class="form-group">
														<input name="menu" id="menu_<?=$row_menu['id_menu']?>" class="menu" type="checkbox" value="<?=$row_menu['id_menu']?>"  <?= isset($usuario_menu[$row_menu['id_menu']]) ? "" : "disabled='disabled'" ?>   <?= isset($usuario_menu[$row_menu['id_menu']]) ? ( "checked" ) : "" ?> >
														<i class="<?=$row_menu['icon']?>"></i>
														<label for="menu_<?=$row_menu['id_menu']?>" ><?=$row_menu['nombre']?></label>
													</div>
												</div>
												<?
											}
											?>
										</div>
										<hr>
									<?}?>
								</div>
							</div>

						</div>
					</div>
				</div>				
			</form><!--
		</div>
	</div>
</div>-->

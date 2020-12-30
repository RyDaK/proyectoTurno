<form id="frm-mensajes" class="" onsubmit="return false;" >
	<input type="hidden" value="<?=$id_comercio?>" id="id_comercio" name="id_comercio"/>
	<input type="hidden" value="" id="id_mens" name="id_mens"/>
	<div class="form-row">
		<div class="col-md-12">
				<h3 class="text-success"><?=$comercio['nombre_comercio'] ?></h3>
				<label ><strong><?=$comercio['razon_social'] ?></strong></label>
				<label >| RUC <?=$comercio['ruc'] ?></label>
		</div>
		<div class="col-md-6">
			<div class="main-card mb-3 card">
				<div id="content-table" class="card-body">
					<div class="row">
						<div class="col-md-12">
							<p>
								<p>
									<i class="fas fa-warning fa-2x color-green mr-2 float-left"></i>
								</p>
								<p class="text-left mt-1">Debe ingresar correctamente los comandos caso contrario no se obtendra el resultado esperado.</p>
								<p>
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="main-card mb-3 card">
				<div id="content-table" class="card-body">
					<div class="row">
						<div class="col-md-12">
							<label >Comandos </label><br>
						</div>
						<div class="col-md-12">
							<label >
							<button type="button" href="javascript:;" class="btn btn-cnf-cmd" data-cmd="[raz_social]"><strong>[raz_social]</strong></button>: Razón social del comercio.<br>
							<button type="button" href="javascript:;" class="btn btn-cnf-cmd" data-cmd="[pdv_nombre]"><strong>[pdv_nombre]</strong></button>: Nombre del punto de venta. <br>
							<button type="button" href="javascript:;" class="btn btn-cnf-cmd" data-cmd="[cod_pedido]"><strong>[cod_pedido]</strong></button>: Código del pedido realizado. <br>
							<!--<button type="button" href="javascript:;" class="btn btn-cnf-cmd" data-cmd="[tie_entreg]"><strong>[tie_entreg]</strong></button>: Tiempo maximo de entrega. <br>-->
							<button type="button" href="javascript:;" class="btn btn-cnf-cmd" data-cmd="[med_envio]"><strong>[med_envio]</strong></button>: Encargado de transporte. <br>
							<!--<button type="button" href="javascript:;" class="btn btn-cnf-cmd" data-cmd="[usr_nombres]"><strong>[usr_nombres]</strong></button>: Nombre usuario registro. <br>-->
							<button type="button" href="javascript:;" class="btn btn-cnf-cmd" data-cmd="[cli_nombres]"><strong>[cli_nombres]</strong></button>: Cliente solicitante. 
							</label>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="form-row">
		<div class="col-md-3">
			<div class="position-relative form-group">
				<label for="proceso" ><strong>Proceso </strong></label>
				<select class="form-control" name="id_proceso_new" id="id_proceso_new"  patron="requerido">
				<option value="">--Seleccione--</option>
				<?
					foreach($procesos as $row){?>
					<option value="<?=$row['id_proceso'] ?>"><?=$row['nombre'] ?></option>
				<?	}
				?>
			</select>
			</div>
		</div>
		<div class="col-md-7">
			<div class="position-relative form-group">
				<label for="mensaje_new" ><strong>Mensaje </strong></label>
				<textarea name="mensaje_new" rows="3" id="mensaje_new"  patron="requerido" placeholder="Escriba Aquí" type="text" class="form-control"></textarea>
			</div>
		</div>

		<div class="col-md-2">
			<div class="position-relative form-group" style="text-align: right;">

				<button id="btn-add-mensaje" type="button" href="javascript:;" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Guardar"><i class="fa fa-plus" ></i> Guardar</button>
				<button id="btn-update-mensaje" style="display:none;" type="button" href="javascript:;" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Actualizar"><i class="fa fa-save" ></i> Actualizar</button>
				<button id="btn-cancel-mensaje" style="display:none;" type="button" href="javascript:;" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Cancelar">Cancelar</button>
				
			</div> 
		</div>
	</div>
	

	<div class="form-row">
		<div class="col-md-12" >
			<table style="width: 100%; font-size: 12px" id="tb-mensajes-hist" class="table table-hover table-striped table-bordered">
				<thead>
					<tr>
						<th style="text-align:center">#</th>
						<th style="text-align:center"></th>
						<th style="text-align:center">PROCESO</th>
						<th style="text-align:center">MENSAJE</th>
						<th style="text-align:center">ESTADO</th>
					</tr>
				</thead>
				<tbody>
					<?$i=1; foreach($mensajes as $row){?>
						<tr>
							<td style="text-align:center">
								<?=$i++?>
								<input type="hidden" value="<?=$row['id_conf_mens']?>" id="id_mens_<?=$row['id_conf_mens']?>"/>
							</td>
							<td>
								<div class="row">	
									<div class="col-md-1">
										<button type="button" href="javascript:;" class="btn btn-editar-mensaje" data-toggle="tooltip" data-placement="top" title="" data-id="<?=!empty($row['id_conf_mens'])? $row['id_conf_mens'] : ''?>" data-original-title="Editar"><i class="fa fa-pencil-alt" ></i></button>
									</div>
								</div>
								<div class="row">	
									<div class="col-md-1">
										<? if(($row['estado']==1)){?> <a href="javascript:;" style="padding:0px;" class="btn btn-estado-cnf-mensaje-des" data-estado="0" data-id="<?=!empty($row['id_conf_mens'])? $row['id_conf_mens'] : ''?>" ><i class="fa fa-toggle-off" ></i></a>
										<?}else{?> <a href="javascript:;" style="padding:0px;" class="btn btn-estado-cnf-mensaje-act" data-estado="1" data-id="<?=!empty($row['id_conf_mens'])? $row['id_conf_mens'] : ''?>" ><i class="fa fa-toggle-on" ></i></a><?}?>
									</div>
								</div>
							</td>
							<td style="text-align:center"><?=!empty($row['proceso'])? $row['proceso'] : '-'?></td>
							<td style="text-align:center">
								<?=!empty($row['mensaje'])? $row['mensaje'] : ''?>
								<!-- <textarea disable name="mensaje" rows="3" id="mensaje_<?=$row['id_conf_mens']?>" placeholder="Mensaje" type="text" class="form-control"><?=!empty($row['mensaje'])? $row['mensaje'] : ''?></textarea> -->
							</td>
							<td style="text-align:center">
								<?= $row['estado']==1 ? "<label class='mb-2 mr-2 badge badge-success' >ACTIVO</label>" : "<label class='mb-2 mr-2 badge badge-danger' >INACTIVO</label>"  ?>
							</td>
						</tr>
					<?}?>
				</tbody>
			</table>
		</div>
	</div>

	
	
</form>

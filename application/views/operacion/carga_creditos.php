<form id="frm-creditos" class="" onsubmit="return false;" >
	<input type="hidden" value="<?=$id_comercio?>" id="id_comercio" name="id_comercio"/>
	<div class="form-row">
		<div class="col-md-8">
			<div class="position-relative form-group">
				<h3 class="text-success"><?=$comercio['nombre'] ?></h3>
				<label ><strong><?=$comercio['razon_social'] ?></strong></label>
				<label >| RUC <?=$comercio['ruc'] ?></label>

			</div>
		</div>
		<div class="col-md-4"  style="text-align:right;">
			<div class="main-card mb-3 card">
				<div id="content-table" class="card-body">
					<div class="row">
						<div class="col-md-12">
							<label style="text-align:left;" >Creditos al <strong><!--del comercio <?=isset($comercio['nombre'])? $comercio['nombre'] : ''  ?>--><?= date('d/m/Y')?></strong>  </label><br>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12" style="text-align:right;">
							<? $clr="#777777";
								$creds="";
								if(isset($comercio['creditosActual'])){
									if($comercio['creditosActual']>0){
										$clr="#3bc939";
										
									}
									else{
										$clr="#e40101";
									}
									$creds=$comercio['creditosActual'];
								}
							?>

							<label style="color:<?=$clr?>;font-size: 2.5em;"><strong><?= ($creds!="")? $creds."" : "0" ?></strong></label>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="form-row">
		<div class="col-md-4">
			<div class="position-relative form-group">
				<label ><strong>Créditos</strong></label>
				<input name="creditos" id="creditos" placeholder="Escriba Aquí" type="number" class="form-control" patron="requerido" >
			</div>
		</div>
		
		<div class="col-md-4">
			<div class="position-relative form-group">
			<label ><strong></strong></label>
							<button id="btn-add-credito" type="button" href="javascript:;" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Guardar Credito"><i class="fa fa-plus" ></i> Recargar</button>

				<!-- <label >Fecha Vencimiento<strong></strong></label>
				<input type="text" class="form-control input-sm" id="txt-fechas_simple" name="txt-fechas_simple" value="<?= date("d/m/Y")?>" /> -->
			</div>
		</div>
		<div class="col-md-4">
			<div class="position-relative form-group" style="text-align: right;">
				<!--<button id="btn-add-credito" type="button" href="javascript:;" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Guardar Credito"><i class="fa fa-plus" ></i> Guardar</button>-->
			</div> 
		</div>
	</div>

	<div class="form-row">
		<table style="width: 100%; font-size: 12px" id="tb-creditos-hist" class="table table-hover table-striped table-bordered">
			<thead>
				<tr>
					<th style="text-align:center">#</th>
					<th style="text-align:center">ATIVAR o DESACTIVAR <br>CRÉDITOS</th>
					<th style="text-align:center">FECHA CARGA</th>
					<th style="text-align:center">CREDITOS CARGADOS</th>
					<th style="text-align:center">ACTIVO/INACTIVO</th>
				</tr>
			</thead>
			<tbody>
				<?$i=1; foreach($comercio_historico as $row){?>
					<tr>
						<td style="text-align:center"><?=$i++?></td>
						<td style="text-align:center">
							<? if(($row['estado']==1)){?> <a href="javascript:;" style="padding:0px;" class="btn btn-estado-credito-des" data-estado="0" data-id="<?=!empty($row['id_comercio_cred'])? $row['id_comercio_cred'] : ''?>" data-creditos="<?=!empty($row['creditosCarga'])? $row['creditosCarga'] : ''?>" ><i class="fa fa-toggle-on" ></i></a>
							<?}else{?> <a href="javascript:;" style="padding:0px;" class="btn btn-estado-credito-act" data-estado="1" data-id="<?=!empty($row['id_comercio_cred'])? $row['id_comercio_cred'] : ''?>" data-creditos="<?=!empty($row['creditosCarga'])? $row['creditosCarga'] : ''?>" ><i class="fa fa-toggle-off" ></i></a><?}?>
						</td>
						<td style="text-align:center"><?=!empty($row['fecIni'])? date_change_format($row['fecIni']) : '-'?></td>
						<td style="text-align:center"><?=!empty($row['creditosCarga'])? $row['creditosCarga'] : '-'?></td>
						<td style="text-align:center">
							<?= $row['estado']==1 ? "<label class='mb-2 mr-2 badge badge-success'>Créditos Activos</label>" : "<label class='mb-2 mr-2 badge badge-danger'>Créditos Inactivos</label>"  ?>
						</td>
					</tr>
				<?}?>
			</tbody>
		</table>
	</div>

	
	
</form>
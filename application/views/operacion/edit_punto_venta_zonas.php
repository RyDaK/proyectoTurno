<form id="frm-zonas" class="" onsubmit="return false;" >
	<input type="hidden" value="<?=$id_pdv?>" id="id_pdv_zona" name="id_pdv_zona"/>
	<input type="hidden" value="<?= isset($comercio['costo_delivery']) ? $comercio['costo_delivery'] :''  ?>" name="costo_delivery_def"/>
	
	<div class="form-row">
		<div class="col-md-6">
			<div class="position-relative form-group">
				<h3 class="text-success"><?=$comercio['nombre_comercio'] ?></h3>
				<label ><strong><?=$comercio['razon_social'] ?></strong></label>
				<label >| RUC <?=$comercio['ruc'] ?></label>
			</div>
		</div>
		<div class="col-md-6">
			<div class="main-card mb-3 card">
				<div id="content-table" class="card-body">
					<div class="row">
						<div class="col-md-12">
							<label >Costo Delivery <strong>(Global)</strong> <!--<strong><?=$comercio['razon_social'] ?></strong>--></label><br>
						</div>
						<div class="col-md-12" style="text-align:right;"><br>
							<label style="font-size: large;"><strong><?= isset($comercio['costo_delivery']) ? $comercio['costo_delivery'] :''  ?></strong></label>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="form-row">
		<div class="col-md-6">
			<div class="position-relative form-group">
				<label for="Distrito" ><strong>Distrito </strong></label>
				<select class="form-control" name="id_ubigeo" id="id_ubigeo">
					<option value="">Distrito</option>
					<? foreach($distritos as $row){ ?>
						<option value="<?=$row['id_ubigeo']?>"><?=$row['distrito']?></option>
					<? }?>
				</select>
			</div>
		</div>

		<div class="col-md-4">
			<div class="position-relative form-group">
				<label for="costo" ><strong>Costo </strong></label>
				<div class="position-relative form-group">
					<input name="costo_delivery" id="costo_delivery" placeholder="Escribe Aquí" type="number" class="form-control">
				</div>
			</div>
		</div>

		<div class="col-md-2">
			<div class="position-relative form-group" style="text-align: right;">
				<button id="btn-add-zona" type="button" href="javascript:;" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Guardar"><i class="fa fa-plus" ></i> Guardar</button>
			</div> 
		</div>
	</div>
	

	<div class="form-row">
		<table style="width: 100%; font-size: 12px" id="tb-zonas-hist" class="table table-hover table-striped table-bordered">
			<thead>
				<tr>
					<th style="text-align:center">#</th>
					<th style="text-align:center"></th>
					<th style="text-align:center">DISTRITO</th>
					<th style="text-align:center">COSTO DELIVERY</th>
					<th style="text-align:center">ESTADO</th>
				</tr>
			</thead>
			<tbody>
				<?$i=1; foreach($zonas as $row){?>
					<tr>
						<td style="text-align:center">
							<?=$i++?>
							<input type="hidden" value="<?=$row['id_pdv_zona']?>" name="id_zona" id="id_zona_<?=$row['id_pdv_zona']?>"/>
						</td>
						<td>
							<? if(($row['estado']==1)){?> <a href="javascript:;" style="padding:0px;" class="btn btn-estado-venta-zona-des" data-estado="0" data-id="<?=!empty($row['id_pdv_zona'])? $row['id_pdv_zona'] : ''?>" ><i class="fa fa-toggle-off" ></i></a>
							<?}else{?> <a href="javascript:;" style="padding:0px;" class="btn btn-estado-venta-zona-act" data-estado="1" data-id="<?=!empty($row['id_pdv_zona'])? $row['id_pdv_zona'] : ''?>" ><i class="fa fa-toggle-on" ></i></a><?}?>
						</td>
						<td style="text-align:center">
							<select class="form-control" name="id_ubigeo_zona" id="id_ubigeo_<?=$row['id_pdv_zona']?>">
								<? foreach($distritos as $row_d){ ?>
									<option value="<?=$row_d['id_ubigeo']?>" <?= isset($row['id_ubigeo']) ? ( $row['id_ubigeo']==$row_d['id_ubigeo'] ? "SELECTED" : "") : "" ?> ><?=$row_d['distrito']?></option>
								<? }?>
							</select>
						</td>
						<td style="text-align:center">
							<input name="costo_delivery_zona" id="costo_delivery_<?=$row['id_pdv_zona']?>" placeholder="Escribe Aquí" type="text" class="form-control" value="<?=!empty($row['costo'])? $row['costo'] : '-'?>" >
						</td>
						<td style="text-align:center">
							<?= $row['estado']==1 ? "<label class='mb-2 mr-2 badge badge-success' >ACTIVO</label>" : "<label class='mb-2 mr-2 badge badge-danger'  >INACTIVO</label>"  ?>
						</td>
					</tr>
				<?}?>
			</tbody>
		</table>
	</div>

	
	
</form>
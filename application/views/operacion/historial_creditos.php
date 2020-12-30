<form id="frm-creditos" class="" onsubmit="return false;" >
	<input type="hidden" value="<?=$id_comercio?>" id="id_comercio" name="id_comercio"/>
	<div class="form-row">
		<div class="col-md-6">
			<div class="position-relative form-group">
					<h3 class="text-success"><?=$comercio['nombre_comercio'] ?></h3>
				<label ><strong><?=$comercio['razon_social'] ?></strong></label>
				<label >| RUC <?=$comercio['ruc'] ?></label>
			</div>
		</div>
		<div class="col-md-6">
		 
		</div>
	</div>
	

	<div class="form-row" >
		<div class="col-md-12">
			<table style="width: 100%; font-size: 12px;" id="tb-creditos-hist" class="table table-hover table-striped table-bordered">
				<thead>
					<tr>
						<th style="text-align:center">#</th>
						<th style="text-align:center">FECHA CARGA</th>
						<th style="text-align:center">CREDITOS CARGADOS</th>
					</tr>
				</thead>
				<tbody>
					<?$i=1; foreach($comercio_credito as $row){?>
						<tr>
							<td style="text-align:center"><?=$i++?></td>
							<td style="text-align:center"><?=!empty($row['fecIni'])? date_change_format($row['fecIni']) : '-'?></td>
							<td style="text-align:center"><?=!empty($row['creditosCarga'])? $row['creditosCarga'] : '-'?></td>
						</tr>
					<?}?>
				</tbody>
			</table>
		</div>
	</div>

	
	
</form>

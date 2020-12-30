<div class="row">
	<div class="col-6 col-lg-3">
		<input type="text" class="form-control input-sm" id="txt-fechas" name="txt-fechas" value="<?= date("d/m/Y").' - '.date("d/m/Y") ?>" />
	</div>
	<div class="col-2 col-lg-3">
		<select id="comercio" name="comercio" class="form-control-md form-control" >
			<option value="" >-- Comercio--</option>
			<?foreach($comercios as $row){?>
				<option value="<?=$row['id_comercio']?>" ><?=$row['comercio']?></option>
			<?}?>
		</select>
	</div>
	<div class="col-2 col-lg-3">
		<select id="pdv" name="pdv" class="form-control-md form-control" >
			<option value="" >-- PDV--</option>
		</select>
	</div>
	<div class="col-2 col-lg-3">
		<button id="btn-refresh-liq" type="button" href="javascript:;" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Actualizar lista"><i class="fa fa-refresh" ></i></button>
	</div>
</div>
<div class="divider"></div>

<div class="row">
	<div class="col-12">
		<div class="main-card mb-3 card">
			<div id="content-table" >
				<div class="alert alert-default2"><img src="assets/images/load.gif" /> Buscando registros...</div>          
			</div>
		</div>
	</div>
</div>
<script>
	var json_pdv = <?=json_encode($pdv);?>
</script>
	
	<div class="row">
		<div class="col-2 col-lg-3">
			<? if( isset($id_perfil)){
				if($id_perfil==1){?>
					<select id="comercio" name="comercio" class="form-control-md form-control" >
						<option value="" >-- Comercio--</option>
						<?foreach($comercios as $row){?>
							<option value="<?=$row['id_comercio']?>" ><?=$row['nombre']?></option>
						<?}?>
					</select>
				<?}
			}?>
		</div>
		<div class="col-10 col-lg-9">
			<button id="btn-add-usuario" type="button" href="javascript:;" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Nuevo"><i class="fa fa-plus" ></i> Nuevo</button>
			<button id="btn-refresh-usuarios" type="button" href="javascript:;" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Actualizar lista"><i class="fa fa-refresh" ></i> Actualizar</button>
		</div>
	</div>
	<div class="divider"></div>

	<!--<div class="row">
		<div class="main-card mb-3 card col-12">
			<div class="card-body"  id="content-table">
				<div class="alert alert-default2"><img src="assets/images/load.gif" /> Buscando registros...</div>          
			</div>
		</div>
	</div>-->
	<div class="row">
		<div class="col-12">
			<div class="main-card mb-3 card">
				<div id="content-table" class="">
					<div class="alert alert-default2"><img src="assets/images/load.gif" /> Buscando registros...</div>          
				</div>
			</div>
		</div>
	</div>

 


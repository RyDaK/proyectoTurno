<div class="table-responsive" style="padding: 0.3em;">
	<!--<div class="col-md-12">-->
		<!--<table data-order='[[ 0, "desc" ]]' style="width: 100%; font-size: 12px; height:100%; " id="tb-list" class="table table-hover table-striped table-bordered">-->
		<table style="width: 100%; font-size: 12px" id="tb-list" class="table table-hover table-striped table-bordered">
			<thead>
				<tr>
					<th ></th>
					<th style="text-align:center">#</th>
					<th style="text-align:center">COD USUARIO (AUTO)</th>
					<th style="text-align:center">APELLIDO PATERNO</th>
					<th style="text-align:center">APELLIDO MATERNO</th>
					<th style="text-align:center">NOMBRES</th>
					<th style="text-align:center">FECHA<BR />CREACIÓN</th>
					<th style="text-align:center">PERFIL</th>
					<th style="text-align:center">CUENTA</th>
					<th style="text-align:center">USUARIO/CLAVE</th>
					<th style="text-align:center">CONDICIÓN</th>
				</tr>
			</thead>
			<tbody>
				<?$i=1; if(isset($usuarios)){ foreach($usuarios as $row){?>
					<tr>
						<td ><?=$i++?></td>
						<td style="text-align:center">
							<div class="row">	
								<div class="col-md-1">
									<button type="button" href="javascript:;" style="padding:0px;margin:0px;" data-id="<?=!empty($row['id_usuario'])? $row['id_usuario'] : ''?>" data-uh="<?=!empty($row['id_usuario_hist'])? $row['id_usuario_hist'] : ''?>" class="btn btn-edit-usuario" data-toggle="tooltip" data-placement="top" title="" data-original-title="Editar"><i class="fa fa-pencil-alt" ></i></button>
								</div>
								<!-- <div class="col-md-3">
									<button type="button" href="javascript:;" class="btn btn-vis-usuario" data-toggle="tooltip" data-placement="top" title="" data-original-title="Visualizar"><i class="fa fa-cube" ></i> </button>
								</div> -->
								<div class="col-md-1">
									<? if(($row['estado']==1)){?> <a href="javascript:;" style="padding:0px;margin:0px;" class="btn btn-estado-usuario_des" data-estado="0" data-id="<?=!empty($row['id_usuario'])? $row['id_usuario'] : ''?>" ><i class="fa fa-toggle-off" ></i></a>
									<?}else{?> <a href="javascript:;" style="padding:0px;margin:0px;" class="btn btn-estado-usuario_act" data-estado="1" data-id="<?=!empty($row['id_usuario'])? $row['id_usuario'] : ''?>" ><i class="fa fa-toggle-on" ></i></a><?}?>
								</div>
							</div>
						</td>
						

						<td style="text-align:center">
							<?=!empty($row['id_usuario'])? $row['id_usuario'] : '-'?>
						</td>
						<td ><?=!empty($row['ape_paterno'])? $row['ape_paterno'] : '-'?></td>
						<td ><?=!empty($row['ape_materno'])? $row['ape_materno'] : '-'?></td>
						<td ><?=!empty($row['nombres'])? $row['nombres'] : '-'?></td>
						<td style="text-align:center"><?=!empty($row['fecIni'])? date_change_format($row['fecIni']) : '-'?><?!empty($row['fecFin'])? date_change_format($row['fecFin']) : 'En Curso'?></td>
						<td style="text-align:center"><?=!empty($row['perfil'])? $row['perfil'] : '-'?></td>
						<td style="text-align:center"><?=!empty($row['comercio'])? $row['comercio'] : '-'?></td>
						<td style="text-align:center"><?=!empty($row['nombre_usuario'])? $row['nombre_usuario'] : '-'?> / <?=!empty($row['clave'])? $row['clave'] : '-'?></td>
						<td style="text-align:center">
							<?= $row['estado']==1 ? "<label class='mb-2 mr-2 badge badge-success'>ACTIVO</label>" : "<label class='mb-2 mr-2 badge badge-danger'>INACTIVO</label>"  ?>
						</td>
					</tr>
				<?} }?>
			</tbody>
		</table>
		</div>
	<!--</div>-->
		
	


 


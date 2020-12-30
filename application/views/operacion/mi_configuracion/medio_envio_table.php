<div class="table-responsive">
<table style="width: 100%; font-size: 12px;" class="table table-hover table-striped table-bordered "><!-- id="tb-medio-hist"-->
    <thead>
        <tr>
            <th style="text-align:center"></th>
            <th style="text-align:center">TITULO</th>
            <th style="text-align:center">EMAIL</th>
            <th style="text-align:center">TELÉFONO</th>
            <th style="text-align:center">TIPO</th>
            <th style="text-align:center">EMPRESA</th>
            <th style="text-align:center">ACTIVO/INACTIVO</th>
        </tr>
    </thead>
    <tbody>
        <?$i=1; if(isset($medio_envios)){ foreach($medio_envios as $row){?>
            <tr>
                <td style="text-align:center">
					<button type="button" href="javascript:;" class="btn btn-editar-medio" data-toggle="tooltip" data-placement="top" title="" data-id="<?=!empty($row['id_medio_env'])? $row['id_medio_env'] : ''?>" data-original-title="Editar"><i class="fa fa-pencil-alt" ></i></button>
<? if(($row['estado']==1)){?> <a href="javascript:;" style="padding:0px;margin:0px;" class="btn btn-estado-medio-des" data-estado="0" data-id="<?=!empty($row['id_medio_env'])? $row['id_medio_env'] : ''?>" ><i class="fa fa-toggle-off" ></i></a>
							<?}else{?> <a href="javascript:;" style="padding:0px;margin:0px;" class="btn btn-estado-medio-act" data-estado="1" data-id="<?=!empty($row['id_medio_env'])? $row['id_medio_env'] : ''?>" ><i class="fa fa-toggle-on" ></i></a><?}?>
					<!--<div class="row">	
						<div class="col-md-1">
							<button type="button" href="javascript:;" class="btn btn-editar-medio" data-toggle="tooltip" data-placement="top" title="" data-id="<?=!empty($row['id_medio_env'])? $row['id_medio_env'] : ''?>" data-original-title="Editar"><i class="fa fa-pencil-alt" ></i></button>
						</div>
					</div>
					<div class="row">
						<div class="col-md-1">
							
						</div>
					</div>-->
				</td>
                <td style="text-align:center"><?=!empty($row['titulo'])? $row['titulo'] : '-'?></td>
                <td style="text-align:center"><?=!empty($row['email'])? $row['email'] : '-'?></td>
                <td style="text-align:center"><?=!empty($row['telefono'])? $row['telefono'] : '-'?></td>
                <td style="text-align:center"><?=!empty($row['tipo'])? $row['tipo'] : '-'?></td>
                <td style="text-align:center"><?=!empty($row['empresa'])? $row['empresa'] : '-'?></td>
                <td style="text-align:center">
                    <?= $row['estado']==1 ? "<label class='mb-2 mr-2 badge badge-success'>ACTIVO</label>" : "<label class='mb-2 mr-2 badge badge-danger'>INACTIVO</label>"  ?>
                </td>
            </tr>
        <?} }?>
    </tbody>
</table>
</div>
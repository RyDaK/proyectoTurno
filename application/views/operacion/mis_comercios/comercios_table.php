<div class="row">
	<div class="col-md-12 text-right" style="padding: 2em">
		<button type="button" href="javascript:;" class="btn btn-primary btn-go-section" data-section="sec-1" data-toggle="tooltip" data-placement="top" title="" data-original-title="Ir a la sección de nuevo"><i class="fa fa-arrow-up" ></i> Ir a Nuevo</button>
	</div>
</div>
<div class="table-responsive" style="padding: 0.3em;">
<form id="frm-comercios" class="" onsubmit="return false;" >
    <table style="width: 100%; font-size: 12px" id="tb-list" class="table table-hover table-striped table-bordered">
        <thead>
            <tr>
                <th style="text-align:center">#</th>
                <th style="text-align:center">RAZÓN SOCIAL</th>
				<th style="text-align:center">NOMBRE COMERCIAL</th>
                <!--<th style="text-align:center">EMAIL</th>-->
                <th style="text-align:center">RUC</th>
                <th style="text-align:center">CRÉDITOS</th>
                <th style="text-align:center">ACTIVO/INACTIVO</th>
            </tr>
        </thead>
        <tbody>
            <?$i=1; foreach($comercios as $row){?>
                <tr data-id="<?=$row['id_comercio']?>" >
                    <td style="text-align:center"><input name="comercio" id="comercio_<?=$row['id_comercio']?>" value="<?=$row['id_comercio']?>" type="checkbox"  ></td>
                    <td><?=!empty($row['razon_social'])? $row['razon_social'] : '-'?></td>
					<td><?=!empty($row['nombre'])? $row['nombre'] : '-'?></td>
                    <!--<td><?=!empty($row['email'])? $row['email'] : '-'?></td>-->
                    <td style="text-align:center"><?=!empty($row['ruc'])? $row['ruc'] : '-'?></td>
                    <td style="text-align:center"><?=!empty($row['creditosActual'])? $row['creditosActual'] : '-'?></td>
                    <td style="text-align:center"><?= $row['estado']==1 ? "<label class='mb-2 mr-2 badge badge-success'>ACTIVO</label>" : "<label class='mb-2 mr-2 badge badge-danger' >INACTIVO</label>"  ?></td>
                </tr>
            <?}?>
        </tbody>
    </table>
</form>
</div>
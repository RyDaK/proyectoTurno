<div class="table-responsive">
<table style="width: 100%; font-size: 12px" id="" class="table table-hover table-striped table-bordered">
    <thead>
        <tr>
            <th style="text-align:center">#</th>
            <th style="text-align:center"></th>
            <th style="text-align:center">LOCAL</th>
            <th style="text-align:center">EMAIL</th>
            <th style="text-align:center">TELÉFONO</th>
            <th style="text-align:center">DIRECCION</th>
            <th style="text-align:center">UBIGEO</th>
            <th style="text-align:center">ZONAS DE ATENCION</th>
            <th style="text-align:center">ESTADO</th>
        </tr>
    </thead>
    <tbody>
        <?$i=1; if(isset($puntos_venta)){ foreach($puntos_venta as $row){?>
            <tr>
                <td style="text-align:center"><?=$i++?></td>
                <td style="text-align:center">
					<div class="row">	
						<div class="col-md-1">
							<button type="button" href="javascript:;" class="btn btn-editar-pdv" data-toggle="tooltip" data-placement="top" title="" data-id-pdv="<?=!empty($row['id_pdv'])? $row['id_pdv'] : ''?>" data-original-title="Editar"><i class="fa fa-pencil-alt" ></i></button>
						</div>
					</div>
					<div class="row">	
						<div class="col-md-1">
							<? if(($row['estado_punto']==1)){?> <a href="javascript:;" style="padding:0px;margin:0px;" class="btn btn-estado-punto-venta-des" data-estado="0" data-id="<?=!empty($row['id_pdv'])? $row['id_pdv'] : ''?>" ><i class="fa fa-toggle-off" ></i></a>
							<?}else{?> <a href="javascript:;" style="padding:0px;margin:0px;" class="btn btn-estado-punto-venta-act" data-estado="1" data-id="<?=!empty($row['id_pdv'])? $row['id_pdv'] : ''?>" ><i class="fa fa-toggle-on" ></i></a><?}?>
						</div>
					</div>
                </td>
                <td style="text-align:center"><?=$row['nombre']?></td>
                <td style="text-align:center"><?=!empty($row['email'])? $row['email'] : '-'?></td>
                <td style="text-align:center">
                    <? 
                    $nums="";
                    if(!empty($row['telefonos'])){ 
                        foreach($row['telefonos'] as $row_t){ 
                        $nums.=$row_t+"<br>";
                    } } ?>
                    <?=$nums?>
                </td>
                <td style="text-align:center"><?=!empty($row['via'])? $row['via'] : ''?> <?=!empty($row['zona'])? $row['zona'] : ''?> <?=!empty($row['direccion'])? $row['direccion'] : ''?></td>
                <td style="text-align:center"><?=!empty($row['distrito'])? $row['distrito'] : '-'?></td>
                <td style="text-align:center">
                    <button type="button" id="boton-zona-atencion-<?=$row['id_pdv']?>" href="javascript:;" class="btn btn-light btn-zona-atencion" data-toggle="tooltip" data-placement="top" title="" data-id-pdv="<?=!empty($row['id_pdv'])? $row['id_pdv'] : ''?>" data-cod-prov="<?=!empty($row['cod_prov'])? $row['cod_prov'] : ''?>" data-cod-dep="<?=!empty($row['cod_dep'])? $row['cod_dep'] : ''?>" data-original-title="Zonas de atencion">Zonas</button>
                </td>

                <td style="text-align:center"><?= $row['estado_punto']==1 ? "<label class='mb-2 mr-2 badge badge-success'>ACTIVO</label>" : "<label class='mb-2 mr-2 badge badge-danger' >INACTIVO</label>"  ?></td>
            </tr>
        <?} }?>
    </tbody>
</table>
</div>
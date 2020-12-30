<?$i=1;$cols=1;$c=1; if(isset($articulos)){ foreach($articulos as $row){?>
    <?= ($c==1)? '<div class="carousel-item '.(($i==1)? "active" : "" ).'" ><div class="row">' : ''?>

        <div class="col-md-3" style="border: solid 5px #ffffff;">
            <div class="row">
                
                <div class="col-md-12" style="padding-left:0;padding-right:0;" >
                    <img id="img_articulo_<?=$row['id_articulo']?>" src="<?= ($row['ruta_imagen']!=null)? '../files/articulos/'.$row['ruta_imagen'].'.jpg': "../public/assets/images/default-image.jpg"; ?>" title="<?= ($row['observacion']!=null)? $row['observacion']: "-"; ?>" data-estado="0" style="height:200px;width:200px;">
                </div>
                <div class="col-md-12" style="position:absolute;text-align:right;">
                    <label><strong><i class="<?= ($row['visible']==1) ? "fa fa-eye" : "fa fa-eye-slash" ?> " title="<?= ($row['visible']==1) ? "Visible" : "Oculto" ?>" style="background-color:#ffffff;padding:5px;"></i></strong></label>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
					<div class="row">
						<div class="col-md-12">
							<label><strong><?=$row['nombre']?></strong></label>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<label>Precio: <strong><?= !empty($row['precio'])? moneda(floatval($row['precio'])): "-"; ?></strong></label>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<label>Empaque: <strong><?= !empty($row['costo_empaque'])? moneda(floatval($row['costo_empaque'])): "-"; ?></strong></label>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<button data-id="<?=$row['id_articulo']?>" type="button" href="javascript:;" class="btn btn-success btn-edit-articulo " data-toggle="tooltip" data-placement="top" title="" data-original-title="Editar" style="margin:5px;"><i class="fa fa-pencil-square-o" ></i></button>
							<button id="btn-hide-articulo-<?=$row['id_articulo']?>"  data-id="<?=$row['id_articulo']?>" data-vis="<?=$row['visible']?>" type="button" href="javascript:;" class="btn btn-success btn-change-vis-articulo" style="margin:5px;" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?= ($row['visible']==1) ? "Ocultar" : "Mostrar" ?>"><i class="<?= ($row['visible']==1) ? "fa fa-eye-slash" : "fa fa-eye" ?>" ></i> </button>
							<button id="btn-remove-articulo-<?=$row['id_articulo']?>" data-id="<?=$row['id_articulo']?>" type="button" href="javascript:;" class="btn btn-danger btn-remove-articulo" data-toggle="tooltip" data-placement="top" style="margin:5px;" title="" data-original-title="Remover"><i class="fa fa-times" ></i></button>
						</div>
					</div>
                </div>
            </div>
        </div>
    <?= ($cols==4)? '</div></div>' :''?>
        
<?
if($cols==4){
$cols=1;
$c=1;
}else{
$cols++;
$c=0;
}

$i++;} }?>
<?= ($i>1)? '</div></div>' :' No existen articulos registrados.'?>

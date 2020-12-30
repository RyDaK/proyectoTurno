<div id="divllenar">
<?
	$importe_total = 0;
	$i=0;
	$moneda="S/.";
	foreach($listado_pedidos as $row){
?>
<hr>
	<div class="row">
		<div class="col-sm-12 col-md-2" >
			<center>
			<img src="../files/articulos/<?=!empty($row->foto_plato)? $row->foto_plato.".jpg": "default.jpg"?>" alt="Lights" class="" style="text-align: center; height: 100px; width:150px ;border-radius: 10px 10px 10px 10px;" >
			</center>
		</div>
		
		<div class="col-sm-12 col-md-7" >
			<h5 class="text-success" ><?= $row->plato?> <a href="javascript:;" class="btn btn-default btn-xs" onclick="Cliente.confirmar_eliminar_articulo(<?=$row->idDetallePedido?>);" ><i class="fas fa-trash-alt"></i></a></h5>
			<div class="position-relative form-group">
                <textarea name="observaciones<?=$i?>" id="observaciones<?=$i?>" placeholder="Especifíque detalles de su pedido" rows="2" class="form-control" ><?=$row->comentario?></textarea>
			</div>
		</div>
		<div class="col-sm-12 col-md-3" >
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon" style="width: 100px;">Precio Unit.</span>
					<input value="<?=$moneda?>" class="form-control simbolo_moneda" readonly="readonly" style="flex:none;width:50px" >
					<input id="precio_plato<?=$i?>" ped_cod_env_det="<?=$row->idDetallePedido?>" type="text" class="form-control" name="precio_plato" value="<?=number_format($row->precio_unitario, 2, '.', '.')?>" readonly="readonly" >
				</div>
			</div>
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon" style="width: 100px;">Cant.</span>
					<input id="cantidad_platos<?=$i?>" ped_cod_env_det="<?=$row->idDetallePedido?>"  type="text"  patron="requerido,enteros" class="form-control cantidad_platos"  name="cantidad_platos" value="<?= $row->cantidad?>" >    
				</div>
			</div>
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon" style="width: 100px;">Costo Empaque{s}.</span>
					<input value="<?=$moneda?>" class="form-control simbolo_moneda" readonly="readonly" style="flex:none;width:50px" >
					<input id="precio_empaque<?=$i?>" ped_cod_env_det="<?=$row->idDetallePedido?>" type="text" class="form-control" name="precio_plato" value="<?=dos_decimales($row->empaque * $row->cantidad)?>" readonly="readonly" >
				</div>
			</div>
			<div class="form-group" hidden="hidden">
				<div class="input-group">
					<span class="input-group-addon" style="width: 100px;">Costo Empaque{s}.</span>
					<input value="<?=$moneda?>" class="form-control simbolo_moneda" readonly="readonly" style="flex:none;width:50px" >
					<input id="precio_empaque_uni<?=$i?>" ped_cod_env_det="<?=$row->idDetallePedido?>" type="text" class="form-control" name="precio_plato" value="<?=$row->empaque?>" readonly="readonly" >
				</div>
			</div>
			<div class="form-group">
				<div  class="input-group">
					<span class="input-group-addon bg-success text-white" style="width: 100px; padding: 0.5em; border-radius: 5px 0px 0px 5px;" >Sub Total S/.</span>
					<input value="<?=$moneda?>" class="form-control simbolo_moneda" readonly="readonly" style="flex:none;width:50px" >
					<input id="total_pedido_det<?=$i?>" type="text" class="form-control" name="total_pedido_det" value="<?=number_format($row->importe, 2, '.', '.')?>" readonly="readonly" >                                        
				</div>
			</div>
		</div>
	</div>
	<?
		$importe_total += ($row->importe);
		$i++;
		}
	?>
	<hr />
	<div class="row" >
		<div class="col-sm-12 col-md-9" ></div>
		<div class="col-sm-12 col-md-3" >
			<div class="form-group">
				<div  class="input-group">
					<span class="input-group-addon bg-success text-white" style="width: 100px; padding: 0.5em; border-radius: 5px 0px 0px 5px;" >Total S/.</span>
					<input value="<?=$moneda?>" class="form-control simbolo_moneda" readonly="readonly" style="flex:none;width:50px" >
					<input id="total_pedido" type="text" class="form-control" patron="requerido" name="total_pedido" value="<?=number_format($importe_total, 2, '.', '.') ?>" readonly="readonly" >
				</div>
			</div>
		</div>
	</div>
	<div class="row" >
		<div class="col-sm-12 col-md-6" ></div>
		<div class="col-sm-12 col-md-3" >
			<br>
			<button ped_cod_env="<?=$cod_usuario_ped ?>" cod_local_comercio="<?=$id_pdv?>" local_comercio="<?=$pdv?>" cod_tipo_comercio="<?=$id_giro?>" tipo_comercio="<?=$giro?>" nombre_comercio="<?=$comercio?>"  id_comercio="<?=$id_comercio?>"  type="submit" id="tarjeta_plato_comercio" class="btn btn-success btn-block form-control" style="border: 3px;">Seguir Comprando</button>

		</div>
		<div class="col-sm-12 col-md-3" >
			<br>
			<button ped_cod="<?=$id_pedido?>" ped_cod_env="<?=$cod_usuario_ped ?>" onclick="Cliente.confirmar_pedido_cliente();"  type="submit" id="btn-confirmar-pedido-cliente" class="btn btn-success btn-block form-control" style="border: 3px;">Confirmar Pedido</button>
		</div>
	</div>
	<br />
</div>


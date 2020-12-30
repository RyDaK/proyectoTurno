<style>
	.bg-ok{
		background-color: #cbffcb;
		color: #000000;
	}
	.bg-advertencia{
		background-color: #ffe400;
		color: #000000;
	}
	.bg-problem{
		background-color: #ff0000;
		color: #fff;
	}
	.req-content{
		font-family: Montserrat-Regular, sans-serif !important;
		font-size: 12px;
		color: #000;
	}
	.title-req{
		color: #ff9707;
		font-size: 20px;
		display: block;
	}
	/**/
	.line-timeline {
		font-family: Montserrat-Regular, sans-serif !important;
		font-size: 10px;
		color: #000;
		list-style-type: none;
		display: flex;
		align-items: center;
		justify-content: center;
		padding: 0px;
	}

	.line-li {
	  transition: all 200ms ease-in;
	}

	.line-timestamp {
	  margin-bottom: 20px;
	  padding: 0px 30px;
	  display: flex;
	  flex-direction: column;
	  align-items: center;
	  font-weight: 100;
	}

	.line-status {
	  padding: 10px 10px;
	  display: flex;
	  justify-content: center;
	  border-top: 2px solid #D6DCE0;
	  position: relative;
	  transition: all 200ms ease-in;
	}
	.line-status h4 {
	  font-weight: normal;
	  font-size: 14px;
	  text-align: center;
	  /*width: 50px;
      white-space: nowrap;
      text-overflow: ellipsis;
      overflow: hidden;*/
	}
	
	.line-timestamp span {
	  width: 50px;
	  font-size: 9px;
      /*white-space: nowrap;
      text-overflow: ellipsis;
      overflow: hidden;*/
	}
	
	.line-status:before {
	  content: "";
	  width: 25px;
	  height: 25px;
	  background-color: white;
	  border-radius: 25px;
	  border: 1px solid #ddd;
	  position: absolute;
	  top: -15px;
	  left: 42%;
	  transition: all 200ms ease-in;
	}

	.line-li.line-complete .line-status {
	  border-top: 2px solid #66DC71;
	}
	.line-li.line-complete .line-status:before {
	  background-color: #66DC71;
	  border: none;
	  transition: all 200ms ease-in;
	}
	.line-li.line-complete .line-status h4 {
	  color: #66DC71;
	}
</style>
<div id="divllenar">
<div class="row">
	<div class="col-md-12">
		<ul class="line-timeline" id="timeline">
			<li class="line-li  <?=isset($hora['realizado'])? 'line-complete':''?> ">
				<div class="line-timestamp">
					<?if(isset($hora['realizado'])){?>
						<span class="author"><center><?=$fecha['realizado']?></center></span>
						<span class="date">&nbsp;</span>
						<span class="date">&nbsp;</span>
					<?} else {?>
						<span class="author">&nbsp;</span>
						<span class="date">&nbsp;</span>
						<span class="date">&nbsp;</span>
					<?}?>
				</div>
				<div class="line-status">
					<h4><i class="fas fa-cart-arrow-down"></i><br />SOLICITADO</h4>
				</div>
			</li>
			<li class="line-li  <?=isset($hora['confirmado'])? 'line-complete':''?> ">
				<div class="line-timestamp">
					<?if(isset($hora['confirmado'])){?>
						<span class="author"><center><?=$fecha['confirmado']?></center></span>
						<span class="date">&nbsp;</span>
						<span class="date">&nbsp;</span>
					<?} else {?>
						<span class="author">&nbsp;</span>
						<span class="date">&nbsp;</span>
						<span class="date">&nbsp;</span>
						<span class="date">&nbsp;</span>
					<?}?>
				</div>
				<div class="line-status">
					<h4><i class="fas fa-cash-register"></i><br />CONFIRMADO</h4>
				</div>
			</li>
			<li class="line-li  <?=isset($hora['producido'])? 'line-complete':''?> ">
				<div class="line-timestamp">
					<?if(isset($hora['producido'])){?>
						<span class="author"><center><?=$fecha['producido']?></center></span>
						<span class="date">&nbsp;</span>
						<span class="date">&nbsp;</span>
					<?} else {?>
						<span class="author">&nbsp;</span>
						<span class="date">&nbsp;</span>
						<span class="date">&nbsp;</span>
						<span class="date">&nbsp;</span>
					<?}?>
				</div>
				<div class="line-status">
					<h4><i class="fas fa-thumbs-up"></i><br />LISTO</h4>
				</div>
			</li>
			<li class="line-li  <?=isset($hora['despacho'])? 'line-complete':''?> ">
				<div class="line-timestamp">
					<?if(isset($hora['despacho'])){?>
						<span class="author"><center><?=$fecha['despacho']?></center></span>
						<span class="date">&nbsp;</span>
						<span class="date">&nbsp;</span>
					<?} else {?>
						<span class="author">&nbsp;</span>
						<span class="date">&nbsp;</span>
						<span class="date">&nbsp;</span>
						<span class="date">&nbsp;</span>
					<?}?>
				</div>
				<div class="line-status">
					<h4><i class="fas fa-motorcycle"></i><br />ENVIADO</h4>
				</div>
			</li>
		</ul> 
	</div>
</div>
<div id="divllenar">

<?
	$importe_total = 0;
	$i=0;
	$moneda = "S/.";
	foreach($listado_pedidos as $row){
?>
	<div class="row">
		<div class="col-sm-12 col-md-2" >
			<img src="../files/articulos/<?=!empty($row->foto_plato)? $row->foto_plato.".jpg": "default.jpg"?>" alt="Lights" class="" style="text-align: center; height: 100px; width:150px ; border-radius: 5px 5px 5px 5px;" >
		</div>
		<div class="col-sm-12 col-md-7" >
			<h5 class="text-success" ><?= $row->plato?> <a href="javascript:;" class="btn btn-default btn-xs" ><i class="fas fa-food"></i></a></h5>
			<div class="position-relative form-group">
                <textarea name="observaciones<?=$i?>" id="observaciones<?=$i?>" placeholder="No hay comentarios" rows="2" class="form-control"  readonly="readonly"><?=$row->comentario?></textarea>
			</div>
		</div>
		<div class="col-sm-12 col-md-3" >
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon" style="width: 100px;">Precio Unit.</span>
					<input value="<?=$moneda?>" class="form-control simbolo_moneda" readonly="readonly" style="flex:none;width:50px" >
					<input id="precio_plato<?=$i?>" ped_cod_env_det="<?=$row->idDetallePedido?>" type="text" class="form-control" name="precio_plato" value="<?=number_format($row->precio_unitario,2,'.','.')?>" readonly="readonly" >
				</div>
			</div>
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon" style="width: 100px;">Cantidad</span>
					<input id="cantidad_platos<?=$i?>" ped_cod_env_det="<?=$row->idDetallePedido?>"  type="text"  patron="requerido,enteros" class="form-control cantidad_platos" readonly="readonly" name="cantidad_platos" value="<?= $row->cantidad?>" >    
				</div>
			</div>
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon" style="width: 100px;">Costo Empaque{s}.</span>
					<input value="<?=$moneda?>" class="form-control simbolo_moneda" readonly="readonly" style="flex:none;width:50px" >
					<input id="precio_empaque<?=$i?>" ped_cod_env_det="<?=$row->idDetallePedido?>" type="text" class="form-control" name="precio_plato" value="<?=number_format(($row->empaque * $row->cantidad),2,'.','.')?>" readonly="readonly" >
				</div>
			</div>
			<div class="form-group">
				<div  class="input-group">
					<span class="input-group-addon bg-success text-white" style="width: 100px; padding: 0.5em; border-radius: 5px 0px 0px 5px;" >Sub Total</span>
					<input value="<?=$moneda?>" class="form-control simbolo_moneda" readonly="readonly" style="flex:none;width:50px" >
					<input id="total_pedido_det<?=$i?>" type="text" class="form-control" name="total_pedido_det" value="<?=number_format($row->importe,2,'.','.')?>" readonly="readonly" >                                        
				</div>
			</div>
		</div>
	</div>
	<?
		$importe_total += number_format(($row->importe),2,'.','.');
		$i++;
		if(isset($row->costo_delivery)){
			$delivery = number_format($row->costo_delivery,2,'.','.');
		}else{
			$delivery ='';
		}
		$entrega = $row->id_metodo_env;

		}

		if($entrega == 2){
			$delivery =0;
		}
	?>
	<hr />
		<div class="row" >
			<div class="col-sm-12 col-md-9" ></div>
			<div class="col-sm-12 col-md-3" >
				<div class="form-group">
					<div  class="input-group">
						<span class="input-group-addon bg-success text-white" style="width: 100px; padding: 0.5em; border-radius: 5px 0px 0px 5px;" >Costo Envío</span>
						<input value="<?=$moneda?>" class="form-control simbolo_moneda" readonly="readonly" style="flex:none;width:50px" >
						<input id="costo_envio" type="text" class="form-control" patron="requerido" name="costo_envio" value="<?=($entrega == 1)? dos_decimales($delivery) : "0"?>" readonly="readonly" >
					</div>
				</div>
			</div>
		</div>
	<br />
	<div class="row" >
		<div class="col-sm-12 col-md-9" ></div>
		<div class="col-sm-12 col-md-3" >
			<div class="form-group">
				<div  class="input-group">
					<span class="input-group-addon bg-success text-white" style="width: 100px; padding: 0.5em; border-radius: 5px 0px 0px 5px;" >Total </span>
					<input value="<?=$moneda?>" class="form-control simbolo_moneda" readonly="readonly" style="flex:none;width:50px" >
					<input id="total_pedido" type="text" class="form-control" patron="requerido" name="total_pedido" value="<?=dos_decimales($importe_total + $delivery)?>" readonly="readonly" >
				</div>
			</div>
		</div>
	</div>
	<br>

</div>
</div>

<script>
	//  $('#total_pedido').val( "S/ "+($.number($('#costo_envio').val()) + $.number($('#total_pedido').val())));
	//  $('#costo_envio').val("S/ "+$('#costo_envio').val())
</script>
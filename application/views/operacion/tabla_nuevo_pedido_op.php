<div class="row col-12 col-sm-12 col-md-12 col-lg-12 mx-auto m-0" id="tabla_nuevo_pedido_op">
				<div class="row col-12 col-sm-12 col-md-12 col-lg-12 m-0 p-0">
					<table class="table table-bordered" id="elemento_tabla_nuevo_pedido">
					  <thead>
					    <tr>
					      <th>ELIMINAR</th>
					      <th>ARTICULO</th>
					      <th>PRECIO</th>
					      <th>CANTIDAD</th>
					      <th>SUBTOTAL</th>
					    </tr>
					  </thead>
						<tbody id="cuerpo_carrito">
							
							</tbody>
						</table>
					
				</div>
				<div class="row col-12 col-sm-12 col-md-12 col-lg-12 m-0 p-0" hidden="hidden" id="parte_1_op">
						<div  class="col-md-8"></div>
						<div class="form-group col-md-4">
							<div  class="input-group">
								<span class="input-group-addon" >Total sin Envío: </span>
								<input id="total_pedido"  type="text" class="form-control input-total" name="total_pedido_det" value="<?=isset($total_pedido)?"S/. ".dos_decimales($total_pedido):""?>" readonly="readonly">
							</div>
						</div>
				</div>
				<div class="row col-12 col-sm-12 col-md-12 col-lg-12 m-0 p-0" >
						<div  class="col-md-10"></div>
								<!-- <input id="total_pedido" hidden="hidden" type="text" class="form-control input-total" name="total_pedido_det" value="<?=isset($total_pedido)?"S/. ".$total_pedido:""?>" readonly="readonly"> -->
								<button class="btn btn-success" id="confirmar_temp" onclick="confirmar_pedido_op();">Confirmar</button>
						</div>

				</div>
			</div>
		</div>

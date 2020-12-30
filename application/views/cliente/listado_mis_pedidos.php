<div id="divllenar">
<!--  -->

		<div class="row">
			<div class="col-md-12">
				<button id="btn-refresh" type="button" href="javascript:;" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Actualizar"><i class="fa fa-refresh" ></i> Actualizar</button>
			<!-- <button id="btn-new" type="button" href="javascript:;" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Agregar Pedido"><i class="fa fa-plus" ></i> Nuevo</button> -->
			<button id="btn-send" type="button" href="javascript:;" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="" data-original-title=""><i class="fa fa-map" ></i> Tracke tu Pedido</button>
		</div>
	</div>
	<div class="divider"></div> 
	<div class="main-card mb-3 card">
		<div id="content-table" class="card-body">
<table style="width: 100%; font-size: 12px" id="tb-list" class="table table-hover table-striped table-bordered">
<thead>
    <tr>
        <th></th>
      <th>FECHA</th>
      <th>HORA</th>
      <th>COMERCIO</th>
      <th>PDV</th>
      <th>MEDIO DE PAGO</th>
      <th>TIPO</th>
      <th>DIRECCIÓN</th>
      <th>ETAPA</th>
    </tr>
</thead>
    <tbody>
        <?foreach($data as $row){?>
            <tr data-id="<?=$row->idPedidoCliente?>">
                <td class="text-center"></td>
                <td class="text-center"><?=$row->fecha_?></td>
                <td class="text-center"><?=$row->hora_?></td>
                <td class="text-center"><?=$row->comercio?></td>
                <td class="text-center"><?=$row->local?></td>
                <td class="text-center"><?=$row->medio_pago_?></td>
                <td class="text-center"><?=$row->medio_entrega_?></td>
                <td class="text-center"><?=$row->direccion ?></td>
                <td class="text-center"><?=$row->etapa?></td>
            </tr>
        <?}?>
    </tbody>
</table>

		</div>
    </div>
    
 <!--  -->
</div>

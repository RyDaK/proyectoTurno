

<!--<button class="btn btn-lg btn-info sweet-11" onclick="_gaq.push(['_trackEvent', 'example, 'try', 'Info']);">Info</button>-->
<table style="width: 100%; font-size: 9px" id="tb-list" class="table table-hover table-striped table-bordered">
	<thead>
		<tr>
			<th>SELECT</th>
			<th>EDIT</th>
			<!--<th>TICKET</th>-->						<th># de Comensales</th>
			<th>FECHA<br />PEDIDO</th>
			<th>HORA PEDIDO</th>
			<th>TIEMPO<br />ESPERA</th>
			<th>PDV</th>
			<th>CLIENTE</th>
			<th>TELÉFONO</th>
			<th>ATENCIÓN</th>
		</tr>
	</thead>
	<tbody>
		<?$i=1; foreach($data as $row){?>
			<tr data-id="<?=$row['id_pedido']?>" >
				<td class="text-center" ></td>
				<td class="text-center" ><?='<a href="javascript:;" data-id="'.$row['id_pedido'].'" data-value=\''.json_encode($row).'\' class="btn-edit-telefono"><i class="fa fa-edit"></i></a> '?></td>
				<td class="text-center" ><?=$row['ticket']?></td>
				<td class="text-center" ><?=date_change_format($row['fecha_registro'])?></td>
				<td class="text-center" ><?=$row['hora_registro']?></td>
				<td class="text-center" ><?=$row['tiempo_transcurrido']?></td>
				<td ><?=$row['pdv']?></td>
				<td ><?=$row['cliente']?></td>
				<td class="text-center" ><?=!empty($row['telefono'])? $row['telefono'] : '-'?></td>
				<td  ><?=!empty($row['usuario'])? $row['usuario'] : '-'?></td>
			</tr>
		<?}?>
	</tbody>
</table>

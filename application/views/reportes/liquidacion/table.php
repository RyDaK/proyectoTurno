<table style="width: 100%; font-size: 12px" id="tb-list" class="table table-hover table-striped table-bordered">
	<thead>
		<tr>
			<th>TICKET</th>
			<th>FECHA<BR />PEDIDO</th>
			<th>HORA PEDIDO</th>
			<th>FECHA<BR />ATENCIÓN</th>
			<th>HORA ATENCIÓN</th>
			<th>TIEMPO<BR />ESPERA</th>
			<th>PDV</th>
			<th>CLIENTE</th>
			<th>TELÉFONO</th>
			<th>ATENCIÓN</th>
			<th>AUTOGESTION</th>
			<th>ETAPA ACTUAL</th>
		</tr>
	</thead>
	<tbody>
		<?$i=1; foreach($pedidos as $row){?>
			<tr >
				<td class="text-center" ><?=$row['ticket']?></td>
				<td class="text-center" ><?=date_change_format($row['fecha_registro'])?></td>
				<td class="text-center" ><?=$row['hora_registro']?></td>
				<td class="text-center" ><?=!empty($row['fecha_atencion'])? date_change_format($row['fecha_atencion']): '-'?></td>
				<td class="text-center" ><?=!empty($row['hora_atencion'])? $row['hora_atencion'] : '-'?></td>
				<td class="text-center" ><?=!empty($row['tiempo_transcurrido'])? $row['tiempo_transcurrido'] : '-'?></td>
				<td ><?=$row['pdv']?></td>
				<td ><?=$row['cliente']?></td>
				<td class="text-center" ><?=!empty($row['telefono'])? $row['telefono'] : '-'?></td>
				<td  ><?=!empty($row['usuario'])? $row['usuario'] : '-'?></td>
				
				<td class="text-center" ><?=!empty($row['flagAuto'])? 'SI' : 'NO'?></td>
				<td class="text-center" ><?=!empty($row['etapa'])? $row['etapa'] : '-'?></td>
			</tr>
		<?}?>
	</tbody>
</table>

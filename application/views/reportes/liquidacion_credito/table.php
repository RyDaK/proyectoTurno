<div class="table-responsive" style="padding: 0.3em;">
<table style="width: 100%; font-size: 12px" id="tb-list" class="table table-hover table-striped table-bordered">
	<thead>
		<tr>
			<th class="text-center">COMERCIO</th>
			<th class="text-center">FECHA CARGA</th>
			<th class="text-center">CREDITOS CARGA</th>
			<th class="text-center">PDV</th>
			<th class="text-center">CREDITOS CONSUMO</th>
			<th class="text-center">SALDO ACTUAL</th>
			
		</tr>
	</thead>
	<tbody>
		<?$i=1; foreach($pedidos as $ix => $row){?>
			<tr >
				<td class="text-center bg-success text-white"><?=($row['comercio'])?></td>
				<td>-</td>
				<?$total = 0; foreach($pedidos_recarga[$ix]['creditos'] as $ix_c => $row_c ){?>
					<?$total = $total + $row_c['creditosCarga']?></td>
				<?}?>
				<td class="text-center bg-success text-white"><?=$total?></td>
				<td>-</td>
				<td class="text-center bg-success text-white" ><?=$gastos_t=isset($ix) ? (isset($gastos_comercio[$ix])? count($gastos_comercio[$ix]) : 0) : 0?></td>
				<td class="text-center bg-success text-white" ><?=$total-$gastos_t?></td>
				
			</tr>
			<?if(isset($pedidos_recarga[$ix]['creditos'])){?>
			<?foreach($pedidos_recarga[$ix]['creditos'] as $ix_c => $row_c ){?>
				<tr >
					<td></td>
					<td class="text-center" ><?=$row_c['fecIni']?></td>
					<td class="text-center" ><?=$row_c['creditosCarga']?></td>
					<td class="text-center" >-</td>
					<td class="text-center" >-</td>
					<td class="text-center" >-</td>
				</tr>
			<?}?>
			<?}?>
			<?if(isset($consumos[$ix])){?>
			<?foreach($consumos[$ix] as $ix_u => $row_u ){?>
				<tr >
					<td></td>
					<td class="text-center" >-</td>
					<td class="text-center" >-</td>
					<td class="text-center" ><?=$row_u['local']?></td>
					<td class="text-center" ><?=count($gastos[$ix][$ix_u])?></td>
					<td class="text-center" >-</td>
				</tr>
			<?}?>
			<?}?>
		<?}?>
	</tbody>
</table>
</div>

<div class="table-responsive" id="tb-list-content" style="padding: 0.3em;max-width: 1000px;">
    <table style="width: 100%; font-size: 12px" id="tb-list" class="table table-hover table-striped table-bordered">
	<thead>
		<tr>
			<th class="text-center">COMERCIO</th>
			<th class="text-center">COD<BR> PEDIDO</th>
			<th class="text-center">PDV</th>

			<th class="text-center">FECHA<BR> PEDIDO</th>
			<th class="text-center">HORA<BR> PEDIDO</th>

			<th class="text-center">CANAL</th>
			<th class="text-center">SUB CANAL</th>
			<th class="text-center">DELIVERY<BR>O<BR>RECOJO</th>
			<th class="text-center">MONTO<BR>DE<BR>COMPRA</th>

			<th class="text-center">NOMBRE<BR>CLIENTE</th>
			<th class="text-center">DIRECCIÓN<BR>CLIENTE</th>
			<th class="text-center">DISTRITO<BR>CLIENTE</th>

			<th class="text-center">FORMA DE<BR>PAGO</th>
			<th class="text-center">HORA DE<BR>CONFIRMACIÓN</th>
			<th class="text-center">HORA DE<BR>PRODUCCION</th>
			<th class="text-center">HORA DE<BR>DESPACHO</th>
			<th class="text-center">MEDIO DE<BR>ENVÍO</th>
			<th class="text-center">ETAPA DE<BR>ACTUAL</th>
		</tr>
	</thead>
	<tbody>
		<?$i=1; foreach($pedidos as $row){
			$dia='-';
			$mes='-';
			$anio='-';
			$hora='-';
			if(!empty($row['tiempo_entrega'])){
				$fecha=explode(' ',$row['tiempo_entrega']);
				if(is_array($fecha)){
					$fecha_=explode('-',$fecha[0]);
					if(is_array($fecha_)){
						$mes=$fecha_[1];
						$dia=$fecha_[2];
						$anio=$fecha_[0];
						$hora=$fecha[1];
					}
				}
			}

			$hora_registro='-';
			if(!empty($row['tiempo_entrega'])){
				$fecha=explode(' ',$row['tiempo_entrega']);
				if(is_array($fecha)){
					$hora_registro=$fecha[1];
				
				}
			}
			
			$hora_confirma='-';
			if(isset($etapas[$row['id_pedido']]['2'])){
				$hora = $etapas[$row['id_pedido']]['2'];
				$hora_x=explode(" ",$hora['fecha']);
				if(is_array($hora_x)){
					$hora_confirma=$hora_x[1];
				
				}
			}
			
			$hora_produce='-';
			if(isset($etapas[$row['id_pedido']]['3'])){
				$hora = $etapas[$row['id_pedido']]['3'];
				$hora_x=explode(" ",$hora['fecha']);
				if(is_array($hora_x)){
					$hora_produce=$hora_x[1];
				
				}
			}
			
			$hora_despacha='-';
			if(isset($etapas[$row['id_pedido']]['4'])){
				$hora = $etapas[$row['id_pedido']]['4'];
				$hora_x=explode(" ",$hora['fecha']);
				if(is_array($hora_x)){
					$hora_despacha=$hora_x[1];
				
				}
			}
	
			?>
			<tr >
				<td class="text-center" ><?=!empty($row['comercio'])? $row['comercio'] : '-'?></td>
				<td class="text-center" ><?=!empty($row['id_pedido'])? $row['id_pedido'] : '-'?></td>
				<td class="text-center" ><?=!empty($row['local'])? $row['local'] : '-'?></td>

				<td class="text-center" ><?= $anio.'/'.$mes.'/'.$dia?></td>
				<td class="text-center" ><?= $hora_registro?></td>
				
				<td class="text-center" ><?=!empty($row['canal'])? $row['canal'] : '-'?></td>
				<td class="text-center" ><?=!empty($row['subcanal'])? $row['subcanal'] : '-'?></td>
				<td class="text-center" ><?=!empty($row['tipo'])? (($row['tipo'] == 1)? 'Envio a Domicilio' : 'Recojo en Local') : '-'?></td>
				<?
					$total = isset($detalle[$row['id_pedido']])? $detalle[$row['id_pedido']]['total'] : 0;
					$total = $row['monto'] + $total;
				?>
				<td class="text-center" ><?=!empty($total)? moneda($total) : '-'?></td>

				<td class="text-center" ><?=!empty($row['nombres'])? $row['nombres'] : '-'?></td>
				<td class="text-center" ><?=!empty($row['direccion'])? utf8_decode($row['direccion']) : '-'?></td>
				<td class="text-center" ><?=!empty($row['distrito'])? $row['distrito'] : '-'?></td>

				<td class="text-center" ><?=!empty($row['tipo_pago'])? $row['tipo_pago'] : '-'?></td>
				<td class="text-center" ><?=$hora_confirma?></td>
				<td class="text-center" ><?=$hora_produce?></td>
				<td class="text-center" ><?=$hora_despacha?></td>
				<td class="text-center" ><?=!empty($row['medio_env'])? $row['medio_env'] : '-'?></td>
				<td class="text-center" ><?=!empty($row['etapa'])? $row['etapa'] : '-'?></td>
			</tr>
		<?}?>
	</tbody>
</table>
</div>
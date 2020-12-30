<div class="row">
	<div class="col-md-6 col-lg-4">
		<div class="card mb-3 widget-content ">
			<div class="widget-content-wrapper">
				<div class="widget-content-left">
					<div class="widget-heading"><?= isset($comercio['razon_social']) ? $comercio['razon_social'] : '-' ?></div>
					<div class="widget-subheading">De : <?=isset($fecIni) ? ($fecIni) : ''?> Hasta : <?=isset($fecFin) ? ($fecFin) : ''?></div>
					<hr>
					<div class="widget-content">
						<div class="row">
							<table>
							<thead>
								<th>Fecha de Compra de Creditos</th>
								<th>Cantidad de Creditos</th>
							</thead>
							<tbody>
								<?if(isset($creditos)) { ?>
									<tr>
										<td><?= isset($creditos['fecIni']) ? date_change_format($creditos['fecIni']) : ''?></td><td><?=$creditos['creditosCarga']?></td>
									</tr>

								<?}?>
								
							</tbody>
							
							</table>
						</div>
					</div>
					<hr>
					<div class="widget-heading">
						<div class="row">
							<div class="col-md-6">
								<label>SALDO A LA FECHA </label>
							</div>
							<div class="col-md-6">
								<?= isset($comercio['creditosActual']) ? $comercio['creditosActual'] : '-' ?>
							</div>
						</div>
					</div>
				</div>
				 
			</div>
		</div>
	</div>
	 
	
</div>
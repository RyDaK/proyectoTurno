<div class="row">
	<div class="col-md-6 col-lg-3">
		<div class="card mb-3 widget-content ">
			<div class="widget-content-wrapper">
				<div class="widget-content-left">
					<div class="widget-heading">Total Pedidos</div>
					<div class="widget-subheading">Pedidos realizados</div>
				</div>
				<div class="widget-content-right">
					<div class="widget-numbers text-success"><span><a href="javascript:;" class="lk-pedidos-table text-success" style="text-decoration: underline;" data-auto="" data-etapa="" ><?=$total_pedidos?></a></span></div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-6 col-lg-3">
		<div class="card mb-3 widget-content ">
			<div class="widget-content-wrapper">
				<div class="widget-content-left">
					<div class="widget-heading">Pedidos de Clientes</div>
					<div class="widget-subheading">Pedidos autogestionados</div>
				</div>
				<div class="widget-content-right">
					<div class="widget-numbers text-success"><span><a href="javascript:;" class="lk-pedidos-table text-success" style="text-decoration: underline;" data-auto="si" data-etapa="" ><?=$total_pedidos_auto?></a></span></div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-6 col-lg-3">
		<div class="card mb-3 widget-content ">
			<div class="widget-content-wrapper">
				<div class="widget-content-left">
					<div class="widget-heading">Pedidos de Usuarios</div>
					<div class="widget-subheading">Pedidos de empleados</div>
				</div>
				<div class="widget-content-right">
					<div class="widget-numbers text-success"><span><a href="javascript:;" class="lk-pedidos-table text-success" style="text-decoration: underline;" data-auto="no" data-etapa="" ><?=$total_pedidos_user?></a></span></div>
				</div>
			</div>
		</div>
	</div>
	<?
		$por = ($total_pedidos > 0)? round($pedidos_confirmados/$total_pedidos *100,2) : 0;
		$bg = ($por > 50)? 'bg-success': 'bg-danger';
		$color = ($por > 50)? 'text-success': 'text-danger';
	?>
	<div class="col-md-6 col-lg-3">
		<div class="card-shadow-danger mb-3 widget-chart widget-chart2 text-left card">
			<div class="widget-content">
				<div class="widget-content-outer">
					<div class="widget-content-wrapper">
						<div class="widget-content-left pr-2 fsize-1">
							<div class="widget-numbers mt-0 fsize-3 <?=$color?>"><?=$por?>%</div>
						</div>
						<div class="widget-content-right w-100">
							<div class="progress-bar-xs progress">
								<div class="progress-bar <?=$bg?>" role="progressbar" aria-valuenow="<?=$por?>" aria-valuemin="0" aria-valuemax="100" style="width: <?=$por?>%;"></div>
							</div>
						</div>
					</div>
					<div class="widget-content-left fsize-1">
						<div class="text-muted opacity-6"><a href="javascript:;" class="lk-pedidos-table text-success" style="text-decoration: underline;" data-auto="" data-etapa="2" >Pedidos Confirmados</a></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
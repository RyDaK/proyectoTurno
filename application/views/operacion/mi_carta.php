<div class="row">
	<div class="col-md-12">
		<div class="main-card mb-3 card">
		<div id="content-table" class="card-body">
			<form id="frm-register-articulos" class="" onsubmit="return false;" >
			<input type="hidden" value="" id="id_articulo" name="id_articulo"/>
			<div class="row">
				<div class="col-md-12 form-group" style="text-align:right;">
					<button id="btn-hide-all-articulos" type="button" href="javascript:;" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Ocultar"><i class="fa fa-eye" ></i> Ocultar Todo</button>
				</div>
			</div>
			<hr />
			<div class="row">
				<div class="col-md-4" style="text-align:center;">
				</div>
				<div class="col-md-4" style="text-align:right;">
					<button id="btn-refresh-articulos" type="button" href="javascript:;" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Buscar"></i> Buscar</button>	
				</div>
				<div class="col-md-4" style="text-align:center;">
					<input id="nombre_articulo_bus" placeholder="Escribe Aquí" type="text" class="form-control" >
				</div>
			</div>
			<br />
			<div id="carouselExampleControls" class="carousel slide row"  data-ride="carousel" data-interval="0">
				<div class="col-md-1">
					<a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev" style="background-color: #cccccc; width:100%;">
						<span class="carousel-control-prev-icon" aria-hidden="true"></span>
						<span class="sr-only">Previous</span>
					</a>
				</div>
				<div class="col-md-10" id="content-table-articulo">
					<div class="alert alert-default2"><img src="assets/images/load.gif" /> Buscando registros...</div>          
				</div>
				<div class="col-md-1">
					<a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next" style="background-color: #cccccc; width:100%;">
						<span class="carousel-control-next-icon" aria-hidden="true"></span>
						<span class="sr-only">Next</span>
					</a>
				</div>
				</div>
				
			</form>
		</div>
	</div>
	</div>
</div>

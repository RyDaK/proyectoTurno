<div id="divllenar">
<div class="row">
			<div class="col-md-10"></div>
			<div class="col-md-2">
				<button style="float:right" onclick="retroceder()" id="btn-back"  etapa="" type="button" href="javascript:;" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Anterior"><i class="fa fa-arrow-left" ></i> Regresar</button>
			</div>
	</div>
	<br>
    <div class="row">
		<div class="col-md-12">
            <?=$mensaje;?>
		</div>
	</div>
<!-- <label for=""><a href="javascript:Cliente.cargar_form_login_cliente();">Link_comercio</a></label><br> -->
</div>
<script>
	function retroceder(){
		document.getElementById("home_link").click();
	}
	
</script>

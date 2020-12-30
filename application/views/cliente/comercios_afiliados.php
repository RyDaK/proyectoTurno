<div id="divllenar">
<div class="row">
			<div class="col-md-10"></div>
			<div class="col-md-2">
				<button style="float:right" onclick="retroceder()" id="btn-back"  etapa="" type="button" href="javascript:;" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Anterior"><i class="fa fa-arrow-left" ></i> Regresar</button>
			</div>
	</div>
	<br>
    <div class="row">
        <?
  foreach($comercios_afiliados as $row){?>
  <div class="col-md-3 col-sm-4 col-6" style="margin-bottom: 1em" >
     <div class="thumbnail" id="tarjeta_comercio" cod_tipo_comercio="<?=$row->idTipoComercio?>"  id_comercio="<?=$row->id_comercio?>" nombre_comercio="<?=$row->nombre?>" tipo_comercio="<?=$row->tipoComercio ?>">
        <a href="javascript:;" style="text-decoration: none; color: #000;">
        <div class="row" >
				<div class="col-md-12">
					<img src="../files/logos/<?=isset($row->ruta_logo)? $row->ruta_logo.".jpg": "default.jpg"?>" alt="Lights" class="w-100" style="text-align: center; height: 130px; border-radius: 5px 5px 0px 0px;" >
				</div>
            </div>
            <div class="row" >
				<div class="col-md-12">
					<div  style="margin: 0.5em; text-decoration: none">
						<h6 class="text-danger" ><?= isset($row->nombre)? $row->nombre : $row->razon_social?></h6>
                        <label style="display:block;font-size: 10px;margin-bottom: 0em;" ><?= $row->tipoComercio?></label>
						<label style="display:block;font-size: 8px;margin-bottom: 0em;" ><?= isset($row->rubro)? $row->rubro:"-"?></label>
                    </div>
				</div>
			</div>
        </a>
    </div>
</div>
<?}?>
</div>
<!-- <label for=""><a href="javascript:Cliente.cargar_form_login_cliente();">Link_comercio</a></label><br> -->
</div>
<script>
	function retroceder(){
		document.getElementById("home_link").click();
	}
	
</script>

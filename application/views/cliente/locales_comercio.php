<div id="divllenar">
<div class="row">
			<div class="col-md-10"></div>
			<div class="col-md-2">
				<button  style="float:right" onclick="retroceder()" id="btn-back"  etapa="" type="button" href="javascript:;" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Anterior"><i class="fa fa-arrow-left" ></i> Regresar</button>
			</div>
	</div>
	<br>
<div class="row">
        <?
        date_default_timezone_set("America/Lima");
        $currentDate = date('Y-m-d');
        $currentTime = date('H:i');
  foreach($locales_comercio as $row){?>
   <div class="col-md-3 col-sm-4 col-6" style="margin-bottom: 1em" >
     <div class="thumbnail" id="tarjeta_plato_comercio" cod_local_comercio="<?=$row->idComercioLocal?>" cod_tipo_comercio="<?=$row->tipo_comercio?>"  id_comercio="<?=$row->id_comercio?>" local_comercio="<?= $row->local?>" nombre_comercio="<?=$row->nombre?>" tipo_comercio="<?=$row->tipoComercio ?>">
        <a href="javascript:;" style="text-decoration: none; color: #000;">
            <div class="row" >
                    <div class="col-md-12">
    					<img src="../files/logos/<?=isset($row->ruta_logo)? $row->ruta_logo.".jpg": "default.jpg"?>" alt="Lights" class="w-100" style="text-align: center; height: 130px; border-radius: 5px 5px 0px 0px;" >
                    </div>
                </div> 
        <div class="row" >
				<div class="col-md-12">
					<div  style="margin: 0.5em; text-decoration: none">
						<h6 class="text-danger" ><?= isset($row->local)? $row->local : $row->razon_social?></h6>
                        <label style="margin-bottom: 0em;font-size: 10px;color:<?=isset($row->hora_fin) && ($currentTime<$row->hora_fin) && ($currentTime>$row->hora_ini)? " green" : " red "?>"><?=isset($row->hora_ini) && isset($row->hora_fin) && ($currentTime<$row->hora_fin) && ($currentTime>$row->hora_ini)? " Abierto: " : "Cerrado: " ?></label>
                        <label style="margin-bottom: 0em;font-size: 10px"><?=isset($row->hora_ini) && isset($row->hora_fin)? $row->hora_ini." - ".$row->hora_fin: "" ?></label><br />
                        <label style="display:block;margin-bottom: 0em;font-size: 10px"><?=isset($row->numero)? "Telf: ".$row->numero: " - " ?></label>
                        <label style="display:block;margin-bottom: 0em;font-size: 10px"><?=isset($row->distrito)? $row->distrito: " - " ?></label>
                        <label style="display:block;margin-bottom: 0em;font-size: 9px"><?=isset($row->direccion)&&isset($row->via)? $row->via." ".$row->direccion: " - " ?></label>

                    </div>
				</div>
			</div>
    </a>
</div>
</div>
<?}?>
</div>
</div>
<script>
	function retroceder(){
		document.getElementById("enlace_filtrado").click();
	}
	
</script>

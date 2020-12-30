<div id="divllenar">

<div class="row">

			<div class="col-md-10"></div>

			<div class="col-md-2">

				<button style="float:right"  id="btn-back_2"  etapa="" type="button" href="javascript:;" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Anterior"><i class="fa fa-arrow-left" > </i> Regresar</button>

			</div>

			<!-- <div class="col-md-1">

				<button id="btn-next" etapa="" type="button" href="javascript:;" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Siguiente"><i class="fa fa-arrow-right" ></i></button>

			</div> -->

	</div>

	<br>

    <div class="row">

        <?

  foreach($platos_comercio as $row){?>

 <div class="col-md-3 col-sm-4 col-6" style="margin-bottom: 1em" >

     <div class="thumbnail">

        <a href="javascript:;" style="text-decoration: none; color: #000;">

            <div class="row" >

                <div class="col-md-12">

                   <img src="../files/articulos/<?=isset($row->foto_plato)? $row->foto_plato.".jpg": "default.jpg"?>" alt="Lights" class="w-100" style="text-align: center; height: 130px; border-radius: 5px 5px 0px 0px;" >

                </div>

            </div>

			<div class="row" >

				<div class="col-md-12">

					<div  style="margin: 0.5em; text-decoration: none">

						<h6 class="text-danger" ><?=$row->plato?></h6>

						<label style="font-size:11px; color: grey" >
						<p style="word-break: break-word;text-align: justify;">
						<?=$row->observacion?>
						</p>
						</label>		

						<div style="text-align: center">

							<div style="font-size: 12px" class="mb-3 mr-3 badge badge-danger" ><?= 'Precio: S/ '.number_format(moneda($row->precio), 2, ',', '.')?></div><br />

							<div >

								<div class="position-relative form-group">

									<label for="txt_cantidad_pedidos"><strong>Cantidad</strong></label>

									<?= '<input id="txt_cantidad_pedidos'.$row->idComercioPlato.'" class="form-control" type="number" min="0" id="staticEmail" placeholder="0">'?></p>

								</div>

							</div>

							<button type="button" cod_local_comercio="<?=$cod_local_comercio?>" cod_comercio="<?=$row->id_comercio?>"cod_plato="<?=$row->idComercioPlato ?>" id="btn-pedir-plato" class="btn btn-success btn-block" >Añadir</button>



						</div>

					</div>

				</div>

			</div>

		</a>

	</div>

</div>

<?}?>

</div>

</div>


<style type="text/css">

	img#combos{
		width: 100%;
		height: 100%;
	}

	.nombre-menu{
		color: red;
	}

	.fa-plus-circle{
		color: red;
		font-size: 170%;
		padding-top: 8%;
	}

	.caja-total-menu{
		padding-right: 0px;
		padding-top: 1%;
	}

	.caja-text-menu{
		padding-left: 0px;
	}

	.total-text-menu{
		width: 50%;
		background-color:red ; 
		color: white;
		font-size: 110%;
		padding-top: 2%;
	}

	.total-total-menu{
		font-size: 110%;
		text-align: center;
	}

	.calendario-menu{
		width: 100%;
		border-color: #d1d1d1;
	}
	textarea{
		border-color: #d1d1d1; 
		width: 80%
	}
	.textarea-menu{
		padding-left: 0px;
	}

	.form-control.btn-sm.selectpicker{
		width: 80%;
	}
	.input-total{
		height: 30px;
		width: 50%;
		padding-top: 3px;
		text-align: center;
		font-size: 80%;
	}

	.input-group-addon{
		width: 50%;
		height: 30px;
		background-color: #57cbb3; 
		color: white;
		text-align: center;
		padding-top: 3px;
	}

</style>
<?
	date_default_timezone_set("America/Lima");
    $currentDate = date('Y-m-d');
    $currentTime = date('H:i');
?>
<div class="container-fluid p-0">
	<div class="row">
            <div class="col-md-2"></div>
				<div class="col-md-8">
					<br>
					<p style="margin-left:10px" >El pedido  <b><?=$data_vista['idPedidoCliente']?></b> está listo para pasar a Producción,si el cliente
					escogió pago ONLINE, verifique que se haya realizado en la Plataforma de
					Pagos con Tarjeta ONLINE, si es así dar Click en botón continuar.</p>
					<p style="margin-left:10px">Costo de envío: <b><?="S/. ".dos_decimales($delivery)?></b></p>
					<p style="margin-left:10px">Total a pagar: <b><?="S/. ".dos_decimales($total_confirmar + $delivery)?></b></p>
           		<div class="col-md-2"></div>
			</div>
	</div>
	<div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
            <button class="form-control btn btn-success" data-id="<?=$data_vista['idPedidoCliente']?>" id="btn_actualizar_pago_enlinea">Continuar</button>
            </div>
            <div class="col-md-4"></div>
	</div>
        
</div>

			


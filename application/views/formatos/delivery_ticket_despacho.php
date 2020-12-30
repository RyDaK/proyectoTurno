<!DOCTYPE html>
<html lang="es">
<head>
<title>TICKET - TURNO</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<style>
		@media print {
			@page {
				margin:0px;
			}
		}   
		.page{
			width: 100mm;
			height: 200mm;
			padding: 0mm;
			margin: 0mm;
			border: solid 1px #000;
		}
		.table {  
			display: table;
			font-size: 9pt;
			font-family: "Tahoma", "Geneva", sans-serif;
		}  
  
        .row{  
            display: table-row; 
        }  
  
        .cell{
			display: table-cell;
			position: absolute;
        }  
		.clear-min{
			clear: both;
			display:inline-block;
			height: 1cm;
		}
		.clear{
			clear: both;
			display:inline-block;
			height: 2cm;
		}
	</style>
	</head>
	<body>
		<div class="page" style="height:<?=(((count($data))*30)+100).'mm'?>" >
			<div class="table" >
				<div class="row" >
					<div class="cell" style="left: 27mm !important; top: 15mm !important"><h2>TICKET - DESPACHO</h2></div>
				</div>
				<div class="row" >
					<div class="cell" style="left: 10mm !important; top: 40mm !important" ># Pedido: <?=$idPedido?></div>
				</div>
				<?$total_pedido = 0;
				foreach($data as $row){
												$nuevo_importe= ($row->importe);
												$total_pedido += $nuevo_importe;
												$fecha = $row->fecha;
												$hora =$row->hora;
												$pago =$row->medio_pago;
												$entrega = $row->id_metodo_env;
												$direccion = $row->direccion;
												$id_comercio = $row->id_comercio;
												$medio_envio = $row->medio_envio;
												$medio_pago = $row->medio_pago;
												$costo_delivery = $row->costo_delivery;
												$idPedidoCliente = $row->idPedidoCliente;
												$distrito_envio = $row->distrito;
												$usuario = $row->nombre_usuario;
					?>
					
				<?}?>
				<div class="row">
					<div class="cell" style="left: 10mm !important; top: 50mm !important" >Nombre del Cliente: <?=$usuario?></div>
				</div>
				<div class="row">
					<div class="cell" style="left: 10mm !important; top: 60mm !important" >Distrito: <?=$distrito_envio?></div>
				</div>
				<div class="row">
					<div class="cell" style="left: 10mm !important; top: 70mm !important" >Direccion: <?=$direccion?></div>
				</div>
				 
				<?$mm = 70;
					foreach($data as $row){?>
				<div class="row">
					<?$mm +=10;?>
					<div class="cell" style="left: 10mm !important; top:<?=$mm."mm"?> !important" >Artículo: <?=$row->plato?></div>
					<?$mm +=10;?>
					<div class="cell" style="left: 10mm !important; top:<?=$mm."mm"?>!important" >Comentario: <?=isset($row->comentario)? $row->comentario: '-'?></div>
					<?$mm +=10;?>
					<div class="cell" style="left: 10mm !important; top:<?=$mm."mm"?> !important" >Cantidad: <?=isset($row->cantidad)? $row->cantidad: '-'?></div>
				</div>
					<hr>
					
				<?}?>

				<div class="row">
					<div class="cell" style="left: 10mm !important; top:  <?=($mm+10)."mm"?> !important" >Total a pagar: <?=dos_decimales($total_pedido + $costo_delivery)?></div>
				</div>
				<div class="row" >
					<div class="cell" style="left: 35mm !important; top: <?=($mm+20)."mm"?> !important; font-size: 7pt;">TURNO - "La espera que no desespera"</div>
				</div>
			</div>
		</div>
	</body>
</html>
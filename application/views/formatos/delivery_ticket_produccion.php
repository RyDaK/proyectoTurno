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
			height: 100%;
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
		<div class="page" style="height:<?=(((count($data))*30)+70).'mm'?>" >
			<div class="table" >
				<div class="row" >
					<div class="cell" style="left: 20mm !important; top: 15mm !important"><h2>TICKET - PRODUCCION</h2></div>
				</div>
				<div class="row" >
					<div class="cell" style="left: 10mm !important; top: 40mm !important" ># Pedido: <?=$idPedido?></div>
				</div>
				
				<?$mm = 40;
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
				<?
				}?>
				<div class="row" >
					<div class="cell" style="left: 30mm !important; top: <?=($mm+10)."mm"?> !important; font-size: 7pt;">TURNO - "La espera que no desespera"</div>
				</div>
			</div>
		</div>
	</body>
</html>
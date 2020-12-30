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
		<div class="page" >
			<div class="table" >
				<div class="row" >
					<div class="cell" style="left: 47mm !important; top: 15mm !important"><h2>TICKET</h2></div>
				</div>
				<div class="row" >
					<div class="cell" style="left: 10mm !important; top: 40mm !important" ># Pedido: <?=$idPedido?></div>
				</div>
				<div class="row" >
					<div class="cell" style="left: 10mm !important; top: 50mm !important" ><table width="16px" height="16px" style="display: inline-block" ><tr><td style="border: 1px solid #000" ><?=isset($etapas['2'])? 'Ok': '&nbsp;&nbsp;&nbsp;&nbsp;' ?></td></tr></table>&nbsp;&nbsp;-&nbsp;&nbsp;Confirmado <strong><?=isset($etapas['2'])? $etapas['2']['hora_']: '' ?></strong></div>
				</div>
				<div class="row" >
					<div class="cell" style="left: 10mm !important; top: 60mm !important" ><table width="16px" height="16px" style="display: inline-block" ><tr><td style="border: 1px solid #000" ><?=isset($etapas['3'])? 'Ok': '&nbsp;&nbsp;&nbsp;&nbsp;' ?></td></tr></table>&nbsp;&nbsp;-&nbsp;&nbsp;Producido <strong><?=isset($etapas['3'])? $etapas['3']['hora_']: '' ?></strong></div>
				</div>
				<div class="row" >
					<div class="cell" style="left: 10mm !important; top: 70mm !important" ><table width="16px" height="16px" style="display: inline-block" ><tr><td style="border: 1px solid #000" ><?=isset($etapas['4'])? 'Ok': '&nbsp;&nbsp;&nbsp;&nbsp;' ?></td></tr></table>&nbsp;&nbsp;-&nbsp;&nbsp;Despachado <strong><?=isset($etapas['4'])? $etapas['4']['hora_']: '' ?></strong></div>
				</div>
				<div class="row" >
					<div class="cell" style="left: 35mm !important; top: 90mm !important; font-size: 7pt;">TURNO - "La espera que no desespera"</div>
				</div>
			</div>
		</div>
	</body>
</html>